<div class="form-group checkbox <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>form-error<?php endif; ?>">
	<label for="<?php echo esc_attr( $id ); ?>">
		<input type="checkbox"
		       id="<?php echo esc_attr( $id ); ?>"
		       name="<?php echo esc_attr( $id ); ?>"
		       value="1"
		       <?php if ( ! empty( $value ) ) : ?>checked="checked"<?php endif; ?>>

		<?php echo wp_kses( $label, wp_kses_allowed_html( 'post' ) ); ?>
		<?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
	</label>

	<?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>
		<div class="form-error">
			<?php foreach( $_SESSION['form_errors'][ $id ] as $message ) : ?>
				<p><?php echo esc_html( $message ); ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div><!-- /.form-group -->