<div id="location" class="panel woocommerce_options_panel">

	<?php $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null ); ?>

	<?php if ( ! empty( $api_key ) ) : ?>
		<div id="location-google-map" style="height: 400px;"></div>
		<p class="form-field options_group">
			<label for="<?php echo LISTING_MANAGER_LISTING_PREFIX; ?>location_search"><?php echo esc_html__( 'Search', 'listing-manager-front' ); ?></label>
			<input type="text" class="location-google-map-search" id="<?php echo LISTING_MANAGER_LISTING_PREFIX; ?>location_search">
		</p>		

		<?php woocommerce_wp_text_input( [
			'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'location_latitude',
			'label'			=> esc_html__( 'Latitude', 'listing-manager' ),
			'type' 			=> 'text',
			'wrapper_class'	=> 'options_group',
		] ); ?>

		<?php woocommerce_wp_text_input( [
			'id'			=> LISTING_MANAGER_LISTING_PREFIX . 'location_longitude',
			'label'			=> esc_html__( 'Longitude', 'listing-manager' ),
			'type' 			=> 'text',
			'wrapper_class'	=> 'options_group',
		] ); ?>
	<?php else : ?>
		<p><?php echo esc_html__( 'You are missing Google Maps API key. You can set it under "Customizer - Listing Manager General - Google Maps API key"' ); ?></p>
	<?php endif; ?>
</div><!-- /.panel -->