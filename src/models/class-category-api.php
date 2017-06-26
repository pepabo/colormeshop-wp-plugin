<?php
namespace ColorMeShop\Models;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

/**
 * カテゴリーAPI
 *
 * @see https://shop-pro.jp/?mode=api_interface#get-v1categoriesjson
 */
class Category_Api {
	/**
	 * @var string
	 */
	private $token;

	/**
	 * @var array
	 */
	private $cache = null;

	/**
	 * @param string $token OAuth トークン
	 */
	public function __construct( $token ) {
		$this->token = $token;
	}

	/**
	 * @return array
	 * @throws \RuntimeException
	 */
	public function fetch() {
		if ( $this->cache ) {
			return $this->cache;
		}

		$request = new Request(
			'GET',
			'https://api.shop-pro.jp/v1/categories.json',
			[
				'Authorization' => 'Bearer ' . $this->token,
			]
		);
		$client = new Client();

		try {
			$response = $client->send( $request );
		} catch ( RequestException $e ) {
			throw new \RuntimeException( 'カテゴリー情報取得に失敗しました.' );
		}

		$this->cache = self::decode_contents( $response->getBody()->getContents() );

		return $this->cache;
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
