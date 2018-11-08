<div class="form-group <?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>form-error<?php endif; ?>">
	<label for="<?php echo esc_attr( $id ); ?>">
		<?php echo esc_html( $label ); ?>
		<?php if ( $required ) : ?><span class="required">*</span><?php endif; ?>
	</label>
	
	<textarea class="form-control"
	  	<?php if ( ! empty( $rows ) ) : ?>rows="<?php echo esc_attr( $rows ); ?>"<?php endif; ?>
		<?php if ( $required ) : ?>required="required"<?php endif; ?>
		name="<?php echo esc_attr( $id ); ?>"
		id="<?php echo esc_attr( $id ); ?>"><?php if ( ! empty( $value ) ) : ?><?php echo esc_html( $value ); ?><?php endif; ?></textarea>
	
	<?php if ( ! empty( $_SESSION['form_errors'][ $id ] ) ) : ?>
		<div class="form-error">
			<?php foreach( $_SESSION['form_errors'][ $id ] as $message ) : ?>
				<p><?php echo esc_html( $message ); ?></p>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div><!-- /.form-group -->