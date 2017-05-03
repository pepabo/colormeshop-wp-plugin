<?php
namespace ColorMeShop\Models;

class ProductApi {
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
     * @return Product
     * @throws \RuntimeException
     */
	public function fetch( $product_id ) {
		$url      = "https://api.shop-pro.jp/v1/products/{$product_id}.json";
		$response = wp_remote_get( $url, [ 'headers' => [ 'Authorization' => 'Bearer ' . $this->token ] ] );
		if ( is_wp_error( $response ) || $response['response']['code'] !== 200 ) {
			throw new \RuntimeException( '商品情報取得に失敗しました. product_id: ' . $product_id );
		}

		$content  = json_decode( $response['body'], true );
		if ( ! $content ) {
			throw new \RuntimeException( '商品情報のデコードに失敗しました. product_id: ' . $product_id );
		}

		return new Product( $content );
    }
}