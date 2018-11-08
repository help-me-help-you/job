<div id="branding" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'branding_name',
		'label'			=> esc_html__( 'Business Name', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'branding_slogan',
		'label'			=> esc_html__( 'Slogan', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'branding_color',
		'label'			=> esc_html__( 'Color', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'branding_logo',
		'label'			=> esc_html__( 'Logo', 'listing-manager' ),
		'type' 			=> 'number',
		'wrapper_class'	=> 'options_group',
	] ); ?>
</div><!-- /.panel -->