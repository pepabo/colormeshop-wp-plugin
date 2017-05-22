<?php
namespace ColorMeShop\Shortcodes;

use ColorMeShop\Models\Product as ProductModel;

class Product_Test extends \WP_UnitTestCase {
	/** @var \Pimple\Container */
	private $container;

	/** @var string */
	private $error_log;

	/** @var string */
	private $original_error_log;

	public function setUp() {
		parent::setUp();
		$expl = <<<"__EOS__"
説明のテスト
説明のテスト
説明のテスト
__EOS__;
		$smartphone_expl = <<<"__EOS__"
説明のテスト(スマートフォン)
説明のテスト(スマートフォン)
説明のテスト(スマートフォン)
__EOS__;

		$product = new ProductModel([
			'product' => [
				'id' => 123,
				'name' => 'テスト商品',
                'model_number' => 'テスト型番',
				'price' => 1200,
				'sales_price' => 1000,
				'members_price' => 800,
				'unit' => '個',
				'weight' => 2000,
				'simple_expl' => '簡易説明のテスト',
				'expl' => $expl,
				'smartphone_expl' => $smartphone_expl,
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
		$this->assertSame( 'colormeshop_product', Product::name() );
	}

	/**
	 * @test
	 */
	public function show_product_idが無い場合_空文字を返す() {
		$this->assertSame(
			'',
			Product::show(
				$this->container,
				[
					'data' => 'id',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_dataが無い場合_空文字を返す() {
		$this->assertSame(
			'',
			Product::show(
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
	public function show_パラメータが不足している_デバッグが有効な場合_ログを出力する() {
		$this->container['WP_DEBUG_LOG'] = function ( $c ) {
			return true;
		};

		Product::show(
			$this->container,
			[],
			null,
			null
		);

		$this->assertStringMatchesFormat( '%aパラメータが不足しています%a',  file_get_contents( $this->error_log ) );
	}

	/**
	 * @test
	 */
	public function show_存在しないdataが指定された場合_空文字を返す() {
		$this->assertSame(
			'',
			Product::show(
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

	/**
	 * @test
	 */
	public function id_商品IDを返す() {
		$this->assertSame(
			123,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'id',
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
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'id',
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

		Product::show(
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
	public function name_商品名を返す() {
		$this->assertSame(
			'テスト商品',
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'name',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function price_定価を返す() {
		$this->assertSame(
			1200,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'price',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function regular_price_通常販売価格を返す() {
		$this->assertSame(
			1000,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'regular_price',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function members_price_会員価格を返す() {
		$this->assertSame(
			800,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'members_price',
				],
				null,
				null
			)
		);
	}

    /**
     * @test
     */
    public function model_型番を返す() {
        $this->assertSame(
            'テスト型番',
            Product::show(
                $this->container,
                [
                    'product_id' => 123,
                    'data' => 'model',
                ],
                null,
                null
            )
        );
    }

	/**
	 * @test
	 */
	public function unit_単位を返す() {
		$this->assertSame(
			'個',
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'unit',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function weight_重量を返す() {
		$this->assertSame(
			2000,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'weight',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function simple_explain_簡易説明を返す() {
		$this->assertSame(
			'簡易説明のテスト',
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'simple_explain',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function explain_商品詳細説明を返す() {
		$expected = <<<"__EOS__"
説明のテスト<br />
説明のテスト<br />
説明のテスト
__EOS__;

		$this->assertSame(
			$expected,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'explain',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function explain_モバイルデバイスの場合スマートフォン用説明を返す() {
		$this->container['is_mobile'] = function ($c) {
			return true;
		};
		$expected = <<<"__EOS__"
説明のテスト(スマートフォン)<br />
説明のテスト(スマートフォン)<br />
説明のテスト(スマートフォン)
__EOS__;

		$this->assertSame(
			$expected,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'explain',
				],
				null,
				null
			)
		);
	}
}
