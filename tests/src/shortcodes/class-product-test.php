<?php
namespace ColorMeShop\Shortcodes;

use ColorMeShop\Models\Product as ProductModel;

class Product_Test extends \WP_UnitTestCase {
	/** @var \Pimple\Container */
	private $container;

	public function setUp() {
		parent::setUp();
		$product = new ProductModel([
			'product' => [
				'id' => 123,
				'name' => 'テスト商品',
				'price' => 1200,
				'sales_price' => 1000,
				'members_price' => 800,
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
}
