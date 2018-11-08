<?php if ( empty( $atts['hide_home_area'] ) ) : ?>
	<div class="form-group form-group-home_area">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_home_area"><?php echo esc_html__( 'Home area', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="number" name="filter-home_area"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Home area', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-home_area'] ) ? $_GET['filter-home_area'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_home_area">
	</div><!-- /.form-group -->
<?php endif; ?>