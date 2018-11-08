<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $title = ! empty( $instance['title'] ) ? $instance['title'] : ''; ?>
<?php $latitude = ! empty( $instance['latitude'] ) ? $instance['latitude'] : null; ?>
<?php $longitude = ! empty( $instance['longitude'] ) ? $instance['longitude'] : null; ?>
<?php $height = ! empty( $instance['height'] ) ? $instance['height'] : null; ?>
<?php $zoom = ! empty( $instance['zoom'] ) ? $instance['zoom'] : null; ?>
<?php $style = ! empty( $instance['style'] ) ? $instance['style'] : null; ?>
<?php $fitbounds = ! empty( $instance['fitbounds'] ) ? $instance['fitbounds'] : null; ?>
<?php $filter = ! empty( $instance['filter'] ) ? $instance['filter'] : null; ?>
<?php $filter_live = ! empty( $instance['filter_live'] ) ? $instance['filter_live'] : null; ?>
<?php $autosubmit = ! empty( $instance['autosubmit'] ) ? $instance['autosubmit'] : null; ?>
<?php $input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels'; ?>
<?php $button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : ''; ?>
<?php $return_url = ! empty( $instance['return_url'] ) ? $instance['return_url'] : ''; ?>
<?php $sort = ! empty( $instance['sort'] ) ? $instance['sort'] : null; ?>
<?php $map_types = ! empty( $instance['map_types'] ) ? $instance['map_types'] : ''; ?>
<?php $map_zoom = ! empty( $instance['map_zoom'] ) ? $instance['map_zoom'] : ''; ?>
<?php $map_geolocation = ! empty( $instance['map_geolocation'] ) ? $instance['map_geolocation'] : ''; ?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

	<div class="widget-inner">
		<?php $shortcode_title = ! empty( $title ) ? "title=\"{$title}\"" : ''; ?>
	    <?php $shortcode_latitude = ! empty( $latitude ) ? "latitude=\"{$latitude}\"" : ''; ?>
	    <?php $shortcode_longitude = ! empty( $longitude ) ? "longitude=\"{$longitude}\"" : ''; ?>
	    <?php $shortcode_height = ! empty( $height ) ? "height=\"{$height}\"" : ''; ?>
	    <?php $shortcode_zoom = ! empty( $zoom ) ? "zoom=\"{$zoom}\"" : ''; ?>
	    <?php $shortcode_style = ! empty( $style ) ? "style=\"{$style}\"" : ''; ?>
	    <?php $shortcode_fitbounds = ! empty( $fitbounds ) ? "show_all_markers=\"{$fitbounds}\"" : ''; ?>
	    <?php $shortcode_filter = ! empty( $filter ) ? "filter=\"{$filter}\"" : ''; ?>
		<?php $shortcode_filter_live = ! empty( $filter_live ) ? "filter_live=\"{$filter_live}\"" : ''; ?>
		<?php $shortcode_autosubmit = ! empty( $autosubmit ) ? "autosubmit=\"{$autosubmit}\"" : ''; ?>
	    <?php $shortcode_button_text = ! empty( $button_text ) ? "button_text=\"{$button_text}\"" : ''; ?>
	    <?php $shortcode_input_titles = ! empty( $input_titles ) ? "input_titles=\"{$input_titles}\"" : ''; ?>
	    <?php $shortcode_return_url = ! empty( $return_url ) ? "return_url=\"{$return_url}\"" : ''; ?>
	    <?php $shortcode_sort = ! empty( $sort ) ? "sort=\"{$sort}\"" : ''; ?>
	    <?php $shortcode_hidden_fields = null; ?>
		<?php $shortcode_map_types = ! empty( $map_types ) ? "map_types=\"{$map_types}\"" : ''; ?>
		<?php $shortcode_map_zoom = ! empty( $map_zoom ) ? "map_zoom=\"{$map_zoom}\"" : ''; ?>
		<?php $shortcode_map_geolocation = ! empty( $map_geolocation ) ? "map_geolocation=\"{$map_geolocation}\"" : ''; ?>

	    <?php foreach( $instance as $instance_key => $instance_value ) : ?>
		    <?php if ( substr( $instance_key, 0, 5 ) === "hide_" ) : ?>
			    <?php $shortcode_hidden_fields .= $instance_key . '=' . '"on" '; ?>
		    <?php endif; ?>
	    <?php endforeach; ?>

	    <?php $shortcode = "[listing_manager_google_map
	    	{$shortcode_title}
	    	{$shortcode_latitude}
	    	{$shortcode_longitude}
	    	{$shortcode_height}
	    	{$shortcode_zoom}	    	
	    	{$shortcode_style}
	    	{$shortcode_fitbounds}
	    	{$shortcode_filter}
	    	{$shortcode_filter_live}
	    	{$shortcode_autosubmit}
	    	{$shortcode_button_text}
	    	{$shortcode_input_titles}
	    	{$shortcode_return_url}
	    	{$shortcode_sort}
	    	{$shortcode_hidden_fields}
	    	{$shortcode_map_types}
	    	{$shortcode_map_zoom}
	    	{$shortcode_map_geolocation}
	    	]"; ?>
		<?php echo do_shortcode( $shortcode ); ?>
	</div>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>