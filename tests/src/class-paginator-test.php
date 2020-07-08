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
<ul class='page-numbers'>
	<li><a class="prev page-numbers" href="http://example.org/">&laquo;</a></li>
	<li><a class="page-numbers" href="http://example.org/">1</a></li>
	<li><span aria-current="page" class="page-numbers current">2</span></li>
	<li><a class="page-numbers" href="http://example.org/?page_no=3">3</a></li>
	<li><a class="page-numbers" href="http://example.org/?page_no=4">4</a></li>
	<li><span class="page-numbers dots">&hellip;</span></li>
	<li><a class="page-numbers" href="http://example.org/?page_no=1000">1,000</a></li>
	<li><a class="next page-numbers" href="http://example.org/?page_no=3">&raquo;</a></li>
</ul>

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
