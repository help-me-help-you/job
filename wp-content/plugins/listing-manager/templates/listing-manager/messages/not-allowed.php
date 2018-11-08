<div class="woocommerce-message">
    <?php if ( ! empty( $message ) ) : ?>
        <?php echo wp_kses( $message, wp_kses_allowed_html( 'post' ) ); ?>
    <?php else : ?>
        <?php echo esc_html__( 'You are not allowed to access this page.', 'listing-manager' ); ?>
    <?php endif; ?>
</div><!-- /.woocommerce-message -->
