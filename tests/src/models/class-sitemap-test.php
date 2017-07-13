<?php
namespace ColorMeShop\Models;

class Sitemap_Test extends \WP_UnitTestCase {
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
	 * @vcr models/sitemap/output_index_default_permalink.yml
	 */
	public function output_index_商品ページのパーマリンクがデフォルトの場合() {
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_page=sitemap&amp;offset=0</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_page=sitemap&amp;offset=1000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_page=sitemap&amp;offset=2000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_page=sitemap&amp;offset=3000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_page=sitemap&amp;offset=4000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_page=sitemap&amp;offset=5000</loc>
  </sitemap>
</sitemapindex>

__EOS__;

		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/?p=123';// デフォルト
		};
		$container['product_page_id'] = function ( $c ) {
			return $this->product_page_id;
		};
		$sitemap = $container['model.sitemap'];
		$this->assertSame( $expected, $sitemap->generate_index() );
	}

	/**
	 * @test
	 * @vcr models/sitemap/output_index_customized_permalink.yml
	 */
	public function output_index_商品ページのパーマリンクがカスタマイズされている場合() {
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <sitemap>
    <loc>http://example.org/shop/sitemap.xml?offset=0</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/shop/sitemap.xml?offset=1000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/shop/sitemap.xml?offset=2000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/shop/sitemap.xml?offset=3000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/shop/sitemap.xml?offset=4000</loc>
  </sitemap>
  <sitemap>
    <loc>http://example.org/shop/sitemap.xml?offset=5000</loc>
  </sitemap>
</sitemapindex>

__EOS__;

		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/shop/';
		};
		$container['product_page_id'] = function ( $c ) {
			return $this->permalink_customized_product_page_id;
		};
		$sitemap = $container['model.sitemap'];
		$this->assertSame( $expected, $sitemap->generate_index() );
	}

	/**
	 * @test
	 * @vcr models/sitemap/output_default_permalink.yml
	 */
	public function output_商品ページのパーマリンクがデフォルトの場合() {
		// URL パラメータに colorme_item を追加する
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_item=118515509</loc>
    <lastmod>2017-05-30T05:45:30+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>http://example.org/?page_id={$this->product_page_id}&amp;colorme_item=117182895</loc>
    <lastmod>2017-06-05T01:23:54+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>

__EOS__;

		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/?p=123';// デフォルト
		};
		$container['product_page_id'] = function ( $c ) {
			return $this->product_page_id;
		};
		$sitemap = $container['model.sitemap'];
		$this->assertSame( $expected, $sitemap->generate( 0 ) );
	}

	/**
	 * @test
	 * @vcr models/sitemap/output_customized_permalink.yml
	 */
	public function output_商品ページのパーマリンクがカスタマイズされている場合() {
		// URL パラメータを追加する
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>http://example.org/shop/?colorme_item=118515509</loc>
    <lastmod>2017-05-30T05:45:30+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>http://example.org/shop/?colorme_item=117182895</loc>
    <lastmod>2017-06-05T01:23:54+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>

__EOS__;

		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/shop/';
		};
		$container['product_page_id'] = function ( $c ) {
			return $this->permalink_customized_product_page_id;
		};
		$sitemap = $container['model.sitemap'];
		$this->assertSame( $expected, $sitemap->generate( 0 ) );
	}

	/**
	 * @test
	 * @vcr models/sitemap/output_more_than_50_items.yml
	 */
	public function output_商品数50以上の場合() {
		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};
		$container['product_page_url'] = function ( $c ) {
			return 'https://example.com/shop/';
		};
		$container['product_page_id'] = function ( $c ) {
			return $this->permalink_customized_product_page_id;
		};
		$sitemap = $container['model.sitemap'];

		$matches = [];
		preg_match_all( '#<loc>http://example\.org/shop/\?colorme_item=[0-9]+</loc>#', $sitemap->generate( 0 ), $matches );
		$this->assertCount( 101, $matches[0] );
	}
}
