<?php
namespace ColorMeShop\Shortcodes;

use ColorMeShop\Shortcode_Interface;
use ColorMeShop\Swagger\ApiException;

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

		if ( method_exists( self::class, '_' . $filtered_atts['data'] ) ) {
			try {
				return call_user_func_array(
					[ self::class, '_' . $filtered_atts['data'] ],
					[ $container, $filtered_atts, $content, $tag ]
				);
			} catch ( ApiException $e ) {
				if ( $container['WP_DEBUG_LOG'] ) {
					error_log( $e );
				}
				return '';
			}
		}

		return '';
	}

	/**
	 * @param int|null $n
	 * @return string
	 */
	private static function number_format( $n ) {
		if ( is_null( $n ) ) {
			return '';
		}

		return number_format( $n );
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
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['id'];
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
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['name'];
	}

	/**
	 * 型番
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _model( $container, $filtered_atts, $content, $tag ) {
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['model_number'];
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
		return self::number_format( $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['price'] );
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
		return self::number_format( $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['sales_price'] );
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
		return self::number_format( $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['members_price'] );
	}

	/**
	 * 単位
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _unit( $container, $filtered_atts, $content, $tag ) {
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['unit'];
	}

	/**
	 * 重量
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _weight( $container, $filtered_atts, $content, $tag ) {
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['weight'];
	}

	/**
	 * 簡易説明
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _simple_explain( $container, $filtered_atts, $content, $tag ) {
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['simple_expl'];
	}

	/**
	 * 商品詳細説明
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _explain( $container, $filtered_atts, $content, $tag ) {
		$p = $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product'];
		// モバイルデバイスの場合はスマートフォン用の説明を返す(フィーチャーフォン未対応)
		if ( null !== $p['smartphone_expl'] && '' !== $p['smartphone_expl'] && $container['is_mobile'] ) {
			return nl2br( $p['smartphone_expl'] );
		}

		return nl2br( $p['expl'] );
	}

	/**
	 * 個別送料
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _postage( $container, $filtered_atts, $content, $tag ) {
		return $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product']['delivery_charge'];
	}

	/**
	 * 在庫数
	 *
	 * @param \Pimple\Container $container
	 * @param array $filtered_atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	private static function _stocks( $container, $filtered_atts, $content, $tag ) {
		$p = $container['api.product_api']->fetch( $filtered_atts['product_id'] )['product'];
		if ( ! $p['stock_managed'] ) {
			return '';
		}

		return number_format( $p['stocks'] ) . self::_unit( $container, $filtered_atts, $content, $tag );
	}
}
