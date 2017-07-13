<?php
namespace ColorMeShop\Models;

class Setting {

	const KEY = 'colorme_wp_settings';

	public function get( $name = null ) {
		$setting = get_option( self::KEY );
		if ( $name === null ) {
			return $setting ? $setting : [];
		}

		return $setting && array_key_exists( $name, $setting ) ? $setting[ $name ] : '';
	}

	public function token() {
		return $this->get( 'token' );
	}

	public function client_id() {
		return $this->get( 'client_id' );
	}

	public function client_secret() {
		return $this->get( 'client_secret' );
	}

	public function product_page_id() {
		return $this->get( 'product_page_id' );
	}
}
