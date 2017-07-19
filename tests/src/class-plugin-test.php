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
	 * @vcr plugin/show_items.yml
	 */
	public function show_items() {
		$page_id = _create_product_page_with_customized_permalink();
		_get_container()['model.setting']->update( [
			'product_page_id' => $page_id,
		] );

		$plugin = new Plugin;
		$content = $plugin->show_items( '' );

		// - API のレスポンスで返ってくる商品の詳細ページへのリンクが含まれていること
		// - 最初と最後の商品だけチェック
		$this->assertContains( '<a href="http://example.org/shop/?colorme_item=118849164">', $content );
		$this->assertContains( '<a href="http://example.org/shop/?colorme_item=118849098">', $content );
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
