<?php $post_id = get_the_ID(); ?>

<?php query_posts( [
  'post_type'       => 'field',
  'posts_per_page'  => -1,
] ); ?>

<?php if ( have_posts() ): ?>
    <div class="listing-manager-fields">
        <?php while( have_posts() ) : the_post(); ?>
            <?php $show = get_post_meta( get_the_ID(), LISTING_MANAGER_FIELD_PREFIX . 'show_custom_field', true ); ?>

            <?php if ( 'on' === $show ) : ?>
                <?php $slug = get_post_meta( get_the_ID(), LISTING_MANAGER_FIELD_PREFIX . 'slug', true ); ?>
                <?php $type = get_post_meta( get_the_ID(), LISTING_MANAGER_FIELD_PREFIX . 'type', true ); ?>
                <?php $label = get_post_meta( get_the_ID(), LISTING_MANAGER_FIELD_PREFIX . 'label', true ); ?>

                <?php if ( ! empty( $slug ) ) : ?>
                    <div class="listing-manager-field">
                        <div class="listing-manager-field-label">
                            <?php echo esc_html( $label ); ?>
                        </div><!-- /.listing-manager-field-label -->

                        <div class="listing-manager-field-value">
                            <?php if ( 'taxonomy' === $type ) : ?>
                                <?php $taxonomy = get_post_meta( get_the_ID(), LISTING_MANAGER_FIELD_PREFIX . 'taxonomy', true ); ?>
                                <?php $terms = wp_get_post_terms( $post_id, $taxonomy ); ?>

                                <?php if ( is_array( $terms ) ) : ?>
                                    <?php $count = 1; ?>
                                    <?php foreach ( $terms as $term ) : ?>
                                        <?php echo esc_html( $term->name ); ?><?php if ( $count != count( $terms ) ) : ?>, <?php endif; ?>
                                        <?php $count++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php else :?>
                                <?php $value = get_post_meta( $post_id, $slug, true );?>
                                <?php echo esc_html( $value ); ?>
                            <?php endif; ?>
                        </div><!-- /.listing-manager-field-value -->
                    </div><!-- /.listing-manager-field -->
                <?php endif; ?>
            <?php endif; ?>
        <?php endwhile; ?>
    </div><!-- /.listing-manager-fields -->
<?php endif; ?>

<?php wp_reset_query(); ?>