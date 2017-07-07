<?php
namespace ColorMeShop;

use Pepabo\OAuth2\Client\Provider\ColorMeShop as OAuth2Client;

/**
 * @package ColorMeShop
 */
class Admin {
	/**
	 * @var OAuth2Client
	 */
	private $oauth2_client;

	/**
	 * @var array
	 */
	private $colorme_wp_settings;

	/**
	 * @var string
	 */
	private $templates_dir;

	/**
	 * @var string
	 */
	private $client_id;

	/**
	 * @var string
	 */
	private $client_secret;

	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var int
	 */
	private $product_page_id;

	/**
	 * @param OAuth2Client $oauth2_client
	 * @param array $colorme_wp_settings
	 * @param string $templates_dir
	 * @param string $client_id
	 * @param string $client_secret
	 * @param string $client_secret
	 * @param string $token
	 * @param int $product_page_id
	 */
	public function __construct(
		OAuth2Client $oauth2_client,
		$colorme_wp_settings,
		$templates_dir,
		$client_id,
		$client_secret,
		$token,
		$product_page_id
	) {
		$this->oauth2_client = $oauth2_client;
		$this->colorme_wp_settings = $colorme_wp_settings;
		$this->templates_dir = $templates_dir;
		$this->client_id = $client_id;
		$this->client_secret = $client_secret;
		$this->token = $token;
		$this->product_page_id = $product_page_id;
	}

	public function register() {
		add_action( 'admin_init', [ $this, 'page_init' ] );
		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'wp_ajax_colormeshop_callback', [ $this, 'on_authorized' ] );
	}

	/**
	 * 管理画面にプラグイン設定ページを追加する
	 *
	 * @return void
	 */
	public function add_plugin_page() {
		add_menu_page( 'カラーミーショップ', 'カラーミーショップ', 'manage_options', 'colorme_wp_settings', [
			$this,
			'create_admin_page',
		] );
	}

	public function create_admin_page() {
		include $this->templates_dir . '/settings.php';
	}

	/**
	 * プラグイン設定ページを定義する
	 *
	 * @return void
	 */
	public function page_init() {
		register_setting( 'colorme_wp_settings', 'colorme_wp_settings', [ $this, 'settings_sanitize' ] );
		add_settings_section( 'general', '', '', 'colorme_wp_settings' );
		add_settings_field( 'client_id', 'クライアントID', [
			$this,
			'client_id_setting_callback',
		], 'colorme_wp_settings', 'general' );
		add_settings_field( 'client_secret', 'クライアントシークレット', [
			$this,
			'client_secret_setting_callback',
		], 'colorme_wp_settings', 'general' );
		add_settings_field( 'token', 'トークン', [
			$this,
			'token_setting_callback',
		], 'colorme_wp_settings', 'general' );
		add_settings_field( 'product_page_id', '商品ページID', [
			$this,
			'pruduct_page_id_setting_callback',
		], 'colorme_wp_settings', 'general' );
	}

	public function token_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[token]"
			   value="<?php echo esc_attr( $this->token ) ?>" class="regular-text" />
		<br/>
		<?php

	}

	public function client_id_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[client_id]"
			   value="<?php echo esc_attr( $this->client_id ) ?>" class="regular-text" /><br/>
		<?php

	}

	public function client_secret_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[client_secret]"
			   value="<?php echo esc_attr( $this->client_secret ) ?>" class="regular-text" /><br/>
		<?php

	}

	public function pruduct_page_id_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[product_page_id]"
			   value="<?php echo esc_attr( $this->product_page_id ) ?>" class="small-text" />
		<br/>
		<?php
	}

	public function settings_sanitize( $inputs ) {
		return $inputs;
	}

	/**
	 * OAuth 認証のコールバック処理
	 *
	 * @return void
	 */
	public function on_authorized() {
		$access_token     = $this->oauth2_client->getAccessToken( 'authorization_code', [
			'code' => $_GET['code'],
		] );
		$this->colorme_wp_settings['token'] = $access_token->getToken();
		update_option( 'colorme_wp_settings', $this->colorme_wp_settings, true );

		header( 'Location: ' . admin_url( '?page=colorme_wp_settings' ), true );

		return;
	}
}
