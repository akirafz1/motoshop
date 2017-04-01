<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Category extends ApplicationModel {
	
	function Category() {
		
		$this->authorize('administrator', 'manager', 'editor');
		$this->table = DB_PREFIX.'folder';
		$this->schema = array(
		'folder_type'=>array('分類', 'notnull', 'alphaNumeric', 'except'=>array('search', 'update')),
		'folder_id'=>array('except'=>array('search', 'update')),
		'folder_caption'=>array('カテゴリ名', 'notnull', 'length:100'),
		'folder_name'=>array('fix'=>$_SESSION['realname']),
		'folder_date'=>array('fix'=>date('Y-m-d H:i:s'), 'except'=>array('search', 'update')),
		'folder_order'=>array('順序', 'numeric', 'except'=>array('search')),
		'add_level'=>array('except'=>array('search')),
		'add_group'=>array('except'=>array('search')),
		'add_user'=>array('except'=>array('search')),
		'public_level'=>array('except'=>array('search')),
		'public_group'=>array('except'=>array('search')),
		'public_user'=>array('except'=>array('search')),
		'edit_level'=>array('except'=>array('search')),
		'edit_group'=>array('except'=>array('search')),
		'edit_user'=>array('except'=>array('search')));
		if (isset($_GET['type']) && $_GET['type'] != 'customer') {
			$this->died('URLが無効です。');
		}
		
	}
	
	function validate() {
	
		if (count($this->error) <= 0) {
			$query = "SELECT MAX(folder_id) AS folder_id FROM ".$this->table." WHERE (folder_type = '".$this->quote($_GET['type'])."')".$where;
			$data = $this->fetchOne($query);
			if ($data['folder_id'] > 0) {
				$this->post['folder_id'] = intval($data['folder_id']) + 1;
			} else {
				$this->post['folder_id'] = 1;
			}
		}
	
	}
	
	function index() {
		
		$this->where[] = "(folder_type = '".$this->quote($_GET['type'])."')";
		$hash = $this->permitList('folder_order, folder_id', 0);
		return $hash;
	
	}

	function view() {
	
		$hash['data'] = $this->permitFind();
		$hash += $this->findUser($hash['data']);
		return $hash;

	}
	
	function add() {
		
		$hash['data'] = $this->permitInsert('index.php?type='.$_GET['type']);
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}
	
	function edit() {
		
		$hash['data'] = $this->permitFind('edit');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$this->validateSchema('update');
			$this->permitValidate();
			$this->updatePost();
			$this->redirect('index.php?type='.$hash['data']['folder_type']);
			$this->post['folder_type'] = $hash['data']['folder_type'];
			$hash['data'] = $this->post;
		}
		$hash += $this->findUser($hash['data']);
		return $hash;
	
	}

	function delete() {
	
		$hash['data'] = $this->permitFind('edit');
		$node = $this->fetchCount(DB_PREFIX.$hash['data']['folder_type'], "WHERE folder_id = ".intval($hash['data']['folder_id']), 'id');
		if ($node > 0) {
			$this->error[] = 'データが存在するカテゴリは削除できません。';
		}
		$this->deletePost();
		if ($this->response) {
			$this->response = $this->query("DELETE FROM ".DB_PREFIX."item WHERE (item_type = 'customer' OR item_type = 'history') AND folder_id = ".intval($hash['data']['folder_id']));
		}
		$this->redirect('index.php?type='.$hash['data']['folder_type']);
		$hash += $this->findUser($hash['data']);
		return $hash;

	}

}

?>