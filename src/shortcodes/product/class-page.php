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
		$product = $container['model.product_api']->fetch($filtered_atts['product_id']);

		ob_start();
		include __DIR__ . '/../../../templates/item.php';
		return ob_get_clean();
	}
}
