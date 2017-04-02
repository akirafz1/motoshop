<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('application/loader.php');
$view->heading('管理画面', 'administration');
?>
<h1>管理画面</h1>
<?php
if (file_exists('setup.php')) {
	echo $view->error($hash['error']);
?>
<form class="content" method="post" action="">
	<input type="submit" value="　削除　" />
</form>
<?php
}
?>
<ul class="itemlink" style="padding-top:20px;">
	<li><a href="user/"><img src="images/arrownext.gif" />ユーザー管理</a></li>
<?php
if ($view->authorize('administrator')) {
	echo '<li><a href="group/"><img src="images/arrownext.gif" />グループ管理</a></li>';
}
?>
	<li><a href="category/?type=customer"><img src="images/arrownext.gif" />カテゴリ管理</a></li>
<!--
	<li><a href="customer/config.php"><img src="images/arrownext.gif" />顧客設定</a></li>
	<li><a href="history/config.php"><img src="images/arrownext.gif" />車両設定</a></li>
-->

<?php
if ($view->authorize('administrator') && file_exists('administration')) {
	echo '<li><a href="administration/"><img src="images/arrownext.gif" />データベース管理</a></li>';
}
?>
</ul>
<?php
$view->footing();
?>