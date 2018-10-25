<?php
/**
 * Plugin Name: ColorMeShop Wordpress Plugin
 * Plugin URI: https://github.com/pepabo/colormeshop-wp-plugin
 * Description: カラーミーショップ Wordpress プラグインはWordpressでオンラインショップを構築することができるプラグインです。商品管理やショッピングカートの機能はカラーミーショップを利用することで、本格的なオンラインショップ構築をWordpressで行うことができます。
 * Version: 1.0.2
 * Author: GMO Pepabo, Inc.
 * Author URI: https://pepabo.com/
 * License: GPL2
 */
if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
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
		カラーミーショップ Wordpress プラグインは PHP5.6 以上が必要ですが、ご利用中のバージョンは <strong>{$v}</strong> です。<br />
		現在、プラグインは動作を停止していますので、PHP のアップデート後に再度プラグインを有効化してください。<br />
		ご利用お待ちしています！
	</p>
</div>
__EOS__;

}
