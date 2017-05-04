<?php
namespace ColorMeShop;

interface Shortcode_Interface {
	/**
	 * ショートコード名を返す
	 *
	 * @return string
	 */
	public static function name();

	/**
	 * ショートコード出力の文字列を返す
	 *
	 * @see https://wpdocs.osdn.jp/%E3%82%B7%E3%83%A7%E3%83%BC%E3%83%88%E3%82%B3%E3%83%BC%E3%83%89_API
	 * @param \Pimple\Container $container
	 * @param array $atts
	 * @param string $content
	 * @param string $tag
	 * @return string
	 */
	public static function show( $container, $atts, $content, $tag );
}
