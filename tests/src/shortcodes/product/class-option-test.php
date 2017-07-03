<?php
namespace ColorMeShop\Shortcodes\Product;

class Option_Test extends \WP_UnitTestCase {

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
		$this->assertSame( 'colormeshop_option', Option::name() );
	}

	/**
	 * @test
	 * @vcr shortcodes/product/option/200.yml
	 */
	public function show_オプション名を返す() {
		$this->assertSame(
			'赤　×　S',
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
	 * @vcr shortcodes/product/option/200.yml
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
	 * @vcr shortcodes/product/option/200.yml
	 */
	public function show_オプションの価格を返す() {
		$this->assertSame(
			'1,111',
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
	 * @vcr shortcodes/product/option/400.yml
	 */
	public function show_商品情報の取得に失敗した場合_空文字を返す() {
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
	 * @vcr shortcodes/product/option/400.yml
	 */
	public function show_商品情報の取得に失敗した_デバッグが有効な場合_ログを出力する() {
		$this->container['WP_DEBUG_LOG'] = function ( $c ) {
			return true;
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
	 * @vcr shortcodes/product/option/200.yml
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
	 * @vcr shortcodes/product/option/200.yml
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
	 * @vcr shortcodes/product/option/200.yml
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
