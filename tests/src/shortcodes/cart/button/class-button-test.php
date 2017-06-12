<?php
namespace ColorMeShop\Shortcodes\Cart;


class Button_Test extends \WP_UnitTestCase {

	public function setUp() {
		$shop = new \stdClass();
		$shop->url = 'https://test.shop-pro.jp';

		$shop_api = $this->getMockBuilder( '\ColorMeShop\Models\Shop_Api' )
			->setConstructorArgs( [ 'dummy_token' ] )
			->setMethods( [ 'fetch' ] )
			->getMock();
		$shop_api->expects( $this->any() )
			->method( 'fetch' )
			->willReturn( $shop );

		$this->container = _get_container();
		$this->container['model.shop_api'] = function ( $c ) use ( $shop_api ) {
			return $shop_api;
		};
	}

	/**
	 * @test
	 */
	public function name_ショートコード名を返す() {
		$this->assertSame( 'colormeshop_cart_button', Button::name() );
	}

	/**
	 * @test
	 */
	public function show_カートボタン用のscriptタグを返す() {
		$this->assertSame(
			'<script type="text/javascript" src="https://test.shop-pro.jp/?mode=cartjs&pid=123&style=basic&name=n&img=n&expl=n&stock=n&price=n&inq=n&sk=n" charset="euc-jp"></script>',
			Button::show(
				$this->container,
				[
					'product_id' => 123,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_styleを指定できる() {
		$this->assertSame(
			'<script type="text/javascript" src="https://test.shop-pro.jp/?mode=cartjs&pid=123&style=washi&name=n&img=n&expl=n&stock=n&price=n&inq=n&sk=n" charset="euc-jp"></script>',
			Button::show(
				$this->container,
				[
					'product_id' => 123,
					'style' => 'washi',
				],
				null,
				null
			)
		);
	}
}
