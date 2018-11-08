<h2><?php echo esc_html__( 'Contact', 'listing-manager' ); ?></h2>

<?php $contact_authenticated = get_theme_mod( 'listing_manager_contact_authenticated', null ); ?>

<?php if ( empty( $contact_authenticated ) || is_user_logged_in() ) : ?>
    <dl>
        <?php $email = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'contact_email', true ); ?>
        <?php if ( ! empty( $email ) ) : ?>
            <dt><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?></dt>
            <dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></dd>
        <?php endif; ?>

        <?php $phone = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'contact_phone', true ); ?>
        <?php if ( ! empty( $phone ) ) : ?>
            <dt><?php echo esc_html__( 'Phone', 'listing-manager' ); ?></dt>
            <dd><?php echo esc_html( $phone ); ?></dd>
        <?php endif; ?>

        <?php $website = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'contact_website', true ); ?>
        <?php if ( ! empty( $website ) ) : ?>
            <dt><?php echo esc_html__( 'Website', 'listing-manager' ); ?></dt>
            <dd><a href="<?php echo esc_attr( $website ); ?>"><?php echo esc_html( $website ); ?></a></dd>
        <?php endif; ?>

        <?php $address = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'contact_address', true ); ?>
        <?php if ( ! empty( $address ) ) : ?>
            <dt><?php echo esc_html__( 'Address', 'listing-manager' ); ?></dt>
            <dd><?php echo esc_html( $address ); ?></dd>
        <?php endif; ?>
    </dl>
<?php else : ?>
    <p>
        <?php echo esc_html__( 'You must be logged in to see contact information.', 'listing-manager' ); ?>
    </p>
<?php endif; ?>