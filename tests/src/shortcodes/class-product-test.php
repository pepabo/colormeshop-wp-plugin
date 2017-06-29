<?php
namespace ColorMeShop\Shortcodes;

class Product_Test extends \WP_UnitTestCase {
	/** @var \Pimple\Container */
	private $container;

	/** @var string */
	private $error_log;

	/** @var string */
	private $original_error_log;

	public function setUp() {
		parent::setUp();

		$this->container = _get_container();
		$this->container['token'] = function ( $c ) {
			return 'dummy';
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
	 * @vcr shortcodes/product/200.yml
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
	 * @vcr shortcodes/product/400.yml
	 */
	public function show_商品情報の取得に失敗した場合_空文字を返す() {
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
	 * @vcr shortcodes/product/400.yml
	 */
	public function show_商品情報の取得に失敗した_デバッグが有効な場合_ログを出力する() {
		$this->container['WP_DEBUG_LOG'] = function ( $c ) {
			return true;
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
	 * @vcr shortcodes/product/unset_price.yml
	 */
	public function number_format_価格未設定の場合_空文字を返す() {
		$this->assertSame(
			'',
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
	 * @vcr shortcodes/product/200.yml
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function price_定価を返す() {
		$this->assertSame(
			'1,500',
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function regular_price_通常販売価格を返す() {
		$this->assertSame(
			'1,000',
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function members_price_会員価格を返す() {
		$this->assertSame(
			'1,011',
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function model_型番を返す() {
		$this->assertSame(
			'KATABAN',
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
	 * @vcr shortcodes/product/200.yml
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
	 * @vcr shortcodes/product/200.yml
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function simple_explain_簡易説明を返す() {
		$this->assertSame(
			'商品の説明です。',
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function explain_商品詳細説明を返す() {
		$expected = <<<"__EOS__"
商品の説明です。<br />
商品の説明です。<br />
商品の説明です。
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function explain_モバイルデバイスの場合スマートフォン用説明を返す() {
		$this->container['is_mobile'] = function ( $c ) {
			return true;
		};
		$expected = <<<"__EOS__"
スマートフォンショップ用商品の説明です。<br />
スマートフォンショップ用商品の説明です。<br />
スマートフォンショップ用商品の説明です。
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
	 * @vcr shortcodes/product/200.yml
	 */
	public function postage_個別送料を返す() {
		$this->assertSame(
			1000,
			Product::show(
				$this->container,
				[
					'product_id' => 123,
					'data' => 'postage',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 * @vcr shortcodes/product/200.yml
	 */
	public function stocks_単位付きの在庫数を返す() {
		$this->assertSame(
			'1,000個',
			Product::show(
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
	 * @vcr shortcodes/product/unlimited.yml
	 */
	public function stocks_在庫管理していない場合は空文字を返す() {
		$this->assertSame(
			'',
			Product::show(
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
}
