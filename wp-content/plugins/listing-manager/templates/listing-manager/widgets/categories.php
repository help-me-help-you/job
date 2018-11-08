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

	<?php if ( ! empty( $instance['description'] ) ) : ?>
		<div class="description">
			<?php echo esc_html( $instance['description'] ); ?>
		</div><!-- /.description -->
	<?php endif; ?>

	<?php $shortcode_parent_count = ! empty( $instance['parent_count'] ) ? 'parent_count="' . $instance['parent_count'] . '"' : ''; ?>
    <?php $shortcode_child_count = ! empty( $instance['child_count'] ) ? 'child_count="' . $instance['child_count'] . '"' : ''; ?>
	<?php $shortcode = "[listing_manager_categories $shortcode_parent_count $shortcode_child_count]"; ?>
	<?php echo do_shortcode( $shortcode )?>

	<?php if ( ! empty( $instance['classes'] ) ) : ?>
</div>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
