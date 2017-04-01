<?php
/*
 * Copyright(c) 2009 limitlink,Inc. All Rights Reserved.
 * http://limitlink.jp/
 * 文字コード UTF-8
 */
if ($type == 'public') {
?>
公開する範囲を設定します。<br />
<table cellspacing="0">
<tr><th>公開：</th><td>全員に公開します。</td></tr>
<tr><th>非公開：</th><td>登録者以外には公開されません。</td></tr>
<tr><th>公開するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーのみに公開します。</td></tr>
</table>
<?php
} elseif ($type == 'edit') {
?>
編集する権限を設定します。
<table cellspacing="0">
<tr><th>許可：</th><td>全員が編集できます。</td></tr>
<tr><th>登録者のみ：</th><td>登録者のみが編集できます。</td></tr>
<tr><th>許可するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーが編集できます。</td></tr>
</table>
<?php
} elseif ($type == 'add') {
?>
カテゴリにデータを追加する権限を設定します。
<table cellspacing="0">
<tr><th>許可：</th><td>全員がデータを追加できます。</td></tr>
<tr><th>登録者のみ：</th><td>登録者のみがデータを追加できます。</td></tr>
<tr><th>許可するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーがデータを追加できます。</td></tr>
</table>
<?php
} elseif ($type == 'categorypublic') {
?>
公開する範囲を設定します。
<table cellspacing="0">
<tr><th>公開：</th><td>全員に公開します。</td></tr>
<tr><th>公開するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーのみに公開します。</td></tr>
</table>
<?php
} elseif ($type == 'categoryedit') {
?>
カテゴリの設定を編集する権限を設定します。<br />
許可するユーザーは「編集者」以上の権限が必要です。
<table cellspacing="0">
<tr><th>許可：</th><td>全員が編集できます。</td></tr>
<tr><th>登録者のみ：</th><td>登録者のみが編集できます。</td></tr>
<tr><th>許可するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーが編集できます。</td></tr>
</table>
<?php
} elseif ($type == 'groupadd') {
?>
グループにユーザーを追加する権限を設定します。<br />
許可するユーザーは「マネージャ」以上の権限が必要です。
<table cellspacing="0">
<tr><th>許可：</th><td>全員がユーザーを追加できます。</td></tr>
<tr><th>登録者のみ：</th><td>登録者のみがユーザーを追加できます。</td></tr>
<tr><th>許可するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーがユーザーを追加できます。</td></tr>
</table>
<?php
} elseif ($type == 'groupedit') {
?>
編集する権限を設定します。<br />
許可するユーザーは「管理者」以上の権限が必要です。
<table cellspacing="0">
<tr><th>許可：</th><td>全員が編集できます。</td></tr>
<tr><th>登録者のみ：</th><td>登録者のみが編集できます。</td></tr>
<tr><th>許可するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーが編集できます。</td></tr>
</table>
<?php
} elseif ($type == 'useredit') {
?>
編集する権限を設定します。<br />
許可するユーザーは「マネージャ」以上の権限が必要です。
<table cellspacing="0">
<tr><th>許可：</th><td>全員が編集できます。</td></tr>
<tr><th>登録者のみ：</th><td>登録者のみが編集できます。</td></tr>
<tr><th>許可するグループ・<br />ユーザーを設定：</th>
<td>設定したグループ・ユーザーが編集できます。</td></tr>
</table>
<?php
} elseif ($type == 'userid') {
?>
ユーザーIDに使用できる文字は半角英数字、-(ハイフン)、_(アンダーバー)、.(ドット)です。
<?php
} elseif ($type == 'userpassword') {
?>
パスワードに使用できる文字は4文字以上32文字以下の半角英数字のみです。
<?php
} elseif ($type == 'userauthority') {
?>
ユーザーの権限を設定します。<br />
通常はメンバーに設定し、必要に応じて権限を付与します。
<table cellspacing="0">
<tr><th>メンバー：</th><td>一般のユーザーです。</td></tr>
<tr><th>編集者：</th><td>カテゴリを管理する権限があります。</td></tr>
<tr><th>マネージャ：</th>
<td>編集者の権限に加え、<br />・ユーザーを管理する権限<br />・顧客設定・車両設定をする権限<br />があります。</td></tr>
<tr><th>管理者：</th>
<td>マネージャの権限に加え、<br />・グループを管理する権限<br />があります。</td></tr>
</table>
<?php
} elseif ($type == 'itemcaption') {
?>
項目名を設定します。<br />
項目名を空欄にするとデータが保存されていても表示されません。<br />
「必須」にチェックを入れると必須項目になります。<br />
「一覧表示」にチェックを入れると一覧に表示されます。
<?php
} elseif ($type == 'iteminput') {
?>
データ追加時のフォームを選択します。
<table cellspacing="0">
<tr><th>標準：</th><td>標準のフォームを表示します。</td></tr>
<tr><th>数字：</th><td>半角数字のみ追加できます。</td></tr>
<tr><th>英字：</th><td>半角英字のみ追加できます。</td></tr>
<tr><th>英数字：</th><td>半角英数字のみ追加できます。</td></tr>
<tr><th>日時：</th><td>
フォーマットで指定された形式で自動的に現在の日時をフォームに入力します。<br />
Y：年、m：月、d：日<br />
H：時、i：分、s：秒<br />
</td></tr>
<tr><th>テキストエリア：</th><td>改行が可能なテキストエリアを表示します。</td></tr>
<tr><th>セレクトボックス：</th><td>セレクトボックスを表示します。<br />選択する値は「,(カンマ)」区切りで入力します。</td></tr>
<tr><th>チェックボックス：</th><td>
チェックボックスを表示します。<br />
選択する値は「,(カンマ)」区切りで入力します。<br />
複数項目が選択可能で選択された値は「,(カンマ)」区切りで保存されます。
</td></tr>
<tr><th>ラジオボタン：</th><td>ラジオボタンを表示します。<br />選択する値は「,(カンマ)」区切りで入力します。</td></tr>
</table>
<?php
} elseif ($type == 'itemdefault') {
?>
標準設定は、新しく追加されたカテゴリや項目が設定されていないカテゴリにも適用されます。
<?php
}
?>