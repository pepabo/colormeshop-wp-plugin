<?php
namespace ColorMeShop;

use Illuminate\Pagination\LengthAwarePaginator;

class Paginator {

	/**
	 * @var LengthAwarePaginator
	 */
	private $paginator;

	/**
	 * @param array $search_params
	 * @param array $response
	 */
	public function __construct( $search_params, $response ) {
		$pager_params = array_merge(
			[
				'colorme_page' => 'items',
			],
			$search_params
		);
		unset( $pager_params['offset'] );

		$this->paginator = new LengthAwarePaginator(
			$response['products'],
			$response['meta']['total'],
			$response['meta']['limit'],
			get_query_var( 'page_no' ),
			[
				'path' => get_permalink(),
				'query' => $pager_params,
				'pageName' => 'page_no',
			]
		);
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
}
