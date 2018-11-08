<?php if ( empty( $atts['hide_description'] ) ) : ?>
	<div class="form-group form-group-description">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_description"><?php echo esc_html__( 'Description', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-description"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Description', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-description'] ) ? $_GET['filter-description'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_description">
	</div><!-- /.form-group -->
<?php endif; ?>