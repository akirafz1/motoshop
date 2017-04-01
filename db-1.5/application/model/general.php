<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

class General extends ApplicationModel {
	
	function administration() {
	
		$this->authorize('administrator', 'manager');
		if (file_exists('setup.php')) {
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				if (is_writable('setup.php')) {
					if (@unlink('setup.php') == false) {
						$this->error[] = 'セットアップファイルの削除に失敗しました。';
					}
				} else {
					$this->error[] = 'セットアップファイルに書き込み権限がありません。<br />削除に失敗しました。';
				}
			} else {
				$this->error[] = 'セットアップファイル(setup.php)が存在します。<br />削除してください。';
			}
		}
	
	}

}

?>