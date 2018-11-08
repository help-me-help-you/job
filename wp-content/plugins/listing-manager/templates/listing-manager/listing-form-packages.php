<div class="listing-manager-submission-packages-wrapper">
    <?php if ( is_user_logged_in() ) : ?>
        <?php $packages = ListingManager\Product\PackageProduct::get_purchased_packages(); ?>

        <?php if ( ! empty( $packages ) ) : ?>
            <h3><?php echo esc_html__( 'Select already purchased package', 'listing-manager' ); ?></h3>

            <div class="listing-manager-submission-packages">
                <?php foreach ( $packages as $order_package ) : ?>
                    <?php $package = get_post( $order_package['product_id'] )?>
                    <?php $class = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'class' , true ); ?>
                    <?php $product = wc_get_product( $package->ID ); ?>

                    <div class="listing-manager-submission-package <?php if ( ! empty( $class ) ) : ?><?php echo esc_attr( $class ); ?><?php endif; ?> <?php if ( ListingManager\Product\PackageProduct::is_expired( $order_package['order_id'], $order_package['product_id'] ) ) : ?>expired<?php endif; ?>">
                        <label>
                            <h4>
                                <?php echo esc_html( $package->post_title ); ?>
                                <span><?php echo $product->get_price_html(); ?></span>
                            </h4>

                            <?php $duration = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'duration', true ); ?>
                            <?php $limit = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'limit', true ); ?>

                            <?php if ( ! empty( $duration ) || ! empty( $limit ) ) : ?>
                                <ul>
                                    <?php if ( ! empty( $limit ) ) : ?>
                                        <li>
                                            <span>
                                                <?php echo ListingManager\Product\PackageProduct::get_listing_count_for_order( $order_package['order_id'] ); ?>
                                                <?php echo esc_html__( 'of', 'listing-manager' ); ?>
                                                <?php echo ListingManager\Product\PackageProduct::get_limit_formatted( $package->ID ); ?>
                                            </span>
                                        </li>
                                    <?php endif; ?>

                                    <?php if ( ! empty( $duration ) ) : ?>
                                        <li><span><?php echo ListingManager\Product\PackageProduct::get_expiration_formatted( $order_package['order_id'], $order_package['product_id'] ); ?></span></li>
                                    <?php endif; ?>

                                    <?php if ( '-1' !== $duration ) : ?>
                                        <li>
                                            <a href="?action=listing-manager-extend&amp;order-id=<?php echo esc_attr( $order_package['order_id'] ); ?>&amp;package-id=<?php echo $order_package['product_id']?>">
                                                <?php echo esc_html__( 'Extend', 'listing-manager' ); ?>

                                                <?php if ( 1 === $duration ) : ?>
                                                    <span><?php echo sprintf( esc_html__( '%s day', 'listing-manager' ), 1 ); ?></span>
                                                <?php else : ?>
                                                    <span><?php echo sprintf( esc_html__( '%s days', 'listing-manager' ), $duration ); ?></span>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            <?php endif; ?>

                            <?php if ( ! empty( $_GET['id'] ) ) : ?>
                                <?php $order = get_post_meta( $_GET['id'], LISTING_MANAGER_LISTING_PREFIX . 'package_order', true ); ?>
                            <?php endif; ?>
                            <input type="radio" name="listing_package_order"
                                   <?php if ( ListingManager\Product\PackageProduct::is_expired( $order_package['order_id'], $order_package['product_id'] ) ) : ?>disabled="disabled"<?php endif; ?>
                                   <?php if ( ! empty( $_GET['id'] ) && $order == $order_package['order_id'] ): ?>checked="checked"<?php endif; ?>
                                   value="<?php echo esc_attr( $order_package['order_id'] ); ?>">
                        </label>
                    </div><!-- /.listing-manager-submission-package -->
                <?php endforeach; ?>
            </div><!-- /.listing-manager-submission-packages -->
        <?php endif; ?>
    <?php endif; ?>

    <?php $packages = ListingManager\Product\PackageProduct::get_packages(); ?>

    <?php if ( ! empty( $packages ) ) : ?>
        <h3><?php echo esc_html__( 'Purchase new package', 'listing-manager' ); ?></h3>

        <div class="listing-manager-submission-packages">
            <?php foreach ( $packages as $package ) : ?>
                <?php $class = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'class' , true ); ?>
                <div class="listing-manager-submission-package <?php if ( ! empty( $class ) ) : ?><?php echo esc_attr( $class ); ?><?php endif; ?>">
                    <label>
                        <?php $product = wc_get_product( $package->ID ); ?>

                        <h4>
                            <?php echo esc_html( $package->post_title ); ?>
                            <span><?php echo $product->get_price_html(); ?></span>
                        </h4>


                        <?php $duration = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'duration', true ); ?>
                        <?php $limit = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'limit', true ); ?>

                        <?php if ( ! empty( $duration ) || ! empty( $limit ) ) : ?>
                            <ul>
                                <?php if ( ! empty( $limit ) ) : ?>
                                    <li>
                                        <strong><?php echo esc_html__( 'Limit', 'listing-manager' ); ?>:</strong>
                                        <span><?php echo ListingManager\Product\PackageProduct::get_limit_formatted( $package->ID ); ?></span>
                                    </li>
                                <?php endif; ?>

                                <?php if ( ! empty( $duration ) ) : ?>
                                    <li>
                                        <strong><?php echo esc_html__( 'Duration', 'listing-manager' ); ?>:</strong>
                                        <span><?php echo ListingManager\Product\PackageProduct::get_duration_formatted( $package->ID ); ?></span>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>

                        <input type="radio"
                               <?php if ( ! empty( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package_order' ] ) && ! empty( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ] ) ): ?>
                                   <?php if ( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ] == $package->ID ) : ?>
                                       checked="checked"
                                   <?php endif; ?>
                               <?php endif; ?>
                               name="listing_package"
                               value="<?php echo esc_attr( $package->ID ); ?>">
                    </label>
                </div><!-- /.listing-manager-submission-package -->
            <?php endforeach; ?>
        </div><!-- /.listing-manager-submission-packages -->
    <?php endif; ?>
</div><!-- /.listing-manager-submission-packages-wrapper -->
