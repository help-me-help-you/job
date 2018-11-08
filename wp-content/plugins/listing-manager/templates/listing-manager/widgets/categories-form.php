<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $parent_count = ! empty( $instance['parent_count'] ) ? $instance['parent_count'] : ''; ?>
<?php $child_count = ! empty( $instance['child_count'] ) ? $instance['child_count'] : ''; ?>
<?php $classes = ! empty( $instance['classes'] ) ? $instance['classes'] : ''; ?>

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

<!-- PARENT COUNT -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'parent_count' ) ); ?>">
		<?php echo esc_html__( 'Parent count', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'parent_count' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'parent_count' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $parent_count ); ?>">
</p>

<!-- CHILD COUNT -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'child_count' ) ); ?>">
		<?php echo esc_html__( 'Child count', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'child_count' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'child_count' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $child_count ); ?>">
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
