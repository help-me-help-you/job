<?php if ( ! empty( $chained ) ) : ?>
    <?php $selects = ListingManager\Utilities::build_taxonomy_selects( $taxonomy ); ?>
    <?php $select_previous = null; ?>

    <div class="form-group-bundle">
        <?php foreach ( $selects as $level => $options ) : ?>
            <div class="form-group <?php if ( ! empty( $select_previous ) ) : ?>hidden<?php endif; ?> <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>form-error<?php endif; ?>">
                <label for="<?php echo esc_attr( $taxonomy ); ?>-<?php echo esc_attr( $level ); ?>">
                    <?php if ( empty( $select_previous ) ) : ?>
                        <?php echo esc_html( $label ); ?>
                        <?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
                    <?php else : ?>
                        <?php echo esc_html__( 'Child term', 'listing-manager' ); ?>
                    <?php endif; ?>
                </label>

                <select id="<?php echo esc_attr( $taxonomy ); ?>-<?php echo esc_attr( $level ); ?>"
                        <?php if ( ! empty( $select_previous ) ) : ?>data-chain-to="<?php echo esc_attr( $taxonomy ); ?>-<?php echo esc_attr( $select_previous ); ?>"<?php endif; ?>
                        class="form-control chained" name="<?php echo esc_attr( $id ); ?>[]">
                    <?php if ( empty( $select_previous ) ) : ?>
                        <option value=""><?php echo esc_html__( 'Select', 'listing-manager' ); ?></option>
                    <?php else : ?>
                        <option value="">--</option>
                    <?php endif; ?>

                    <?php foreach ( $options as $option ) : ?>
                        <option value="<?php echo esc_attr( $option['value'] ); ?>"
                                <?php if ( ! empty( $_GET['id'] ) && has_term( $option['value'], $taxonomy, $_GET['id'] ) ) : ?>selected="selected"<?php endif; ?>
                                class="<?php echo esc_attr( $option['parent'] ); ?>">
                            <?php echo esc_html( $option['name'] ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php $select_previous = $level; ?>
            </div><!-- /.form-group -->
        <?php endforeach; ?>

        <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>
            <div class="form-error">
                <?php foreach( $_SESSION['form_errors'][ $id ] as $message ) : ?>
                    <p><?php echo esc_html( $message ); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div><!-- /.form-group-bundle -->
<?php else : ?>
    <div class="form-group <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>form-error<?php endif; ?>">
        <label for="<?php echo esc_attr( $id ); ?>">
            <?php echo esc_html( $label ); ?>
            <?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
        </label>

        <?php $terms = get_terms( $taxonomy, [
            'hide_empty' 	=> false,
            'parent'		=> 0,
        ] ); ?>

        <select name="<?php echo esc_attr( $id ); ?><?php if ( $multiple ) : ?>[]<?php endif; ?>" <?php if ( $multiple ) : ?>multiple="multiple"<?php endif; ?> class="form-control">
            <?php if ( is_array( $terms ) ) : ?>
                <?php foreach ( $terms as $term ) : ?>
                    <option <?php if ( ! empty( $_GET['id'] ) && has_term( $term, $taxonomy, $_GET['id'] ) ) : ?>selected="selected"<?php endif; ?> value="<?php echo esc_attr( $term->term_id ); ?>">
                        <?php echo esc_html( $term->name ); ?>
                    </option>

                    <?php $subterms = get_terms( $taxonomy, [
                        'hide_empty' 	=> false,
                        'parent'		=> $term->term_id,
		            ] ); ?>

                    <?php if ( is_array( $subterms ) ) : ?>
                        <?php foreach ( $subterms as $subterm ) : ?>
                            <option <?php if ( ! empty( $_GET['id'] ) && has_term( $subterm, $taxonomy, $_GET['id'] ) ) : ?>selected="selected"<?php endif; ?> value="<?php echo esc_attr( $subterm->term_id ); ?>">
                                - <?php echo esc_html( $subterm->name ); ?>
                            </option>

                            <?php $subsubterms = get_terms( $taxonomy, [
                                'hide_empty' 	=> false,
                                'parent'		=> $subterm->term_id,
				            ] ); ?>

                            <?php if ( is_array( $subsubterms ) ) : ?>
                                <?php foreach ( $subsubterms as $subsubterm ) : ?>
                                    <option <?php if ( ! empty( $_GET['id'] ) && has_term( $subsubterm, $taxonomy, $_GET['id'] ) ) : ?>selected="selected"<?php endif; ?> value="<?php echo esc_attr( $subterm->term_id ); ?>">
                                        -- <?php echo esc_html( $subsubterm->name ); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>

        <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>
            <div class="form-error">
                <?php foreach( $_SESSION['form_errors'][ $id ] as $message ) : ?>
                    <p><?php echo esc_html( $message ); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div><!-- /.form-group -->
<?php endif; ?>