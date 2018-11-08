<div id="package" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_PACKAGE_PREFIX . 'limit',
		'label'			=> esc_html__( 'No. of listings', 'listing-manager' ),
		'type' 			=> 'number',
		'wrapper_class'	=> 'options_group',
		'description'	=> esc_html__( 'Use -1 for unlimited number of listings.', 'listing-manager' ),
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_PACKAGE_PREFIX . 'duration',
		'label'			=> esc_html__( 'Duration', 'listing-manager' ),
		'type' 			=> 'number',
		'wrapper_class'	=> 'options_group',
		'description'	=> esc_html__( 'Insert -1 for unlimited duration.', 'listing-manager' ),
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_PACKAGE_PREFIX . 'class',
		'label'			=> esc_html__( 'CSS Class', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_checkbox( [
		'id' 			=> LISTING_MANAGER_PACKAGE_PREFIX . 'exclude',
		'label' 		=> esc_html__( 'Exclude from pricing tables', 'listing-manager' ),
		'wrapper_class'	=> 'options_group',
		'cbvalue' 		=> '1'
	] ); ?>
</div><!-- /.panel -->