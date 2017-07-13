<?php
namespace ColorMeShop;

class Admin_Test extends \WP_UnitTestCase {
	/** @var \Pimple\Container */
	private $container;

	public function setUp() {
		parent::setUp();
		$this->container = _get_container();
		$this->container['token'] = function ( $c ) {
			return 'dummy';
		};
		$this->container['client_id'] = function ( $c ) {
			return 'dummy_client_id';
		};
		$this->container['client_secret'] = function ( $c ) {
			return 'dummy_client_secret';
		};

		$this->container['oauth2_client'] = function ( $c ) {
			$access_token = $this->getMockBuilder( '\League\OAuth2\Client\Token\AccessToken' )
				->disableOriginalConstructor()
				->setMethods( [ 'getToken' ] )
				->getMock();
			$access_token->expects( $this->any() )
				->method( 'getToken' )
				->willReturn( 'test_token' );

			$oauth2_client = $this->getMockBuilder( '\Pepabo\OAuth2\Client\Provider\ColorMeShop' )
				->disableOriginalConstructor()
				->setMethods( [ 'getAccessToken' ] )
				->getMock();
			$oauth2_client->expects( $this->any() )
				->method( 'getAccessToken' )
				->willReturn( $access_token );

			return $oauth2_client;
		};
	}

	/**
	 * @test
	 */
	public function create_admin_page_プラグインの設定に必要な要素を出力すること() {
		$regex = <<<__EOS__
/
.*<input type="text".*name="colorme_wp_settings\[client_id\]"
[\s\S]*<input type="text".*name="colorme_wp_settings\[client_secret\]"
[\s\S]*<input type="text".*name="colorme_wp_settings\[token\]"
[\s\S]*<input type="text".*name="colorme_wp_settings\[product_page_id\]".*
/
__EOS__;

		$this->expectOutputRegex( $regex );

		$this->container['admin']->page_init();
		$this->container['admin']->create_admin_page();
	}

	/**
	 * @test
	 */
	public function token_setting_callback() {
		$this->expectOutputString(<<<__EOS__
		<input type="text" id="message" name="colorme_wp_settings[token]"
			   value="dummy" class="regular-text" />
		<br/>
		
__EOS__
		);
		$this->container['admin']->token_setting_callback();
	}

	/**
	 * @test
	 */
	public function client_id_setting_callback() {
		$this->expectOutputString(<<<__EOS__
		<input type="text" id="message" name="colorme_wp_settings[client_id]"
			   value="dummy_client_id" class="regular-text" /><br/>
		
__EOS__
		);
		$this->container['admin']->client_id_setting_callback();
	}

	/**
	 * @test
	 */
	public function client_secret_setting_callback() {
		$this->expectOutputString(<<<__EOS__
		<input type="text" id="message" name="colorme_wp_settings[client_secret]"
			   value="dummy_client_secret" class="regular-text" /><br/>
		
__EOS__
		);
		$this->container['admin']->client_secret_setting_callback();
	}

	/**
	 * @test
	 *
	 * HTTP ヘッダを出力するので `headers already sent` の警告を避けるためにプロセスを分ける
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function on_authorized() {
		// undefined index を避けるため
		$_GET['code'] = '';

		$this->container['admin']->on_authorized();
		$this->assertSame( 'test_token', get_option( 'colorme_wp_settings' )['token'] );
	}
}
