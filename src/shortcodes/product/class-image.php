<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Shortcode_Interface;
use ColorMeShop\Swagger\ApiException;

class Image implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop_image';
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
			$product = $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product'];
		} catch ( ApiException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( $e );
			}
			return '';
		}

		switch ( $filtered_atts['type'] ) {
			case 'main':
				$image_url = ( $product['mobile_image_url'] && $container['is_mobile'] ) ? $product['mobile_image_url'] : $product['image_url'];
				break;
			case 'thumbnail':
				$image_url = $product['thumbnail_image_url'];
				break;
			default:
				if ( ! self::is_request_for_other_image( $filtered_atts ) ) {
					return '';
				}
				$image_url = self::extract_other_image( $container, $filtered_atts );
				break;
		}

		if ( ! $image_url ) {
			return '';
		}

		$attributes = '';
		// 引数なしでショートコードを使った場合 $atts は空文字になる
		if ( is_array( $atts ) ) {
			foreach ( array_diff( $atts, $filtered_atts ) as $k => $v ) {
				$attributes .= sprintf( ' %s="%s"', $k, $v );
			}
		}

		return sprintf(
			'<img src="%s"%s />',
			$image_url,
			$attributes
		);
	}

	/**
	 * @param array $filtered_atts
	 * @return bool
	 */
	private static function is_request_for_other_image( $filtered_atts ) {
		return preg_match( '/\Aother[0-9]+\z/', $filtered_atts['type'] ) === 1;
	}

	/**
	 * @param string $other_image_type
	 * @return int
	 */
	private static function extract_other_image_index( $other_image_type ) {
		return (int) str_replace( 'other', '', $other_image_type );
	}

	/**
	 * @param \stdClass $product
	 * @param bool $is_mobile
	 * @return array
	 */
	private static function extract_other_images( $product, $is_mobile ) {
		$filtered_images = array_filter($product['images'], function ( $image ) use ( $is_mobile ) {
			if ( $is_mobile ) {
				return $image['mobile'];
			}

			return ! $image['mobile'];
		});

		return array_values( $filtered_images );
	}

	/**
	 * その他画像の URL を返す
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @return string
	 */
	private static function extract_other_image( $container, $filtered_atts ) {
		$index = self::extract_other_image_index( $filtered_atts['type'] );
		$other_images = self::extract_other_images(
			$container['api.product_api']->fetch( $filtered_atts['product_id'] )['product'],
			$container['is_mobile']
		);

		return isset( $other_images[ $index - 1 ] ) ? $other_images[ $index - 1 ]['src'] : '';
	}
}
