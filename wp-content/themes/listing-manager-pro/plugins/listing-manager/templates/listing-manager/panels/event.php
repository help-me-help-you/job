<div id="event" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'event_date',
		'label'			=> esc_html__( 'Start Date', 'listing-manager' ),
		'type' 			=> 'text',
		'class'         => 'date-picker-field',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'event_time',
		'label'			=> esc_html__( 'Start Time', 'listing-manager' ),
		'type' 			=> 'text',
		'class'         => 'time-picker-field',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'event_date_end',
		'label'			=> esc_html__( 'End Date', 'listing-manager' ),
		'type' 			=> 'text',
		'class'         => 'date-picker-field',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'event_time_end',
		'label'			=> esc_html__( 'End Time', 'listing-manager' ),
		'type' 			=> 'text',
		'class'         => 'time-picker-field',
		'wrapper_class'	=> 'options_group',
	] ); ?>
</div><!-- /.panel -->
