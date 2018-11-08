<h2><?php echo esc_html__( 'Car Attributes', 'listing-manager' ); ?></h2>

<dl>
	<?php $engine = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'car_engine', true ); ?>
	<?php if ( ! empty( $engine ) ) : ?>
		<dt><?php echo esc_html__( 'Engine', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $engine ); ?></dd>
	<?php endif; ?>

	<?php $model = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'car_model', true ); ?>
	<?php if ( ! empty( $model ) ) : ?>
		<dt><?php echo esc_html__( 'Model', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $model ); ?></dd>
	<?php endif; ?>

	<?php $year = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'car_year', true ); ?>
	<?php if ( ! empty( $year ) ) : ?>
		<dt><?php echo esc_html__( 'Year', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $year ); ?></dd>
	<?php endif; ?>

	<?php $mileage = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'car_mileage', true ); ?>
	<?php if ( ! empty( $mileage ) ) : ?>
		<dt><?php echo esc_html__( 'Mileage', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $mileage ); ?></dd>
	<?php endif; ?>

	<?php $color = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'car_color', true ); ?>
	<?php if ( ! empty( $color ) ) : ?>
		<dt><?php echo esc_html__( 'Color', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $color ); ?></dd>
	<?php endif; ?>
</dl>
