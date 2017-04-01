<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Liquid extends Helper {

	function form($item, $data) {
	
		$string = '';
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $row) {
				$string .= '<tr><th>'.$row['item_caption'];
				if ($row['item_null'] == 'notnull') {
					$string .= '<span class="necessary">(必須)</span>';
				}
				$string .= '</th><td>';
				if ($row['item_input'] == 'textarea') {
					if ($row['item_property'] < 2 || $row['item_property'] > 100) {
						$row['item_property'] = 5;
					}
					$string .= '<textarea name="'.$row['item_field'].'" class="inputcomment" rows="'.$row['item_property'].'">'.$data[$row['item_field']].'</textarea>';
				} elseif (in_array($row['item_input'], array('select', 'checkbox', 'radio'))) {
					$array = explode(',', $row['item_property']);
					if (is_array($array) && count($array) > 0) {
						if ($row['item_input'] == 'select') {
							$option = array();
							foreach ($array as $key => $value) {
								$option[$value] = $value;
							}
							$string .= $this->selector($row['item_field'], $option, $data[$row['item_field']]);
						} else {
							foreach ($array as $key => $value) {
								if ($row['item_input'] == 'checkbox') {
									$temporary = explode(',', $data[$row['item_field']]);
									$checked = '';
									if (in_array($value, $temporary)) {
										$checked = $value;
									}
									$string .= $this->checkbox($row['item_field'].'[]', $value, $checked, $row['item_field'].$key, $value).'&nbsp;';
								} elseif ($row['item_input'] == 'radio') {
									$string .= $this->radio($row['item_field'], $value, $data[$row['item_field']], $row['item_field'].$key, $value).'&nbsp;';
								}
							}
						}
					}
				} else {
					if ($row['item_input'] == 'numeric') {
						$class = 'inputnumeric';
					} elseif ($row['item_input'] == 'date') {
						$class = 'inputvalue';
/*
						if (strlen($data[$row['item_field']]) <= 0) {
							$data[$row['item_field']] = date($row['item_property']);
						}
*/
					} else {
						$class = 'inputtitle';
					}
					$string .= '<input type="text" name="'.$row['item_field'].'" class="'.$class.'" value="'.$data[$row['item_field']].'" />';
				}
				$string .= '</td></tr>';
			}
		}
		return $string;
	
	}
	
	function listheader($item, $pagination) {
		
		$string = '';
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $row) {
				if (strlen($row['item_field']) > 0 && strlen($row['item_caption']) > 0 && $row['item_display'] == 1) {
					$string .= '<th>'.$pagination->sortby($row['item_field'], $row['item_caption']).'</th>';
				}
			}
		}
		return $string;
	
	}
	
	function listcontent($item, $data) {
	
		$string = '';
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $row) {
				if (strlen($row['item_field']) > 0 && strlen($row['item_caption']) > 0 && $row['item_display'] == 1) {
					$string .= '<td>'.$data[$row['item_field']].'&nbsp;</td>';
				}
			}
		}
		return $string;
	
	}
	
	function view($item, $data) {
	
		$string = '';
		if (is_array($item) && count($item) > 0) {
			foreach ($item as $row) {
				if ($row['item_input'] == 'textarea') {
					$data[$row['item_field']] = nl2br($data[$row['item_field']]);
				}
				$string .= '<tr><th>'.$row['item_caption'].'</th><td>'.$data[$row['item_field']].'</td></tr>';
			}
		}
		return $string;
	
	}
	
	function configitem($item, $default = 0) {
	
		if (is_array($item) && count($item) > 0) {
			$option = array('text'=>'標準', 'numeric'=>'数字', 'alpha'=>'英字', 'alphanumeric'=>'英数字', 'date'=>'日時', 'textarea'=>'テキストエリア', 'select'=>'セレクトボックス', 'checkbox'=>'チェックボックス', 'radio'=>'ラジオボタン');
			if ($default == 1) {
				$disabled = ' disabled="disabled"';
			}
			foreach ($item as $key => $row) {
				$string = '%s: <input type="text" name="item['.$key.'][item_property]" class="%s" value="'.$row['item_property'].'"'.$disabled.' />';
				if ($row['item_input'] == 'date') {
					$string = sprintf($string, 'フォーマット', 'inputalpha');
				} elseif ($row['item_input'] == 'textarea') {
					$string = sprintf($string, '行数', 'inputnumeric');
				} elseif (in_array($row['item_input'], array('select', 'checkbox', 'radio'))) {
					$string = sprintf($string, '値', 'inputalpha');
				} else {
					$string = '';
				}
?>
				<tr><td><input type="text" name="item[<?=$key?>][item_caption]" class="inputalpha" value="<?=$row['item_caption']?>"<?=$disabled?> /></td>
				<td class="customeriteminput">
					<?=$this->selector('item['.$key.'][item_input]', $option, $row['item_input'], ' onchange="Customer.input(this, '.$key.')"'.$disabled)?>
					<span><?=$string?></span>
				</td>
				<td class="customeritemcheck"><input type="checkbox" name="item[<?=$key?>][item_null]" value="notnull"<?=$this->attribute('checked', $row['item_null'], 'notnull').$disabled?> /></td>
				<td class="customeritemcheck"><input type="checkbox" name="item[<?=$key?>][item_display]" value="1"<?=$this->attribute('checked', $row['item_display'], '1').$disabled?> /></td>
				<td><input type="text" name="item[<?=$key?>][item_order]" class="inputnumeric" value="<?=$row['item_order']?>"<?=$disabled?> /></td></tr>
<?php
			}
		}
	
	}

}

?>