<?php
/**
 * Plugin Name: ColorMeShop WordPress Plugin
 * Plugin URI: https://github.com/pepabo/colormeshop-wp-plugin
 * Description: カラーミーショップ WordPress プラグインはWordPressでオンラインショップを構築することができるプラグインです。商品管理やショッピングカートの機能はカラーミーショップを利用することで、本格的なオンラインショップ構築をWordPressで行うことができます。
 * Version: 3.0.1
 * Author: GMO Pepabo, Inc.
 * Author URI: https://pepabo.com/
 * License: GPL2
 */
if ( version_compare( PHP_VERSION, '7.3', '<' ) ) {
	add_action( 'admin_notices', 'colormeshop_wp_plugin_requirements_error' );
	return;
}

require_once( 'vendor/autoload.php' );

$p = new \ColorMeShop\Plugin;
$p->register();

/**
 * 動作条件に満たない場合のエラーメッセージを出力する
 *
 * @return void
 */
function colormeshop_wp_plugin_requirements_error() {
	$v = PHP_VERSION;
	echo <<<__EOS__
<div class="error">
	<p>
		カラーミーショップ WordPress プラグインは PHP7.3 以上が必要ですが、ご利用中のバージョンは <strong>{$v}</strong> です。<br />
		現在、プラグインは動作を停止していますので、PHP のアップデート後に再度プラグインを有効化してください。<br />
		ご利用お待ちしています！
	</p>
</div>
__EOS__;

}
