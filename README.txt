=== ColorMeShop WordPress Plugin ===
Contributors: colormeshop
Tags: ecommerce, ec, colormeshop
Requires at least: 5.2
Tested up to: 6.4.2
Requires PHP: 7.3.0
Stable tag: trunk
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

カラーミーショップ WordPress プラグインはWordPressでオンラインショップを構築することができるプラグインです。

== Description ==

商品管理やショッピングカートの機能はカラーミーショップを利用することで、本格的なオンラインショップ構築をWordPressで行うことができます。
なお、ご利用には[カラーミーショップ](https://shop-pro.jp/)との契約が必要です。

当プラグインでは以下の機能を備えています。

### 商品ページの自動作成及びXMLサイトマップ作成機能

カラーミーショップで登録された商品情報に基づいてWordPress上へ商品ページの自動作成とWordPressからXMLサイトマップの出力を行うことができます。
また、商品ページは後述のショートコードを用いて商品ページのカスタマイズをすることも可能です。

### ショートコード機能

当プラグインをインストールすることで、以下の様なショートコードがご利用いただけるようになります。

- 商品情報を表示用ショートコード
- 商品画像を表示用ショートコード
- 商品オプション表示用ショートコード
- カートボタン表示用ショートコード
- テンプレートにレイアウトされている商品ページ表示用ショートコード

詳しくはプラグインをインストール後に表示されるメニューの説明をご覧ください。

### 備考

カラーミーショップWordPressプラグインの利用には[カラーミーショップ](https://shop-pro.jp/)の契約と[デベロッパーの登録(無償)](https://developer.shop-pro.jp/sign_up)が必要になります。
プラグインはカラーミーショップAPIを介してカラーミーショップで作成されたオンラインショップの商品情報を取得し、WordPress側へ反映を行います。

== Installation ==

WordPressのダッシュボードより

1. プラグイン＞プラグインの追加 より "colormeshop" で検索してください
2. プラグインのメニューからプラグインを有効化してください
3. プラグイン内の説明に従って、プラグインとカラーミーショップAPIの連携を設定してください

== Frequently Asked Questions ==

If you have any questions, please let me know via https://github.com/pepabo/colormeshop-wp-plugin/issues/

== Changelog ==
= 1.0.0 =
* 初回リリース
= 1.0.1 =
* プラグインの説明文を更新
= 1.0.2 =
* 商品カテゴリー一覧ページの不具合を修正
= 1.0.3 =
* 商品画像のショートコード不具合を修正
= 1.0.4 =
* 商品画像のショートコード不具合を修正
= 1.0.5 =
* 管理画面での編集時にエラーが出る不具合を修正
= 1.0.6 =
* count関数のWarningが出ているのを修正
= 2.0.0 =
* サポートバージョンをWordPress 5.2.0、PHP 7.3.0以上に変更
