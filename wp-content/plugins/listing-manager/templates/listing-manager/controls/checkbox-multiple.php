<?php if ( ! empty( $instance->label ) ) : ?>
	<span class="customize-control-title"><?php echo esc_html( $instance->label ); ?></span>
<?php endif; ?>

<?php if ( ! empty( $instance->description ) ) : ?>
	<span class="description customize-control-description"><?php echo $instance->description; ?></span>
<?php endif; ?>

<?php $multi_values = ! is_array( $instance->value() ) ? explode( ',', $instance->value() ) : $instance->value(); ?>

<ul>
	<?php foreach ( $instance->choices as $value => $label ) : ?>

		<li>
			<label>
				<input type="checkbox" value="<?php echo esc_attr( $value ); ?>" <?php checked( in_array( $value, $multi_values ) ); ?> />
				<?php echo esc_html( $label ); ?>
			</label>
		</li>

	<?php endforeach; ?>
</ul>

<input type="hidden" <?php $instance->link(); ?> value="<?php echo esc_attr( implode( ',', $multi_values ) ); ?>">