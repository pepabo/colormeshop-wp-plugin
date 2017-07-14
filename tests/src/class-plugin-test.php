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

	/**
	 * @test
	 * @runInSeparateProcess
	 * @preserveGlobalState disabled
	 */
	public function handle_template_redirect_404ページを表示する() {
		$page = $this->factory->post->create_and_get( [
			'post_title' => 'テストページ',
			'post_type'  => 'page',
		] );
		$this->go_to( '/?page_id=' . $page->ID );

		_get_container()['model.setting']->update( [
			'product_page_id' => $page->ID,
		] );

		$plugin = new Plugin;
		$plugin->handle_template_redirect();

		global $wp_query;
		$this->assertTrue( $wp_query->is_404 );
	}
}
