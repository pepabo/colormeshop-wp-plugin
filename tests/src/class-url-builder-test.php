<?php
namespace ColorMeShop;

class Url_Builder_Test extends \WP_UnitTestCase {

	/**
	 * @test
	 */
	public function item() {
		$this->assertSame( 'https://example.com/shop/?colorme_item=1', $this->url_builder()->item( 1 ) );
		$this->assertSame( 'https://example.com/?p=123&colorme_item=1', $this->url_builder_with_query()->item( 1 ) );
	}

	/**
	 * @test
	 */
	public function items() {
		$params = [];
		$this->assertSame( 'https://example.com/shop/?colorme_page=items', $this->url_builder()->items( $params ) );
		$this->assertSame( 'https://example.com/?p=123&colorme_page=items', $this->url_builder_with_query()->items( $params ) );

		$params = [
			'category_id_big' => 1,
			'category_id_small' => 2,
		];
		$this->assertSame( 'https://example.com/shop/?colorme_page=items&category_id_big=1&category_id_small=2', $this->url_builder()->items( $params ) );
		$this->assertSame( 'https://example.com/?p=123&colorme_page=items&category_id_big=1&category_id_small=2', $this->url_builder_with_query()->items( $params ) );
	}

	/**
	 * @test
	 */
	public function categories() {
		$this->assertSame( 'https://example.com/shop/?colorme_page=categories', $this->url_builder()->categories() );
		$this->assertSame( 'https://example.com/?p=123&colorme_page=categories', $this->url_builder_with_query()->categories() );
	}

	/**
	 * @test
	 */
	public function sitemap_index() {
		$this->assertSame( 'https://example.com/shop/sitemap.xml', $this->url_builder()->sitemap_index() );
		$this->assertSame( 'https://example.com/?p=123&colorme_sitemap=1', $this->url_builder_with_query()->sitemap_index() );
	}

	/**
	 * @test
	 */
	public function sitemap() {
		$this->assertSame( 'https://example.com/shop/sitemap.xml?offset=1', $this->url_builder()->sitemap( 1 ) );
		$this->assertSame( 'https://example.com/?p=123&colorme_sitemap=1&offset=1', $this->url_builder_with_query()->sitemap( 1 ) );
	}

	private function url_builder() {
		$container = _get_container();
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/shop/';
		};

		return $container['url_builder'];
	}

	private function url_builder_with_query() {
		$container = _get_container();
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/?p=123';
		};

		return $container['url_builder'];
	}
}
