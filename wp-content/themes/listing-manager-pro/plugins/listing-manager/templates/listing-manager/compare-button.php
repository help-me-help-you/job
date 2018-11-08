<div class="listing-manager-compare">
    <a href="<?php echo ListingManager\Logic\CompareLogic::get_link( get_the_ID(), ListingManager\Logic\CompareLogic::is_compared( get_the_ID() ) ); ?>" class="button">
        <span>
            <?php if ( ! ListingManager\Logic\CompareLogic::is_compared( get_the_ID() ) ) : ?>
        	       <?php echo apply_filters( 'listing_manager_compare_title', esc_html__( 'Add to compare', 'listing-manager' ) )?>
            <?php else : ?>
                <?php echo apply_filters( 'listing_manager_compare_title', esc_html__( 'Remove from compare', 'listing-manager' ) )?>
            <?php endif; ?>
        </span>
    </a><!-- /.button -->
</div><!-- /.listing-manager-compare -->
