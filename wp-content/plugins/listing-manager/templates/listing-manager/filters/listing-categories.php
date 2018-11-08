<?php if ( empty( $atts['hide_listing_categories'] ) ) : ?>
    <?php $selects = ListingManager\Utilities::build_taxonomy_selects( 'product_cat' ); ?>
    <?php $select_previous = null; ?>

    <?php foreach ( $selects as $level => $options ) : ?>
        <div class="form-group">
            <?php if ( 'labels' == $input_titles ) : ?>
                <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_listing_categories">
                    <?php echo esc_html__( 'Category', 'listing-manager' ); ?>
                </label>
            <?php endif; ?>

            <select id="listing-categories-<?php echo esc_attr( $level ); ?>" 
                    <?php if ( ! empty( $select_previous ) ) : ?>data-chain-to="listing-categories-<?php echo esc_attr( $select_previous ); ?>"<?php endif; ?>
                    class="form-control chained" name="filter-listing-categories[]">
                    <?php if ( empty( $select_previous ) ) : ?>
                        <option value="0">
                            <?php if ( 'placeholders' == $input_titles ) : ?>
                                <?php echo esc_html__( 'Category', 'listing-manager' ); ?>
                            <?php else : ?>
                                <?php echo esc_html__( 'All categories', 'listing-manager' ); ?>
                            <?php endif; ?>
                        </option>
                    <?php else : ?>
                        <option value="">--</option>
                    <?php endif; ?>             

                <?php foreach ( $options as $option ) : ?>
                    <option value="<?php echo esc_attr( $option['value'] ); ?>" 
                            <?php if ( ! empty( $_GET['filter-listing-categories'] ) && in_array( $option['value'], $_GET['filter-listing-categories'] )  ) : ?>selected="selected"<?php endif; ?>
                            class="<?php echo esc_attr( $option['parent'] ); ?>">
                        <?php echo esc_html( $option['name'] ); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div><!-- /.form-group -->

        <?php $select_previous = $level; ?>
    <?php endforeach; ?>
<?php endif; ?>
