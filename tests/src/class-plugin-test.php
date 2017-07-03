<?php
namespace ColorMeShop;

class Plugin_Test extends \WP_UnitTestCase {
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

		$plugin = new Plugin;

		$this->assertFalse( $plugin->is_valid_product_page_id( null ) );
		$this->assertFalse( $plugin->is_valid_product_page_id( '' ) );
		$this->assertFalse( $plugin->is_valid_product_page_id( 0 ) );
		$this->assertFalse( $plugin->is_valid_product_page_id( 'TEST' ) );
		// 記事 id
		$this->assertFalse( $plugin->is_valid_product_page_id( $post_id ) );
		// 存在しない id
		$this->assertFalse( $plugin->is_valid_product_page_id( 999999 ) );
		$this->assertTrue( $plugin->is_valid_product_page_id( $page_id ) );
	}
}
