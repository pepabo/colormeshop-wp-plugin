<?php
// @see https://shop-pro.jp/?mode=api_interface#get-v1productsjson
// 表示件数
$params = [
	'limit' => 10,
];
$params['offset'] = $params['limit'] * ( (int) get_query_var( 'page_no' ) - 1);
foreach ( [ 'category_id_big', 'category_id_small' ] as $k ) {
	$v = get_query_var( $k );
	if ( $v ) {
		$params[ $k ] = $v;
	}
}

$paginator = $this->container['model.product_api']->paginate( $params );

?>
<h2>商品 一覧</h2>

<?php if ( $paginator->data() ) : ?>
	<dl>
	<?php foreach ( $paginator->data() as $p ) : ?>
		<!-- 商品名 -->
		<dt><?php echo $p['id'] ?>: <?php echo $p['name'] ?></dt>

		 <!-- 画像 -->
		<?php if ( $p['image_url'] ) : ?>
			 <dd><img src="<?php echo $p['image_url'] ?>" /></dd>
		<?php endif; ?>

		<!-- 説明 -->
		<?php if ( $p['expl'] ) : ?>
			<dd><?php echo nl2br( $p['expl'] ) ?></dd>
		<?php endif; ?>
	<?php endforeach; ?>
	</dl>

	<!-- ページャ -->
	<?php echo $paginator->links() ?>
<?php else : ?>
	該当する商品がありません。
<?php endif; ?>
