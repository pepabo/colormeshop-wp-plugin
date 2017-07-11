<div class="wrap">
    <h1>カラーミーショップ連携設定</h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <?php
				if ( $this->container['product_page_id'] && ! $this->is_valid_product_page_id( $this->container['product_page_id'] ) ) : ?>
					<div class="error"><p>商品ページIDには、固定ページの ID を設定してください。</p></div>
				<?php endif; ?>
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<h2 class="hndle">設定</h2>
						<div class="inside">
							<?php
							global $parent_file;
							if ( 'options-general.php' !== $parent_file ) {
								require( ABSPATH . 'wp-admin/options-head.php' );
							}
							?>
							<form method="post" action="options.php">
								<?php
								settings_fields( 'colorme_wp_settings' );
								do_settings_sections( 'colorme_wp_settings' );
								submit_button();
								?>
							</form>
							<?php if ( ! $this->container['product_page_id'] || ! $this->is_valid_product_page_id( $this->container['product_page_id'] ) ) : ?>
								<div>
									<p>※ 商品カテゴリーページ、商品一覧ページ、サイトマップを生成するには商品ページ ID を設定してください。</p>
									<p>商品ページ ID の設定方法は<a href="#colorme_sitemap">こちら</a>をご参照ください。</p>
								</div>
							<?php else : ?>
								<div>
									<ul>
										<li>商品 <a href="<?php echo $this->container['product_page_url'] ?>?colorme_item=カラーミーショップの商品ID" target="_blank"><?php echo $this->container['product_page_url'] ?>?colorme_item=カラーミーショップの商品ID</a></li>
										<li>商品カテゴリー <a href="<?php echo $this->container['url_builder']->categories() ?>" target="_blank"><?php echo $this->container['url_builder']->categories() ?></a></li>
										<li>商品一覧 <a href="<?php echo $this->container['url_builder']->items() ?>" target="_blank"><?php echo $this->container['url_builder']->items() ?></a></li>
										<li>サイトマップ <a href="<?php echo $this->container['url_builder']->sitemap() ?>" target="_blank"><?php echo $this->container['url_builder']->sitemap() ?></a></li>
									</ul>
								</div>
							<?php endif; ?>
							<a href="<?php echo $this->container['oauth2_client']->getAuthorizationUrl( [
								'scope' => [ 'read_products' ],
							] ) ?>">カラーミーショップアカウントで認証する</a>
						</div>
					</div>
				</div>
				<a id="colorme_settings"></a>
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="inside">
							<iframe id="embed_getting_started" width="100%" src="<?php echo $this->container['plugin_dir_url'] ?>/docs/embed/getting_started.html" ></iframe>
						</div>
					</div>
				</div>
				<a id="colorme_page"></a>
				<div class="meta-box-sortables ui-sortable">
					 <div class="postbox">
						 <div class="inside">
							 <iframe id="embed_create_page" width="100%" src="<?php echo $this->container['plugin_dir_url'] ?>/docs/embed/create_page.html" ></iframe>
						 </div>
					 </div>
				</div>


				<a id="colorme_sitemap"></a>
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="inside">
							<iframe id="embed_sitemap" width="100%" src="<?php echo $this->container['plugin_dir_url'] ?>/docs/embed/sitemap.html" ></iframe>
						</div>
					</div>
				</div>

				<a id="colorme_shortcode"></a>
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<div class="inside">
							<iframe id="embed_shortcode" width="100%" src="<?php echo $this->container['plugin_dir_url'] ?>/docs/embed/shortcode.html" ></iframe>
						</div>
					</div>
				</div>
			</div>
			<!-- post-body-content -->
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">
					<div class="postbox">
						<div class="inside">
							<ul>
								<li><a href="https://shop-pro.jp/" target="_blank">カラーミーショップ</a></li>
								<li><a href="#">プラグインについてのご質問・ご要望</a></li>
								<li><a href="#colorme_settings">プラグイン設定手順</a></li>
								<li><a href="#colorme_page">商品ページを作成できます！</a></li>
								<li><a href="#colorme_sitemap">商品のサイトマップが自動生成されます！</a></li>
								<li><a href="#colorme_shortcode">ご利用可能なショートコード</a></li>
							</ul>
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
					<div class="postbox">
						<h2 class="hndle">プラグインについて</h2>
						<div class="inside">
							<p>
								<a href="#">(プラグインのリポジトリURL)</a><br />
								当プラグインについて、お気づきの点やアイデアをお持ちのかたはぜひ開発にご参加ください。<br />
								また、「こんな機能あったら良さそうなんだけど、どうでしょう？」といったお話も大歓迎ですので気軽に投稿してみましょう!<br />
								<a href="https://pepabo.com/" target="_blank">GMO Pepabo, Inc.</a>
							</p>
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
				</div>
				<!-- .meta-box-sortables -->
			</div>
			<!-- #postbox-container-1 .postbox-container -->
		</div>
		<!-- #post-body .metabox-holder .columns-2 -->
		<br class="clear">
	</div>
	<!-- #poststuff -->
</div> <!-- .wrap -->
