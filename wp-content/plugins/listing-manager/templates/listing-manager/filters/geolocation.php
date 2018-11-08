<?php if ( empty( $atts['hide_geolocation'] ) ) : ?>
	<div class="form-group form-group-geolocation">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_geolocations"><?php echo esc_html__( 'Location', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-geolocation"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Location', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control form-control-geolocation" value="<?php echo ! empty( $_GET['filter-geolocation'] ) ? $_GET['filter-geolocation'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_geolocation">
	</div><!-- /.form-group -->
<?php endif; ?>