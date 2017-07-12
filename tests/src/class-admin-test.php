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

		// oauth2_client をモックに置き換えておかないと php-vcr を使った他のテストが落ちてしまう
		// 要調査
		$this->container['oauth2_client'] = function ( $c ) {
			return $this->getMockBuilder( '\Pepabo\OAuth2\Client\Provider\ColorMeShop' )
				->disableOriginalConstructor()
				->getMock();
		};
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
}
