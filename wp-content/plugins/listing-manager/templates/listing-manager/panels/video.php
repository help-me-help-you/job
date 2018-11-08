<div id="video" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'video_youtube',
		'label'			=> esc_html__( 'YouTube', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
        'description'   => 'https://www.youtube.com/embed/CODE_HERE',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'video_vimeo',
		'label'			=> esc_html__( 'Vimeo', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
		'description'   => 'https://player.vimeo.com/video/CODE_HERE',
	] ); ?>
</div><!-- /.panel -->