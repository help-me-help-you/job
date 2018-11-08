<?php if ( empty( $atts['hide_year_built'] ) ) : ?>
	<div class="form-group form-group-year_built">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_year_built"><?php echo esc_html__( 'Year built', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-year_built"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Year built', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-year_built'] ) ? $_GET['filter-year_built'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_year_built">
	</div><!-- /.form-group -->
<?php endif; ?>