<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $image = ! empty( $instance['image'] ) ? $instance['image'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $classes = ! empty( $instance['classes'] ) ? $instance['classes'] : ''; ?>
<?php $action_title = ! empty( $instance['action_title'] ) ? $instance['action_title'] : ''; ?>
<?php $action_link = ! empty( $instance['action_link'] ) ? $instance['action_link'] : ''; ?>

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

<!-- IMAGE -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'image' ) ); ?>">
		<?php echo esc_html__( 'Image', 'listing-manager' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $widget->get_field_id( 'image' ) ); ?>"
            name="<?php echo esc_attr( $widget->get_field_name( 'image' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $image ); ?>">
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

<!-- ACTION TITLE -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'action_title' ) ); ?>">
		<?php echo esc_html__( 'Action title', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'action_title' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'action_title' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $action_title ); ?>">
	<br>
</p>

<!-- ACTION LINK -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'action_link' ) ); ?>">
		<?php echo esc_html__( 'Action link', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'action_link' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'action_link' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $action_link ); ?>">
	<br>
</p>