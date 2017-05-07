<?php
namespace ColorMeShop\Shortcodes\Product;

class Page_Test extends \WP_UnitTestCase {
	/**
	 * @test
	 */
	public function name_ショートコード名を返す() {
		$this->assertSame( 'colormeshop_product_page', Page::name() );
	}

	/**
	 * @test
	 */
	public function show_テンプレート名が不正な場合は空文字を返す() {
		$this->assertSame(
			'',
			Page::show(
				_get_container(),
				[
					'template' => '/etc/hosts',
				],
				null,
				null
			)
		);
	}
}
