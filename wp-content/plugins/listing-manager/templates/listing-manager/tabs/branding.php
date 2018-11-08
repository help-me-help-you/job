<h2><?php echo esc_html__( 'Branding', 'listing-manager' ); ?></h2>

<dl>
    <?php $name = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'branding_name', true ); ?>
    <?php if ( ! empty( $name ) ) : ?>
        <dt><?php echo esc_html__( 'Name', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $name ); ?></dd>
    <?php endif; ?>

    <?php $slogan = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'branding_slogan', true ); ?>
    <?php if ( ! empty( $slogan ) ) : ?>
        <dt><?php echo esc_html__( 'Slogan', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $slogan ); ?></dd>
    <?php endif; ?>

    <?php $color = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'branding_color', true ); ?>
    <?php if ( ! empty( $color ) ) : ?>
        <dt><?php echo esc_html__( 'Color', 'listing-manager' ); ?></dt>
        <dd><?php echo esc_html( $color ); ?></dd>
    <?php endif; ?>

    <?php $logo = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'branding_logo', true ); ?>
    <?php if ( ! empty( $logo) ) : ?>
        <dt><?php echo esc_html__( 'Logo', 'listing-manager' ); ?></dt>
        <dd>
            <?php $src = wp_get_attachment_image_src( $logo ); ?>
            <img src="<?php echo esc_attr( $src[0] ); ?>" alt="">
        </dd>
    <?php endif; ?>
</dl>
