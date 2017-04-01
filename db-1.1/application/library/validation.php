<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class Validation {
	
	function notnull($string, $caption) {
	
		if (strlen($string) <= 0) {
			return $caption.'を入力してください。';
		}
		
	}
	
	function notsymbol($string, $caption) {
	
		if (preg_match('/[!#\$%&\?"\'~|`=+*<>\^@:;\/\\\(\)\[\]\{\}]+/', $string)) {
			return $caption.'に使用できない記号が含まれます。';
		}
		
	}
	
	function zenkaku($string, $caption) {
	
		if (strlen($string) > 0 && preg_match("/(?:\xEF\xBD[\xA1-\xBF]|\xEF\xBE[\x80-\x9F])|[\x20-\x7E]/", $string)) {
			return $caption.'は全角で入力して下さい。';
		}
		
	}

	function numeric($string, $caption) {
	
		if (!preg_match('/^[0-9]*$/', $string)) {
			return $caption.'は半角数字で入力してください。';
		}
		
	}
	
	function hizuke($string, $caption) {
	
		if (strlen($string) > 0 && !strptime($string, '%Y/%m/%d')) { 
			return $caption.'は[yyyy/mm/dd]フォーマットで正しい日付を入力してください。';
		}
		
	}
	
	function phone($string, $caption) {
	
		if (!preg_match('/^[-0-9]*$/', $string)) {
			return $caption.'は半角数字、-(ハイフン)で入力してください。';
		}
		
	}
	
	function postcode($string, $caption) {
	
		if (!preg_match('/^[-0-9]*$/', $string)) {
			return $caption.'は半角数字、-(ハイフン)で入力してください。';
		}
		
	}
	
	function email($string, $caption) {
	
		if (strlen($string) > 0 && !preg_match('/^[-_a-zA-Z0-9\.!#$%&()=\^~<>?]+@[-_a-zA-Z0-9\.!#$%&()=\^~<>?]+\.[a-zA-Z]+$/', $string)) {
			return $caption.'の値が無効です。';
		}
		
	}
	
	function length($string, $caption, $min = 0, $max = 0) {
		
		if ($max <= 0) {
			$max = $min;
			$min = 0;
		}
		if ($min > 0 && (mb_strlen($string) < $min || mb_strlen($string) > $max)) {
			return $caption.'は'.$min.'文字以上'.$max.'文字以下で入力してください。';
		} elseif (mb_strlen($string) > $max) {
			return $caption.'は'.$max.'文字以下で入力してください。';
		}
		
	}
	
	function line($string, $caption, $max = 0) {
	
		$string = str_replace(array("\r\n","\r"), "\n", $string);
		if (substr_count($string, "\n") > $max) {
			return $caption.'は'.$max.'行以下で入力してください。';
		}
		
	}
	
	function alpha($string, $caption) {
	
		if (!preg_match('/^[a-zA-Z]*$/', $string)) {
			return $caption.'は半角英字で入力してください。';
		}
		
	}
	
	function alphaNumeric($string, $caption) {
	
		if (!preg_match('/^[a-zA-Z0-9]*$/', $string)) {
			return $caption.'は半角英数字で入力してください。';
		}
		
	}
	
	function userid($string, $caption) {
	
		if (!preg_match('/^[-_\.a-zA-Z0-9]*$/', $string)) {
			return $caption.'は半角英数字、-(ハイフン)、_(アンダーバー)、.(ドット)で入力してください。';
		}
		
	}
	
	function url($string, $caption) {
	
		if (strlen($string) > 0 && !preg_match('/^(https?):\/\/[-_a-zA-Z0-9.!~*\'();\/?:@&=+$,%#]+$/', $string)) {
			return $caption.'の値が無効です。';
		}
		
	}
	
	function range($string, $caption, $min = 0, $max = 0) {
	
		if ($string < $min || $string > $max) {
			return $caption.'は'.$min.'以上'.$max.'以下で入力してください。';
		}
		
	}

}
?>