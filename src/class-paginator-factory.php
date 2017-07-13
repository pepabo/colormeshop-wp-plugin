<?php
namespace ColorMeShop;

class Paginator_Factory {
	/**
	 * @var Url_Builder
	 */
	private $url_builder;

	/**
	 * @var int
	 */
	private $current_page_no;

	/**
	 * @param Url_Builder $url_builder
	 * @param int $current_page_no
	 */
	public function __construct( Url_Builder $url_builder, $current_page_no ) {
		$this->url_builder = $url_builder;
		$this->current_page_no = $current_page_no;
	}

	/**
	 * @param array $params
	 * @param array $response
	 * @return Paginator
	 */
	public function make( $params, $response ) {
		return new Paginator( $params, $response, $this->url_builder->product_page_permalink(), 'items', $this->current_page_no );
	}
}

