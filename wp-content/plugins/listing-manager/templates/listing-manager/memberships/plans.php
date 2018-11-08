<?php if ( function_exists( 'wc_memberships_get_user_active_memberships' ) ) : ?>
    <div class="listing-manager-membership-plans-wrapper">
        <?php $plans = wc_memberships_get_user_active_memberships(); ?>
        <?php $membership = ! empty( $_GET['id'] ) ? get_post_meta( $_GET['id'], LISTING_MANAGER_LISTING_PREFIX . 'membership', true ): null; ?>

        <?php if ( is_array( $plans ) ) : ?>
            <h3><?php echo esc_html__( 'Select membership plan', 'listing-manager' ); ?></h3>

            <?php if ( 0 !== count( $plans ) ) : ?>
                <div class="listing-manager-membership-plans">
                    <?php foreach( $plans as $plan ) : ?>
                        <?php $max = get_post_meta( $plan->plan->post->ID, LISTING_MANAGER_MEMBERSHIP_PREFIX . 'max', true ); ?>
                        <?php $count = count( \ListingManager\Logic\MembershipLogic::get_listings_in_plan( $plan->id ) ); ?>

                        <?php if ( ! empty( $max ) ) : ?>
                            <div class="form-group listing-manager-membership-plan checkbox <?php if ( $max == $count ) : ?>disabled<?php endif; ?>">
                                <label>
                                    <h4 class="listing-manager-membership-plan-name">
                                        <?php echo esc_html( $plan->plan->name ); ?>
                                    </h4><!-- /.listing-manager-membership-plan-name -->

                                    <ul class="listing-manager-membership-plan-meta">
                                        <li class="listing-manager-membership-plan-meta-current">
                                            <?php if ( '-1' === $max ) : ?>
                                                <span><?php echo esc_html__( 'Unlimited listings.', 'listing-manager' ); ?></span>
                                            <?php else : ?>
                                                <span><?php echo esc_html__( 'Max. allowed listings', 'listing-manager' ); ?>:</span> <strong><?php echo esc_html( $max ); ?></strong>
                                            <?php endif; ?>
                                        </li><!-- /.listing-manager-membership-plan-meta-current -->

                                        <li class="listing-manager-membership-plan-meta-current">
                                            <span><?php echo esc_html__( 'Current listings count', 'listing-manager' ); ?>:</span> <strong><?php echo esc_html( $count ); ?></strong>
                                        </li><!-- /.listing-manager-membership-plan-meta-current -->
                                    </ul>

                                    <input type="radio"
                                           name="<?php echo LISTING_MANAGER_LISTING_PREFIX; ?>membership"
                                           <?php if ( $max == $count ) : ?>class="disabled"<?php endif; ?>
                                           <?php if ( ! empty( $membership ) && $membership == $plan->id ) : ?>checked="checked"<?php endif; ?>
                                           value="<?php echo esc_attr( $plan->id ); ?>">
                                </label>
                            </div><!-- /.form-group -->
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div><!-- /.listing-manager-membership-plans -->
            <?php else : ?>
                <p>
                    <?php echo esc_html__( 'No membership plans defined.', 'listing-manager' ); ?>
                </p>
            <?php endif; ?>
        </div><!-- /.listing-manager-membership-plans-wrapper -->
    <?php endif; ?>
<?php else: ?>
    <div class="listing-manager-plugin-not-activated">
        <p>
            <?php echo esc_html__( 'Required plugin is not activated.', 'listing-manager' ); ?>
        </p>
    </div><!-- /.listing-manager-plugin-not-activated -->
<?php endif; ?>