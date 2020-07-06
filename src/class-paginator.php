<?php
namespace ColorMeShop;

class Paginator {

	/**
	 * @var int
	 */
	private $total_pages;

	/**
	 * @var int
	 */
	private $current_page;

	/**
	 * @var array
	 */
	private $response;

	/**
	 * @param array $search_params
	 * @param array $response
	 * @param string $product_page_url
	 * @param string $page_name
	 * @param int $current_page_no
	 */
	public function __construct( $search_params, $response, $product_page_url, $page_name, $current_page_no ) {
		$this->total_pages  = ceil( $response['meta']['total'] / $response['meta']['limit'] );
		$this->current_page = is_numeric( $current_page_no ) ? intval( $current_page_no ) : 1;
		$this->response     = $response;
	}

	/**
	 * @return string
	 */
	public function links() {
		return paginate_links(
			array(
				'total'     => $this->total_pages,
				'current'   => $this->current_page,
				'format'    => '?page_no=%#%',
				'prev_text' => '&laquo;',
				'next_text' => '&raquo;',
				'type'      => 'list',
			)
		);
	}

	/**
	 * @return array
	 */
	public function data() {
		return $this->response['products'];
	}

	/**
	 * @return int
	 */
	public function total() {
		return $this->response['meta']['total'];
	}
}
