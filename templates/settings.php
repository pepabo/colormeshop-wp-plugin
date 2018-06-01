<?php
// 別 PR で iframe 読み込みにするので、それまでの暫定対応
$plugin_dir_url = plugin_dir_url( dirname( __DIR__ ) . '/colormeshop-wp-plugin.php' );
?>
<div class="wrap">
	<h1>カラーミーショップ連携設定</h1>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content -->
			<div id="post-body-content">
				<?php
				if ( $this->setting->product_page_id() && ! $this->setting->is_valid_product_page_id() ) : ?>
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
								settings_fields( \ColorMeShop\Models\Setting::KEY );
								do_settings_sections( \ColorMeShop\Admin::MENU_SLUG );
								submit_button();
								?>
							</form>
							<?php if ( ! $this->setting->product_page_id() || ! $this->setting->is_valid_product_page_id() ) : ?>
								<div>
									<p>※ 商品カテゴリーページ、商品一覧ページ、サイトマップを生成するには商品ページ ID を設定してください。</p>
									<p>商品ページ ID の設定方法は<a href="#colorme_sitemap">こちら</a>をご参照ください。</p>
								</div>
							<?php else : ?>
								<div>
									<ul>
										<li>商品 <a href="<?php echo $this->url_builder->product_page_permalink() ?>?colorme_item=カラーミーショップの商品ID" target="_blank"><?php echo $this->url_builder->product_page_permalink() ?>?colorme_item=カラーミーショップの商品ID</a></li>
										<li>商品カテゴリー <a href="<?php echo $this->url_builder->categories() ?>" target="_blank"><?php echo $this->url_builder->categories() ?></a></li>
										<li>商品一覧 <a href="<?php echo $this->url_builder->items() ?>" target="_blank"><?php echo $this->url_builder->items() ?></a></li>
										<li>サイトマップ <a href="<?php echo $this->url_builder->sitemap() ?>" target="_blank"><?php echo $this->url_builder->sitemap() ?></a></li>
									</ul>
								</div>
							<?php endif; ?>
							<a href="<?php echo $this->oauth2_client->getAuthorizationUrl( [
								'scope' => [ 'read_products' ],
							] ) ?>">カラーミーショップアカウントで認証する</a>
						</div>
					</div>
				</div>
				<a id="colorme_settings"></a>
				<div class="meta-box-sortables ui-sortable">
					<div class="postbox">
						<h2 class="hndle">カラーミーショップ WordPressプラグイン 利用方法</h2>
						<div class="inside">
							<p>
                                ご利用を開始する前に、以下の手順に沿ってアプリケーションの追加を完了してください。
                            </p>
						</div>
						<h2>1. デベロッパーアカウントの作成</h2>
						<div class="inside">
							<p>
								カラーミー デベロッパーアカウントを <a href="https://api.shop-pro.jp/developers/sign_up" target="_blank">こちら</a> から作成してください。
							</p>
						</div>
						<!-- .inside -->
						<h2>2. アプリケーションの追加</h2>
						<div class="inside">
							<p>
								作成したデベロッパーアカウントで「<a href="https://api.shop-pro.jp/developers/sign_in" target="_blank">カラーミーショップDevelopers</a>」にログインしてください。「<a href="https://api.shop-pro.jp/oauth/applications/new" target="_blank">アプリケーション追加</a>」からプラグイン用のアプリケーションを追加します。
							</p>
							<div>
								<img height="250" src="<?php echo $plugin_dir_url ?>screenshots/add_application.png" />
							</div>
							<p>
								リダイレクトURLは<input class="regular-text" type="text" value="<?php echo site_url() ?>/wp-admin/admin-ajax.php" />を入力してください。
							</p>
							<p>
								保存後、表示される「クライアントID」「クライアントシークレット」を<br />
								このページの基本設定に入力してください。
							</p>
							<div>
								<img height="250" src="<?php echo $plugin_dir_url ?>screenshots/application_credentials.png" />
							</div>
							<p>
								基本設定の「変更を保存」をクリックして保存後、「カラーミーショップアカウントで認証する」をクリックしてください。<br />
								「トークン」が自動的に入力されれば設定は完了です！
							</p>
						</div>
						<!-- .inside -->
					</div>
					<a id="colorme_page"></a>
					<div class="postbox">
						<h2 class="hndle">商品ページ 作成方法</h2>
						<div class="inside">
							<p>
								商品用の固定ページを作成し、<a href="#colorme_shortcode">ショートコード</a>を使って商品情報をレイアウトしてください。
							</p>
							<div>
								<a target="_blank" href="<?php echo $plugin_dir_url ?>screenshots/create_page.png"><img height="400" src="<?php echo $plugin_dir_url ?>screenshots/create_page.png" /></a>
							</div>
							<p>
								<code>https://<商品ページ>/?colorme_item=<商品ID></code> にアクセスすると...！
							</p>
							<div>
								<a target="_blank" href="<?php echo $plugin_dir_url ?>screenshots/shop_page.png"><img height="400" src="<?php echo $plugin_dir_url ?>screenshots/shop_page.png" /></a>
							</div>
						</div>
						<h2>ショートコードやレイアウトなど詳しく分からない場合</h2>
						<div class="inside">
							<p>
								本文に <input type="text" value="[colormeshop_page]" /> を貼り付けて保存してください！
							</p>
						</div>
					</div>
					<a id="colorme_sitemap"></a>
					<div class="postbox">
						<h2 class="hndle">商品ページのサイトマップ 設定方法</h2>
						<h2>設定</h2>
						<div class="inside">
							<p>
								商品ページの ID を<a href="#colorme_settings">カラーミーショップ連携設定</a>に保存してください。
							</p>
							<div>
								<a target="_blank" href="<?php echo $plugin_dir_url ?>screenshots/page_id.png"><img height="400" src="<?php echo $plugin_dir_url ?>screenshots/page_id.png" /></a>
							</div>
							<div>
								<a target="_blank" href="<?php echo $plugin_dir_url ?>screenshots/save_page_id.png"><img height="400" src="<?php echo $plugin_dir_url ?>screenshots/save_page_id.png" /></a>
							</div>
						</div>
						<h2><code><商品ページのURL>/sitemap.xml</code> にアクセスすると...！</h2>
						<div class="inside">
							<div>
								<a target="_blank" href="<?php echo $plugin_dir_url ?>screenshots/sitemap.png"><img height="400" src="<?php echo $plugin_dir_url ?>screenshots/sitemap.png" /></a>
							</div>
						</div>
					</div>
					<!-- .postbox -->
					<a id="colorme_shortcode"></a>
					<div class="meta-box-sortables ui-sortable">
						<div class="postbox">
							<h2 class="hndle">ショートコード一覧</h2>
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
									<dt>[colormeshop_image]</dt>
									<dd>
										<dl>
											<dt>説明</dt>
											<dd>商品画像を表示します</dd>
											<dt>使い方</dt>
											<dd><code>[colormeshop_image product_id="123" type="main"]</code></dd>
											<dt>パラメータ</dt>
											<dd>
												<dl>
													<dt>product_id (商品ID)</dt>
													<dd>省略した場合は $_GET['colorme_item'] の値が使われます</dd>
													<dt>type (取得したい画像の種類)</dt>
													<dd>
														<dl>
															<dt>利用可能な属性</dt>
															<dd>
																省略した場合は main になります
																<ul>
																	<li>main (メイン画像)</li>
																	<li>thumbnail (サムネイル画像)</li>
																	<li>other1 (その他画像)</li>
																	<li>※ 以降、 otherXXX で XXX 番目に登録されている画像を指定してください</li>
																	<li>※ モバイルアクセス時はモバイル用画像を表示します</li>
																</ul>
															</dd>
														</dl>
													</dd>
												</dl>
											</dd>
										</dl>
									</dd>
									<dt>[colormeshop_option]</dt>
									<dd>
										<dl>
											<dt>説明</dt>
											<dd>商品オプションを表示します</dd>
											<dt>使い方</dt>
											<dd><code>[colormeshop_option product_id="123" index=1 data="title"]</code></dd>
											<dt>パラメータ</dt>
											<dd>
												<dl>
													<dt>product_id (商品ID)</dt>
													<dd>省略した場合は $_GET['colorme_item'] の値が使われます</dd>
													<dt>index (表示するオプション番号)</dt>
													<dd>
														<ul>
															<li>オプションの組み合わせが 6つ ある場合は 1 〜 6 の数字が入ります</li>
															<li>省略した場合は 1 になります</li>
														</ul>
													</dd>
													<dt>data (表示するオプションの属性)</dt>
													<dd>
														<dl>
															<dt>利用可能な属性</dt>
															<dd>
																省略した場合は title になります
																<ul>
																	<li>title (オプション名)</li>
																	<li>stocks (在庫数)</li>
																	<li>models_number (型番)</li>
																	<li>option_price (販売価格)</li>
																	<li>option_members_price (会員価格)</li>
																</ul>
															</dd>
														</dl>
													</dd>
												</dl>
											</dd>
										</dl>
									</dd>
									<dt>[colormeshop_cart_button]</dt>
									<dd>
										<dl>
											<dt>説明</dt>
											<dd>カートボタンを表示します</dd>
											<dt>使い方</dt>
											<dd><code>[colormeshop_cart_button product_id="123" style="washi"]</code></dd>
											<dt>パラメータ</dt>
											<dd>
												<dl>
													<dt>product_id (商品ID)</dt>
													<dd>省略した場合は $_GET['colorme_item'] の値が使われます</dd>
													<dt>style (ボタンのデザイン)</dt>
													<dd>
														省略した場合は basic になります
														<dl>
															<dt>利用可能な属性</dt>
															<dd>
																<ul>
																	<li>basic</li>
																	<li>cloth_blue</li>
																	<li>cloth_yellow</li>
																	<li>cloth_green</li>
																	<li>washi</li>
																	<li>check_blue</li>
																	<li>check_red</li>
																</ul>
															</dd>
														</dl>
													</dd>
												</dl>
											</dd>
										</dl>
									</dd>
									<dt>[colormeshop_page]</dt>
									<dd>
										<dl>
											<dt>説明</dt>
											<dd>テンプレートにレイアウトされている商品ページを表示します</dd>
											<dt>使い方</dt>
											<dd><code>[colormeshop_page product_id="123" template="default"]</code></dd>
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
								<li><a href="https://goo.gl/forms/s6zzeS3Q7jKDTbFO2" target="_blank">プラグインについてのご質問・ご要望</a></li>
								<li><a href="#colorme_settings">カラーミーショップ WordPressプラグイン 利用方法</a></li>
								<li><a href="#colorme_page">商品ページ 作成方法</a></li>
								<li><a href="#colorme_sitemap">商品ページのサイトマップ 設定方法</a></li>
								<li><a href="#colorme_shortcode">ショートコード一覧</a></li>
							</ul>
						</div>
						<!-- .inside -->
					</div>
					<!-- .postbox -->
					<div class="postbox">
						<h2 class="hndle">プラグインについて</h2>
						<div class="inside">
							<p>
                                当プラグインについてお気付きの点やご要望等お持ちの方は、ぜひお気軽に <a href="https://goo.gl/forms/s6zzeS3Q7jKDTbFO2" target="_blank">https://goo.gl/forms/s6zzeS3Q7jKDTbFO2</a> までお寄せください。
                            </p>
                            <p>
                                また当プラグインをはじめ、カラーミーショップやECサービスの開発にご興味のある方は、<a href="https://pepabo.com/recruit/" target="_blank">GMOペパボ 株式会社の採用ページ</a> もご覧ください。
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
