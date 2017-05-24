<div class="wrap">
    <h1>カラーミーショップ連携設定</h1>
    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
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
	                        <?php echo do_shortcode( '[authentication_link]' ); ?>
                        </div>
                    </div>
                </div>
                <a id="colorme_settings"></a>
                <div class="meta-box-sortables ui-sortable">
                    <div class="postbox">
                        <h2 class="hndle">カラーミーショップ WordPress プラグインをインストールしていただきありがとうございます！</h2>
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
                    <a id="colorme_shortcode"></a>
                    <div class="meta-box-sortables ui-sortable">
                        <div class="postbox">
                            <h2 class="hndle">ショートコード</h2>
                            <div class="inside">
                                <dl>
                                    <dt>[colormeshop_product]</dt>
                                    <dd>
                                        <dl>
                                            <dt>説明</dt>
                                            <dd>商品情報を表示します</dd>
                                            <dt>使い方</dt>
                                            <dd><code>[colormeshop_product product_id="123" data="price"]</code></dd>
                                            <dt>パラメータ</dt>
                                            <dd>
                                                <dl>
                                                    <dt>product_id (商品ID)</dt>
                                                    <dd>省略した場合は $_GET['colorme_item'] の値が使われます</dd>
                                                    <dt>data (取得したい属性)</dt>
                                                    <dd>
                                                        <dl>
                                                            <dt>利用可能な属性</dt>
                                                            <dd>
                                                                <ul>
                                                                    <li>id (商品ID)</li>
                                                                    <li>name (商品名)</li>
                                                                    <li>model (型番)</li>
                                                                    <li>price (定価)</li>
                                                                    <li>regular_price (通常販売価格 (割引前の販売価格))</li>
                                                                    <li>members_price (会員価格)</li>
                                                                    <li>unit (単位)</li>
                                                                    <li>weight (重量)</li>
                                                                    <li>simple_explain (簡易説明)</li>
                                                                    <li>explain (商品詳細説明)</li>
                                                                </ul>
                                                            </dd>
                                                        </dl>
                                                    </dd>
                                                </dl>
                                            </dd>
                                        </dl>
                                    </dd>
                                    <dt>[colormeshop_product_page]</dt>
                                    <dd>
                                        <dl>
                                            <dt>説明</dt>
                                            <dd>テンプレートにレイアウトされている商品ページを表示します</dd>
                                            <dt>使い方</dt>
                                            <dd><code>[colormeshop_product_page product_id="123" template="default"]</code></dd>
                                            <dt>パラメータ</dt>
                                            <dd>
                                                <dl>
                                                    <dt>product_id (商品ID)</dt>
                                                    <dd>省略した場合は $_GET['colorme_item'] の値が使われます</dd>
                                                    <dt>template (テンプレート名)</dt>
                                                    <dd>
                                                        <dl>
                                                            <dt>利用可能なテンプレート</dt>
                                                            <dd>
                                                                <ul>
                                                                    <li>default (デフォルト)</li>
                                                                </ul>
                                                            </dd>
                                                        </dl>
                                                    </dd>
                                                </dl>
                                            </dd>
                                        </dl>
                                    </dd>
                                </dl>
                            </div>
                            <!-- .inside -->
                        </div>
                        <!-- .postbox -->
                    </div>
				</div>
				<!-- .meta-box-sortables .ui-sortable -->
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
