<?php
namespace ColorMeShop;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator {

	/**
	 * @var LengthAwarePaginator
	 */
	private $paginator;

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
		$pager_params = array_merge(
			[
				'colorme_page' => $page_name,
			],
			$search_params
		);
		unset( $pager_params['limit'] );
		unset( $pager_params['offset'] );

		$this->paginator = new LengthAwarePaginator(
			$response['products'],
			$response['meta']['total'],
			$response['meta']['limit'],
			$current_page_no,
			[
				'path' => $product_page_url,
				'query' => $pager_params,
				'pageName' => 'page_no',
			]
		);
		$this->response = $response;
	}

	/**
	 * @return string
	 */
	public function links() {
		return $this->paginator->links();
	}

	/**
	 * @return array
	 */
	public function data() {
		return $this->paginator->toArray()['data'];
	}

	/**
	 * @return int
	 */
	public function total() {
		return $this->response['meta']['total'];
	}
}
