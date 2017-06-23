<?php
// @see https://shop-pro.jp/?mode=api_interface#get-v1productsjson
$params = [
	'offset' => (int) get_query_var( 'offset' ),
	'limit' => 50,
];

foreach ( [ 'category_id_big', 'category_id_small' ] as $k ) {
	if ( $v = get_query_var( $k ) ) {
		$params[ $k ] = $v;
	}
}

$response = $this->container['model.product_api']->search( $params );
?>
<h2>商品 一覧</h2>

<?php if ( $response['products'] ) : ?>
	<dl>
	<?php foreach ( $response['products'] as $p ) : ?>
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
<?php else : ?>
	該当する商品がありません。
<?php endif; ?>
