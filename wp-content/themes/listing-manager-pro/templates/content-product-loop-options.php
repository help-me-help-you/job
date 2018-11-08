<?php if ( defined('LISTING_MANAGER_LISTING_PREFIX' ) ) : ?>
    <div class="options">
        <div class="options-header">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <ul class="options-list">
            <?php $compare_link = ListingManager\Logic\CompareLogic::get_link( get_the_ID(), ListingManager\Logic\CompareLogic::is_compared( get_the_ID() ) ); ?>

            <?php if ( ! empty( $compare_link ) ) : ?>
                <li>
                    <a href="<?php echo esc_attr( $compare_link ); ?>">
                        <?php if (  ListingManager\Logic\CompareLogic::is_compared( get_the_ID() ) ) : ?>
                            <?php echo esc_html__( 'Remove from compare', 'listing-manager-pro' ); ?>
                        <?php else : ?>
                            <?php echo esc_html__( 'Add to compare', 'listing-manager-pro' ); ?>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php $favorite_link = ListingManager\Logic\FavoriteLogic::get_link( get_the_ID() ); ?>
            <?php if ( ! empty( $favorite_link ) ) : ?>
                <li>
                    <a href="<?php echo esc_attr( $favorite_link ); ?>">
                        <?php echo esc_html__( 'Add to favorites', 'listing-manager-pro' ); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php $claim_link = ListingManager\Logic\ClaimLogic::get_link( get_the_ID() ); ?>
            <?php if ( ! empty( $claim_link ) ) : ?>
                <li>
                    <a href="<?php echo esc_attr( $claim_link ); ?>">
                        <?php echo esc_html__( 'Claim listing', 'listing-manager-pro' ); ?>
                    </a>
                </li>
            <?php endif; ?>

            <?php $report_link = ListingManager\Logic\ReportLogic::get_link( get_the_ID() ); ?>
            <?php if ( ! empty( $report_link ) ) : ?>
                <li>
                    <a href="<?php echo esc_attr( $report_link ); ?>">
                        <?php echo esc_html__( 'Report listing', 'listing-manager-pro' ); ?>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div><!-- /.options -->
<?php endif; ?>