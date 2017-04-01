<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('車両');
$pagination = new Pagination(array('parent'=>$_GET['parent']));
$current[intval($hash['parent']['customer_type'])] = ' class="current"';
if ($hash['parent']['customer_type'] == 1) {
	$location = array('company.php', 'companyview.php');
} else {
	$location = array('index.php', 'view.php');
}
$liquid = new Liquid;

if ($_GET['b_url'] == '1' || !isset($_SESSION['backurl'])) {
	$_SESSION['backurl'] = $_SERVER['HTTP_REFERER'];
}

?>
<div class="contentcontrol">
	<h1>車両</h1>
	<table class="customertype" cellspacing="0"><tr>
		<td><a<?=$current[0]?> href="index.php">・</a></td>
<!--		<td><a<?=$current[1]?> href="index.php?type=1">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
<li><a href="<?=$_SESSION['backurl']?>">前の画面に戻る</a></li>
<li><a href="../customer/<?=$location[1]?>?id=<?=intval($_GET['parent'])?>">顧客詳細</a></li>
</ul>
<table class="view" cellspacing="0" style="margin-bottom:20px;">
<?php
if ($hash['parent']['customer_type'] == 1) {
?>
	<tr><th>担当者</th><td><?=$hash['parent']['customer_name']?>&nbsp;</td></tr>
	<tr><th>部署</th><td><?=$hash['parent']['customer_department']?>&nbsp;</td></tr>
<?php
} else {
?>
	<tr><th>顧客ID</th><td><?=$hash['parent']['id']?>&nbsp;</td></tr>
	<tr><th>名前</th><td><?=$hash['parent']['customer_name']?>&nbsp;</td></tr>
<?php
}
?>
	<tr><th>会社名</th><td><?=$hash['parent']['customer_company']?>&nbsp;</td></tr>
	<tr><th>電話番号</th><td><?=$hash['parent']['customer_phone']?>&nbsp;</td></tr>
	<tr><th>携帯番号</th><td><?=$hash['parent']['customer_mobile']?>&nbsp;</td></tr>
	<tr><th>会社TEL</th><td><?=$hash['parent']['customer_workphone']?>&nbsp;</td></tr>
</table>

<ul class="operate">

<?php
if ($view->permitted($hash['category'], 'add')) {
	echo '<li><a href="add.php'.$view->parameter(array('parent'=>$_GET['parent'])).'">車両追加</a></li>';
}
if (count($hash['list']) <= 0) {
	$attribute = ' onclick="alert(\'出力するデータがありません。\');return false;"';
}
?>

<!--
	<li><a href="csv.php<?=$view->parameter(array('sort'=>$_GET['sort'], 'desc'=>$_GET['desc'], 'search'=>$_GET['search'], 'parent'=>$_GET['parent']))?>"<?=$attribute?>>CSV出力</a></li>
-->

<!--
<?php
if ($view->authorize('administrator', 'manager')) {
	echo '<li><a href="config.php?folder='.intval($hash['parent']['folder_id']).'">車両設定</a></li>';
}
?>
-->

</ul>

<!--
<?=$view->searchform(array('parent'=>$_GET['parent']))?>
-->

<table class="list" cellspacing="0">
	<tr>
	<th class="listlink">&nbsp;</th>
	<th><?=$pagination->sortby('id', '車両ID')?></th>
	<th><?=$pagination->sortby('history_adddate', '登録日')?></th>
	<th><?=$pagination->sortby('history_machine', '車名')?></th>
	<th><?=$pagination->sortby('history_color', '車体色')?></th>
	<th><?=$pagination->sortby('history_regnum', '登録番号')?></th>
	<th><?=$pagination->sortby('history_carnum', '車体番号')?></th>
	<th><?=$pagination->sortby('history_gokinum', '号機番号')?></th>
	<th><?=$pagination->sortby('history_sell', '売却日')?></th>
	</tr>
<?php
if (is_array($hash['list']) && count($hash['list']) > 0) {
	foreach ($hash['list'] as $row) {

		if ($row['history_sell'] > 0) {
			$tr_tag = '<tr bgcolor="#cccccc">';
		} else {
			$tr_tag = '<tr>';
		}
		print $tr_tag;
?>
		<td><a href="view.php?id=<?=$row['id']?>">詳細</a></td>
		<td><?=$row['id']?></a>&nbsp;</td>
		<td><?=$row['history_adddate']?>&nbsp;</td>
		<td><?=$row['history_machine']?>&nbsp;</td>
		<td><?=$row['history_color']?>&nbsp;</td>
		<td><?=$row['history_regnum']?>&nbsp;</td>
		<td><?=$row['history_carnum']?>&nbsp;</td>
		<td><?=$row['history_gokinum']?>&nbsp;</td>
		<td><?=$row['history_sell']?>&nbsp;</td>
		</tr>
<?php
	}
}
?>
</table>

<?php
echo $view->pagination($pagination, $hash['count']);
$view->footing();
?>