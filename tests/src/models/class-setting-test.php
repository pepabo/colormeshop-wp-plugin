<?php
namespace ColorMeShop\Models;

class Setting_Test extends \WP_UnitTestCase {

	/**
	 * @test
	 */
	public function is_valid_product_page_id() {
		$setting = _get_container()['model.setting'];

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

		$this->assertFalse( $setting->is_valid_product_page_id( null ) );
		$this->assertFalse( $setting->is_valid_product_page_id( '' ) );
		$this->assertFalse( $setting->is_valid_product_page_id( 0 ) );
		$this->assertFalse( $setting->is_valid_product_page_id( 'TEST' ) );
		// 記事 id
		$this->assertFalse( $setting->is_valid_product_page_id( $post_id ) );
		// 存在しない id
		$this->assertFalse( $setting->is_valid_product_page_id( 999999 ) );
		$this->assertTrue( $setting->is_valid_product_page_id( $page_id ) );
	}
}
