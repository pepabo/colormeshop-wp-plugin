<?php
namespace ColorMeShop\Models;

use ColorMeShop\Api\Product_Api;
use Psr\Http\Message\ResponseInterface;
use Tackk\Cartographer\ChangeFrequency;
use Tackk\Cartographer\Sitemap as S;
use Tackk\Cartographer\SitemapIndex;

class Sitemap {
	/**
	 * @var \ColorMeShop\Models\Product_Api
	 */
	private $product_api;

	/**
	 * @var \ColorMeShop\Url_Builder
	 */
	private $url;

	/**
	 * @var \Tackk\Cartographer\Sitemap
	 */
	private $sitemap;

	/**
	 * @var int サイトマップの商品 URL 数
	 */
	const NUMBER_OF_ITEM_URLS_PER_PAGE = 1000;

	/**
	 * @param \ColorMeShop\Models\Product_Api $product_api
	 * @param \ColorMeShop\Url_Builder $url
	 */
	public function __construct( $product_api, $url ) {
		$this->product_api = $product_api;
		$this->url = $url;
		$this->sitemap = new S();
	}

	/**
	 * サイトマップインデックスを生成する
	 *
	 * @return string
	 * @throws \RuntimeException
	 */
	public function generate_index() {
		$sitemap_index = new SitemapIndex;
		$total = $this->product_api->total();

		for ( $i = 0; $i <= $total; $i += self::NUMBER_OF_ITEM_URLS_PER_PAGE ) {
			$sitemap_index->add( $this->url->sitemap( $i ), null );
		}

		return $sitemap_index->toString();
	}

	/**
	 * サイトマップを生成する
	 *
	 * @param int $offset
	 * @return string
	 * @throws \RuntimeException
	 */
	public function generate( $offset ) {
		$this->product_api->fetch_with_callback(
			function ( ResponseInterface $r ) {
				$contents = Product_Api::decode_contents( $r->getBody()->getContents() );
				foreach ( $contents['products'] as $p ) {
					$this->sitemap->add( $this->url->item( $p['id'] ), $p['update_date'], ChangeFrequency::WEEKLY, 0.5 );
				}
			},
			$offset,
			self::NUMBER_OF_ITEM_URLS_PER_PAGE
		);

		return $this->sitemap->toString();
	}
}
