<?php
// @see https://shop-pro.jp/?mode=api_interface#get-v1productsjson
$response = $this->container['model.product_api']->search(
	[
		'offset' => (int) get_query_var( 'offset' ),
		'limit' => 50,
	]
);
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
