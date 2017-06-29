<?php
namespace ColorMeShop\Shortcodes\Product;

class Image_Test extends \WP_UnitTestCase {
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
		$this->assertSame( 'colormeshop_image', Image::name() );
	}

	/**
	 * @test
	 * @vcr shortcodes/product/image/400.yml
	 */
	public function show_商品情報の取得に失敗した場合_空文字を返す() {
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
	 * @vcr shortcodes/product/image/400.yml
	 */
	public function show_商品情報の取得に失敗した_デバッグが有効な場合_ログを出力する() {
		$this->container['WP_DEBUG_LOG'] = function ( $c ) {
			return true;
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
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_商品画像のタグを返す() {
		$this->assertSame(
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/123.jpg?cmsp_timestamp=20170622190708" />',
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
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_モバイル用商品画像のタグを返す() {
		$this->container['is_mobile'] = function ( $c ) {
			return true;
		};
		$this->assertSame(
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/118849164_mb.jpg?cmsp_timestamp=20170622190708" />',
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
	 * @vcr shortcodes/product/image/noimage.yml
	 */
	public function show_画像が登録されていない場合_空文字を返す() {
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
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_画像タグに追加の属性を指定できる() {
		$this->assertSame(
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/123.jpg?cmsp_timestamp=20170622190708" width="100" class="foo bar" />',
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
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_サムネイル用商品画像のタグを返す() {
		$this->assertSame(
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/118849164_th.jpg?cmsp_timestamp=20170622190708" />',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'type' => 'thumbnail',
				],
				null,
				null
			)
		);
	}

	/**
	 * @test
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_その他画像のタグを返す() {
		$this->assertSame(
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/118849164_o1.jpg?cmsp_timestamp=20170623170718" />',
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
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/118849164_o2.jpg?cmsp_timestamp=20170623170718" />',
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
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_モバイル用その他画像のタグを返す() {
		$this->container['is_mobile'] = function ( $c ) {
			return true;
		};
		$this->assertSame(
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/118849164_o1_mb.jpg" />',
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
			'<img src="http://img21.shop-pro.jp/PA01356/136/product/118849164_o2_mb.jpg" />',
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
	 * @vcr shortcodes/product/image/200.yml
	 */
	public function show_存在しない画像の場合_空文字を返す() {
		$this->assertSame(
			'',
			Image::show(
				$this->container,
				[
					'product_id' => 123,
					'type' => 'XXXXXXXX',
				],
				null,
				null
			)
		);
	}
}
