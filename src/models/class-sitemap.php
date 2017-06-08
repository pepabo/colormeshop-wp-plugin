<?php
namespace ColorMeShop\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use Psr\Http\Message\ResponseInterface;
use Tackk\Cartographer\Sitemap as S;
use Tackk\Cartographer\ChangeFrequency;

class Sitemap {
	/**
	 * @var stringg
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
	 * @param string
	 * @param \ColorMeShop\Models\Product_Api $product_api
	 */
	public function __construct( $product_page_url, $product_api ) {
		$this->product_page_url = $product_page_url;
		$this->product_api = $product_api;
		$this->sitemap = new S();
	}

	/**
	 * サイトマップを返す
	 *
	 * @return string
	 */
	public function output() {
		$request = $this->product_api->create_request();

		$client = new Client();
		try {
			$response = $client->send( $request );
		} catch ( RequestException $e ) {
			throw new \RuntimeException( '商品情報取得に失敗しました.' );
		}

		$contents  = json_decode( $response->getBody()->getContents(), true );
		if ( ! $contents ) {
			throw new \RuntimeException( '商品情報のデコードに失敗しました.' );
		}

		$total = $contents['meta']['total'];

		$requests = function () use ( $total ) {
			for ( $offset = 0; $offset < $total; $offset += 50 ) {
				yield $this->product_api->create_request( $offset );
			}
		};

		$pool = new Pool($client, $requests(), [
			'concurrency' => 5,
			'fulfilled' => function ( ResponseInterface $r ) {
				$contents = json_decode( $r->getBody()->getContents(), true );
				if ( ! $contents ) {
					throw new \RuntimeException( '商品情報のデコードに失敗しました.' );
				}
				foreach ( $contents['products'] as $p ) {
					$this->sitemap->add( $this->make_feed_url( $p ), $p['update_date'], ChangeFrequency::WEEKLY, 0.5 );
				}
			},
			'rejected' => function ( $reason ) {
				throw new \RuntimeException( $reason->getMessage() );
			},
		]);
		$pool->promise()->wait();

		return $this->sitemap->toString();
	}

	/**
	 * 商品ページ URL
	 *
	 * @param array $product
	 * @return string
	 */
	private function make_feed_url( $product ) {
		if ( strpos( $this->product_page_url, '?' ) === false ) {
			return trim( $this->product_page_url, '/' ) . '/?colorme_item=' . $product['id'];
		}

		return $this->product_page_url . '&colorme_item=' . $product['id'];

	}
}
