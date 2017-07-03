<?php
// 取得できるカテゴリー情報
// @see https://shop-pro.jp/?mode=api_interface#get-v1categoriesjson
$response = $this->container['swagger.api.category']->getProductCategories();
?>
<h2>商品カテゴリー 一覧</h2>

<?php if ( $response ) : ?>
	<dl>
	<?php foreach ( $response['categories'] as $c ) :
		if ( 'showing' !== $c['display_state'] ) :
			continue;
		endif;
	?>
	<!-- TODO: 商品一覧ページの URL を表示する -->
	<!-- カテゴリー名 -->
	<dt><?php echo $c['name'] ?></dt>

	<!-- 大カテゴリー ID -->
	<dd> <?php echo $c['id_big'] ?></dd>

	<!-- カテゴリー画像 -->
	<?php if ( $c['image_url'] ) : ?>
		<dd><img src="<?php echo $c['image_url'] ?>" /></dd>
	<?php endif; ?>

	<!-- 説明 -->
	<?php if ( $c['expl'] ) : ?>
		<dd><?php echo nl2br( $c['expl'] ) ?></dd>
	<?php endif; ?>

	<!-- 属する小カテゴリ -->
	<?php if ( $c['children'] ) : ?>
			<dl>
			<?php foreach ( $c['children'] as $child ) :
				if ( 'showing' !== $child['display_state'] ) :
					continue;
				endif;
			?>
				<!-- カテゴリー名 -->
				<dt><?php echo $child['name'] ?></dt>

				<!-- 小カテゴリー ID -->
				<dd> <?php echo $child['id_small'] ?></dd>

				<!-- カテゴリー画像 -->
				<?php if ( $child['image_url'] ) : ?>
					<dd><img src="<?php echo $child['image_url'] ?>" /></dd>
				<?php endif; ?>

				<!-- 説明 -->
				<?php if ( $child['expl'] ) : ?>
					<dd><?php echo nl2br( $child['expl'] ) ?></dd>
				<?php endif; ?>
			<?php endforeach; ?>
			</dl>
		<?php endif; ?>
	<?php endforeach; ?>
	</dl>
<?php else : ?>
	商品カテゴリーが登録されていません。
<?php endif; ?>
