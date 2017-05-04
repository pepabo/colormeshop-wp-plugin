<?php
/**
 * Plugin Name: カラーミーショップ Wordpressプラグイン
 * Plugin URI: http://
 * Description: カラーミーショップAPIと連携して商品詳細ページを自動生成します
 * Version: 0.1
 * Author: GMO Pepabo, Inc.
 * Author URI: https://pepabo.com/
 * License: GPL2
 */

require_once( 'vendor/autoload.php' );

use ColorMeShop\Models\Shop;
use ColorMeShop\Models\Product_Api;
use ColorMeShop\Shortcode_Invoker;
use Pepabo\OAuth2\Client\Provider\ColorMeShop as OAuth2Client;
use Pimple\Container;

class ColorMeShop_WP_Plugin {
	/**
	 * DI コンテナ
	 *
	 * @var Pimple\Container
	 */
	private $container;

	public function __construct() {
		$this->initialize_container();
		$this->register_shortcode();

		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'admin_init', [ $this, 'page_init' ] );

		add_action( 'init', [ $this, 'manage_item_routes' ] );
		add_action( 'init', [ $this, 'custom_rewrite_tag' ], 10, 0 );
		register_activation_hook( __FILE__, [ $this, 'flush_application_rewrite_rules' ] );
		add_action( 'colormeshop_category', [ $this, 'show_category' ] );
		add_shortcode( 'authentication_link', [ $this, 'show_authentication_link' ] );

		add_action( 'wp_ajax_colormeshop_callback', [ $this, 'colormeshop_callback' ] );

		remove_action( 'wp_head', '_wp_render_title_tag', 1 );
	}

	public function colormeshop_callback() {
		$access_token     = $this->container['oauth2_client']->getAccessToken( 'authorization_code', [
			'code' => $_GET['code'],
		] );
		$options          = $this->container['colorme_wp_settings'];
		$options['token'] = $access_token->getToken();
		update_option( 'colorme_wp_settings', $options, true );

		header( 'Location: ' . admin_url( '?page=colorme_wp_settings' ), true );

		return;
	}

	public function manage_item_routes() {
		add_rewrite_rule( '^item/([^/]+)/?', 'index.php?colorme_item=$matches[1]', 'top' );
	}

	public function custom_rewrite_tag() {
		add_rewrite_tag( '%colorme_item%', '([^&]+)' );
	}

	public function flush_application_rewrite_rules() {
		$this->manage_item_routes();
		flush_rewrite_rules();
	}

	public function show_authentication_link( $attr, $content = null ) {
		return '<a href="' . $this->container['oauth2_client']->getAuthorizationUrl( [
			'scope' => [ 'read_products write_products' ],
		] ) . '">カラーミーショップアカウントで認証する</a>';
	}

	public function product_title_tag( $title ) {
		echo '<title>' . $title . ' | ' . get_bloginfo() . '</title>';
	}

	// 設定ページ関連
	public function add_plugin_page() {
		add_menu_page( 'カラーミーショップ', 'カラーミーショップ', 'manage_options', 'colorme_wp_settings', [
			$this,
			'create_admin_page',
		] );
	}

	public function page_init() {
		register_setting( 'colorme_wp_settings', 'colorme_wp_settings', [ $this, 'settings_sanitize' ] );
		add_settings_section( 'general', '基本設定', '', 'colorme_wp_settings' );
		add_settings_field( 'token', 'トークン', [
			$this,
			'token_setting_callback',
		], 'colorme_wp_settings', 'general' );
		add_settings_field( 'client_id', 'クライアントID', [
			$this,
			'client_id_setting_callback',
		], 'colorme_wp_settings', 'general' );
		add_settings_field( 'client_secret', 'クライアントシークレット', [
			$this,
			'client_secret_setting_callback',
		], 'colorme_wp_settings', 'general' );
	}

	public function create_admin_page() {
		include dirname( __FILE__ ) . '/templates/settings.php';
	}

	public function token_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[token]"
			   value="<?php esc_attr_e( $this->container['token'] ) ?>"/>
		<br/>
		<?php

	}

	public function client_id_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[client_id]"
			   value="<?php esc_attr_e( $this->container['client_id'] ) ?>"/><br/>
		<?php

	}

	public function client_secret_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[client_secret]"
			   value="<?php esc_attr_e( $this->container['client_secret'] ) ?>"/><br/>
		<?php

	}

	public function settings_sanitize( $inputs ) {
		return $inputs;
	}

	/**
	 * @return void
	 */
	private function initialize_container() {
		$container          = new Container();

		$container['colorme_wp_settings'] = function ( $c ) {
			return get_option( 'colorme_wp_settings' );
		};

		$container['templates_dir'] = function ( $c ) {
			return __DIR__ . '/templates';
		};

		$container['token'] = function ( $c ) {
			$settings = $c['colorme_wp_settings'];

			return $settings && array_key_exists( 'token', $settings ) ? $settings['token'] : '';
		};

		$container['client_id'] = function ( $c ) {
			$settings = $c['colorme_wp_settings'];

			return $settings && array_key_exists( 'client_id', $settings ) ? $settings['client_id'] : '';
		};

		$container['client_secret'] = function ( $c ) {
			$settings = $c['colorme_wp_settings'];

			return $settings && array_key_exists( 'client_secret', $settings ) ? $settings['client_secret'] : '';
		};

		$container['oauth2_client'] = function ( $c ) {
			return new OAuth2Client( [
				'clientId'     => $c['client_id'],
				'clientSecret' => $c['client_secret'],
				'redirectUri'  => admin_url( 'admin-ajax.php?action=colormeshop_callback' ),
			] );
		};

		$container['target_id'] = function ( $c ) {
			global $wp_query;

			return isset( $wp_query->query_vars['colorme_item'] ) ? $wp_query->query_vars['colorme_item'] : null;
		};

		$container['model.shop'] = function ( $c ) {
			return new Shop( $c['token'] );
		};

		$container['model.product_api'] = function ( $c ) {
			return new Product_Api( $c['token'] );
		};

		$this->container = $container;
	}

	/**
	 * src/shortcodes 配下に定義されたショートコードを登録する
	 *
	 * @return void
	 */
	private function register_shortcode() {
		$to_invoker_methodname = function ( $class ) {
			return '_' . str_replace( '/', '_', $class );
		};

		$shortcode_invoker = new Shortcode_Invoker( $this->container );
		$classmap = include( __DIR__ . '/vendor/composer/autoload_classmap.php' );
		foreach ( $classmap as $class => $path ) {
			if ( strpos( $path, $baseDir . '/src/shortcodes/' ) !== 0 ) {
				continue;
			}
			add_shortcode(
				call_user_func( [ $class, 'name' ] ),
				[ $shortcode_invoker, $to_invoker_methodname( $class ) ]
			);
		}
	}
}

$colorme = new ColorMeShop_WP_Plugin();
