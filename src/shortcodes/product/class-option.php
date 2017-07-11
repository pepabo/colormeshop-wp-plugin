<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Shortcode_Interface;
use ColorMeShop\Swagger\ApiException;

class Option implements Shortcode_Interface {

	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop_option';
	}

	/**
	 * @param \Pimple\Container $container
	 * @param array $atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	public static function show( $container, $atts, $content, $tag ) {
		$filtered_atts = shortcode_atts(
			[
				'product_id' => $container['target_id'],
				'index' => 1,
				'data' => 'title',
			],
			$atts
		);

		try {
			$product = $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product'];
		} catch ( ApiException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( $e );
			}
			return '';
		}

		if ( ! $product['variants'] || ! isset( $product['variants'][ $filtered_atts['index'] - 1 ] ) ) {
			return '';
		}

		$v = $product['variants'][ $filtered_atts['index'] - 1 ];
		if ( ! isset( $v[ $filtered_atts['data'] ] ) ) {
			return '';
		}

		switch ( $filtered_atts['data'] ) {
			case 'stocks':
				return number_format( $v[ $filtered_atts['data'] ] ) . $product['unit'];
				break;
			case 'option_price':
			case 'option_members_price':
				return number_format( $v[ $filtered_atts['data'] ] );
				break;
			default:
				return $v[ $filtered_atts['data'] ];
				break;
		}
	}
}
