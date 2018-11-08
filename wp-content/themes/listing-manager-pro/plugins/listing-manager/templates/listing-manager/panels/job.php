<div id="job" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'job_start',
		'label'			=> esc_html__( 'Start', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'job_contract',
		'label'			=> esc_html__( 'Contract', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'job_position',
		'label'			=> esc_html__( 'Position', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'job_skills',
		'label'			=> esc_html__( 'Required skills', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>
</div><!-- /.panel -->
