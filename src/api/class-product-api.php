<?php
namespace ColorMeShop\Api;

use ColorMeShop\Paginator;
use ColorMeShop\Paginator_Factory;
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
	 * @var Paginator_Factory
	 */
	private $paginator_factory;

	/**
	 * @var int 1リクエストあたりの最大件数
	 */
	const MAXIMUM_NUMBER_PER_REQUEST = 50;

	/**
	 * @var array
	 */
	private $caches = [];

	/**
	 * @param Paginator_Factory $paginator_factory
	 * @param \ColorMeShop\Swagger\Api\ProductApi $swagger_api
	 */
	public function __construct( $paginator_factory, $swagger_api ) {
		$this->paginator_factory = $paginator_factory;
		$this->swagger_api = $swagger_api;
	}

	/**
	 * 商品データの取得
	 *
	 * @param int $product_id 商品ID (required)
	 * @throws \ColorMeShop\Swagger\ApiException on non-2xx response
	 * @throws \InvalidArgumentException
	 * @return \ColorMeShop\Swagger\Model\InlineResponse2007
	 */
	public function fetch( $product_id ) {
		if ( isset( $this->caches[ $product_id ] ) ) {
			return $this->caches[ $product_id ];
		}

		$this->caches[ $product_id ] = $this->swagger_api->getProduct( $product_id );

		return $this->caches[ $product_id ];
	}

	/**
	 * 商品数
	 *
	 * @return int
	 * @throws \RuntimeException
	 */
	public function total() {
		try {
			$response = (new Client)->send( $this->create_request( [
				'limit' => 1,
				'offset' => 0,
			] ) );
		} catch ( RequestException $e ) {
			throw new \RuntimeException( '商品情報取得に失敗しました.' );
		}

		return self::decode_contents( $response->getBody()->getContents() )['meta']['total'];
	}

	/**
	 * @param \Closure $fulfilled
	 * @param int $initial_offset
	 * @param int $limit
	 * @return void
	 * @throws \RuntimeException
	 */
	public function fetch_with_callback( $fulfilled, $initial_offset, $limit ) {
		$client = new Client;
		$total = $this->total();

		$should_continue = function ( $current_offset ) use ( $total, $initial_offset, $limit ) {
			return $current_offset < $total
				&& $current_offset < ($initial_offset + $limit);
		};

		// 商品情報を取得
		$requests = function () use ( $initial_offset, $should_continue ) {
			for ( $offset = $initial_offset; $should_continue($offset); $offset += self::MAXIMUM_NUMBER_PER_REQUEST ) {
				yield $this->create_request( [
					'limit' => self::MAXIMUM_NUMBER_PER_REQUEST,
					'offset' => $offset,
				] );
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
	 * @param array $params
	 * @return Paginator
	 */
	public function paginate( $params ) {
		try {
			$response = (new Client)->send( $this->create_request( $params ) );
		} catch ( RequestException $e ) {
			throw new \RuntimeException( '商品情報取得に失敗しました.' );
		}

		return $this->paginator_factory->make(
			$params,
			self::decode_contents( $response->getBody()->getContents() )
		);
	}

	/**
	 * @param array $params
	 * @return \Psr\Http\Message\RequestInterface
	 */
	private function create_request( $params ) {
		$params['display_state'] = 0;
		return new Request(
			'GET',
			'https://api.shop-pro.jp/v1/products.json?' . http_build_query( $params ),
			[
				'Authorization' => 'Bearer ' . $this->swagger_api->getConfig()->getAccessToken(),
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
