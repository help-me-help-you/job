<?php if ( empty( $atts['hide_title'] ) ) : ?>
	<div class="form-group form-group-title">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_title"><?php echo esc_html__( 'Title', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-title"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Title', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-title'] ) ? $_GET['filter-title'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_title">
	</div><!-- /.form-group -->
<?php endif; ?>