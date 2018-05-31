<?php
namespace ColorMeShop;

use ColorMeShop\Models\Setting;
use Pepabo\OAuth2\Client\Provider\ColorMeShop as OAuth2Client;

/**
 * @package ColorMeShop
 */
class Admin {
	/** @var string */
	const MENU_SLUG = 'colorme_wp_settings';

	/**
	 * @var OAuth2Client
	 */
	private $oauth2_client;

	/**
	 * @var Setting
	 */
	private $setting;

	/**
	 * @var string
	 */
	private $templates_dir;

	/**
	 * @var Url_Builder
	 */
	private $url_builder;

	/**
	 * @param OAuth2Client $oauth2_client
	 * @param Setting $setting
	 * @param string $templates_dir
	 * @param Url_Builder $url_builder
	 */
	public function __construct(
		OAuth2Client $oauth2_client,
		Setting $setting,
		$templates_dir,
		Url_Builder $url_builder
	) {
		$this->oauth2_client = $oauth2_client;
		$this->setting       = $setting;
		$this->templates_dir = $templates_dir;
		$this->url_builder   = $url_builder;
	}

	public function register() {
		add_action( 'admin_init', [ $this, 'page_init' ] );
		add_action( 'admin_menu', [ $this, 'add_plugin_page' ] );
		add_action( 'wp_ajax_colormeshop_callback', [ $this, 'wp_ajax_colormeshop_callback' ] );
	}

	/**
	 * 管理画面にプラグイン設定ページを追加する
	 *
	 * @return void
	 */
	public function add_plugin_page() {
		add_menu_page(
			'カラーミーショップ', 'カラーミーショップ', 'manage_options', self::MENU_SLUG, [
				$this,
				'create_admin_page',
			]
		);
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
		register_setting( Setting::KEY, Setting::KEY );
		add_settings_section( 'general', '', '', self::MENU_SLUG );
		add_settings_field(
			'client_id', 'クライアントID', [
				$this,
				'client_id_setting_callback',
			], self::MENU_SLUG, 'general'
		);
		add_settings_field(
			'client_secret', 'クライアントシークレット', [
				$this,
				'client_secret_setting_callback',
			], self::MENU_SLUG, 'general'
		);
		add_settings_field(
			'token', 'トークン', [
				$this,
				'token_setting_callback',
			], self::MENU_SLUG, 'general'
		);
		add_settings_field(
			'product_page_id', '商品ページID', [
				$this,
				'pruduct_page_id_setting_callback',
			], self::MENU_SLUG, 'general'
		);
	}

	public function token_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[token]"
			value="<?php echo esc_attr( $this->setting->token() ); ?>" class="regular-text" />
		<br/>
		<?php

	}

	public function client_id_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[client_id]"
			value="<?php echo esc_attr( $this->setting->client_id() ); ?>" class="regular-text" /><br/>
		<?php

	}

	public function client_secret_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[client_secret]"
			value="<?php echo esc_attr( $this->setting->client_secret() ); ?>" class="regular-text" /><br/>
		<?php

	}

	public function pruduct_page_id_setting_callback() {
		?>
		<input type="text" id="message" name="colorme_wp_settings[product_page_id]"
			value="<?php echo esc_attr( $this->setting->product_page_id() ); ?>" class="small-text" />
		<br/>
		<?php
	}

	/**
	 * wp_ajax アクションフック処理
	 *
	 * @return void
	 */
	public function wp_ajax_colormeshop_callback() {
		$this->on_authorized();

		header( 'Location: ' . admin_url( '?page=' . self::MENU_SLUG ), true );

		// return するとレスポンスボディとして '0' を返してしまうためリダイレクトできないので
		// exit している
		exit;
	}

	/**
	 * OAuth 認証のコールバック処理
	 *
	 * @return void
	 */
	public function on_authorized() {
		$access_token = $this->oauth2_client->getAccessToken(
			'authorization_code', [
				'code' => $_GET['code'],
			]
		);
		$this->setting->update(
			[
				'token' => $access_token->getToken(),
			]
		);
	}
}
