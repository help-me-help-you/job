<?php if ( empty( $atts['hide_keyword'] ) ) : ?>
	<div class="form-group form-group-keyword">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_keyword"><?php echo esc_html__( 'Keyword', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<?php $autocomplete = get_theme_mod( 'listing_manager_autocomplete', false ); ?>
		<input type="text" name="filter-keyword"
			   data-ajax-action="<?php echo admin_url( 'admin-ajax.php' ); ?>"
			   
			   <?php if ( ! empty( $autocomplete ) ) : ?>
			   		autocomplete="off"
			   <?php endif; ?>

		       <?php if ( 'placeholders' == $input_titles ) : ?>
		       		<?php if ( ! empty( $atts['keyword_placeholder'] ) ) : ?>
		       			placeholder="<?php echo apply_filters( 'listing_manager_filter_placeholder', esc_attr( $atts['keyword_placeholder'], $key, $atts ) ); ?>"
		       		<?php else : ?>
		       			placeholder="<?php echo apply_filters( 'listing_manager_filter_placeholder', esc_html__( 'Keyword', 'listing-manager' ), $key, $atts ); ?>"
		       		<?php endif; ?>
               <?php else : ?>
                   placeholder="<?php echo apply_filters( 'listing_manager_filter_placeholder', null, $key, $atts ); ?>"
		       <?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-keyword'] ) ? $_GET['filter-keyword'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_keyword">
	</div><!-- /.form-group -->
<?php endif; ?>