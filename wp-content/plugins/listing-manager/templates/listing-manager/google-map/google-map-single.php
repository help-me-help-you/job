<?php $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null ); ?>
<?php $latitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true ); ?>
<?php $longitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true ); ?>

<?php if ( ! empty( $api_key ) ) : ?>	
	<?php if ( ! empty( $latitude ) && ! empty( $longitude ) ) : ?>
	<div class="listing-manager-google-map-single">
		<?php $style = ListingManager\Logic\GoogleMapLogic::get_style(); ?>

		<div id="map-object-single"
             class="listing-manager-google-map-single-map"
			 <?php if ( ! empty( $style ) ) : ?>data-styles='<?php echo esc_attr( $style ); ?>'<?php endif;?>
             data-zoom="13"
             data-image="<?php the_post_thumbnail_url( 'thumbnail' ); ?>"
			 data-latitude="<?php echo esc_attr( $latitude ); ?>"
			 data-longitude="<?php echo esc_attr( $longitude ); ?>">			
		</div><!-- /.listing-manager-google-map-single -->

		<a href="https://maps.google.com?daddr=<?php echo esc_attr( $latitude ); ?>,<?php echo esc_attr( $longitude ); ?>" class="get-direction" target="_blank">
		    <?php echo esc_html__( 'Get directions', 'listing-manager' ); ?>
		</a>		
	</div><!-- /.listing-manager-google-map-single -->
	<?php endif; ?>
<?php else : ?>
	<p><?php echo esc_html__( 'You are missing Google Maps API key. You can set it under "Customizer - Listing Manager General - Google Maps API key"', 'listing-manager' ); ?></p>
<?php endif; ?>