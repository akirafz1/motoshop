<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
require_once('../application/loader.php');
$view->script('postcode.js');
$view->heading('顧客情報削除');
if ($hash['data']['customer_parent'] > 0) {
	$hash['data']['customer_company'] = sprintf('<a href="companyview.php?id=%d">%s</a>', $hash['data']['customer_parent'], $hash['data']['customer_company']);
}
$liquid = new Liquid;
?>
<div class="contentcontrol">
	<h1>顧客情報削除</h1>
	<table class="customertype" cellspacing="0"><tr>
		<td><a class="current" href="index.php">・</a></td>
<!--		<td><a href="company.php">法人</a></td>  -->
	</tr></table>
	<div class="clearer"></div>
</div>
<ul class="operate">
	<li><a href="#" onclick="history.back(); return false;">前の画面に戻る</a></li>
</ul>
<form class="content" method="post" action="">
	<?=$view->error($hash['error'], '下記の顧客情報を削除します。')?>
	<table class="view" cellspacing="0">
		<tr><th>名前</th><td><?=$hash['data']['customer_name']?>&nbsp;</td></tr>
		<tr><th>かな</th><td><?=$hash['data']['customer_ruby']?>&nbsp;</td></tr>
		<tr><th>郵便番号</th><td><?=$hash['data']['customer_postcode']?>&nbsp;</td></tr>
		<tr><th>住所</th><td><?=$hash['data']['customer_address']?>&nbsp;</td></tr>
		<tr><th>住所２</th><td><?=$hash['data']['customer_addressruby']?>&nbsp;</td></tr>
		<tr><th>電話番号</th><td><?=$hash['data']['customer_phone']?>&nbsp;</td></tr>
		<tr><th>電話番号２</th><td><?=$hash['data']['customer_fax']?>&nbsp;</td></tr>
		<tr><th>携帯電話番号</th><td><?=$hash['data']['customer_mobile']?>&nbsp;</td></tr>
		<tr><th>メールアドレス</th><td><?=$hash['data']['customer_email']?>&nbsp;</td></tr>
		<tr><th>会社名</th><td><?=$hash['data']['customer_company']?><?=$hash['data']['customer_companyview']?>&nbsp;</td></tr>
		<tr><th>会社名（かな）</th><td><?=$hash['data']['customer_companyruby']?>&nbsp;</td></tr>
		<tr><th>会社TEL</th><td><?=$hash['data']['customer_workphone']?>&nbsp;</td></tr>
		<tr><th>担当者名</th><td><?=$hash['data']['customer_workstaff']?>&nbsp;</td></tr>
		<tr><th>登録名/代表者名</th><td><?=$hash['data']['customer_workceo']?>&nbsp;</td></tr>
		<tr><th>登録住所</th><td><?=$hash['data']['customer_regadd']?>&nbsp;</td></tr>
		<tr><th>生年月日</th><td><?=$hash['data']['customer_birthday']?>&nbsp;</td></tr>
		<?=$liquid->view($hash['item'], $hash['data'])?>
		<tr><th>備考</th><td><?=nl2br($hash['data']['customer_comment'])?>&nbsp;</td></tr>
		<tr><th>カテゴリ</th><td><?=$hash['folder'][$hash['data']['folder_id']]?>&nbsp;</td></tr>
	</table>
	<?=$view->property($hash['data'])?>
	<div class="submit">
		<input type="submit" value="　削除　" />&nbsp;
		<input type="button" value="キャンセル" onclick="location.href='index.php<?=$view->positive(array('folder'=>$hash['data']['folder_id']))?>'" />
	</div>
	<input type="hidden" name="id" value="<?=$hash['data']['id']?>" />
</form>
<?php
$view->footing();
?>