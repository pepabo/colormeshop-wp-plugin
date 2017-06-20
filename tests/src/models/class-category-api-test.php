<?php
namespace ColorMeShop\Models;

class Category_Api_Test extends \WP_UnitTestCase {

	/**
	 * @test
	 * @vcr models/category-api/fetch.yml
	 */
	public function fetch() {

		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};

		$r = $container['model.category_api']->fetch();
		$this->assertCount( 2, $r['categories'] );
		$this->assertSame( 2131603, $r['categories'][0]['id_big'] );
		$this->assertSame( 2143688, $r['categories'][1]['id_big'] );
	}

	/**
	 * @test
	 * @vcr models/category-api/fetch_throws_exception.yml
	 * @expectedException \RuntimeException
	 */
	public function fetch_カテゴリー取得に失敗した場合_例外を投げる() {
		$container = _get_container();
		$container['token'] = function ( $c ) {
			return 'dummy';
		};

		$container['model.category_api']->fetch();
	}
}
