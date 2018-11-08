<?php

global $product;

if ( empty( $product ) ) {
    return;
}

if ( ! $product->is_purchasable() ) {
    return;
}
?>

<?php if ( $product->is_in_stock() ) : ?>
    <div class="listing-manager-purchase">
        <div class="listing-manager-purchase-content">
            <div class="listing-manager-purchase-price">
                <?php echo $product->get_price_html(); ?>
            </div><!-- /.listing-manager-purchase-price -->

            <div class="listing-manager-purchase-title">
                <h2><?php the_title(); ?></h2>
            </div><!-- /.listing-manager-purchase -->

            <?php $date = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'event_date', true ); ?>

            <?php if ( ! empty( $date ) ) : ?>
	            <?php $time = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'event_time', true ); ?>

                <div class="listing-manager-purchase-event">
                    <?php echo date_i18n( get_option( 'date_format' ), strtotime( $date ) ); ?>
                    <?php echo date_i18n( get_option( 'time_format' ), strtotime( $time ) ); ?>
                </div><!-- /.listing-manager-purchase-event -->
            <?php endif; ?>
        </div><!-- /.listing-manager-purchase-content -->

        <div class="listing-manager-purchase-button">
            <a href="?add-to-cart=<?php the_ID(); ?>" class="button"><?php echo esc_html__( 'Add to cart', 'listing-manager' ); ?></a>
        </div><!-- /.listing-manager-purchase-button -->

	    <?php if ( $product->get_stock_quantity() ) : ?>
            <div class="listing-manager-purchase-quantity">
			    <?php echo esc_html__( 'Quantity', 'listing-manager' ); ?>: <?php echo $product->get_stock_quantity(); ?>
            </div><!-- /.listing-manager-purchase-quantity -->
	    <?php endif; ?>
    </div><!-- /.listing-manager-purchase -->
<?php else : ?>
    <p>
        <?php echo esc_html__( 'It is not possible to add this product into cart.', 'listing-manager' ); ?>
    </p>
<?php endif; ?>