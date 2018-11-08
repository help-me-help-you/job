<div class="form-group <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>form-error<?php endif; ?>">
	<label for="<?php echo esc_attr( $id ); ?>">
		<?php echo esc_html( $label ); ?>
		<?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
	</label>

	<input type="text"
	       <?php if ( $required ) : ?>required="required"<?php endif; ?>
	       id="<?php echo esc_attr( $id ); ?>"
	       name="<?php echo esc_attr( $id ); ?>"
	       value="<?php if ( ! empty( $value ) ) : ?><?php echo esc_html( $value ); ?><?php endif; ?>"
	       class="form-control date">

	<?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>
		<div class="form-error">
			<?php foreach( $_SESSION['form_errors'][ $id ] as $message ) : ?>
				<p><?php echo esc_html( $message ); ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div><!-- /.form-group -->