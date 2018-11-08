<?php $amenities = wp_get_object_terms( get_the_ID(), 'amenities' ); ?>

<?php if ( is_array( $amenities ) ) : ?>
	<h2><?php echo esc_html__( 'Amenities', 'listing-manager' ); ?></h2>
	
	<ul class="amenities">
	    <?php foreach ( $amenities as $amenity ) : ?>
	        <li>
                <?php do_action( 'listing_manager_amenities_title_before', $amenity ); ?>
                <span><?php echo esc_html( $amenity->name ); ?></span>
		        <?php do_action( 'listing_manager_amenities_title_after', $amenity ); ?>
            </li>
	    <?php endforeach; ?>
	</ul>
<?php endif; ?>
