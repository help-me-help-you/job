<div class="next-prev-links">
    <?php $link = get_previous_post_link( '%link', '<i class="fa fa-chevron-left"></i> %title', true, '', 'product_type' ); ?>
    <?php if ( ! empty( $link ) ) : ?>
        <div class="prev">
            <?php previous_post_link( '%link', '<i class="fa fa-chevron-left"></i> %title', true, '', 'product_type' ); ?>
        </div><!-- /.prev -->
    <?php endif; ?>

    <?php $link = get_next_post_link( '%link', '%title <i class="fa fa-chevron-right"></i>', true, '', 'product_type' ); ?>
    <?php if ( ! empty( $link ) ) : ?>
        <div class="next">
            <?php next_post_link( '%link', '%title <i class="fa fa-chevron-right"></i>', true, '', 'product_type' ); ?>
        </div><!-- /.next -->
    <?php endif; ?>
</div><!-- /.next-prev-links -->