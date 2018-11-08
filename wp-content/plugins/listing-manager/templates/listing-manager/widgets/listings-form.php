<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $description = ! empty( $instance['description'] ) ? $instance['description'] : ''; ?>
<?php $classes = ! empty( $instance['classes'] ) ? $instance['classes'] : ''; ?>
<?php $columns = ! empty( $instance['columns'] ) ? $instance['columns'] : '4'; ?>
<?php $per_page = ! empty( $instance['per_page'] ) ? $instance['per_page'] : '8'; ?>
<?php $category = ! empty( $instance['category'] ) ? $instance['category'] : ''; ?>
<?php $location = ! empty( $instance['location'] ) ? $instance['location'] : ''; ?>
<?php $order = ! empty( $instance['order'] ) ? $instance['order'] : ''; ?>
<?php $orderby = ! empty( $instance['orderby'] ) ? $instance['orderby'] : ''; ?>
<?php $show_pagination = ! empty( $instance['show_pagination'] ) ? $instance['show_pagination'] : ''; ?>

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

<!-- COLUMNS -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'columns' ) ); ?>">
		<?php echo esc_html__( 'Columns', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'columns' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'columns' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $columns ); ?>">
	<br>
</p>

<!-- PER PAGE -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'per_page' ) ); ?>">
		<?php echo esc_html__( 'Per page', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'per_page' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'per_page' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $per_page ); ?>">
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

<!-- ORDER -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'order' ) ); ?>">
		<?php echo esc_html__( 'Order', 'listing-manager' ); ?>
    </label>

    <select name="<?php echo esc_attr( $widget->get_field_name( 'order' ) ); ?>" class="widefat">
        <option value=""><?php echo esc_html__( 'None', 'listing-manager' ); ?></option>

        <option value="asc" <?php if ( 'asc' === $order ): ?>selected="selected"<?php endif; ?>>
            <?php echo esc_html__( 'ASC', 'listing-manager' ); ?>
        </option>

        <option value="desc" <?php if ( 'desc' === $order ): ?>selected="selected"<?php endif; ?>>
		    <?php echo esc_html__( 'DESC', 'listing-manager' ); ?>
        </option>
    </select>
</p>

<!-- ORDERBY -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'orderby' ) ); ?>">
		<?php echo esc_html__( 'Order By', 'listing-manager' ); ?>
    </label>

    <select name="<?php echo esc_attr( $widget->get_field_name( 'orderby' ) ); ?>" class="widefat">
        <option value=""><?php echo esc_html__( 'None', 'listing-manager' ); ?></option>

        <?php foreach ( ['menu_order', 'title',' date', 'rand', 'id'] as $item ) : ?>
            <option value="<?php echo esc_attr( $item ); ?>" <?php if ( $item === $orderby ): ?>selected="selected"<?php endif; ?>>
                <?php echo esc_html( $item ); ?>
            </option>
        <?php endforeach ?>
    </select>
</p>


<!-- SHOW PAGINATION-->
<p>
    <label>
        <input type="checkbox" class="checkbox" value="on"
               id="<?php echo esc_attr( $widget->get_field_id( 'show_pagination' ) ); ?>"
               name="<?php echo esc_attr( $widget->get_field_name( 'show_pagination' ) ); ?>"
			<?php echo ( ! empty( $show_pagination ) ) ? 'checked="checked"' : ''; ?>>
		<?php echo esc_html__( 'Show pagination', 'listing-manager' ); ?>
    </label>
</p>