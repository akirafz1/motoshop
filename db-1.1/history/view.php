<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('車両詳細');
$current[intval($hash['parent']['customer_type'])] = ' class="current"';
$liquid = new Liquid;

if ($_GET['b_url'] == '1' || !isset($_SESSION['backurl'])) {
	$_SESSION['backurl'] = $_SERVER['HTTP_REFERER'];
}
?>
<div class="contentcontrol">
	<h1>車両詳細</h1>
	<table class="customertype" cellspacing="0"><tr>
		<td><a<?=$current[0]?> href="index.php">・</a></td>
<!--		<td><a<?=$current[1]?> href="index.php?type=1">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
<li><a href="<?=$_SESSION['backurl']?>">前の画面に戻る</a></li>

<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="edit.php?id='.$hash['data']['id'].'">編集</a></li>';
	if ($view->authorize('administrator', 'manager')) {
		echo '<li><a href="delete.php?id='.$hash['data']['id'].'">削除</a></li>';
	}
}
?>
</ul>
<table class="view" cellspacing="0">
	<tr><th>車両ID</th><td><?=$hash['data']['id']?>&nbsp;</td></tr>
	<tr><th>登録日</th><td><?=$hash['data']['history_adddate']?>&nbsp;</td></tr>
	<tr><th>車名</th><td><?=$hash['data']['history_machine']?>&nbsp;</td></tr>
	<tr><th>車体色</th><td><?=$hash['data']['history_color']?>&nbsp;</td></tr>
	<tr><th>登録番号</th><td><?=$hash['data']['history_regnum']?>&nbsp;</td></tr>
	<tr><th>車体番号</th><td><?=$hash['data']['history_carnum']?>&nbsp;</td></tr>
	<tr><th>登録時状況</th><td><?=$hash['data']['history_newused']?>&nbsp;</td></tr>
	<tr><th>G登録</th><td><?=$hash['data']['history_gnum']?>&nbsp;</td></tr>
	<tr><th>号機番号</th><td><?=$hash['data']['history_gokinum']?>&nbsp;</td></tr>
	<tr><th>車検日</th><td><?=$hash['data']['history_shaken']?>&nbsp;</td></tr>
	<tr><th>任意保険</th><td><?=$hash['data']['history_hoken']?>&nbsp;</td></tr>
	<tr><th>売却日</th><td><?=$hash['data']['history_sell']?>&nbsp;</td></tr>
	<tr><th>備考</th><td><?=$hash['data']['history_comment']?>&nbsp;</td></tr>
</table>
<?php
$view->property($hash['data']);
$view->footing();
?>