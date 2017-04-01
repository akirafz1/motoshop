<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('postcode.js');
$view->heading('顧客情報');
$pagination = new Pagination(array('folder'=>$_GET['folder']));
$liquid = new Liquid;
$_SESSION['backurl'] = '';
$_SESSION['backurl2'] = '';
?>
<div class="contentcontrol">
	<h1>車両一覧・検索<?=$view->caption($hash['folder'], array('all'=>'すべて表示'))?></h1>
	<table class="customertype" cellspacing="0"><tr>
<!--		<td><a class="current" href="index.php">・</a></td>
		<td><a href="company.php">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
<?php
if ($view->permitted($hash['category'], 'add')) {
//	echo '<li><a href="add.php'.$view->parameter(array('folder'=>$_GET['folder'])).'">顧客追加</a></li>';
}
if (count($hash['list']) <= 0) {
	$attribute = ' onclick="alert(\'出力するデータがありません。\');return false;"';
}
?>

<!--
	<li><a href="csv.php<?=$view->parameter(array('sort'=>$_GET['sort'], 'desc'=>$_GET['desc'], 'search'=>$_GET['search'], 'jufuku'=>$_GET['jufuku'], 'folder'=>$_GET['folder'], 'type'=>0))?>"<?=$attribute?>>CSV出力</a></li>
-->

<?php
if ($view->authorize('administrator', 'manager')) {
//	echo '<li><a href="config.php?folder='.intval($_GET['folder']).'">顧客設定</a></li>';
}
?>

</ul>
<?=$view->searchform(array('folder'=>$_GET['folder']))?>
<table class="content" cellspacing="0"><tr><td class="contentfolder">
	<?=$view->category($hash['folder'], 'customer')?>
	</td><td>
	<table class="list" cellspacing="0">
		<tr>
		<th><?=$pagination->sortby('customer_id', '顧客ID')?></th>
		<th><?=$pagination->sortby('customer_name', '名前')?></th>
<!--		<th><?=$pagination->sortby('id', '車両ID')?></th> -->
		<th><?=$pagination->sortby('history_adddate', '登録日')?></th>
		<th><?=$pagination->sortby('history_machine', '車名')?></th>
		<th><?=$pagination->sortby('history_color', '車体色')?></th>
		<th><?=$pagination->sortby('history_regnum', '登録番号')?></th>
		<th><?=$pagination->sortby('history_carnum', '車体番号')?></th>
		<th><?=$pagination->sortby('history_gokinum', '号機番号')?></th>
		<th><?=$pagination->sortby('history_shaken', '車検日')?></th>
		</tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {
?>
		<tr>
		<td><?=$row['customer_id']?>&nbsp;</td>
		<td><a href="../history/customer.php?parent=<?=$row['customer_id']?>&b_url=1"><?=$row['customer_name']?></a>&nbsp;</td>
<!--		<td><?=$row['id']?>&nbsp;</td> -->
		<td><?=$row['history_adddate']?>&nbsp;</td>
		<td><a href="../history/view.php?id=<?=$row['id']?>&b_url=2"><?=$row['history_machine']?></a>&nbsp;</td>
		<td><?=$row['history_color']?>&nbsp;</td>
		<td><?=$row['history_regnum']?>&nbsp;</td>
		<td><?=$row['history_carnum']?>&nbsp;</td>
		<td><?=$row['history_gokinum']?>&nbsp;</td>
		<td><?=$row['history_shaken']?>&nbsp;</td>
		</tr>
<?php
	}
}
?>
	</table>
	<?=$view->pagination($pagination, $hash['count'])?>
	</td></tr>
</table>

<?php
$view->footing();
?>