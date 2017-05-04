<?php
namespace ColorMeShop\Models;

class Product {
	/**
	 * @var array
	 */
	private $api_response;

	/**
	 * @param array $api_response
	 */
	public function __construct( $api_response ) {
		$this->api_response = $api_response;
	}

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function __get( $name ) {
		return isset( $this->api_response['product'][ $name ] ) ? $this->api_response['product'][ $name ] : null;
	}
}
