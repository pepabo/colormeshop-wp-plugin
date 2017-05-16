<?php
namespace ColorMeShop\Shortcodes;

use ColorMeShop\Shortcode_Interface;

/**
 * @see https://shop-pro.jp/manual/menu_06_02_01#tag03
 */
class Product implements Shortcode_Interface {
	/**
	 * @return string
	 */
	public static function name() {
		return 'colormeshop_product';
	}

	/**
	 * 入力のバリデーションと、商品情報を返す各メソッドへの仲介を行う
	 *
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
				'data' => null,
			],
			$atts
		);

		if ( empty( $filtered_atts['product_id'] ) || empty( $filtered_atts['data'] ) ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( 'パラメータが不足しています. atts: ' . json_encode( $filtered_atts ) );
			}
			return '';
		}

		try {
			$container['model.product_api']->fetch( $filtered_atts['product_id'] );
		} catch ( \RuntimeException $e ) {
			if ( $container['WP_DEBUG_LOG'] ) {
				error_log( $e );
			}
			return '';
		}

		if ( method_exists( self::class, '_' . $filtered_atts['data'] ) ) {
			return call_user_func_array(
				[ self::class, '_' . $filtered_atts['data'] ],
				[ $container, $filtered_atts, $content, $tag ]
			);
		}
	}

	/**
	 * 商品ID
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _id( $container, $filtered_atts, $content, $tag ) {
		return $container['model.product_api']->fetch( $filtered_atts['product_id'] )->id;
	}

	/**
	 * 商品名
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _name( $container, $filtered_atts, $content, $tag ) {
		return $container['model.product_api']->fetch( $filtered_atts['product_id'] )->name;
	}

	/**
	 * 定価
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _price( $container, $filtered_atts, $content, $tag ) {
		return $container['model.product_api']->fetch( $filtered_atts['product_id'] )->price;
	}

	/**
	 * 通常販売価格（割引前の販売価格）
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _regular_price( $container, $filtered_atts, $content, $tag ) {
		return $container['model.product_api']->fetch( $filtered_atts['product_id'] )->sales_price;
	}

	/**
	 * 会員価格
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _members_price( $container, $filtered_atts, $content, $tag ) {
		return $container['model.product_api']->fetch( $filtered_atts['product_id'] )->members_price;
	}
}
