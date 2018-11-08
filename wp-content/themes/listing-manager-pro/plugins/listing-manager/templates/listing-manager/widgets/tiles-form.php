<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $classes = ! empty( $instance['classes'] ) ? $instance['classes'] : ''; ?>
<?php $layout = ! empty( $instance['layout'] ) ? $instance['layout'] : '1/2-1/1/1-2/1'; ?>
<?php $category = ! empty( $instance['category'] ) ? $instance['category'] : ''; ?>
<?php $location = ! empty( $instance['location'] ) ? $instance['location'] : ''; ?>

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

<!-- LAYOUT -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'layout' ) ); ?>">
		<?php echo esc_html__( 'Layout', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'layout' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'layout' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $layout ); ?>">
	<br>
</p>

<!-- CATEGORY -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'category' ) ); ?>">
        <?php echo esc_html__( 'Category', 'listing-manager' ); ?>
    </label>

    <select name="<?php echo esc_attr( $widget->get_field_name( 'category' ) ); ?>" class="widefat">
        <option value=""><?php echo esc_html__( 'None', 'listing-manager' ); ?></option>

        <?php $terms = get_terms('product_cat', [
                'hide_empty' => false,
        ]); ?>

        <?php foreach ( $terms as $term ) :?>
            <option value="<?php echo esc_attr( $term->slug ); ?>" <?php if ( $category == $term->slug ): ?>selected="selected"<?php endif; ?>>
                <?php echo esc_html( $term->name ); ?>
            </option>
        <?php endforeach; ?>
    </select>
</p>

<!-- LOCATION -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'location' ) ); ?>">
        <?php echo esc_html__( 'Location', 'listing-manager' ); ?>
    </label>

    <select name="<?php echo esc_attr( $widget->get_field_name( 'location' ) ); ?>" class="widefat">
        <option value=""><?php echo esc_html__( 'None', 'listing-manager' ); ?></option>

        <?php $terms = get_terms('locations', [
            'hide_empty' => false,
        ]); ?>

        <?php foreach ( $terms as $term ) :?>
            <option value="<?php echo esc_attr( $term->slug ); ?>" <?php if ( $location == $term->slug ): ?>selected="selected"<?php endif; ?>>
                <?php echo esc_html( $term->name ); ?>
            </option>
        <?php endforeach; ?>
    </select>
</p>