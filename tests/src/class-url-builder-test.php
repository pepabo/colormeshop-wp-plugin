<?php
namespace ColorMeShop;

class Url_Builder_Test extends \WP_UnitTestCase {
	/**
	 * ネットショップ用 固定ページID
	 *
	 * @var int
	 */
	private $product_page_id;

	/**
	 * ネットショップ用 固定ページID
	 * (パーマリンクを http://xxx.xxx/xxx/ の形式に変更している)
	 *
	 * @var int
	 */
	private $permalink_customized_product_page_id;

	public function setUp() {
		parent::setUp();
		$this->product_page_id = _create_product_page();
		$this->permalink_customized_product_page_id = _create_product_page_with_customized_permalink();
	}

	/**
	 * @test
	 */
	public function item() {
		$this->assertSame( 'http://example.org/shop/?colorme_item=1', $this->url_builder()->item( 1 ) );
		$this->assertSame( 'http://example.org/?page_id=' . $this->product_page_id . '&colorme_item=1', $this->url_builder_with_query()->item( 1 ) );
	}

	/**
	 * @test
	 */
	public function items() {
		$params = [];
		$this->assertSame( 'http://example.org/shop/?colorme_page=items', $this->url_builder()->items( $params ) );
		$this->assertSame( 'http://example.org/?page_id=' . $this->product_page_id . '&colorme_page=items', $this->url_builder_with_query()->items( $params ) );

		$params = [
			'category_id_big' => 1,
			'category_id_small' => 2,
		];
		$this->assertSame( 'http://example.org/shop/?colorme_page=items&category_id_big=1&category_id_small=2', $this->url_builder()->items( $params ) );
		$this->assertSame( 'http://example.org/?page_id=' . $this->product_page_id . '&colorme_page=items&category_id_big=1&category_id_small=2', $this->url_builder_with_query()->items( $params ) );
	}

	/**
	 * @test
	 */
	public function categories() {
		$this->assertSame( 'http://example.org/shop/?colorme_page=categories', $this->url_builder()->categories() );
		$this->assertSame( 'http://example.org/?page_id=' . $this->product_page_id . '&colorme_page=categories', $this->url_builder_with_query()->categories() );
	}

	/**
	 * @test
	 */
	public function sitemap_index() {
		$this->assertSame( 'http://example.org/shop/sitemap.xml', $this->url_builder()->sitemap_index() );
		$this->assertSame( 'http://example.org/?page_id=' . $this->product_page_id . '&colorme_page=sitemap', $this->url_builder_with_query()->sitemap_index() );
	}

	/**
	 * @test
	 */
	public function sitemap() {
		$this->assertSame( 'http://example.org/shop/sitemap.xml?offset=1', $this->url_builder()->sitemap( 1 ) );
		$this->assertSame( 'http://example.org/?page_id=' . $this->product_page_id . '&colorme_page=sitemap&offset=1', $this->url_builder_with_query()->sitemap( 1 ) );
	}

	private function url_builder() {
		$container = _get_container();
		$container['product_page_id'] = function ( $c ) {
			return $this->permalink_customized_product_page_id;
		};

		return $container['url_builder'];
	}

	private function url_builder_with_query() {
		$container = _get_container();
		$container['product_page_id'] = function ( $c ) {
			return $this->product_page_id;
		};

		return $container['url_builder'];
	}
}
