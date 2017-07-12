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
}
