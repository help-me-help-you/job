<div id="property" class="panel woocommerce_options_panel">
	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_reference',
		'label'			=> esc_html__( 'Reference', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_year_built',
		'label'			=> esc_html__( 'Year built', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_rooms',
		'label'			=> esc_html__( 'Rooms', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_bathrooms',
		'label'			=> esc_html__( 'Bathrooms', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_bedrooms',
		'label'			=> esc_html__( 'Bedrooms', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_garages',
		'label'			=> esc_html__( 'Garages', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_parking_slots',
		'label'			=> esc_html__( 'Parking slots', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_home_area',
		'label'			=> esc_html__( 'Home area', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_lot_area',
		'label'			=> esc_html__( 'Lot area', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>

	<?php woocommerce_wp_text_input( [
		'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'property_lot_dimensions',
		'label'			=> esc_html__( 'Lot dimensions', 'listing-manager' ),
		'type' 			=> 'text',
		'wrapper_class'	=> 'options_group',
	] ); ?>
</div><!-- /.panel -->
