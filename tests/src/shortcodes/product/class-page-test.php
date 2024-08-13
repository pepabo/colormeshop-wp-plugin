<?php
namespace ColorMeShop\Shortcodes\Product;

class Page_Test extends \WP_UnitTestCase {
	/**
	 * @test
	 */
	public function name_ショートコード名を返す() {
		$this->assertSame( 'colormeshop_page', Page::name() );
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

	/**
	 * @test
	 */
	public function show_存在しない商品IDが指定された場合は、ApiExceptionをcatchし空文字を返す() {
		$container = $this->createMock(\Pimple\Container::class);
		$product_api = $this->createMock(\ColorMeShop\Swagger\Api\ProductApi::class);

		$product_api->method('fetch')
			->willThrowException(new \ColorMeShop\Swagger\ApiException());

		$container->method('offsetGet')
			->willReturnMap([
				['api.product_api', $product_api],
				['WP_DEBUG_LOG', false],
			]);

		$this->assertSame(
			'',
			Page::show(
				$container,
				[
					'template' => 'default',
					'product_id' => '999999', // 存在しない商品ID
				],
				null,
				null
			)
		);
	}
}
