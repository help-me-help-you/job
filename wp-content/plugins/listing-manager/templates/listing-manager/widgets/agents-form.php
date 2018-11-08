<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $classes = ! empty( $instance['classes'] ) ? $instance['classes'] : ''; ?>
<?php $count = ! empty( $instance['count'] ) ? $instance['count'] : 3; ?>

<!-- TITLE -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'title' ) ); ?>">
        <?php echo esc_html__( 'Title', 'listing-manager' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $widget->get_field_id( 'title' ) ); ?>"
            name="<?php echo esc_attr( $widget->get_field_name( 'title' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $title ); ?>">
</p>

<!-- DESCRIPTION -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'description' ) ); ?>">
		<?php echo esc_html__( 'Description', 'listing-manager' ); ?>
	</label>

	<textarea class="widefat"
	          rows="4"
	          id="<?php echo esc_attr( $widget->get_field_id( 'description' ) ); ?>"
	          name="<?php echo esc_attr( $widget->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
</p>

<!-- CLASSES -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'classes' ) ); ?>">
		<?php echo esc_html__( 'Classes', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'classes' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'classes' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $classes ); ?>">
	<br>
</p>

<!-- COUNT -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'count' ) ); ?>">
        <?php echo esc_html__( 'Count', 'listing-manager' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $widget->get_field_id( 'count' ) ); ?>"
            name="<?php echo esc_attr( $widget->get_field_name( 'count' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $count ); ?>">
</p>