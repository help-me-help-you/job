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

	<?php $shortcode_type = 'type="listing"'; ?>
	<?php $shortcode_columns = ! empty( $instance['columns'] ) ? 'columns="' . $instance['columns'] . '"' : ''; ?>
	<?php $shortcode_per_page = ! empty( $instance['per_page'] ) ? 'per_page="' . $instance['per_page'] . '"' : ''; ?>
    <?php $shortcode_category = ! empty( $instance['category'] ) ? 'category="' . $instance['category'] . '"' : ''; ?>
    <?php $shortcode_location = ! empty( $instance['location'] ) ? 'location="' . $instance['location'] . '"' : ''; ?>
	<?php $shortcode_order = ! empty( $instance['order'] ) ? 'order="' . $instance['order'] . '"' : ''; ?>
	<?php $shortcode_orderby = ! empty( $instance['orderby'] ) ? 'orderby="' . $instance['orderby'] . '"' : ''; ?>
	<?php $shortcode_show_pagination = ! empty( $instance['show_pagination'] ) ? 'show_pagination="' . $instance['show_pagination'] . '"' : ''; ?>
	<?php $shortcode = "[listing_manager_product_attribute $shortcode_type $shortcode_columns $shortcode_per_page $shortcode_category $shortcode_location $shortcode_show_pagination $shortcode_order $shortcode_orderby]"; ?>
	<?php echo do_shortcode( $shortcode )?>

	<?php if ( ! empty( $instance['classes'] ) ) : ?>
</div>
<?php endif; ?>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>
