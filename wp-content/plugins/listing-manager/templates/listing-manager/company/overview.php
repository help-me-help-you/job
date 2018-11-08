<div class="post-overview">
    <dl>
        <?php $email = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'email', true ); ?>
        <?php if ( ! empty( $email ) ) : ?>
            <dt><?php echo esc_html__( 'Email', 'listing-manager' ); ?></dt>
            <dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></dd>
        <?php endif; ?>

        <?php $web = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'web', true ); ?>
        <?php if ( ! empty( $web ) ) : ?>
            <dt><?php echo esc_html__( 'Web', 'listing-manager' ); ?></dt>
            <dd><a href="<?php echo esc_attr( $web ); ?>"><?php echo esc_attr( $web ); ?></a></dd>
        <?php endif; ?>

        <?php $phone = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'phone', true ); ?>
        <?php if ( ! empty( $phone ) ) : ?>
            <dt><?php echo esc_html__( 'Phone', 'listing-manager' ); ?></dt><dd><?php echo esc_attr( $phone ); ?></dd>
        <?php endif; ?>

        <?php $address = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'address', true ); ?>
        <?php if ( ! empty( $address ) ) : ?>
            <dt><?php echo esc_html__( 'Address', 'listing-manager' )?></dt><dd><?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?></dd>
        <?php endif; ?>
    </dl>
</div><!-- /.post-overview -->    