<?php
namespace ColorMeShop\Shortcodes\Product;

use ColorMeShop\Models\Product;

class Option_Test extends \WP_UnitTestCase {

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
				'unit' => '個',
				'variants' => [
					[
						'title' => '赤　×　L',
						'stocks' => 1000,
						'option_price' => 2000,
						'option_members_price' => 1500,
					],
					[
						'title' => '赤　×　M',
						'stocks' => 500,
						'option_price' => 1000,
						'option_members_price' => 800,
					],
				],
			],
		]);

		$this->container = _get_container();

		$product_api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
			->setConstructorArgs( [ 'dummy_token', $this->container['paginator_factory'] ] )
			->setMethods( [ 'fetch' ] )
			->getMock();
		$product_api->expects( $this->any() )
			->method( 'fetch' )
			->willReturn( $product );

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
		$this->assertSame( 'colormeshop_option', Option::name() );
	}

	/**
	 * @test
	 */
	public function show_オプション名を返す() {
		$this->assertSame(
			'赤　×　L',
			Option::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'title',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_単位付きの在庫数を返す() {
		$this->assertSame(
			'1,000個',
			Option::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'stocks',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_オプションの価格を返す() {
		$this->assertSame(
			'2,000',
			Option::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'option_price',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_商品情報の取得に失敗した場合_空文字を返す() {
		$product_api = $this->getMockBuilder( '\ColorMeShop\Models\Product_Api' )
			->setConstructorArgs( [ 'dummy_token', $this->container['paginator_factory'] ] )
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
			Option::show(
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
			->setConstructorArgs( [ 'dummy_token', $this->container['paginator_factory'] ] )
			->setMethods( [ 'fetch' ] )
			->getMock();
		$product_api->expects( $this->any() )
			->method( 'fetch' )
			->will( $this->throwException( new \RuntimeException() ) );

		$this->container['model.product_api'] = function ( $c ) use ( $product_api ) {
			return $product_api;
		};

		Option::show(
			$this->container,
			[
				'product_id' => 123,
				'data' => 'id',
			],
			null,
			null
		);

		$this->assertStringMatchesFormat( '%aException%a',  file_get_contents( $this->error_log ) );
	}

	/**
	 * @test
	 */
	public function show_indexで取得するオプションを指定できる() {
		$this->assertSame(
			'赤　×　M',
			Option::show(
				$this->container,
				[
					'product_id' => 123,
					'index' => 2,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_存在しないindexを指定した場合_空文字を返す() {
		$this->assertSame(
			'',
			Option::show(
				$this->container,
				[
					'product_id' => 123,
					'index' => 999,
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_存在しないdataを指定した場合_空文字を返す() {
		$this->assertSame(
			'',
			Option::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'XXX',
				],
				null,
				null
			)
		);
	}
}
