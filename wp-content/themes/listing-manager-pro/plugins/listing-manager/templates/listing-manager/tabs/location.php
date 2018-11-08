<h2><?php echo esc_html__( 'Location', 'listing-manager' ); ?></h2>

<?php $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null ); ?>
<?php if ( ! empty( $api_key ) ) : ?>	
	<?php $latitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true ); ?>
	<?php $longitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true ); ?>

	<a href="https://maps.google.com?daddr=<?php echo esc_attr( $latitude ); ?>,<?php echo esc_attr( $longitude ); ?>" class="get-direction">
	    <?php echo esc_html__( 'Get directions', 'listing-manager' ); ?>
	</a>

	<div style="height:500px;width:100%;max-width:100%;list-style:none; transition: none;overflow:hidden;">
	    <div id="display-google-map" style="height:100%; width:100%;max-width:100%;">
	        <iframe style="height:100%;width:100%;border:0;" frameborder="0"
	                src="https://www.google.com/maps/embed/v1/place?q=<?php echo esc_attr( $latitude ); ?>,<?php echo esc_attr( $longitude ); ?>&key=<?php echo esc_attr( $api_key ); ?>">
	        </iframe>
	    </div>

	    <style>#display-google-map img{max-width:none!important;background:none!important;font-size: inherit;}</style>
	</div>
<?php else : ?>
	<p><?php echo esc_html__( 'You are missing Google Maps API key. You can set it under "Customizer - Listing Manager General - Google Maps API key"', 'listing-manager' ); ?></p>
<?php endif; ?>


