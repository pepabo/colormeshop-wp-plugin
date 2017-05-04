<div class="wrap">
    <h2>カラーミーショップ連携設定</h2>
	<?php
	global $parent_file;
	if ( $parent_file != 'options-general.php' ) {
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
