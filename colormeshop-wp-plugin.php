<?php
/**
 * Plugin Name: カラーミーショップ Wordpressプラグイン
 * Plugin URI: http://
 * Description: カラーミーショップAPIと連携して商品詳細ページを自動生成します
 * Version: 0.1
 * Author: GMO Pepabo, Inc.
 * Author URI: https://pepabo.com/
 * License: GPL2
 */
require_once( 'vendor/autoload.php' );

( new \ColorMeShop\Plugin )->register();