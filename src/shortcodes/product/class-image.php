<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Shortcode_Interface;

class Image implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop_product_image';
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
				'type' => 'main',
			],
			$atts
		);

		try {
			$product = $container['model.product_api']->fetch( $filtered_atts['product_id'] );
		} catch ( \RuntimeException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( $e );
			}
			return '';
		}

		switch ( $filtered_atts['type'] ) {
			case 'main':
				// TODO: wp_is_mobile() は #14 をマージしたら DI コンテナに置き換える. モバイルアクセスのテストを書く.
				$image_url = ( $product->mobile_image_url && wp_is_mobile() ) ? $product->mobile_image_url : $product->image_url;
				break;
			case 'thumbnail':
				$image_url = $product->thumbnail_image_url;
				break;
			default:
				return '';
				break;
		}

		if ( ! $image_url ) {
			return '';
		}

		$attributes = '';
		foreach ( array_diff( $atts, $filtered_atts ) as $k => $v ) {
			$attributes .= sprintf( ' %s="%s"', $k, $v );
		}

		return sprintf(
			'<img src="%s"%s />',
			$image_url,
			$attributes
		);
	}
}
