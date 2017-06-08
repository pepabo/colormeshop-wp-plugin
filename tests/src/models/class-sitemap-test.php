<?php
namespace ColorMeShop\Models;

class Sitemap_Test extends \WP_UnitTestCase {
	/**
	 * @test
	 * @group phpvcr
	 * @vcr models/sitemap/output_default_permalink.yml
	 */
	public function output_商品ページのパーマリンクがデフォルトの場合() {
		// URL パラメータに colorme_item を追加する
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://example.com/?p=123&amp;colorme_item=118515509</loc>
    <lastmod>2017-05-30T05:45:30+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://example.com/?p=123&amp;colorme_item=117182895</loc>
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
		$sitemap = new Sitemap(
			'https://example.com/?p=123',// デフォルト
			$container['model.product_api']
		);
		$this->assertSame( $expected, $sitemap->output() );
	}

	/**
	 * @test
	 * @group phpvcr
	 * @vcr models/sitemap/output_customized_permalink.yml
	 */
	public function output_商品ページのパーマリンクがカスタマイズされている場合() {
		// URL パラメータを追加する
		$expected = <<<__EOS__
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://example.com/shop/?colorme_item=118515509</loc>
    <lastmod>2017-05-30T05:45:30+00:00</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.5</priority>
  </url>
  <url>
    <loc>https://example.com/shop/?colorme_item=117182895</loc>
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
		$sitemap = new Sitemap(
			'https://example.com/shop/',
			$container['model.product_api']
		);
		$this->assertSame( $expected, $sitemap->output() );
	}
}
