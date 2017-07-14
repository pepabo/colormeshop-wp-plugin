<?php
namespace ColorMeShop;

class Plugin_Test extends \WP_UnitTestCase {
	/**
	 * @test
	 */
	public function add_query_vars() {
		$plugin = new Plugin;
		$query_vars = $plugin->add_query_vars( [] );

		$this->assertContains( 'colorme_item', $query_vars );
		$this->assertContains( 'colorme_page', $query_vars );
		$this->assertContains( 'category_id_big', $query_vars );
		$this->assertContains( 'category_id_small', $query_vars );
		$this->assertContains( 'offset', $query_vars );
		$this->assertContains( 'page_no', $query_vars );
	}
}
