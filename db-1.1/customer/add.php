<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('postcode.js');
$view->heading('顧客追加');
$hash['data']['folder_id'] = $view->initialize($hash['data']['folder_id'], $_GET['folder']);
$hash['folder'] = array('&nbsp;') + $hash['folder'];
if ($hash['data']['customer_parent'] > 0) {
	$belong = $helper->checkbox('customer_parent', intval($hash['data']['customer_parent']), intval($hash['data']['customer_parent']), 'customer_parent', 'リンク');
}
$liquid = new Liquid;

if ($_GET['b_url'] == '1' || !isset($_SESSION['backurl'])) {
	$_SESSION['backurl'] = $_SERVER['HTTP_REFERER'];
}
?>
<div class="contentcontrol">
	<h1>顧客追加</h1>
	<table class="customertype" cellspacing="0"><tr>
		<td><a class="current" href="index.php">・</a></td>
<!--		<td><a href="company.php">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
<?php
if (isset($_GET['id'])) {
	echo '<li><a href="#" onclick="history.back(); return false;">前の画面に戻る</a></li>';
} else {
	echo '<li><a href="'.$_SESSION['backurl'].'">前の画面に戻る</a></li>';
}
?>
</ul>
<form class="content" method="post" name="customer" action="">
	<?=$view->error($hash['error'])?>
	<table class="form" cellspacing="0">
		<tr><th>名前<span class="necessary">(必須)</span></th><td><input type="text" name="customer_name" class="inputvalue" value="<?=$hash['data']['customer_name']?>" />&nbsp;[全角]</td></tr>
		<tr><th>かな</th><td>
		<input type="text" name="customer_ruby" class="inputvalue" value="<?=$hash['data']['customer_ruby']?>" />&nbsp;[全角]</td></tr>
		<tr><th>郵便番号</th><td>
			<input type="text" name="customer_postcode" id="postcode" class="inputalpha" value="<?=$hash['data']['customer_postcode']?>" />&nbsp;
			<input type="button" value="検索" onclick="Postcode.feed(this)" />
		</td></tr>
		<tr><th>住所</th><td>
			<input type="text" name="customer_address" id="address" class="inputtitle" value="<?=$hash['data']['customer_address']?>" />&nbsp;[全角]
			<input type="button" value="検索" onclick="Postcode.feed(this, 'address')" />
		</td></tr>
		<tr><th>住所２</th><td><input type="text" name="customer_addressruby" id="addressruby" class="inputtitle" value="<?=$hash['data']['customer_addressruby']?>" />&nbsp;[全角]</td></tr>
		<tr><th>電話番号</th><td><input type="text" name="customer_phone" class="inputalpha" value="<?=$hash['data']['customer_phone']?>" /></td></tr>
		<tr><th>FAX</th><td><input type="text" name="customer_fax" class="inputalpha" value="<?=$hash['data']['customer_fax']?>" /></td></tr>
		<tr><th>携帯電話番号</th><td><input type="text" name="customer_mobile" class="inputalpha" value="<?=$hash['data']['customer_mobile']?>" /></td></tr>
		<tr><th>メールアドレス</th><td><input type="text" name="customer_email" class="inputvalue" value="<?=$hash['data']['customer_email']?>" /></td></tr>
		<tr><th>会社名</th><td>
			<input type="text" name="customer_company" class="inputvalue" value="<?=$hash['data']['customer_company']?>" />&nbsp;
<!--
			<input type="button" value="検索" onclick="Customer.companylist(this)" />&nbsp;<span id="belong"><?=$belong?></span>
-->
		</td></tr>
		<tr><th>会社名（かな）</th><td><input type="text" name="customer_companyruby" class="inputvalue" value="<?=$hash['data']['customer_companyruby']?>" /></td></tr>
		<tr><th>会社TEL</th><td><input type="text" name="customer_workphone" id="customer_workphone" class="inputalpha" value="<?=$hash['data']['customer_workphone']?>" /></td></tr>
		<tr><th>登録名/代表者名</th><td><input type="text" name="customer_workceo" id="customer_workceo" class="inputvalue" value="<?=$hash['data']['customer_workceo']?>" />&nbsp;[全角]</td></tr>
		<tr><th>登録住所</th><td><input type="text" name="customer_regadd" id="customer_regadd" class="inputtitle" value="<?=$hash['data']['customer_regadd']?>" />&nbsp;[全角]</td></tr>
		<tr><th>生年月日</th><td><input type="text" name="customer_birthday" id="customer_birthday" class="inputalpha" value="<?=$hash['data']['customer_birthday']?>" />&nbsp;[yyyy/mm/dd]</td></tr>
		<tr><th>備考</th><td><textarea name="customer_comment" class="inputcomment" rows="5"><?=$hash['data']['customer_comment']?></textarea></td></tr>
		<tr><th>カテゴリ</th><td><?=$helper->selector('folder_id', $hash['folder'], $hash['data']['folder_id'])?></td></tr>
	</table>
	<div class="submit">
		<input type="submit" value="　追加　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->parameter(array('folder'=>$_GET['folder']))?>'" />
	</div>
	<input type="hidden" name="customer_type" value="0" />
</form>
<?php
$view->footing();
?>