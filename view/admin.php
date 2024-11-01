<?php
/**
 * $LastChangedDate: 2010-05-31 07:49:40 -0500 (Mon, 31 May 2010) $
 */
if (count(debug_backtrace()) === 0) exit();
?>
<div class="wrap">
	<div id="icon-options-general" class="icon32"><br /></div>
	<h2>WP-AutoPagerize</h2>
	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="wp-autopagerize" />

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row"><label for="className">取得対象</label></th>
					<td><input type="text" id="className" name="wp-autopagerize[className]" value="<?php echo $className ?>" />
					<p>取得追加する要素をclassセレクタで指定します。指定できるセレクタは一つです。<br />
					例) div.entry</p></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="customInsertPos">要素の挿入位置</label></th>
					<td><input type="text" id="customInsertPos" name="wp-autopagerize[customInsertPos]" value="<?php echo $customInsertPos ?>" />
					<p>取得した要素の挿入位置はデフォルトではページャーの前になりますが、指定要素の前にすることができます。<br />
					指定した要素の前に追加されます。要素はIDでのみ指定することができます。<br />
					div#customInsertPosを指定要素にする場合は下記のように指定します。(#やdivなどは除く)<br />
					例) customInsertPos</p></td>
				</tr>
				<tr valign="top">
					<th scope="row">ページ番号</th>
					<td>
						<fieldset><legend class="hidden">ページ番号</legend>
							<p><input type="radio" value="0" name="wp-autopagerize[pageNumber]" id="pageNumberTrue"<?php if( $pageNumber == '0') echo ' checked="checked"' ?> />
							<label for="pageNumberTrue">あり</label></p>
							<p><input type="radio" value="1" name="wp-autopagerize[pageNumber]" id="pageNumberFalse"<?php if( $pageNumber == '1') echo ' checked="checked"' ?> />
							<label for="pageNumberFalse">なし</label></p>
						</fieldset>
						<p><strong>あり</strong>: 取得要素の前にページ番号を追加する<br />
						<strong>なし</strong>: ページ番号は追加しない</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">タイプ</th>
					<td>
						<fieldset><legend class="hidden">タイプ</legend>
							<p><input type="radio" value="0" name="wp-autopagerize[loadingMethod]" id="autoPagerize"<?php if( $loadingMethod == '0') echo ' checked="checked"' ?> />
							<label for="autoPagerize">AutoPagerize</label></p>
							<p><input type="radio" value="1" name="wp-autopagerize[loadingMethod]" id="buttonPagerize"<?php if( $loadingMethod == '1') echo ' checked="checked"' ?> />
							<label for="buttonPagerize">ButtonPagerize</label></p>
						</fieldset>
						<p><strong>AutoPagerize</strong>: ページャーより下にカーソルをもっていくと自動読み込み<br />
						<strong>ButtonPagerize</strong>: ボタンクリックで次ページの記事一覧を下に追加</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">初期設定</th>
					<td>
						<fieldset><legend class="hidden">初期設定</legend>
							<p><input type="radio" value="0" name="wp-autopagerize[defaultCondition]" id="defaultAuto"<?php if( $defaultCondition == '0') echo ' checked="checked"' ?> />
							<label for="defaultAuto">Auto</label></p>
							<p><input type="radio" value="1" name="wp-autopagerize[defaultCondition]" id="defaultDisabled"<?php if( $defaultCondition == '1') echo ' checked="checked"' ?> />
							<label for="defaultDisabled">Disabled</label></p>
						</fieldset>
						<p><strong>AutoPagerizeのときのみ有効</strong><br />
						Disabledにすると、デフォルトで自動読み込みをしない</p>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="buttonValue">読み込みボタンテキスト</label></th>
					<td><input type="text" id="buttonValue" name="wp-autopagerize[buttonValue]" value="<?php echo $buttonValue ?>" />
					<p><strong>ButtonPagerizeのときのみ有効</strong><br />
					追加読み込みボタンのValue</p></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="next">ページャー次ページ</label></th>
					<td><input type="text" id="next" name="wp-autopagerize[next]" value="<?php echo $next ?>" />
					<p>ページャーの次ページリンクのテキスト</p></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="prev">ページャー前ページ</label></th>
					<td><input type="text" id="prev" name="wp-autopagerize[prev]" value="<?php echo $prev ?>" />
					<p>ページャーの前ページリンクのテキスト</p></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="beforeCall">要素追加前の処理</label></th>
					<td>
						<textarea id="beforeCall" name="wp-autopagerize[beforeCall]" cols="40" rows="5"><?php echo $beforeCall ?></textarea>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="callback">コールバック（要素追加後の処理）</label></th>
					<td>
						<textarea id="callback" name="wp-autopagerize[callback]" cols="40" rows="5"><?php echo $callback ?></textarea>
					</td>
				</tr>
			</tbody>
		</table>

		<p class="submit"><input type="submit" value="変更を保存" class="button-primary" name="Submit" /></p>

	</form>
</div>