<h2><?php echo esc_html__( 'Job Attributes', 'listing-manager' ); ?></h2>

<dl>
	<?php $start = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'job_start', true ); ?>
	<?php if ( ! empty( $start ) ) : ?>
		<dt><?php echo esc_html__( 'Starting date', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $start ); ?></dd>
	<?php endif; ?>

	<?php $contract = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'job_contract', true ); ?>
	<?php if ( ! empty( $contract ) ) : ?>
		<dt><?php echo esc_html__( 'Contract', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $contract ); ?></dd>
	<?php endif; ?>

	<?php $position = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'job_position', true ); ?>
	<?php if ( ! empty( $position ) ) : ?>
		<dt><?php echo esc_html__( 'Position', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $position ); ?></dd>
	<?php endif; ?>

	<?php $skills = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'job_skills', true ); ?>
	<?php if ( ! empty( $skills ) ) : ?>
		<dt><?php echo esc_html__( 'Required skills', 'listing-manager' ); ?></dt>
		<dd><?php echo esc_html( $skills ); ?></dd>
	<?php endif; ?>
</dl>
