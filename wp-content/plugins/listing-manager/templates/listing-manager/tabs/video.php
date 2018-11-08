<h2><?php echo esc_html__( 'Video', 'listing-manager' ); ?></h2>

<div class="videos">
    <?php $youtube = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'video_youtube', true ); ?>

    <?php if ( ! empty( $youtube ) ) : ?>
        <iframe width="640" height="360" src="<?php echo esc_url( $youtube ); ?>" frameborder="0" allowfullscreen></iframe>
    <?php endif; ?>

    <?php $vimeo = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'video_vimeo', true ); ?>

    <?php if ( ! empty( $vimeo ) ) : ?>
        <iframe width="640" height="360" src="<?php echo esc_url( $vimeo ); ?>" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
    <?php endif; ?>
</div><!-- /.videos -->
