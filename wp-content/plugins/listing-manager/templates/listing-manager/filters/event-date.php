<?php if ( empty( $atts['hide_event_date'] ) ) : ?>
	<div class="form-group form-group-event-date-from">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_event_date_from"><?php echo esc_html__( 'Event date from', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-event-date-from"
		       <?php if ( 'placeholders' == $input_titles ) : ?>
		       		placeholder="<?php echo esc_html__( 'Event date from', 'listing-manager' ); ?>"
		       <?php endif; ?>
		       class="form-control listing-manager-date-input" value="<?php echo ! empty( $_GET['filter-event-date-from'] ) ? $_GET['filter-event-date-from'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_event_date_from">
	</div><!-- /.form-group -->

	<div class="form-group form-group-event-date-to">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_event_date_to"><?php echo esc_html__( 'Event date to', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-event-date-to"
		       <?php if ( 'placeholders' == $input_titles ) : ?>
		       		placeholder="<?php echo esc_html__( 'Event date to', 'listing-manager' ); ?>"
		       <?php endif; ?>
		       class="form-control listing-manager-date-input" value="<?php echo ! empty( $_GET['filter-event-to'] ) ? $_GET['filter-event-date-to'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_event_date_to">
	</div><!-- /.form-group -->	
<?php endif; ?>