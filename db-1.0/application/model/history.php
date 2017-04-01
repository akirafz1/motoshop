<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class History extends ApplicationModel {

	var $item;
	
	function History() {
	
		$this->schema = array(
		'folder_id'=>array('except'=>array('search', 'update')),
		'customer_id'=>array('except'=>array('search')),
		'customer_type'=>array('except'=>array('search', 'update')),
		'customer_name'=>array('except'=>array()),
		'history_adddate'=>array('登録日', 'hizuke', 'length:10'),
		'history_machine'=>array('車名', 'notsymbol', 'length:100'),
		'history_color'=>array('車体色', 'notsymbol', 'length:100'),
		'history_regnum'=>array('登録番号', 'notsymbol', 'length:20'),
		'history_carnum'=>array('車体番号', 'notsymbol', 'length:20'),
		'history_newused'=>array('登録時状況', 'notsymbol', 'length:10'),
		'history_gnum'=>array('G登録', 'notsymbol', 'length:10'),
		'history_gokinum'=>array('号機番号', 'notsymbol', 'length:20'),
		'history_shaken'=>array('車検日', 'hizuke', 'length:10'),
		'history_hoken'=>array('任意保険', 'notsymbol', 'length:100'),
		'history_sell'=>array('売却日', 'hizuke', 'length:10'),
		'history_comment'=>array('備考', 'notsymbol', 'length:10000', 'line:100'));
		$this->connect();
		$this->item = new Item($this->handler);
	
	}
	
	function index() {
		
		$hash = $this->permitCategory('customer', $_GET['folder']);
		$hash['item'] = $this->item->findItem('history', $_GET['folder']);
		$this->where[] = $this->folderWhere($hash['folder']);
		$this->where[] = "(customer_type = ".intval($_GET['type']).")";
		$hash += $this->findLimit('id', 1);
		return $hash;
	
	}
	
	function customer() {
		
		$hash = $this->permitParent($_GET['parent']);
		$hash['item'] = $this->item->findItem('history', $hash['parent']['folder_id']);
		$this->where[] = "(customer_id = ".intval($hash['parent']['id']).")";
		$hash += $this->findLimit('id', 1);
		return $hash;
	
	}

	function view() {
	
		$hash['data'] = $this->findView();
		$hash += $this->permitParent($hash['data']['customer_id']);
		$hash['item'] = $this->item->findItem('history', $hash['data']['folder_id']);
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function add() {
		
		$hash = $this->permitParent($_GET['parent'], 'add');
		$hash['item'] = $this->item->findItem('history', $hash['parent']['folder_id']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->schema = $this->item->create($this->schema, $hash['item']);
			if (is_array($hash['parent']) && $hash['parent']['id'] > 0) {
				$this->post['folder_id'] = $hash['parent']['folder_id'];
				$this->post['customer_id'] = $hash['parent']['id'];
				$this->post['customer_type'] = $hash['parent']['customer_type'];
				if ($hash['parent']['customer_type'] == 1) {
					$this->post['customer_name'] = $hash['parent']['customer_company'];
				} else {
					$this->post['customer_name'] = $hash['parent']['customer_name'];
				}
			} else {
				$this->error[] = '顧客情報を取得できません。';
			}
			$this->validateSchema('insert');
			$this->insertPost();
			$this->redirect('customer.php'.$this->parameter(array('parent'=>$hash['parent']['id'])));
			$hash['data'] = $this->post;
		}
		return $hash;
	
	}
	
	function edit() {
	
		$hash['data'] = $this->findView();
		$hash += $this->permitParent($hash['data']['customer_id'], 'add');
		$hash['item'] = $this->item->findItem('history', $hash['data']['folder_id']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->schema = $this->item->create($this->schema, $hash['item']);
			$this->validateSchema('update');
			$relocate = $this->fetchOne("SELECT customer_name FROM ".DB_PREFIX."customer WHERE id = ".intval($this->post['customer_id'])); 
			$this->post['customer_name'] = $relocate['customer_name'];
			$this->updatePost();
			$this->redirect('customer.php'.$this->parameter(array('parent'=>$hash['data']['customer_id'])));
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function delete() {
	
		$hash['data'] = $this->findView();
		$hash += $this->permitParent($hash['data']['customer_id']);
		$hash['item'] = $this->item->findItem('history', $hash['data']['folder_id']);
		$this->deletePost();
		$this->redirect('customer.php'.$this->parameter(array('parent'=>$hash['data']['customer_id'])));
		$hash += $this->findUser($hash['data']);
		return $hash;

	}

	function permitParent($id, $level = 'public') {
		
		$hash['parent'] = $this->fetchOne("SELECT * FROM ".DB_PREFIX."customer WHERE id = ".intval($id));
		if (is_array($hash['parent']) && count($hash['parent']) > 0) {
			$hash += $this->permitCategory('customer', $hash['parent']['folder_id'], $level);
		} else {
			$this->error[] = '顧客情報が取得できません。';
		}
		return $hash;

	}
	
	function csv() {
		
		$hash = $this->permitParent($_GET['parent']);
		if ($_GET['parent'] > 0) {
			$this->where[] = "(customer_id = ".intval($hash['parent']['id']).")";
			$folder = $hash['parent']['folder_id'];
			if ($hash['parent']['customer_type'] == 1) {
				$array[] = array('会社名', $hash['parent']['customer_company']);
				$array[] = array('部署', $hash['parent']['customer_department']);
				$array[] = array('担当者', $hash['parent']['customer_name']);
			} else {
				$array[] = array('名前', $hash['parent']['customer_name']);
			}
			$array[] = array('郵便番号', $hash['parent']['customer_postcode']);
			$array[] = array('住所', $hash['parent']['customer_address']);
			$array[] = array('電話番号', $hash['parent']['customer_phone']);
			$array[] = array('メールアドレス', $hash['parent']['customer_email']);
			$array[] = array();
		} else {
			$this->where[] = $this->folderWhere($hash['folder']);
			$this->where[] = "(customer_type = ".intval($_GET['type']).")";
			$folder = intval($_GET['folder']);
			if ($_GET['type'] == 1) {
				$field = array('customer_name'=>'会社名');
			} else {
				$field = array('customer_name'=>'名前');
			}
		}
		$data = $this->findAll('id', 1);
		$item = $this->item->findItem('history', $folder);
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $row) {
				$field[$row['item_field']] = $row['item_caption'];
			}
		}
		$this->exportcsv($data, $field, 'history'.date('Ymd').'.csv', $array);
		
	}
	
	function config() {
	
		$hash = $this->item->add('history', 'index.php'.$this->parameter(array('folder'=>$_GET['folder'])));
		$this->error = $this->item->error;
		return $hash;
	
	}

}

?>