<div class="listing-manager-filter-form-wrapper">
    <form method="get"
          <?php if ( ! empty( $atts['hide_filter_form'] ) ) : ?>style="display: none;"<?php endif; ?>
          action="<?php echo ( ! empty( $atts['return_url'] ) ) ? $atts['return_url'] : ListingManager\Utilities::get_listings_url(); ?>"
          class="listing-manager-filter-form <?php if ( ! empty( $atts['autosubmit'] ) ) : ?>auto-submit-filter<?php endif; ?> <?php if ( ! empty( $atts['input_titles'] ) ) : ?><?php echo esc_attr( $atts['input_titles'] ); ?><?php endif; ?>">
        <?php $fields = ListingManager\Logic\FilterLogic::get_fields(); ?>

        <div class="listing-manager-filter-form-inner">
            <?php if ( ! empty( $atts['title'] ) ) : ?>
                <h2 class="listing-manager-filter-title"><?php echo esc_html( $atts['title'] ); ?></h2>
            <?php endif; ?>

            <?php if ( ! empty( $atts['sort'] ) ) : ?>
                <?php
                $keys = explode( ',', $atts['sort'] );
                $filtered_keys = array_filter( $keys );
                $fields = array_merge( array_flip( $filtered_keys ), $fields );
                ?>
            <?php endif; ?>

            <?php if ( ! empty( $atts['show_only'] ) ) : ?>
                <?php $fields_only = explode( ',', $atts['show_only'] );?>
            <?php endif; ?>

            <?php foreach ( $fields as $key => $value ) : ?>
                <?php $is_field_visible = empty( $instance[ sprintf( 'hide_%s', $key ) ] ); ?>
                <?php $is_field_active = in_array( $key, array_keys( ListingManager\Logic\FilterLogic::get_fields() ) ); ?>

                <?php if ( ! empty( $fields_only ) && ! in_array( $key, $fields_only ) ) : ?>
                    <?php continue; ?>
                <?php endif; ?>

                <?php if ( $is_field_visible && $is_field_active ) : ?>
                    <?php $template = str_replace( '_', '-', $key ); ?>
                    <?php wc_get_template( 'listing-manager/filters/' . $template . '.php', [
                        'key'           => $key,
                        'widget_id'		=> ListingManager\Utilities::get_uuid(),
                        'input_titles'	=> ! empty( $atts['input_titles'] ) ? $atts['input_titles'] : 'labels',
                        'atts'			=> $atts,
                    ], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ( empty( $atts['autosubmit'] ) ) : ?>
                <div class="form-group form-group-button">
                    <button class="button" type="submit">
                        <?php if ( ! empty( $atts['button_text'] ) ) : ?>
                            <?php echo wp_kses_post( $atts['button_text'] ); ?>
                        <?php else : ?>
                            <?php echo esc_html__( 'Filter Listings', 'listing-manager' ); ?>
                        <?php endif; ?>
                    </button>
                </div><!-- /.form-group -->
            <?php endif; ?>
        </div><!-- /.listing-manager-filter-form-inner -->
    </form>
</div><!-- /.listing-manager-filter-form-wrapper -->
