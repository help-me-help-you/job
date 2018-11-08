<?php if ( empty( $atts['hide_reference'] ) ) : ?>
	<div class="form-group form-group-reference">
		<?php if ( 'labels' == $input_titles ) : ?>
			<label for="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_reference"><?php echo esc_html__( 'Reference', 'listing-manager' ); ?></label>
		<?php endif; ?>

		<input type="text" name="filter-reference"
		       <?php if ( 'placeholders' == $input_titles ) : ?>placeholder="<?php echo esc_html__( 'Reference', 'listing-manager' ); ?>"<?php endif; ?>
		       class="form-control" value="<?php echo ! empty( $_GET['filter-reference'] ) ? $_GET['filter-reference'] : ''; ?>"
		       id="<?php echo ! empty( $field_id_prefix ) ? $field_id_prefix : ''; ?><?php echo esc_attr( $args['widget_id'] ); ?>_reference">
	</div><!-- /.form-group -->
<?php endif; ?>