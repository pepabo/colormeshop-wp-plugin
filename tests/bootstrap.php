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
