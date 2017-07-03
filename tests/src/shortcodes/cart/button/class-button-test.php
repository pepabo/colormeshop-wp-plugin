<?php
namespace ColorMeShop\Shortcodes\Cart;

class Button_Test extends \WP_UnitTestCase {
	public function setUp() {
		parent::setUp();

		$this->container = _get_container();
		$this->container['token'] = function ( $c ) {
			return 'dummy';
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
	 * @vcr shortcodes/cart/button/script_tag.yml
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
	 * @vcr shortcodes/cart/button/style.yml
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
