<?php
namespace ColorMeShop\Models;

/**
 * ショップデータAPI
 *
 * @see https://shop-pro.jp/?mode=api_interface#get-v1shopjson
 */
class Shop_Api {
	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var \stdClass
	 */
	private $cache;

	/**
	 * @param string $token OAuth トークン
	 */
	public function __construct( $token ) {
		$this->token = $token;
	}

	/**
	 * @return \stdClass
	 * @throws \RuntimeException
	 */
	public function fetch() {
		if ( $this->cache ) {
			return $this->cache->shop;
		}

		$url        = 'https://api.shop-pro.jp/v1/shop.json';
		$response   = wp_remote_get( $url, [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token,
			],
		] );
		if ( is_wp_error( $response ) || 200 !== $response['response']['code'] ) {
			throw new \RuntimeException( 'ショップ情報取得に失敗しました.' );
		}

		$content = json_decode( $response['body'] );
		if ( ! $content ) {
			throw new \RuntimeException( 'ショップ情報のデコードに失敗しました.' );
		}

		$this->cache = $content;

		return $this->cache->shop;
	}
}
