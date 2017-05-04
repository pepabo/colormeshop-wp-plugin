<?php
namespace ColorMeShop\Models;

class Shop {
	/**
	 * @var string
	 */
	private $token;

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
		$url        = 'https://api.shop-pro.jp/v1/shop.json';
		$response   = wp_remote_get( $url, [
			'headers' => [
				'Authorization' => 'Bearer ' . $this->token,
			],
		] );
		$content    = json_decode( $response['body'] );

		return $content->shop;
	}
}
