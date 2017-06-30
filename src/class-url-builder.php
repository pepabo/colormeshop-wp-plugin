<?php
namespace ColorMeShop;

class Url_Builder {
	/**
	 * @var string
	 */
	private $product_page_url;

	/**
	 * @param string $product_page_url
	 */
	public function __construct( $product_page_url ) {
		$this->product_page_url = $product_page_url;
	}

	/**
	 * @param int $id
	 * @return string
	 */
	public function item( $id ) {
		if ( $this->product_page_has_query() ) {
			return $this->product_page_url . '&colorme_item=' . $id;
		}

		return trim( $this->product_page_url, '/' ) . '/?colorme_item=' . $id;
	}

	/**
	 * @return bool
	 */
	private function product_page_has_query() {
		return strpos( $this->product_page_url, '?' ) !== false;
	}
}
