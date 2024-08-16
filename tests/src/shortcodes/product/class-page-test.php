<?php
namespace ColorMeShop\Shortcodes\Product;

class Page_Test extends \WP_UnitTestCase {

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
		$this->assertSame( 'colormeshop_page', Page::name() );
	}

	/**
	 * @test
	 */
	public function show_テンプレート名が不正な場合は空文字を返す() {
		$this->assertSame(
			'',
			Page::show(
				_get_container(),
				[
					'template' => '/etc/hosts',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 */
	public function show_存在しない商品IDが指定された場合、デバッグが有効であればエラーメッセージを出力し、空文字を返す() {
		$this->container['WP_DEBUG_LOG'] = function ( $c ) {
			return true;
		};

		$pageShow = Page::show(
			$this->container,
			[
				'template' => 'default',
				'product_id' => '00000000',
			],
			null,
			null
		);
		
		$this->assertSame(
			'',
			$pageShow
		);

		$this->assertStringContainsString( '存在しない商品IDが指定された可能性があります。',  file_get_contents( $this->error_log ) );
	}
}
