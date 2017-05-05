<?php
namespace ColorMeShop\Models;

/**
 * ショップデータAPI
 *
 * @see https://shop-pro.jp/?mode=api_interface#get-v1shopjson
 */
class Shop {
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
		$this->cache = json_decode( $response['body'] );

		return $this->cache->shop;
	}
}
