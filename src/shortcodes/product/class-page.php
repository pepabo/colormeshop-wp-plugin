<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Shortcode_Interface;

class Page implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop_page';
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
			array(
				'product_id' => $container['target_id'],
				'template'   => 'default',
			),
			$atts
		);
		$template_file = $container['templates_dir'] . '/product/' . $filtered_atts['template'] . '.php';

		if (
			preg_match( '/\A[a-z]+\z/', $filtered_atts['template'] ) !== 1
			|| ! file_exists( $template_file )
		) {
			return '';
		}

		if ( empty( $filtered_atts['product_id'] ) ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( '商品IDのパラメータが不足しています. atts: ' . json_encode( $filtered_atts ) );
			}
			return '';
		}

		try {
			$product = $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product'];
		} catch ( \ColorMeShop\Swagger\ApiException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( '存在しない商品IDが指定された可能性があります。' . $e );
			}
			return '';
		} catch ( \RuntimeException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( $e );
			}
			return '';
		}

		ob_start();
		include $template_file;
		return ob_get_clean();
	}
}
