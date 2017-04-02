<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */

/**
 * 顧客DB基本設定
 */
//顧客DBバージョン
define('APP_VER', 'ver1.7 (2017/3/20)');

//データベース名 = 本番・テスト・開発
//トップ画像 = 本番用・テスト(開発)
$curpath = dirname($_SERVER["SCRIPT_NAME"]);
if (mb_substr($curpath,1,7) == 'db_test') {
	define('DB_DATABASE', 'mskagurazaka_test');
	define('GIF_FILE', 'images/title_test.gif');
} elseif (mb_substr($curpath,1,6) == 'db_dev') {
	define('DB_DATABASE', 'mskagurazaka_dev');
	define('GIF_FILE', 'images/title_test.gif');
} else {
	define('DB_DATABASE', 'mskagurazaka_customer');
	define('GIF_FILE', 'images/title_moto.gif');
}


/**
 * アプリケーション設定
 */
//アプリケーション
define('APP_TYPE', 'customer');


/**
 * 制限設定
 */
//表示件数
define('APP_LIMIT', '20');
//最大表示件数
define('APP_LIMITMAX', '1000');
//アップロードファイル
define('APP_FILESIZE', '10000000');
define('APP_EXTENSION', 'exe');


/**
 * 認証設定
 */
//有効期限
define('APP_EXPIRE', '7200');
//アイドルタイム
define('APP_IDLE', '3600');


/**
 * パス設定
 */
//アプリケーションディレクトリ
define('DIR_PATH', dirname(__FILE__).'/');
//モデルディレクトリ
define('DIR_MODEL', DIR_PATH.'model/');
//ビューディレクトリ
define('DIR_VIEW', DIR_PATH.'view/');
//ライブラリディレクトリ
define('DIR_LIBRARY', DIR_PATH.'library/');
//ファイルディレクトリ
define('DIR_UPLOAD', DIR_PATH.'upload/');


/**
 * データベース設定
 */
//データベースの種類
define('DB_STORAGE', 'mysql');
//データベースのホスト名
define('DB_HOSTNAME', 'mysql63.xserver.jp');

//データベースユーザー名
define('DB_USERNAME', 'mskagurazaka_1');
//データベースパスワード
define('DB_PASSWORD', 'yokodera');
//テーブル接頭辞
define('DB_PREFIX', 'customer_');
//データベースポート番号
define('DB_PORT', '5432');
//データベース文字コード設定
define('DB_CHARSET', false);
//データベースファイル
define('DB_FILE', DIR_PATH.'database/database.sqlite2');
//郵便番号データファイル
define('DB_POSTCODE', DIR_PATH.'database/KEN_ALL.CSV');
?>