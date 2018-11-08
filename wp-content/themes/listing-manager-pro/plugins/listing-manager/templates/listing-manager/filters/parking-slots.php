<?php if ( empty( $atts['hide_parking_slots'] ) ) : ?>
	<div class="form-group form-group-parking_slots">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_parking_slots"><?php echo esc_html__( 'Parking slots', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-parking_slots"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Parking slots', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-parking_slots'] ) ? $_GET['filter-parking_slots'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_parking_slots">
	</div><!-- /.form-group -->
<?php endif; ?>