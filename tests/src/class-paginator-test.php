<?php
namespace ColorMeShop;

class Paginator_Test extends \WP_UnitTestCase {
	private $paginator;

	public function setUp() {
		parent::setUp();
		$this->paginator = new Paginator(
			[
				'limit' => 10,
				'offset' => 100,
			],
			[
				'products' => [
					[
						'id' => 1,
					],
					[
						'id' => 2,
					],
				],
				'meta' => [
					'total' => 10000,
					'limit' => 10,
					'offset' => 100,
				],
			],
			'https://example.com/shop/',
			'items',
			2
		);
	}

	/**
	 * @test
	 */
	public function links() {
		$expected = <<<__EOS__
<ul class="pagination"><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=1" rel="prev">&laquo;</a></li> <li><a href="https://example.com/shop?colorme_page=items&amp;page_no=1">1</a></li><li class="active"><span>2</span></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=3">3</a></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=4">4</a></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=5">5</a></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=6">6</a></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=7">7</a></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=8">8</a></li><li class="disabled"><span>...</span></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=999">999</a></li><li><a href="https://example.com/shop?colorme_page=items&amp;page_no=1000">1000</a></li> <li><a href="https://example.com/shop?colorme_page=items&amp;page_no=3" rel="next">&raquo;</a></li></ul>
__EOS__;

		$this->assertSame( $expected, (string) $this->paginator->links() );
	}

	/**
	 * @test
	 */
	public function data() {
		$this->assertSame( [
			[
				'id' => 1,
			],
			[
				'id' => 2,
			],
		], $this->paginator->data() );
	}

	/**
	 * @test
	 */
	public function total() {
		$this->assertSame( 10000, $this->paginator->total() );
	}
}
