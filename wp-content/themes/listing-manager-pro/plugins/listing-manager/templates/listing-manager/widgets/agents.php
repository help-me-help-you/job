<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

<?php if ( ! empty( $instance['classes'] ) ) : ?>
	<div class="<?php echo esc_attr( $instance['classes'] ); ?>">
<?php endif; ?>

<?php if ( ! empty( $instance['title'] ) ) : ?>
    <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
	<?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
    <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<?php if ( ! empty( $instance['description'] ) ) : ?>
		<div class="description">
			<?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
		</div><!-- /.description -->
	<?php endif; ?>

	<div class="agents-small-wrapper">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="agent-small">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="agent-small-thumbnail"> 
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail(); ?>
						</a>
					</div><!-- /.agent-small-thumbnail -->
				<?php endif; ?>

				<div class="agent-small-content">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>					
					<?php $listings = ListingManager\Utilities::get_agent_listings( get_the_ID() ); ?>

					<?php if ( ! empty( $listings ) ) : ?>
						<h4>
							<?php echo count( $listings ); ?> <?php echo ( 1 === count( $listings ) ) ? esc_html__( 'listing', 'listing-manager' ) : esc_html__( 'listings', 'listing-manager' ); ?>
						</h4>
					<?php endif; ?>

				</div><!-- /.agent-small-content -->

				<a href="<?php the_permalink(); ?>" class="agent-small-link"></a>
			</div><!-- /.agent-small -->
		<?php endwhile; ?>
	</div><!-- /.agents-small-wrapper -->
<?php endif; ?>

<?php if ( ! empty( $instance['classes'] ) ) : ?>
	</div>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
