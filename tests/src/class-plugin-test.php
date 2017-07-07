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
		$this->assertContains( 'colorme_sitemap', $query_vars );
		$this->assertContains( 'colorme_page', $query_vars );
		$this->assertContains( 'category_id_big', $query_vars );
		$this->assertContains( 'category_id_small', $query_vars );
		$this->assertContains( 'offset', $query_vars );
		$this->assertContains( 'page_no', $query_vars );
	}

	/**
	 * @test
	 */
	public function is_valid_product_page_id() {
		$post_id = $this->factory->post->create( [
			'post_title' => '記事テスト',
			'post_content' => 'テスト',
			'post_type' => 'post',
		] );
		$page_id = $this->factory->post->create( [
			'post_title' => '固定ページテスト',
			'post_content' => 'テスト',
			'post_type' => 'page',
		] );

		$this->assertFalse( Plugin::is_valid_product_page_id( null ) );
		$this->assertFalse( Plugin::is_valid_product_page_id( '' ) );
		$this->assertFalse( Plugin::is_valid_product_page_id( 0 ) );
		$this->assertFalse( Plugin::is_valid_product_page_id( 'TEST' ) );
		// 記事 id
		$this->assertFalse( Plugin::is_valid_product_page_id( $post_id ) );
		// 存在しない id
		$this->assertFalse( Plugin::is_valid_product_page_id( 999999 ) );
		$this->assertTrue( Plugin::is_valid_product_page_id( $page_id ) );
	}
}
