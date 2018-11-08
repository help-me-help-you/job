<div class="post-overview">
    <dl>
        <?php $email = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'email', true ); ?>
        <?php if ( ! empty( $email ) ) : ?>
            <dt><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?></dt>
            <dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></dd>
        <?php endif; ?>

        <?php $web = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'web', true ); ?>
        <?php if ( ! empty( $web ) ) : ?>
            <dt><?php echo esc_html__( 'Web', 'listing-manager' ); ?></dt>
            <dd><a href="<?php echo esc_attr( $web ); ?>"><?php echo esc_attr( $web ); ?></a></dd>
        <?php endif; ?>

        <?php $phone = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'phone', true ); ?>
        <?php if ( ! empty( $phone ) ) : ?>
            <dt><?php echo esc_html__( 'Phone', 'listing-manager' ); ?></dt><dd><?php echo esc_attr( $phone ); ?></dd>
        <?php endif; ?>

        <?php $companies = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'companies', true ); ?>

        <?php if ( ! empty( $companies ) && is_array( $companies ) && count( $companies ) > 0 ) : ?>
            <?php $company_id = array_shift( $companies ); ?>
            <?php $company = get_post( $company_id ); ?>
            <?php if ( ! empty( $company ) ) : ?>
                <dt><?php echo esc_html__( 'Company', 'listing-manager' ); ?></dt>
                <dd>
                    <a href=""><?php echo esc_attr( $company->post_title ); ?></a>
                </dd>
            <?php endif; ?>
        <?php endif; ?>

        <?php $listings = ListingManager\Utilities::get_agent_listings( get_the_ID() ); ?>
        <?php if ( ! empty( $listings ) && is_array( $listings ) && count( $listings > 0 ) ) : ?>
            <dt><?php echo esc_html__( 'Listings', 'listing-manager' ); ?></dt><dd><?php echo count( $listings ); ?></dd>
        <?php endif; ?>
    </dl>
</div><!-- /.post-overview --> 