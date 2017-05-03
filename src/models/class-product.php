<?php
namespace ColorMeShop\Models;

class Product {
    /**
     * @var array
     */
    private $apiResponse;

    /**
     * @param array $apiResponse
     */
	public function __construct( $apiResponse ) {
        $this->apiResponse = $apiResponse;
    }

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function __get( $name ) {
		return isset( $this->apiResponse['product'][$name]) ? $this->apiResponse['product'][$name] : null;
	}
}