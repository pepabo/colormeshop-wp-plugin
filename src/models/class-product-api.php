<?php
namespace ColorMeShop\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

/**
 * 商品データAPI
 *
 * @see https://shop-pro.jp/?mode=api_interface#get-v1productsjson
 */
class Product_Api {
	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var array
	 */
	private $caches = [];

	/**
	 * @var int 1リクエストあたりの最大件数
	 */
	const MAXIMUM_NUMBER_PER_REQUEST = 50;

	/**
	 * @param string $token OAuth トークン
	 */
	public function __construct( $token ) {
		$this->token = $token;
	}

	/**
	 * @param int $product_id
	 * @return Product
	 * @throws \RuntimeException
	 */
	public function fetch( $product_id ) {
		return new Product( $this->call_api( $product_id ) );
	}

	/**
	 * @param int $product_id
	 * @return array
	 * @throws \RuntimeException
	 */
	private function call_api( $product_id ) {
		if ( isset( $this->caches[ $product_id ] ) ) {
			return $this->caches[ $product_id ];
		}

		$url      = "https://api.shop-pro.jp/v1/products/{$product_id}.json";
		$response = wp_remote_get( $url, [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token,
			],
		] );
		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
			throw new \RuntimeException( '商品情報取得に失敗しました. product_id: ' . $product_id );
		}

		$content  = self::decode_contents( $response['body'] );

		$this->caches[ $product_id ] = $content;

		return $content;
	}

	/**
	 * @param \Closure $fulfilled
	 * @return void
	 * @throws \RuntimeException
	 */
	public function fetch_all_with_callback( $fulfilled ) {
		// 初回リクエスト
		// - トータル件数を取得
		// - トータル件数が 50 件以下なら, レスポンスに含まれる商品情報を利用して終了
		$request = $this->create_request();

		$client = new Client();
		try {
			$response = $client->send( $request );
		} catch ( RequestException $e ) {
			throw new \RuntimeException( '商品情報取得に失敗しました.' );
		}

		// 初回リクエストで返ってくる商品情報を処理する
		$fulfilled($response);

		$contents = self::decode_contents( $response->getBody()->getContents() );
		$total = $contents['meta']['total'];
		if ( $total <= self::MAXIMUM_NUMBER_PER_REQUEST ) {
			return;
		}

		// 51 件目以降は並列リクエストする
		$requests = function () use ( $total ) {
			for ( $offset = self::MAXIMUM_NUMBER_PER_REQUEST; $offset < $total; $offset += self::MAXIMUM_NUMBER_PER_REQUEST ) {
				yield $this->create_request( $offset );
			}
		};

		$pool = new Pool($client, $requests(), [
			'concurrency' => 5,
			'fulfilled' => $fulfilled,
			'rejected' => function ( $reason ) {
				throw new \RuntimeException( $reason->getMessage() );
			},
		]);
		$pool->promise()->wait();
	}

	/**
	 * @param int $offset
	 * @return \Psr\Http\Message\RequestInterface
	 */
	public function create_request( $offset = 0 ) {
		$query = http_build_query(
			[
				'limit' => self::MAXIMUM_NUMBER_PER_REQUEST,
				'display_state' => 0,
				'offset' => $offset,
			]
		);
		return new Request(
			'GET',
			'https://api.shop-pro.jp/v1/products.json?' . $query,
			[
				'Authorization' => 'Bearer ' . $this->token,
			]
		);
	}

	/**
	 * @param string $contents
	 * @return array
	 * @throws \RuntimeException
	 */
	public static function decode_contents( $contents ) {
		$contents = json_decode( $contents, true );
		if ( ! $contents ) {
			throw new \RuntimeException( '商品情報のデコードに失敗しました.' );
		}

		return $contents;
	}
}
