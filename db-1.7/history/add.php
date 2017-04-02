<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->heading('車両追加');
$current[intval($hash['parent']['customer_type'])] = ' class="current"';
$liquid = new Liquid;

$new_status = 'unchecked';
$used_status = 'unchecked';
$mente_status = 'unchecked';
$selected_radio = $hash['data']['history_newused'];

if ($selected_radio == '新車') {
	$new_status = 'checked';
} else if ($selected_radio == '中古') {
	$used_status = 'checked';
} else if ($selected_radio == '整備') {
	$mente_status = 'checked';
}

if (strlen($hash['data']['history_adddate']) <= 0) {
	$new_date = date('Y/m/d');
} else {
	$new_date = $hash['data']['history_adddate'];
}
?>
<div class="contentcontrol">
	<h1>車両追加</h1>
	<table class="customertype" cellspacing="0"><tr>
<!--		<td><a<?=$current[0]?> href="index.php">・</a></td>
		<td><a<?=$current[1]?> href="index.php?type=1">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
	<li><a href="customer.php<?=$view->parameter(array('parent'=>$_GET['parent']))?>">車両に戻る</a></li>
</ul>
<form class="content" method="post" name="history" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>登録日</th>
		<td><input type="text" name="history_adddate" class="inputalpha" value="<?php print $new_date; ?>" />&nbsp;[yyyy/mm/dd]</td></tr>
		<tr><th>車名</th>
		<td><input type="text" name="history_machine" class="inputvalue" value="<?=$hash['data']['history_machine']?>" /></td></tr>
		<tr><th>車体色</th>
		<td><input type="text" name="history_color" class="inputvalue" value="<?=$hash['data']['history_color']?>" /></td></tr>
		<tr><th>登録番号</th>
		<td><input type="text" name="history_regnum" class="inputvalue" value="<?=$hash['data']['history_regnum']?>" /></td></tr>
		<tr><th>車体番号</th>
		<td><input type="text" name="history_carnum" class="inputvalue" value="<?=$hash['data']['history_carnum']?>" /></td></tr>
		<tr><th>登録時状況</th><td>
		<input type="radio" name="history_newused" id="history_newused0" value="新車" <?php print $new_status; ?> />
		<label for="history_newused0">新車</label>&nbsp;
		<input type="radio" name="history_newused" id="history_newused1" value="中古" <?php print $used_status; ?> />
		<label for="history_newused1">中古</label>&nbsp;
		<input type="radio" name="history_newused" id="history_newused2" value="整備" <?php print $mente_status; ?> />
		<label for="history_newused2">整備</label>&nbsp;</td></tr>
		<tr><th>G登録</th>
		<td><input type="text" name="history_gnum" class="inputvalue" value="<?=$hash['data']['history_gnum']?>" /></td></tr>
		<tr><th>号機番号</th>
		<td><input type="text" name="history_gokinum" class="inputvalue" value="<?=$hash['data']['history_gokinum']?>" /></td></tr>
		<tr><th>車検日</th>
		<td><input type="text" name="history_shaken" class="inputalpha" value="<?=$hash['data']['history_shaken']?>" />&nbsp;[yyyy/mm/dd]</td></tr>
		<tr><th>任意保険</th>
		<td><input type="text" name="history_hoken" class="inputvalue" value="<?=$hash['data']['history_hoken']?>" /></td></tr>
		<tr><th>売却日</th>
		<td><input type="text" name="history_sell" class="inputalpha" value="<?=$hash['data']['history_sell']?>" />&nbsp;[yyyy/mm/dd]</td></tr>
		<tr><th>備考</th>
		<td><input type="text" name="history_comment" class="inputvalue" value="<?=$hash['data']['history_comment']?>" /></td>
		</tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='customer.php<?=$view->parameter(array('parent'=>$_GET['parent']))?>'" />
	</div>
</form>
<?php
$view->footing();
?>