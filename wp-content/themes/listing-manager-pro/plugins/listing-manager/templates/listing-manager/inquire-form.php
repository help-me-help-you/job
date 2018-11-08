<?php $inquire = get_theme_mod( 'listing_manager_inquire_authenticated', null );?>

<form method="post" action="<?php echo ListingManager\Utilities::get_current_url(); ?>" class="inquire-form">
    <?php if ( ! empty( $inquire ) && ! is_user_logged_in() ) : ?>
        <?php $login_id = get_theme_mod( 'listing_manager_pages_login', null ); ?>
        <div class="inquire-form-login-required">
            <p>
                <?php if ( ! empty( $login_id ) ) : ?>
                    <a href="<?php echo get_permalink( $login_id ); ?>">
                <?php endif; ?>

                <?php echo esc_html__( 'Please login before posting inquire', 'listing-manager-front' ); ?>

                <?php if ( ! empty( $login_id ) ) : ?>
                    </a>
                <?php endif; ?>
            </p>
        </div><!-- /.login-required-->
    <?php endif; ?>

    <input type="hidden" name="post_id" value="<?php the_ID(); ?>">
    <input type="hidden" name="next" value="<?php echo ListingManager\Utilities::get_current_url(); ?>">

    <div class="inquire-form-fields">
        <div class="form-group form-group-name">
            <input class="form-control" name="name" type="text" placeholder="<?php echo esc_html__( 'Name', 'listing-manager' ); ?>" required="required">
        </div><!-- /.form-group -->

        <div class="form-group form-group-email">
            <input class="form-control" name="email" type="email" placeholder="<?php echo esc_html__( 'E-mail', 'listing-manager' ); ?>" required="required">
        </div><!-- /.form-group -->

        <div class="form-group form-group-subject">
            <input class="form-control" name="subject" type="text" placeholder="<?php echo esc_html__( 'Subject', 'listing-manager' ); ?>" required="required">
        </div><!-- /.form-group -->
    </div><!-- /.inquire-form-fields -->

    <div class="form-group form-group-message">
        <textarea class="form-control" name="message" required="required" placeholder="<?php echo esc_html__( 'Message', 'listing-manager' ); ?>" rows="4"></textarea>
    </div><!-- /.form-group -->

    <div class="form-group form-group-button">
        <button type="submit" class="button" name="inquire_form">
            <?php echo esc_html__( 'Send Message', 'listing-manager' ); ?>
        </button><!-- /.form-group -->
    </div><!-- /.button-wrapper -->
</form>