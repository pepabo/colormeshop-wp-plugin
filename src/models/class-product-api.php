<?php
namespace ColorMeShop\Models;

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

		$content  = json_decode( $response['body'], true );
		if ( ! $content ) {
			throw new \RuntimeException( '商品情報のデコードに失敗しました. product_id: ' . $product_id );
		}

		$this->caches[ $product_id ] = $content;

		return $content;
	}

	/**
	 * @return array
	 * @throws \RuntimeException
	 */
	public function fetch_all() {
		if ( isset( $this->caches[ __FUNCTION__ ] ) ) {
			return $this->caches[ __FUNCTION__ ];
		}

		$url      = 'https://api.shop-pro.jp/v1/products.json';
		$response = wp_remote_get( $url, [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token,
			],
		] );
		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
			throw new \RuntimeException( '商品情報取得に失敗しました.' );
		}

		$content  = json_decode( $response['body'], true );
		if ( ! $content ) {
			throw new \RuntimeException( '商品情報のデコードに失敗しました.' );
		}

		$this->caches[ __FUNCTION__ ] = $content;

		return $content;
	}
}
