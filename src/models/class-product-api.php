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
     */
	public function fetch( $product_id ) {
		$url      = "https://api.shop-pro.jp/v1/products/{$product_id}.json";
		$response = wp_remote_get( $url, [ 'headers' => [ 'Authorization' => 'Bearer ' . $this->token ] ] );
		$content  = json_decode( $response['body'], true );

		return new Product( $content );
    }
}