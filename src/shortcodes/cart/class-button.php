<?php
namespace ColorMeShop\Shortcodes\Cart;

use ColorMeShop\Shortcode_Interface;

class Button implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'cart_button';
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
			],
			$atts
		);

		try {
			return "<script type='text/javascript' src='" . $container['model.shop_api']->fetch()->url . '/?mode=cartjs&pid=' . $filtered_atts['product_id'] . "&style=washi&name=n&img=n&expl=n&stock=n&price=n&inq=n&sk=n' charset='euc-jp'></script>";
		} catch ( \RuntimeException $e ) {
			if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
				error_log( $e );
			}
			return '';
		}
	}
}
