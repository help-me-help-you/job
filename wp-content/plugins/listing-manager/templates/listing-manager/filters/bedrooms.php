<?php if ( empty( $atts['hide_bedrooms'] ) ) : ?>
	<div class="form-group form-group-bedrooms">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_bedrooms"><?php echo esc_html__( 'Bedrooms', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-bedrooms"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Bedrooms', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-bedrooms'] ) ? $_GET['filter-bedrooms'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_bedrooms">
	</div><!-- /.form-group -->
<?php endif; ?>