<?php
/**
 * PHPUnit bootstrap file
 *
 * @package Colormeshop_Wp_Plugin
 */

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

// Give access to tests_add_filter() function.
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require dirname( dirname( __FILE__ ) ) . '/colormeshop-wp-plugin.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

// Start up the WP testing environment.
require $_tests_dir . '/includes/bootstrap.php';

/**
 * @return \Pimple\Container
 */
function _get_container() {
	$plugin = new \ColorMeShop\Plugin();
	$prop = (new \ReflectionClass( $plugin ))->getProperty( 'container' );
	$prop->setAccessible( true );

	return $prop->getValue( $plugin );
}

// php-vcr
$configure = \VCR\VCR::configure();
$configure->setCassettePath( 'tests/vcr_fixtures' );
// UA の違いでフィクスチャが使われずテストが落ちてしまうのを避けるため 'headers' を除外
// @see http://php-vcr.github.io/documentation/configuration/#request-matching
$configure->enableRequestMatchers( array( 'method', 'url', 'query_string', 'host', 'body', 'post_fields' ) );
// hook から 'soap' を除外する
// docker イメージに SOAP モジュールがインストールされていないので除外しないと Fatal エラーになってしまう
$configure->enableLibraryHooks( [ 'stream_wrapper', 'curl' ] );

/**
 * ネットショップ用 固定ページを作る
 * パーマリンクはデフォルト (http://xxx.xxx/?page_id=x)
 *
 * @return int
 */
function _create_product_page() {
	return wp_insert_post( [
		'post_title' => 'ネットショップ用 固定ページ',
		'post_content' => 'ネットショップ用 固定ページです',
		'post_type' => 'page',
	] );
}

/**
 * @var int[]
 */
$permalink_customized_product_page_ids = [];

/**
 * ネットショップ用 固定ページを作る
 * (パーマリンクは http://xxx.xxx/xxx/ の形式)
 *
 * @return int
 */
function _create_product_page_with_customized_permalink() {
	$page_id = wp_insert_post( [
		'post_title' => 'ネットショップ用 固定ページ',
		'post_content' => 'ネットショップ用 固定ページです. パーマリンクは' . site_url() . '/shop/ です.',
		'post_type' => 'page',
	] );

	global $permalink_customized_product_page_ids;
	$permalink_customized_product_page_ids[] = $page_id;

	return $page_id;
}

function _customize_permalink( $permalink, $post_id ) {
	global $permalink_customized_product_page_ids;

	if ( in_array( (int) $post_id, $permalink_customized_product_page_ids, true ) ) {
		return site_url() . '/shop/';
	}

	return $permalink;
}

add_filter( 'page_link', '_customize_permalink', 10, 2 );
