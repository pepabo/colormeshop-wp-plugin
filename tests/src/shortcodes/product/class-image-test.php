<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Models\Product;

class Image_Test extends \WP_UnitTestCase {
	/** @var \Pimple\Container */
	private $container;

	/** @var string */
	private $error_log;

	/** @var string */
	private $original_error_log;

	public function setUp() {
		parent::setUp();
		$product = new Product([
			'product' => [
				'id' => 123,
				'image_url' => 'http://img01.shop-pro.jp/PAXXX/XXX/product/123.jpg',
				'mobile_image_url' => 'http://img01.shop-pro.jp/PAXXX/XXX/product/123_mb.jpg',
				'images' => [
					[
						'src' => 'http://img01.shop-pro.jp/PAXXX/XXX/product/123_other1.jpg',
						'position' => 1,
						'mobile' => false,
					],
					[
						'src' => 'http://img01.shop-pro.jp/PAXXX/XXX/product/123_other1_mb.jpg',
						'position' => 1,
						'mobile' => true,
					],
					[
						'src' => 'http://img01.shop-pro.jp/PAXXX/XXX/product/123_other2.jpg',
						'position' => 2,
						'mobile' => false,
					],
					[
						'src' => 'http://img01.shop-pro.jp/PAXXX/XXX/product/123_other2_mb.jpg',
						'position' => 2,
						'mobile' => true,
					],
				],
			],
		]);

		$product_api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
							->setConstructorArgs( [ 'dummy_token' ] )
							->setMethods( [ 'fetch' ] )
							->getMock();
		$product_api->expects( $this->any() )
					->method( 'fetch' )
					->willReturn( $product );

		$this->container = _get_container();
		$this->container['model.product_api'] = function ( $c ) use ( $product_api ) {
			return $product_api;
		};

		// ログ出力先
		$this->error_log = tempnam( sys_get_temp_dir(), 'TEST' );
		$this->original_error_log = ini_set( 'error_log', $this->error_log );
	}

	public function tearDown() {
		parent::tearDown();
		ini_set( 'error_log', $this->original_error_log );
	}

	/**
	 * @test
	 */
	public function name_ショートコード名を返す() {
		$this->assertSame( 'colormeshop_product_image', Image::name() );
	}

	/**
	 * @test
	 */
	public function show_商品情報の取得に失敗した場合_空文字を返す() {
		$product_api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
							->setConstructorArgs( [ 'dummy_token' ] )
							->setMethods( [ 'fetch' ] )
							->getMock();
		$product_api->expects( $this->any() )
					->method( 'fetch' )
					->will( $this->throwException( new \RuntimeException() ) );

		$this->container['model.product_api'] = function ( $c ) use ( $product_api ) {
			return $product_api;
		};

		$this->assertSame(
			'',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_商品情報の取得に失敗した_デバッグが有効な場合_ログを出力する() {
		$this->container['WP_DEBUG_LOG'] = function ( $c ) {
			return true;
		};

		$product_api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
							->setConstructorArgs( [ 'dummy_token' ] )
							->setMethods( [ 'fetch' ] )
							->getMock();
		$product_api->expects( $this->any() )
					->method( 'fetch' )
					->will( $this->throwException( new \RuntimeException() ) );

		$this->container['model.product_api'] = function ( $c ) use ( $product_api ) {
			return $product_api;
		};

		Image::show(
			$this->container,
			[
				'product_id' => 123,
			],
			null,
			null
		);

		$this->assertStringMatchesFormat( '%aException%a',  file_get_contents( $this->error_log ) );
	}

	/**
	 * @test
	 */
	public function show_商品画像のタグを返す() {
		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123.jpg" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_モバイル用商品画像のタグを返す() {
		$this->container['is_mobile'] = function ( $c ) {
			return true;
		};
		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123_mb.jpg" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_画像が登録されていない場合_空文字を返す() {
		$product = new Product([
			'product' => [
				'id' => 123,
				'image_url' => null,
			],
		]);

		$product_api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
							->setConstructorArgs( [ 'dummy_token' ] )
							->setMethods( [ 'fetch' ] )
							->getMock();
		$product_api->expects( $this->any() )
					->method( 'fetch' )
					->willReturn( $product );

		$this->container['model.product_api'] = function ( $c ) use ( $product_api ) {
			return $product_api;
		};

		$this->assertSame(
			'',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_画像タグに追加の属性を指定できる() {
		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123.jpg" width="100" class="foo bar" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'width' => 100,
					'class' => 'foo bar',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_その他画像のタグを返す() {
		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123_other1.jpg" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'type' => 'other1',
				],
				null,
				null
			)
		);

		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123_other2.jpg" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'type' => 'other2',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_モバイル用その他画像のタグを返す() {
		$this->container['is_mobile'] = function ( $c ) {
			return true;
		};
		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123_other1_mb.jpg" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'type' => 'other1',
				],
				null,
				null
			)
		);

		$this->assertSame(
			'<img src="http://img01.shop-pro.jp/PAXXX/XXX/product/123_other2_mb.jpg" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'type' => 'other2',
				],
				null,
				null
			)
		);
	}
}
