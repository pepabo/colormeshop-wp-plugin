<?php
namespace ColorMeShop\Models;

class Setting {
	/** @var string */
	const KEY = 'colorme_wp_settings';

	/**
	 * @param null|string $name
	 * @return array|string
	 */
	public function get( $name = null ) {
		$setting = get_option( self::KEY );
		if ( $name === null ) {
			return $setting ? $setting : [];
		}

		return $setting && array_key_exists( $name, $setting ) ? $setting[ $name ] : '';
	}

	/**
	 * @return string
	 */
	public function token() {
		return $this->get( 'token' );
	}

	/**
	 * @return string
	 */
	public function client_id() {
		return $this->get( 'client_id' );
	}

	/**
	 * @return string
	 */
	public function client_secret() {
		return $this->get( 'client_secret' );
	}

	/**
	 * @return string
	 */
	public function product_page_id() {
		return $this->get( 'product_page_id' );
	}

	/**
	 * 商品ページ ID を検証する
	 *
	 * @param int $product_page_id
	 * @return bool
	 */
	public function is_valid_product_page_id( $product_page_id = null ) {
		if ( null === $product_page_id ) {
			$product_page_id = $this->product_page_id();
		}

		if ( ! $product_page_id || ! is_numeric( $product_page_id ) ) {
			return false;
		}

		$p = get_post( $product_page_id );
		if ( ! $p || 'page' !== $p->post_type ) {
			return false;
		}

		return true;
	}

	/**
	 * @param array $values
	 * @return bool
	 */
	public function update( $values ) {
		$settings = array_merge( $this->get(), $values );

		// update_option() は値に変更が無い場合にも false を返す
		// @see https://codex.wordpress.org/Function_Reference/update_option
		return update_option( self::KEY, $settings, true );
	}
}
