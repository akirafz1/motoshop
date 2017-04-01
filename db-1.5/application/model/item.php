<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Item extends ApplicationModel {
	
	function Item($handler = null) {
		
		if ($handler && !$this->handler) {
			$this->handler = $handler;
		}
		$this->table = DB_PREFIX.'item';
		$this->schema = array(
		'folder_id'=>array(),
		'item_type'=>array(),
		'item_field'=>array(),
		'item_caption'=>array(),
		'item_input'=>array(),
		'item_property'=>array(),
		'item_null'=>array(),
		'item_display'=>array(),
		'item_order'=>array());
	
	}
	
	function validate() {
	
		if (is_array($_POST['item']) && count($_POST['item']) > 0) {
			foreach ($_POST['item'] as $key => $row) {
				if (!$this->isvalid($row['item_input'], array('notnull', 'alpha'))) {
					$error[1] = '入力フォームを選択してください。';
				} elseif ($row['item_input'] == 'textarea' && strlen($row['item_property']) > 0) {
					if (!$this->isvalid($row['item_property'], array('numeric', 'range:2:100'))) {
						$error[2] = 'テキストエリアの行数は2以上100以下で入力してください。';
					}
				} elseif (in_array($row['item_input'], array('select', 'checkbox', 'radio')) && strlen($row['item_property']) <= 0) {
					$error[3] = '入力フォームの値を入力してください。';
				}
				if (!$this->isvalid($row['item_null'], 'alpha')) {
					$error[4] = '必須項目の値が無効です。';
				}
				if (!$this->isvalid($row['item_display'], 'numeric')) {
					$error[5] = '一覧表示の値が無効です。';
				}
				if (!$this->isvalid($row['item_order'], 'numeric')) {
					$error[6] = '順序の値が無効です。';
				}
				if (!in_array($row['item_input'], array('date', 'textarea', 'select', 'checkbox', 'radio'))) {
					$row['item_property'] = '';
				}
				if ($row['item_null'] != 'notnull') {
					$row['item_null'] = '';
				}
				if ($row['item_display'] != 1) {
					$row['item_display'] = 0;
				}
				$this->post['item'][] = $row;
			}
			if (is_array($error) && count($error) > 0) {
				foreach ($error as $value) {
					$this->error[] = $value;
				}
			}
		}
	
	}
	
	function fetchItem($type, $folder, $order = 'item_order,item_field') {
		
		$field = implode(',', $this->schematize());
		$query = "SELECT ".$field." FROM ".$this->table." WHERE item_type = '".$type."' AND folder_id = ".intval($folder)." ORDER BY ".$order;
		return $this->fetchAll($query);
	
	}
	
	function findItem($type, $folder) {
		
		$data = $this->fetchItem($type, $folder);
		if (!is_array($data) || count($data) <= 0) {
			$data = $this->fetchItem($type, 0);
		}
		if (is_array($data) && count($data) > 0) {
			$temporary = array();
			foreach ($data as $row) {
				if (strlen($row['item_caption']) > 0) {
					$temporary[] = $row;
				}
			}
			$data = $temporary;
		}
		return $data;
	
	}
	
	function add($type, $redirect) {
		
		$this->authorize('administrator', 'manager');
		$hash = $this->permitCategory('customer', $_GET['folder']);
		$hash['item'] = $this->fetchItem($type, $_GET['folder'], 'item_field');
		if ($_GET['folder'] > 0) {
			$hash['default'] = $this->fetchItem($type, 0, 'item_field');
		}
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validate();
			if (count($this->error) <= 0) {
				if (count($this->post['item']) > 0 && $_POST['item_default'] <= 0) {
					foreach ($this->post['item'] as $key => $row) {
						$row['folder_id'] = intval($_GET['folder']);
						$row['item_type'] = $type;
						$row['item_field'] = sprintf('%s_item%02d', $type, $key);
						if (is_array($hash['item'][$key]) && $hash['item'][$key]['id'] > 0) {
							$this->updateData($this->table, $row, $hash['item'][$key]['id']);
						} else {
							$this->insertData($this->table, $row);
						}
					}
				} else {
					$key = -1;
				}
				if (count($hash['item']) > $key + 1) {
					for ($i = $key + 1; $i < count($hash['item']); $i++) {
						$this->query("DELETE FROM ".$this->table." WHERE id = ".intval($hash['item'][$i]['id']));
					}
				}
				$this->response = true;
				$this->redirect($redirect);
			}
			$hash['item'] = $this->post['item'];
		} elseif (strlen($_GET['folder']) <= 0) {
			$folder = array(0=>'既存顧客') + $hash['folder'];
			foreach ($folder as $key => $value) {
				$array = $this->fetchItem($type, $key, 'item_field');
				if (is_array($array) && count($array) > 0) {
					$count = 0;
					foreach ($array as $row) {
						if (strlen($row['item_caption']) > 0) {
							$count++;
						}
					}
					$hash['count'][$key] = $count;
				} else {
					$hash['count'][$key] = '標準';
				}
			}
		}
		return $hash;
	
	}
	
	function create($schema, $item) {
		
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $row) {
				$schema[$row['item_field']][0] = $row['item_caption'];
				if ($row['item_null'] == 'notnull') {
					$schema[$row['item_field']][] = 'notnull';
				}
				if ($row['item_input'] == 'numeric' || $row['item_input'] == 'alpha') {
					$schema[$row['item_field']][] = $row['item_input'];
				} elseif ($row['item_input'] == 'alphanumeric') {
					$schema[$row['item_field']][] = 'alphaNumeric';
				} elseif ($row['item_input'] == 'checkbox' && is_array($_POST[$row['item_field']])) {
					$_POST[$row['item_field']] = implode(',', $_POST[$row['item_field']]);
				}
			}
		}
		return $schema;
	
	}

}

?>