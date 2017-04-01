<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
if ($_SESSION['realname']) {
	$realname = $this->escape($_SESSION['realname']).'さん';
}
if ($this->authorize('administrator', 'manager')) {
	$administration = '<a'.$current['administration'].' href="'.$root.'administration.php">管理画面</a>';
}
?>
<div class="header">
	<div class="headertitle">
		<a href="<?=$root?>index.php"><img src="<?=$root.GIF_FILE?>" /></a>
	</div>
	<div class="headerright">
		<a href="<?=$root?>customer/"><?=$realname?></a><?=$administration?>
		<a href="<?=$root?>logout.php">ログアウト</a>
	</div>
	<div class="control">
		<table cellspacing="0"><tr>
			<td<?=$current['customer']?>><a href="<?=$root?>customer/">顧客検索</a></td>
			<td<?=$current['history']?>><a href="<?=$root?>history/">車両検索</a></td>
		</tr></table>
	</div>
</div>
<div class="container">