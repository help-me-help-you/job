<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
$height = ! empty( $instance['height'] ) ? $instance['height'] : '';
$latitude = ! empty( $instance['latitude'] ) ? $instance['latitude'] : '';
$longitude = ! empty( $instance['longitude'] ) ? $instance['longitude'] : '';
$zoom = ! empty( $instance['zoom'] ) ? $instance['zoom'] : '';
$style = ! empty( $instance['style'] ) ? $instance['style'] : '';
$fitbounds = ! empty( $instance['fitbounds'] ) ? $instance['fitbounds'] : '';
$filter = ! empty( $instance['filter'] ) ? $instance['filter'] : '';
$hide_filter_form = ! empty( $instance['hide_filter_form'] ) ? $instance['hide_filter_form'] : '';
$filter_live = ! empty( $instance['filter_live'] ) ? $instance['filter_live'] : '';
$autosubmit = ! empty( $instance['autosubmit'] ) ? $instance['autosubmit'] : '';
$button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : '';
$input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : '';
$return_url = ! empty( $instance['return_url'] ) ? $instance['return_url'] : '';
$map_types = ! empty( $instance['map_types'] ) ? $instance['map_types'] : '';
$map_zoom = ! empty( $instance['map_zoom'] ) ? $instance['map_zoom'] : '';
$map_geolocation = ! empty( $instance['map_geolocation'] ) ? $instance['map_geolocation'] : '';
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

<!-- HEIGHT -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'height' ) ); ?>">
		<?php echo esc_html__( 'Height', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'height' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'height' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $height ); ?>">
</p>

<!-- ZOOM -->
<p>
	<label for="<?php echo esc_attr( $widget->get_field_id( 'zoom' ) ); ?>">
		<?php echo esc_html__( 'Zoom', 'listing-manager' ); ?>
	</label>

	<input  class="widefat"
	        id="<?php echo esc_attr( $widget->get_field_id( 'zoom' ) ); ?>"
	        name="<?php echo esc_attr( $widget->get_field_name( 'zoom' ) ); ?>"
	        type="text"
	        value="<?php echo esc_attr( $zoom ); ?>">
</p>

<!-- STYLE -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'style' ) ); ?>">
		<?php echo esc_html__( 'Style', 'listing-manager' ); ?>
    </label>

    <?php $styles = ListingManager\Logic\GoogleMapLogic::get_styles(); ?>

    <select class="widefat" id="<?php echo esc_attr( $widget->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $widget->get_field_name( 'style' ) ); ?>">
        <option value=""><?php echo esc_html__( 'Default', 'listing-manager' ); ?></option>

        <?php foreach( $styles as $option) : ?>
            <option value="<?php echo esc_attr( $option->slug ); ?>" <?php if ( $option->slug === $style) : ?>selected="selected"<?php endif; ?>>
                <?php echo esc_html( $option->name ); ?>
            </option>
        <?php endforeach; ?>
    </select>
</p>

<h4><?php echo esc_html__( 'GPS Position', 'listing-manager' ); ?></h4>

<!-- LATITUDE -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'latitude' ) ); ?>">
        <?php echo esc_html__( 'Latitude', 'listing-manager' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $widget->get_field_id( 'latitude' ) ); ?>"
            name="<?php echo esc_attr( $widget->get_field_name( 'latitude' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $latitude ); ?>">
</p>

<!-- LONGITUDE -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'longitude' ) ); ?>">
        <?php echo esc_html__( 'Longitude', 'listing-manager' ); ?>
    </label>

    <input  class="widefat"
            id="<?php echo esc_attr( $widget->get_field_id( 'longitude' ) ); ?>"
            name="<?php echo esc_attr( $widget->get_field_name( 'longitude' ) ); ?>"
            type="text"
            value="<?php echo esc_attr( $longitude ); ?>">
</p>

<h4><?php echo esc_html__( 'Options', 'listing-manager' ); ?></h4>

