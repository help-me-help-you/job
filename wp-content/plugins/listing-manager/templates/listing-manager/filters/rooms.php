<?php if ( empty( $atts['hide_rooms'] ) ) : ?>
	<div class="form-group form-group-rooms">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_rooms"><?php echo esc_html__( 'Rooms', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-rooms"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Rooms', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-rooms'] ) ? $_GET['filter-rooms'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_rooms">
	</div><!-- /.form-group -->
<?php endif; ?>