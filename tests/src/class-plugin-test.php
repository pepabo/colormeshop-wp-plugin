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
	 * @vcr plugin/show_categories.yml
	 */
	public function handle_template_redirect_カテゴリ一覧を表示する() {
		$page = $this->factory->post->create_and_get( [
			'post_title' => 'テストページ',
			'post_type'  => 'page',
		] );
		$this->go_to( '/?page_id=' . $page->ID );

		_get_container()['model.setting']->update( [
			'product_page_id' => $page->ID,
		] );
		$this->go_to( '/?page_id=' . $page->ID . '&colorme_page=categories' );

		$plugin = new Plugin;
		$plugin->handle_template_redirect();

		// - API のレスポンスで返ってくるカテゴリへのリンクが含まれていること
		$regex = <<<__EOS__
#
.*<a href="http://example.org/\?page_id={$page->ID}&colorme_page=items&category_id_big=2131603">.*
[\s\S]*<a href="http://example.org/\?page_id={$page->ID}&colorme_page=items&category_id_big=2131603&category_id_small=1">.*
[\s\S]*<a href="http://example.org/\?page_id={$page->ID}&colorme_page=items&category_id_big=2143688">.*
#
__EOS__;
		$this->expectOutputRegex( $regex );
		the_content();
	}

	/**
	 * @test
	 * @vcr plugin/show_items.yml
	 */
	public function handle_template_redirect_商品一覧を表示する() {
		$page = $this->factory->post->create_and_get( [
			'post_title' => 'テストページ',
			'post_type'  => 'page',
		] );
		$this->go_to( '/?page_id=' . $page->ID );

		_get_container()['model.setting']->update( [
			'product_page_id' => $page->ID,
		] );
		$this->go_to( '/?page_id=' . $page->ID . '&colorme_page=items' );

		$plugin = new Plugin;
		$plugin->handle_template_redirect();

		// - API のレスポンスで返ってくる商品の詳細ページへのリンクが含まれていること
		// - 最初と最後の商品だけチェック
		$regex = <<<__EOS__
#
.*<a href="http://example\.org/\?page_id={$page->ID}&colorme_item=118849164">
[\s\S]*<a href="http://example\.org/\?page_id={$page->ID}&colorme_item=118849098">.*
#
__EOS__;
		$this->expectOutputRegex( $regex );
		the_content();
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
