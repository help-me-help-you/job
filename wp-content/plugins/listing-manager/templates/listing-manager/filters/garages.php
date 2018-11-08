<?php if ( empty( $atts['hide_garages'] ) ) : ?>
	<div class="form-group form-group-garages">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_garages"><?php echo esc_html__( 'Garages', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-garages"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Garages', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-garages'] ) ? $_GET['filter-garages'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_garages">
	</div><!-- /.form-group -->
<?php endif; ?>