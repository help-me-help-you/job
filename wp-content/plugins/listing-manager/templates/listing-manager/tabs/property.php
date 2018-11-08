<h2><?php echo esc_html__( 'Property Attributes', 'listing-manager' ); ?></h2>

<dl>
    <?php $reference = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_reference', true ); ?>
    <?php if ( ! empty( $reference ) ) : ?>
        <dt><?php echo esc_html__( 'Reference', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $reference ); ?></dd>
    <?php endif; ?>

    <?php $year_built = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_year_built', true ); ?>
    <?php if ( ! empty( $year_built ) ) : ?>
        <dt><?php echo esc_html__( 'Year built', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $year_built ); ?></dd>
    <?php endif; ?>

    <?php $contracts = wp_get_post_terms( get_the_ID(), 'contracts' ); ?>
    <?php if ( ! empty( $contracts ) && is_array( $contracts ) && count( $contracts ) > 0 ) : ?>
        <?php $contract = array_shift( $contracts ); ?>

        <dt><?php echo esc_html__( 'Contract', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $contract->name ); ?></dd>
    <?php endif; ?>

    <?php $rooms = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_rooms', true ); ?>
    <?php if ( ! empty( $rooms ) ) : ?>
        <dt><?php echo esc_html__( 'Rooms', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $rooms ); ?></dd>
    <?php endif; ?>

    <?php $bathrooms = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_bathrooms', true ); ?>
    <?php if ( ! empty( $bathrooms ) ) : ?>
        <dt><?php echo esc_html__( 'Bathrooms', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $bathrooms ); ?></dd>
    <?php endif; ?>

    <?php $bedrooms = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_bedrooms', true ); ?>
    <?php if ( ! empty( $bedrooms ) ) : ?>
        <dt><?php echo esc_html__( 'Bedrooms', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $bedrooms ); ?></dd>
    <?php endif; ?>

    <?php $garages = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_garages', true ); ?>
    <?php if ( ! empty( $garages ) ) : ?>
        <dt><?php echo esc_html__( 'Garages', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $garages ); ?></dd>
    <?php endif; ?>

    <?php $parking_slots = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_parking_slots', true ); ?>
    <?php if ( ! empty( $parking_slots ) ) : ?>
        <dt><?php echo esc_html__( 'Parking slots', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $parking_slots ); ?></dd>
    <?php endif; ?>

    <?php $home_area = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_home_area', true ); ?>
    <?php if ( ! empty( $home_area ) ) : ?>
        <dt><?php echo esc_html__( 'Home area', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $home_area ); ?></dd>
    <?php endif; ?>

    <?php $lot_area = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_lot_area', true ); ?>
    <?php if ( ! empty( $lot_area ) ) : ?>
        <dt><?php echo esc_html__( 'Lot area', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $lot_area ); ?></dd>
    <?php endif; ?>

    <?php $lot_dimensions = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_lot_dimensions', true ); ?>
    <?php if ( ! empty( $lot_dimensions ) ) : ?>
        <dt><?php echo esc_html__( 'Lot dimensions', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $lot_dimensions ); ?></dd>
    <?php endif; ?>
</dl>
