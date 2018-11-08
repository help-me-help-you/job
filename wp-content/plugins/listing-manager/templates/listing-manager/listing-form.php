<?php $fields = ListingManager\Logic\SubmissionLogic::get_fields(); ?>
<?php $forms = ListingManager\Logic\SubmissionLogic::get_available_forms(); ?>
<?php $submission_type = get_theme_mod( 'listing_manager_submission_type', 'free' ); ?>

<?php if ( ( is_array( $forms ) && count( $forms ) > 0 ) && empty( $_GET['form'] ) ) : ?>
    <div class="listing-manager-submission-forms">
        <h3><?php echo esc_html__( 'Please select a form to add a new listing', 'listing-manager' ); ?></h3>

        <ul>
            <?php foreach ( $forms as $key => $value ) : ?>
                <?php $args = [ 'form' => $key, ]; ?>

                <?php if ( ! empty( $_GET['id'] ) ) : ?>
                    <?php $args['id'] = $_GET['id']; ?>
                <?php endif; ?>

                <?php $query = http_build_query( $args ); ?>

                <li>
                    <a href="?<?php echo $query; ?>">
                        <?php echo esc_html( $value ); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div><!-- /.listing-manager-submission-forms -->
<?php endif; ?>

<?php if ( ( 0 < count( $forms ) && ! empty( $_GET['form'] ) ) || 0 >= count( $forms ) ) : ?>
    <?php $form = ! empty( $_GET['form'] ) ? $_GET['form'] : null; ?>

    <?php if ( 'memberships' === $submission_type && ! is_user_logged_in() ) : ?>
        <div class="listing-manager-submission-login-required">
            <p>
                <?php echo esc_html__( 'Listing submission is allowed only for authenticated users with the membership plan.', 'listing-manager' ); ?>
            </p>
        </div>
    <?php elseif ( in_array( $form, array_keys( $forms ) ) ) : ?>
        <form method="post" class="listing-manager-submission-form" enctype="multipart/form-data" action="<?php echo ListingManager\Utilities::get_current_url(); ?>">
            <input type="hidden" name="form" value="<?php echo esc_attr( $form ); ?>">

            <?php if ( 'packages' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) : ?>
                <?php echo ListingManager\Product\PackageProduct::get_submission_packages(); ?>
            <?php elseif ( 'memberships' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) : ?>
                <?php echo ListingManager\Logic\MembershipLogic::get_submission_plans(); ?>
            <?php endif; ?>

            <div class="listing-manager-submission-fieldsets">
                <?php echo ListingManager\Logic\SubmissionLogic::render_fields( null, $update, $form ); ?>
            </div><!-- /.listing-manager-submission-fieldsets -->

            <div class="listing-manager-submission-action">
                <button type="submit" name="submit_listing" value="1" class="button">
                    <?php echo esc_html__( 'Save', 'listing-manager' ); ?>
                </button>
            </div><!-- /.listing-manager-submission-action -->
        </form>
    <?php else : ?>
        <div class="listing-manager-submission-not-found">
            <p>
                <?php echo esc_html__( 'Listing form not found.', 'listing-manager' )?>
            </p>
        </div><!-- /.listing-manager-submission-not-found -->
    <?php endif; ?>
<?php endif; ?>

<?php ListingManager\Logic\SubmissionLogic::clean_validation_errors(); ?>
