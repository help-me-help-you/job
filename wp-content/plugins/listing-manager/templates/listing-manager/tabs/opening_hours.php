<h2><?php echo esc_html__( 'Opening Hours', 'listing-manager' ); ?></h2>

<?php $has_custom_text = false; ?>
<?php foreach( ListingManager\Utilities::get_days() as $key => $value ) : ?>
    <?php $custom = get_post_meta( get_the_ID(),  LISTING_MANAGER_LISTING_PREFIX  . 'opening_hour_' .  $key . '_custom', true ); ?>

    <?php if ( ! empty( $custom ) ) : ?>
        <?php $has_custom_text = true; ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php $status = ListingManager\Utilities::opening_hours_status( get_the_ID() );?>

<table class="table opening-hours">
    <thead>
        <tr>
            <th>
                <div class="opening-hours-status <?php echo esc_attr( $status ); ?>">
		            <?php if ( 'open' === $status ) : ?>
			            <?php echo esc_attr__( 'Open', 'listing-manager' ); ?>
		            <?php else : ?>
			            <?php echo esc_attr__( 'Closed', 'listing-manager' ); ?>
		            <?php endif; ?>
                </div><!-- /.opening-hours-status -->
            </th>
            <th><?php echo esc_html__( 'Time From', 'listing-manager' ); ?></th>
            <th><?php echo esc_html__( 'Time To', 'listing-manager' ); ?></th>

            <?php if ( $has_custom_text ) : ?>
                <th><?php echo esc_html__( 'Custom Text', 'listing-manager' ); ?></th>
            <?php endif; ?>
        </tr>
    </thead>

    <tbody>
        <?php foreach( ListingManager\Utilities::get_days() as $key => $value ) : ?>
            <tr>
                <td class="day"><?php echo esc_html( $value ); ?></td>
                <?php $from = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX  . 'opening_hour_' .  $key . '_from', true ); ?>
                <td class="from"><?php echo esc_attr( $from ); ?></td>

                <?php $to = get_post_meta( get_the_ID(),  LISTING_MANAGER_LISTING_PREFIX  . 'opening_hour_' .  $key . '_to', true ); ?>
                <td class="to"><?php echo esc_attr( $to ); ?></td>

                <?php if ( $has_custom_text ) : ?>
                    <?php $custom = get_post_meta( get_the_ID(),  LISTING_MANAGER_LISTING_PREFIX  . 'opening_hour_' .  $key . '_custom', true ); ?>
                    <td class="text"><?php echo esc_attr( $custom ); ?></td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>