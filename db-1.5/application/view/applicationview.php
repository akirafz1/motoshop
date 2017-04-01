<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class ApplicationView extends View {

	var $group = array();
	var $user = array();
	
	function ApplicationView($hash = null) {
	
		if (is_array($hash['group'])) {
			$this->group = $hash['group'];
		}
		if (is_array($hash['user'])) {
			$this->user = $hash['user'];
		}
	
	}
	
	function authorize() {
		
		$authorized = false;
		$argument = func_get_args();
		if (is_array($argument) && count($argument) > 0) {
			foreach ($argument as $value) {
				if (strlen($value) > 0 && $value === $_SESSION['authority']) {
					$authorized = true;
				}
			}
		}
		return $authorized;
	
	}
	
	function permitted($data, $level = 'public') {
		
		$permission = false;
		if ($data[$level.'_level'] == 0) {
			$permission = true;
		} elseif (strlen($data['owner']) > 0 && $data['owner'] == $_SESSION['userid']) {
			$permission = true;
		} elseif ($data[$level.'_level'] == 2 && (stristr($data[$level.'_group'], '['.$_SESSION['group'].']') || stristr($data[$level.'_user'], '['.$_SESSION['userid'].']'))) {
			$permission = true;
		}
		return $permission;
	
	}
	
	function permit($data, $level = 'public', $option = null, $type = '') {
		
		if (!is_array($option)) {
			if ($level == 'public') {
				$option = array('公開', '非公開', '公開するグループ・ユーザーを設定');
			} else {
				$option = array('許可', '登録者のみ', '許可するグループ・ユーザーを設定');
			}
		}
		$selected[intval($data[$level.'_level'])] = ' selected="selected"';
		foreach ($option as $key => $value) {
			$string .= '<option value="'.$key.'"'.$selected[$key].'>'.$value.'</option>';
		}
		if ($data[$level.'_level'] == 2) {
			$style = ' style="display:inline"';
		} else {
			$style = ' style="display:none"';
		}
		if ($type == 1) {
			$type = ', 1';
		} else {
			$type = '';
		}
		echo '<select name="'.$level.'_level" onchange="App.permitlevel(this, \''.$level.'\''.$type.')">'.$string.'</select>&nbsp;';
		echo '<span class="operator" id="'.$level.'search" onclick="App.permitlevel(this, \''.$level.'\''.$type.')"'.$style.'>検索</span>';
		echo $this->permitParse($level, 'group', $data);
		echo $this->permitParse($level, 'user', $data);
		
	}
	
	function permitParse($level, $type, $data) {
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$array = $_POST[$level][$type];
		} elseif (strlen($data[$level.'_'.$type]) > 0) {
			$data = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $data[$level.'_'.$type]));
			if (is_array($data) && count($data) > 0) {
				$list = $this->$type;
				foreach ($data as $key) {
					$array[$key] = $list[$key];
				}
			}
		}
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $key => $value) {
				$id = $level.$type.$key;
				$string .= '<div><input type="checkbox" name="'.$level.'['.$type.']['.$key.']"';
				$string .= ' id="'.$id.'" value="'.$value.'" checked="checked" />';
				$string .= '<label for="'.$id.'">'.$value.'</label></div>';
			}
		}
		return $string;
	
	}
	
	function property($data) {
		
		if ($data['owner'] && $data['created']) {
			$created = '&nbsp;('.date('Y/m/d H:i:s', strtotime($data['created'])).')';
			if (strlen($this->user[$data['editor']]) > 0) {
				$string .= '<tr><td>編集者：</td><td>'.$this->user[$data['editor']].'&nbsp;('.date('Y/m/d H:i:s', strtotime($data['updated'])).')</td></tr>';
			}
			if (strlen($data['public_level']) > 0) {
				$public = array('公開', '非公開');
				if ($data['public_level'] == 2) {
					$public[2] = $this->permitlist($data, 'public');
				}
				$string .= '<tr><td>公開設定：</td><td>'.$public[$data['public_level']].'&nbsp;</td></tr>';
			}
			if (strlen($data['edit_level']) > 0) {
				$edit = array('許可', '登録者のみ');
				if ($data['edit_level'] == 2) {
					$edit[2] = $this->permitlist($data, 'edit');
				}
				$string .= '<tr><td>編集設定：</td><td>'.$edit[$data['edit_level']].'&nbsp;</td></tr>';
			}
			echo '<table class="property" cellspacing="0"><tr><td>登録者：</td><td>';
			echo $this->user[$data['owner']].$created.'</td></tr>';
			echo $string.'</table>';
		}

	}
	
	function permitlist($data, $level = 'public') {
	
		if ($data[$level.'_level'] == 2) {
			$result = $this->enumerate($data[$level.'_group'], $this->group);
			if (strlen($result) > 0) {
				$result .= '&nbsp;';
			}
			$result .= $this->enumerate($data[$level.'_user'], $this->user);
			return $result;
		}

	}
	
	function enumerate($string, $list, $separator = '&nbsp;') {
		
		if (strlen($string) > 0 && is_array($list)) {
			$result = array();
			$array = explode(',', str_replace(array('][', '[', ']'), array(',', '', ''), $string));
			if (is_array($array) && count($array) > 0) {
				foreach ($array as $value) {
					if (array_key_exists($value, $list)) {
						$result[] = $list[$value];
					}
				}
			}
			return implode($separator, $result);
		}
		
	}
	
	function searchformime($parameter = null) {
		
		$string = '<form method="get" class="searchform" action="';
		$string .= $_SERVER['SCRIPT_NAME'].$this->parameter($parameter);
		$string .= '"><input type="text" name="search" id="search" class="inputsearch" value="';
		$string .= $this->escape($_REQUEST['search']);
		$string .= '" style="ime-mode: active;"/><input type="submit" value="検索" /></form>';
		return $string;
		
	}
	
	function searchform($parameter = null) {
		
		$string = '<form method="get" class="searchform" action="';
		$string .= $_SERVER['SCRIPT_NAME'].$this->parameter($parameter);
		$string .= '"><input type="text" name="search" id="search" class="inputsearch" value="';
		$string .= $this->escape($_REQUEST['search']);
		$string .= '" style="ime-mode: inactive;"/><input type="submit" value="検索" /></form>';
		return $string;
		
	}
	
	function category($folderlist, $type, $url = 'index.php', $default = null) {
		
		if ($_GET['folder'] == 'all') {
			$current['all'] = ' class="current"';
		} else {
			$current[intval($_GET['folder'])] = ' class="current"';
		}
		if (!is_array($default)) {
			$default = array(0=>'既存顧客', 'all'=>'すべて表示');
		}
		echo '<div class="folder"><div class="foldercaption">カテゴリ</div><ul class="folderlist">';
		if (strlen($default[0]) > 0) {
			echo '<li'.$current[0].'><a href="'.$url.'">'.$default[0].'</a></li>';
		}
		if (is_array($folderlist) && count($folderlist) > 0) {
			foreach ($folderlist as $key => $value) {
				echo '<li'.$current[$key].'><a href="'.$url.'?folder='.$key.'">'.$value.'</a></li>';
			}
		}
		if (strlen($default['all']) > 0) {
			echo '<li'.$current['all'].'><a href="'.$url.'?folder=all">'.$default['all'].'</a></li>';
		}
		echo '</ul>';
		if ($this->authorize('administrator', 'manager', 'editor')) {
			echo '<div class="folderoperate"><a href="../category/?type='.$type.'">編集</a></div>';
		}
		echo '</div>';
		
	}
	
	function caption($folderlist, $array = null, $string = '') {
		
		if (strlen($_GET['folder']) > 0) {
			if (is_array($folderlist) && strlen($folderlist[$_GET['folder']]) > 0) {
				$string = ' - '.$folderlist[$_GET['folder']];
			} elseif (is_array($array) && strlen($array[$_GET['folder']]) > 0) {
				$string = ' - '.$array[$_GET['folder']];
			}
		}
		return $string;
		
	}
	
	function explain($type) {
		
		if (!file_exists('application')) {
			$root = '../';
		}
		echo '<img class="explain" src="'.$root.'images/explain.gif" onclick="App.explain(this)" />';
		echo '<div class="explanation">';
		require(DIR_VIEW.'explain.php');
		echo '<div class="explanationclose"><span class="operator">[閉じる]</span></div></div>';
	
	}

}

?>