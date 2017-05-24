<div class="wrap">
    <h1>カラーミーショップ連携設定</h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2>カラーミーショップ WordPress プラグインをインストールしていただきありがとうございます！</h2>
                        <div class="inside">
                            <p>
                                プラグインをご利用いただくには、いくつか設定が必要になりますので下記手順に沿って設定をお願いします。<br />
                                カラーミーショップのご登録がお済みでない方は<a href="https://shop-pro.jp/?mode=signup" target="_blank">こちら</a>からお願いいたします！
                            </p>
                        </div>
                        <h2>カラーミーデベロッパーアカウント作成</h2>
                        <div class="inside">
                            <p>
                                カラーミーデベロッパーアカウントをお持ちでない方は<a href="https://api.shop-pro.jp/developers/sign_up" target="_blank">こちら</a>から登録してください。
                            </p>
                        </div>
                        <!-- .inside -->
                        <h2>アプリケーション追加</h2>
                        <div class="inside">
                            <p>
                                作成したアカウントで<a href="https://api.shop-pro.jp/developers/sign_in" target="_blank">カラーミーショップDevelopers</a>にログイン後、<a href="https://api.shop-pro.jp/oauth/applications/new" target="_blank">アプリケーション追加</a>からプラグイン用のアプリケーションを追加してください。
                            </p>
                            <div>
                                <img height="250" src="<?php echo plugins_url() ?>/colormeshop-wp-plugin/screenshots/add_application.png" />
							</div>
							<p>
								リダイレクトURLは<input class="regular-text" type="text" value="http://<?php echo $_SERVER['SERVER_NAME'] . ( 80 === $_SERVER['SERVER_PORT'] ? '' : ':' . $_SERVER['SERVER_PORT']) ?>/wp-admin/admin-ajax.php" />を入力してください。
							</p>
							<p>
								保存後、表示される「クライアントID」「クライアントシークレット」を<br />
								このページの基本設定に入力してください。
							</p>
							<div>
								<img height="250" src="<?php echo plugins_url() ?>/colormeshop-wp-plugin/screenshots/application_credentials.png" />
							</div>
							<p>
								基本設定の「変更を保存」をクリックして保存後、「カラーミーショップアカウントで認証する」をクリックしてください。<br />
								「トークン」が自動的に入力されれば設定は完了です！
							</p>
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->
			</div>
			<!-- post-body-content -->
		</div>
		<!-- #post-body .metabox-holder .columns-2 -->
		<br class="clear">
	</div>
	<!-- #poststuff -->
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
	<?php echo do_shortcode( '[authentication_link]' ); ?>
</div> <!-- .wrap -->
