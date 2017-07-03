<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<h2><?php echo $product['name'] ?> </h2>
		<?php echo $product['expl'] ?><br/>
		<br/>
		価格: <?php echo $product['sales_price'] ?> 円 <br/>
		<br/>
		<img src="<?php echo $product['image_url'] ?>">
		<br/>
		<?php echo do_shortcode( '[colormeshop_cart_button product_id=' . $product['id'] . ']' ); ?>
		<br/>
		<hr>
	</main>
</div>
