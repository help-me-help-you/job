<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : '';
$return_url = ! empty( $instance['return_url'] ) ? $instance['return_url'] : '';
$autosubmit = ! empty( $instance['autosubmit'] ) ? $instance['autosubmit'] : '';
$sort = ! empty( $instance['sort'] ) ? $instance['sort'] : '';
?>

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

<!-- BUTTON TEXT -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'button_text' ) ); ?>">
		<?php echo esc_html__( 'Button text', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'button_text' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'button_text' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $button_text ); ?>">
</p>

<!-- RETURN URL -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'return_url' ) ); ?>">
		<?php echo esc_html__( 'Return URL', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'return_url' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'return_url' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $return_url ); ?>">
</p>

<!-- AUTOSUBMIT -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'autosubmit' ) ); ?>">
        <input 	type="checkbox"
                  <?php if ( ! empty( $autosubmit ) ) : ?>checked="checked"<?php endif; ?>
                  name="<?php echo esc_attr( $widget->get_field_name( 'autosubmit' ) ); ?>"
                  id="<?php echo esc_attr( $widget->get_field_id( 'autosubmit' ) ); ?>">

        <?php echo esc_html__( 'Autosubmit', 'listing-manager' ); ?>
    </label>
</p>


<!-- INPUT TITLES -->
<label><?php echo esc_html__( 'Input titles', 'listing-manager' ); ?></label>

<ul>
	<li>
		<label>
			<input type="radio" class="radio" value="labels"
				   id="<?php echo esc_attr( $widget->get_field_id( 'input_titles' ) ); ?>"
			       name="<?php echo esc_attr( $widget->get_field_name( 'input_titles' ) ); ?>"
				   <?php echo ( empty( $input_titles ) || 'labels' == $input_titles ) ? 'checked="checked"' : ''; ?>>
			<?php echo esc_html__( 'Labels', 'listing-manager' ); ?>
		</label>
	</li>

	<li>
		<label>
			<input type="radio" class="radio" value="placeholders"
			       id="<?php echo esc_attr( $widget->get_field_id( 'input_titles' ) ); ?>"
			       name="<?php echo esc_attr( $widget->get_field_name( 'input_titles' ) ); ?>"			
				   <?php echo ( 'placeholders' == $input_titles ) ? 'checked="checked"' : ''; ?>>
			<?php echo esc_html__( 'Placeholders', 'listing-manager' ); ?>
		</label>
	</li>
</ul>

<?php

wc_get_template( 'listing-manager/widgets/filter-fields.php', [
	'widget' 	=> $widget,
	'instance' 	=> $instance,
], '', LISTING_MANAGER_DIR . 'templates/' ); ?>