<?php
// @see https://shop-pro.jp/?mode=api_interface#get-v1productsjson
// 表示件数
$params = [
	'limit' => 10,
];
if ( 0 === (int) get_query_var( 'page_no' ) ) {
	$params['offset'] = 0;
} else {
	$params['offset'] = $params['limit'] * ( (int) get_query_var( 'page_no' ) - 1);
}
foreach ( [ 'category_id_big', 'category_id_small' ] as $k ) {
	$v = get_query_var( $k );
	if ( $v ) {
		$params[ $k ] = $v;
	}
}

$paginator = $this->container['api.product_api']->paginate( $params );
$url = $this->container['url_builder'];

?>
<h2>商品 一覧</h2>

<?php if ( $paginator->data() ) : ?>
	全 <?php echo number_format( $paginator->total() ) ?> 件
	<dl>
	<?php foreach ( $paginator->data() as $p ) : ?>
		<!-- 商品名 -->
		<dt>
			<a href="<?php echo $url->item( $p['id'] ) ?>">
				<?php echo $p['id'] ?>: <?php echo $p['name'] ?>
			</a>
		</dt>

		<dd>販売価格: <?php echo number_format( $p['sales_price'] ) ?>円</dd>
		<dd>定価: <?php echo number_format( $p['price'] ) ?>円</dd>
		<dd>会員向け価格: <?php echo number_format( $p['members_price'] ) ?>円</dd>
		<dd>原価: <?php echo number_format( $p['cost'] ) ?>円</dd>

		 <!-- PC画像 -->
		<?php if ( $p['image_url'] && ! $this->container['is_mobile'] ) : ?>
			 <dd><img src="<?php echo $p['image_url'] ?>" /></dd>
		<?php endif; ?>

		<!-- モバイル画像 -->
		<?php if ( $p['mobile_image_url'] && $this->container['is_mobile'] ) : ?>
			<dd><img src="<?php echo $p['mobile_image_url'] ?>" /></dd>
		<?php endif; ?>

		<!-- サムネイル画像 -->
		<?php if ( $p['thumbnail_image_url'] ) : ?>
			<dd><img src="<?php echo $p['thumbnail_image_url'] ?>" /></dd>
		<?php endif; ?>

		<!-- その他の画像 -->
		<?php if ( $p['images'] ) : ?>
			<?php foreach ( $p['images'] as $i ) : ?>
				<?php if ( $this->container['is_mobile'] ) : ?>
					<!-- モバイル用 -->
					<?php if ( $i['mobile'] ) : ?><img src="<?php echo $i['src'] ?>" /><?php endif; ?>
				<?php else : ?>
					<!-- PC用 -->
					<?php if ( ! $i['mobile'] ) : ?><img src="<?php echo $i['src'] ?>" /><?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>

		<!-- 簡易説明 -->
		<?php if ( $p['simple_expl'] ) : ?>
			<dd><?php echo nl2br( $p['simple_expl'] ) ?></dd>
		<?php endif; ?>
		<?php if ( $this->container['is_mobile'] && $p['smartphone_expl'] ) : ?>
			<!-- モバイル用 説明 -->
			<dd><?php echo nl2br( $p['smartphone_expl'] ) ?></dd>
		<?php elseif ( $p['expl'] ) : ?>
			<!-- PC用 説明 -->
			<dd><?php echo nl2br( $p['expl'] ) ?></dd>
		<?php endif; ?>
	<?php endforeach; ?>
	</dl>

	<!-- ページャ -->
	<?php echo $paginator->links() ?>
<?php else : ?>
	該当する商品がありません。
<?php endif; ?>
