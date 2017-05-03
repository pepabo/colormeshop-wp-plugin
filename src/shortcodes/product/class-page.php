<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Shortcode_Interface;

class Page implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop-product-page';
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
			[ 'product_id' => $container['target_id'] ],
			$atts
		);

		try {
			$product = $container['model.product_api']->fetch( $filtered_atts['product_id'] );
		} catch ( \RuntimeException $e ) {
			if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
				error_log( $e );
			}
			return '';
		}

		ob_start();
		include $container['templates_dir'] . '/item.php';
		return ob_get_clean();
	}
}
