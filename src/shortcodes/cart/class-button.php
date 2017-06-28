<?php
namespace ColorMeShop\Shortcodes\Cart;

use ColorMeShop\Shortcode_Interface;

class Button implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop_cart_button';
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
				'style' => 'basic',
			],
			$atts
		);

		try {
			return sprintf(
				'<script type="text/javascript" src="%s/?mode=cartjs&pid=%d&style=%s&name=n&img=n&expl=n&stock=n&price=n&inq=n&sk=n" charset="euc-jp"></script>',
				$container['swagger.api.shop']->getShop()['shop']->getUrl(),
				$filtered_atts['product_id'],
				$filtered_atts['style']
			);
		} catch ( \RuntimeException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( $e );
			}
			return '';
		}
	}
}
