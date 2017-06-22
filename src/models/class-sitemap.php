<?php
namespace ColorMeShop\Models;

use Psr\Http\Message\ResponseInterface;
use Tackk\Cartographer\ChangeFrequency;
use Tackk\Cartographer\Sitemap as S;
use Tackk\Cartographer\SitemapIndex;

class Sitemap {
	/**
	 * @var string
	 */
	private $product_page_url;

	/**
	 * @var \ColorMeShop\Models\Product_Api
	 */
	private $product_api;

	/**
	 * @var \Tackk\Cartographer\Sitemap
	 */
	private $sitemap;

	/**
	 * @var int サイトマップの商品 URL 数
	 */
	const NUMBER_OF_ITEM_URLS_PER_PAGE = 1000;

	/**
	 * @param string
	 * @param \ColorMeShop\Models\Product_Api $product_api
	 */
	public function __construct( $product_page_url, $product_api ) {
		$this->product_page_url = $product_page_url;
		$this->product_api = $product_api;
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
			$sitemap_index->add( $this->make_sitemap_url( $i ), null );
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
					$this->sitemap->add( $this->make_item_url( $p ), $p['update_date'], ChangeFrequency::WEEKLY, 0.5 );
				}
			},
			$offset,
			self::NUMBER_OF_ITEM_URLS_PER_PAGE
		);

		return $this->sitemap->toString();
	}

	/**
	 * サイトマップ URL
	 *
	 * @param int $offset
	 * @return string
	 */
	private function make_sitemap_url( $offset ) {
		if ( strpos( $this->product_page_url, '?' ) === false ) {
			return $this->product_page_url . 'sitemap.xml?offset=' . $offset;
		}

		return $this->product_page_url . '&colorme_sitemap=1&offset=' . $offset;
	}

	/**
	 * 商品ページ URL
	 *
	 * @param array $product
	 * @return string
	 */
	private function make_item_url( $product ) {
		if ( strpos( $this->product_page_url, '?' ) === false ) {
			return trim( $this->product_page_url, '/' ) . '/?colorme_item=' . $product['id'];
		}

		return $this->product_page_url . '&colorme_item=' . $product['id'];

	}
}
