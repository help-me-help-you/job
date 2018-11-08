<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="marker" id="marker-<?php echo get_the_ID(); ?>">
    <div class="marker-inner">
	    <?php $image_url = wp_get_attachment_image_url( get_post_thumbnail_id() ); ?>

        <?php if ( ! empty( $image_url ) ) : ?>
            <span class="marker-image" style="background-image: url('<?php echo esc_attr( $image_url ); ?>');"></span>
        <?php else : ?>
            <span class="marker-image"></span>
        <?php endif; ?>

        <?php $veritified = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'is_verified', true ); ?>
        <?php if ( ! empty( $veritified ) ) : ?>
            <div class="marker-verified"><i class="fa fa-check"></i> <span class="screen-reader-text"><?php echo esc_html__( 'Verified', 'listing-manager' ); ?></span></div>
        <?php endif; ?>

        <div class="marker-title"><?php echo the_title(); ?></div>
    </div>
</div>