<!-- FITBOUNDS-->
<p>
    <label>
        <input type="checkbox" class="checkbox" value="on"
               id="<?php echo esc_attr( $widget->get_field_id( 'fitbounds' ) ); ?>"
               name="<?php echo esc_attr( $widget->get_field_name( 'fitbounds' ) ); ?>"
            <?php echo ( ! empty( $fitbounds ) ) ? 'checked="checked"' : ''; ?>>
        <?php echo esc_html__( 'Show all markers', 'listing-manager' ); ?>
    </label>
</p>

<!-- FILTER-->
<p>
    <label>
        <input type="checkbox" class="checkbox" value="on"
               id="<?php echo esc_attr( $widget->get_field_id( 'filter' ) ); ?>"
               name="<?php echo esc_attr( $widget->get_field_name( 'filter' ) ); ?>"
            <?php echo ( ! empty( $filter ) ) ? 'checked="checked"' : ''; ?>>
        <?php echo esc_html__( 'Show filter', 'listing-manager' ); ?>
    </label>
</p>

<!-- HIDE FILTER FORM -->
<p>
    <label>
        <input type="checkbox" class="checkbox" value="on"
               id="<?php echo esc_attr( $widget->get_field_id( 'hide_filter_form' ) ); ?>"
               name="<?php echo esc_attr( $widget->get_field_name( 'hide_filter_form' ) ); ?>"
            <?php echo ( ! empty( $hide_filter_form ) ) ? 'checked="checked"' : ''; ?>>
        <?php echo esc_html__( 'Hide filter form (CSS display: none only)', 'listing-manager' ); ?>
    </label>
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

<!-- LIVE FILTER -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'filter_live' ) ); ?>">
        <input 	type="checkbox"
                  <?php if ( ! empty( $filter_live ) ) : ?>checked="checked"<?php endif; ?>
                  name="<?php echo esc_attr( $widget->get_field_name( 'filter_live' ) ); ?>"
                  id="<?php echo esc_attr( $widget->get_field_id( 'filter_live' ) ); ?>">

        <?php echo esc_html__( 'Live Filter', 'listing-manager' ); ?>
    </label>
</p>

<p>
	<?php echo esc_html__( 'Use Live filter and Hide filter form options for displaying listings based on current search fields.', 'listing-manager' ); ?>
</p>

<h4><?php echo esc_html__( 'Toolbar', 'listing-manager' ); ?></h4>

<!-- MAP TYPES -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'map_types' ) ); ?>">
        <input 	type="checkbox"
                  <?php if ( ! empty( $map_types ) ) : ?>checked="checked"<?php endif; ?>
                  name="<?php echo esc_attr( $widget->get_field_name( 'map_types' ) ); ?>"
                  id="<?php echo esc_attr( $widget->get_field_id( 'map_types' ) ); ?>">

        <?php echo esc_html__( 'Map types', 'listing-manager' ); ?>
    </label>
</p>

<!-- ZOOM -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'map_zoom' ) ); ?>">
        <input 	type="checkbox"
                  <?php if ( ! empty( $map_zoom ) ) : ?>checked="checked"<?php endif; ?>
                  name="<?php echo esc_attr( $widget->get_field_name( 'map_zoom' ) ); ?>"
                  id="<?php echo esc_attr( $widget->get_field_id( 'map_zoom' ) ); ?>">

        <?php echo esc_html__( 'Zoom', 'listing-manager' ); ?>
    </label>
</p>

<!-- GEOLOCATION -->
<p>
    <label for="<?php echo esc_attr( $widget->get_field_id( 'map_geolocation' ) ); ?>">
        <input 	type="checkbox"
                  <?php if ( ! empty( $map_geolocation ) ) : ?>checked="checked"<?php endif; ?>
                  name="<?php echo esc_attr( $widget->get_field_name( 'map_geolocation' ) ); ?>"
                  id="<?php echo esc_attr( $widget->get_field_id( 'map_geolocation' ) ); ?>">

        <?php echo esc_html__( 'Geolocation', 'listing-manager' ); ?>
    </label>
</p>

<h4><?php echo esc_html__( 'Filter Options', 'listing-manager' ); ?></h4>

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


<h4><?php echo esc_html__( 'Filter Fields', 'listing-manager' ); ?></h4>

<?php wc_get_template( 'listing-manager/widgets/filter-fields.php', [
	'widget' 	=> $widget,
	'instance' 	=> $instance,
], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
