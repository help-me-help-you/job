<div id="contact" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'contact_email',
		'label'			=> esc_html__( 'E-mail', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'contact_phone',
		'label'			=> esc_html__( 'Phone', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'contact_website',
		'label'			=> esc_html__( 'Website', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_textarea_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'contact_address',
		'label'			=> esc_html__( 'Address', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>
</div><!-- /.panel -->