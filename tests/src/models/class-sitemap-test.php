<?php
namespace ColorMeShop\Models;

class Sitemap_Test extends \WP_UnitTestCase {

	/**
	 * @var Product_Api
	 */
	private $api;

	public function setUp() {
		$this->api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
			->setConstructorArgs( [ 'dummy_token' ] )
			->setMethods( [ 'fetch_all' ] )
			->getMock();
		$this->api->expects( $this->any() )
			->method( 'fetch_all' )
			->willReturn([
				'products' => [
					[
						'id' => 1,
						'update_date' => '2017-01-01 00:00:00',
					],
					[
						'id' => 2,
						'update_date' => '2017-01-02 00:00:00',
					],
				],
			]);
	}

	/**
	 * @test
	 */
	public function output_商品ページのパーマリンクがデフォルトの場合() {
		// URL パラメータに colorme_item を追加する
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://example.com/?p=123&amp;colorme_item=1</loc>
    <lastmod>2017-01-01T00:00:00+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://example.com/?p=123&amp;colorme_item=2</loc>
    <lastmod>2017-01-02T00:00:00+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>

__EOS__;

		$sitemap = new Sitemap(
			'https://example.com/?p=123',// デフォルト
			$this->api
		);
		$this->assertSame( $expected, $sitemap->output() );
	}

	/**
	 * @test
	 */
	public function output_商品ページのパーマリンクがカスタマイズされている場合() {
		// URL パラメータを追加する
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://example.com/shop/?colorme_item=1</loc>
    <lastmod>2017-01-01T00:00:00+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://example.com/shop/?colorme_item=2</loc>
    <lastmod>2017-01-02T00:00:00+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
</urlset>

__EOS__;

		$sitemap = new Sitemap(
			'https://example.com/shop/',
			$this->api
		);
		$this->assertSame( $expected, $sitemap->output() );
	}
}
