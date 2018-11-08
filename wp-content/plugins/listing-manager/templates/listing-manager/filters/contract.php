<?php if ( empty( $atts['hide_contract'] ) ) : ?>
    <div class="form-group">
        <?php if ( 'labels' == $input_titles ) : ?>
            <label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_contract"><?php echo esc_html__( 'Contract', 'listing-manager' ); ?></label>
        <?php endif; ?>

        <?php $contracts = get_terms( 'contracts', [
            'hide_empty' => false,
        ] ); ?>

        <select class="form-control"
                name="filter-contract"
                data-size="10"
                <?php if ( count( $contracts ) > 10 ) : ?>data-live-search="true"<?php endif;?>
                id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_contract">

            <option value="">
                <?php if ( 'placeholders' == $input_titles ) : ?>
                    <?php echo esc_html__( 'Contract', 'listing-manager' ); ?>
                <?php else : ?>
                    <?php echo esc_html__( 'All contracts', 'listing-manager' ); ?>
                <?php endif; ?>
            </option>

            <?php foreach ( $contracts as $value ) : ?>
                <option value="<?php echo esc_attr( $value->term_id ); ?>" <?php if ( ! empty( $_GET['filter-contract'] ) && $value->term_id == $_GET['filter-contract'] ) : ?>selected="selected"<?php endif; ?>>
                    <?php echo esc_html( $value->name ); ?>                    
                </option>
            <?php endforeach; ?>
        </select>
    </div><!-- /.form-group -->
<?php endif; ?>
