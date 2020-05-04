<h1 align="center">カラーミーショップ WordPress プラグイン</h1>

<div align="center">

![icon](https://user-images.githubusercontent.com/1885716/42558421-255927dc-852c-11e8-98ad-2ff181592abe.png)

</div>

WordPress で [カラーミーショップ](https://shop-pro.jp/) に登録している商品情報を扱ったり、商品ページを自動生成することができるプラグインです :muscle: 

## 利用方法

当プラグインは [カラーミーショップ API](https://shop-pro.jp/func/api/) を利用して商品情報などを取得しています。  
そのため、予め下記に登録していただき、発行された情報を WordPress 管理画面で入力してください。

- [カラーミーデベロッパーアカウント](https://api.shop-pro.jp/developers/sign_up)
- [OAuthアプリケーション登録](https://api.shop-pro.jp/oauth/applications/new)

## 動作環境

PHP 7.3 以上

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

PHP_CodeSniffer の WordPress 用ルールセットである [WordPress-Coding-Standards](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) を利用しています。

また、PHPの互換性をチェックするために、[PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility)も利用しています。

これらの設定は、[ruleset.xml](./ruleset.xml)にあります。以下のコマンドで、phpcsによるチェックや自動変換を行うことができます。


```
# 規約チェック
$ docker-compose run composer vendor/bin/phpcs --standard=ruleset.xml
# インデントなどは自動整形できます
$ docker-compose run composer vendor/bin/phpcbf --standard=ruleset.xml
```

### APIクライアント

[Swagger Codegen](https://github.com/swagger-api/swagger-codegen) で生成したAPIクライアントを利用していて、[`src/Swagger`](https://github.com/pepabo/colormeshop-wp-plugin/tree/master/src/Swagger) に配置しています。

APIクライアントを更新する場合は下記のコマンドを実行してください。

```bash
# 準備
$ brew install pipenv
$ pipenv install

# APIクライアントを生成する
$ pipenv run fab generate_api_client
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
# 準備
$ brew install pipenv
$ pipenv install

# zipファイルを作成する
$ pipenv run fab build

# 開発中のプラグイン(ワーキングディレクトリのファイル)でzipファイルを作成する場合
$ pipenv run fab build:dev
```
