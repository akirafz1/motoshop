<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('車両削除');
$current[intval($hash['parent']['customer_type'])] = ' class="current"';
$liquid = new Liquid;
?>
<div class="contentcontrol">
	<h1>車両削除</h1>
	<table class="customertype" cellspacing="0"><tr>
		<td><a<?=$current[0]?> href="index.php">・</a></td>
<!--		<td><a<?=$current[1]?> href="index.php?type=1">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
	<li><a href="customer.php<?=$view->parameter(array('parent'=>$hash['parent']['id']))?>">車両一覧に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記の車両を削除します。')?>
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
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='customer.php<?=$view->positive(array('parent'=>$hash['parent']['id']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>