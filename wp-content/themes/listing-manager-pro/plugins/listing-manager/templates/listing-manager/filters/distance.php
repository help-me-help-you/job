<?php if ( empty( $atts['hide_distance'] ) ) : ?>
	<div class="form-group form-group-distance">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_distance"><?php echo esc_html__( 'Distance', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<div class="input-group">
			<input type="number" name="filter-distance"
			       min="0"
			       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Distance', 'listing-manager' ); ?>"<?php endif; ?>
			       class="form-control" value="<?php echo ! empty( $_GET['filter-distance'] ) ? $_GET['filter-distance'] : ''; ?>"
			       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_distance">
			<span class="input-group-addon">
				<?php echo get_theme_mod( 'listing_manager_distance_unit_long', 'mi' );?>
			</span>
		</div><!-- /.input-group -->

		<input type="hidden" name="filter-distance-latitude" value="<?php if ( ! empty( $instance['latitude'] ) ) : ?><?php echo esc_attr( $instance['latitude'] ); ?><?php else : ?><?php echo ! empty( $_GET['filter-distance-latitude'] ) ? esc_attr( $_GET['filter-distance-latitude'] ) : ''; ?><?php endif; ?>">
		<input type="hidden" name="filter-distance-longitude" value="<?php if ( ! empty( $instance['longitude'] ) ) : ?><?php echo esc_attr( $instance['longitude'] ); ?><?php else : ?><?php echo ! empty( $_GET['filter-distance-longitude'] ) ? esc_attr( $_GET['filter-distance-longitude'] ) : ''; ?><?php endif; ?>">
	</div><!-- /.form-group -->
<?php endif; ?>