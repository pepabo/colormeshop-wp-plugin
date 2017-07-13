<?php
namespace ColorMeShop;

use ColorMeShop\Models\Setting;

class Url_Builder {
	/**
	 * @var Setting
	 */
	private $setting;

	/**
	 * @param Setting $setting
	 */
	public function __construct( Setting $setting ) {
		$this->setting = $setting;
	}

	/**
	 * @param int $id
	 * @return string
	 */
	public function item( $id ) {
		if ( $this->product_page_has_query() ) {
			return $this->product_page_permalink() . '&colorme_item=' . $id;
		}

		return trim( $this->product_page_permalink(), '/' ) . '/?colorme_item=' . $id;
	}

	/**
	 * @param array $params
	 * @return string
	 */
	public function items( $params = [] ) {
		if ( $this->product_page_has_query() ) {
			$items_url = $this->product_page_permalink() . '&colorme_page=items';
		} else {
			$items_url = trim( $this->product_page_permalink(), '/' ) . '/?colorme_page=items';
		}

		return $items_url . ( ($params) ? '&' . http_build_query( $params ) : '');
	}

	/**
	 * @return string
	 */
	public function categories() {
		if ( $this->product_page_has_query() ) {
			return $this->product_page_permalink() . '&colorme_page=categories';
		}

		return trim( $this->product_page_permalink(), '/' ) . '/?colorme_page=categories';
	}

	/**
	 * @return string
	 */
	public function sitemap_index() {
		return $this->sitemap( null );
	}

	/**
	 * @param int $offset
	 * @return string
	 */
	public function sitemap( $offset = null ) {
		if ( $this->product_page_has_query() ) {
			return $this->product_page_permalink() . '&colorme_page=sitemap' . ((null === $offset) ? '' : '&offset=' . $offset);
		}

		return trim( $this->product_page_permalink(), '/' ) . '/sitemap.xml' . ((null === $offset) ? '' : '?offset=' . $offset);
	}

	/**
	 * @return bool
	 */
	private function product_page_has_query() {
		return strpos( $this->product_page_permalink(), '?' ) !== false;
	}

	/**
	 * @return string
	 */
	public function product_page_permalink() {
		return get_permalink( $this->setting->product_page_id() );
	}
}
