<?php if ( empty( $atts['hide_bathrooms'] ) ) : ?>
	<div class="form-group form-group-bathrooms">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_bathrooms"><?php echo esc_html__( 'Bathrooms', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-bathrooms"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Bathrooms', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-bathrooms'] ) ? $_GET['filter-bathrooms'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_bathrooms">
	</div><!-- /.form-group -->
<?php endif; ?>