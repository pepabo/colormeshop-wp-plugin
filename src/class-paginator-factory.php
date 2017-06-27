<?php
namespace ColorMeShop;

class Paginator_Factory {
    /**
     * @var string
     */
	private $product_page_url;

    /**
     * @var int
     */
	private $current_page_no;

    /**
     * @param string $product_page_url
     * @param int $current_page_no
     */
	public function __construct( $product_page_url, $current_page_no ) {
		$this->product_page_url = $product_page_url;
		$this->current_page_no = $current_page_no;
	}

    /**
     * @param array $params
     * @param array $response
     * @return Paginator
     */
	public function make( $params, $response ) {
		return new Paginator( $params, $response, $this->product_page_url, 'items', $this->current_page_no );
	}
}

