# カラーミーショップ WordPress プラグイン

WordPress で [カラーミーショップ](https://shop-pro.jp/) に登録している商品情報を扱ったり、商品ページを自動生成することができるプラグインです :muscle: 

## 利用方法

当プラグインは [カラーミーショップ API](https://shop-pro.jp/func/api/) を利用して商品情報などを取得しています。  
そのため、予め下記に登録していただき、発行された情報を WordPress 管理画面で入力してください。

- [カラーミーデベロッパーアカウント](https://api.shop-pro.jp/developers/sign_up)
- [OAuthアプリケーション登録](https://api.shop-pro.jp/oauth/applications/new)

## 動作環境

PHP 5.6 以上

## 一緒に開発しませんか？

当プラグインについて、お気づきの点やアイデアをお持ちのかたはぜひ開発にご参加ください。  
また、「こんな機能あったら良さそうなんだけど、どうでしょう？」といったお話も大歓迎ですので気軽に [Issues](https://github.com/pepabo/colormeshop-wp-plugin/issues) に投稿してみましょう!

### 開発の流れ

1. このリポジトリに Star をつける (重要です! :sparkles: )
1. 自分のリポジトリにフォーク
1. ブランチを切る (`git checkout -b my-new-feature`)
1. 変更をコミット (`git commit -am 'Add some feature`)
1. ブランチをプッシュ (`git push origin my-new-feature`)
1. Pull Request を作成

### すぐに開発を始められます

[docker](https://www.docker.com/) 用のコンテナ定義ファイル `docker-compose.yml` を用意していますので、ローカル環境にすばやく WordPress を立ち上げてプラグインの開発を始められます。

```
$ cp wp.env.sample wp.env
$ docker-compose up -d
$ open http://localhost:8080
```

## 開発ガイド

### コーディング規約

PHP_CodeSniffer の WordPress 用ルールセットである [WordPress-Coding-Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) を利用することを推奨しています。

当プラグインでは上記ルールセットの [WordPress-Core](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards#rulesets) に準拠していますので、Pull Request を作成される際は予め規約エラーがないことを確認してください。


```
# インストール
$ composer create-project wp-coding-standards/wpcs --no-dev
# 規約チェック
$ wpcs/vendor/bin/phpcs --standard=WordPress-Core hoge.php
# インデントなどは自動整形できます
$ wpcs/vendor/bin/phpcbf --standard=WordPress-Core hoge.php
```

### モデルやショートコードを追加したけどオートロードされない場合は

[dump-autoload](https://getcomposer.org/doc/03-cli.md#dump-autoload) を実行してクラスマップを再生成してください。  
WordPress の命名規則は [PSR](http://www.php-fig.org/psr/psr-4/) と異なるので、[classmap](https://getcomposer.org/doc/04-schema.md#classmap) を利用しています。


```
$ composer dump-autoload
```

### ユニットテスト

docker コンテナ内でユニットテストを実行するためのスクリプトを用意しています。  

```
$ tests/run.sh
```

初回実行時はテスト環境のインストールが走るので少し時間がかかります。

### ビルド

```
$ fab build
```
