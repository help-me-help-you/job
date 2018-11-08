<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php $input_titles = ! empty( $instance['input_titles'] ) ? $instance['input_titles'] : 'labels'; ?>
<?php $button_text = ! empty( $instance['button_text'] ) ? $instance['button_text'] : ''; ?>
<?php $return_url = ! empty( $instance['return_url'] ) ? $instance['return_url'] : ''; ?>
<?php $autosubmit = ! empty( $instance['autosubmit'] ) ? $instance['autosubmit'] : ''; ?>
<?php $sort = ! empty( $instance['sort'] ) ? $instance['sort'] : ''; ?>

<?php echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) ); ?>

	<div class="widget-inner">
	    <?php if ( ! empty( $instance['title'] ) ) : ?>
	        <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
	        <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
	        <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
	    <?php endif; ?>

	    <?php $shortcode_title = ! empty( $title ) ? "button_title=\"{$title}\"" : ''; ?>
	    <?php $shortcode_button_text = ! empty( $button_text ) ? "button_text=\"{$button_text}\"" : ''; ?>
	    <?php $shortcode_input_titles = ! empty( $input_titles ) ? "input_titles=\"{$input_titles}\"" : ''; ?>
	    <?php $shortcode_return_url = ! empty( $return_url ) ? "return_url=\"{$return_url}\"" : ''; ?>
	    <?php $shortcode_sort = ! empty( $sort ) ? "sort=\"{$sort}\"" : ''; ?>
	    <?php $shortcode_autosubmit = ! empty( $autosubmit ) ? "autosubmit=\"{$autosubmit}\"" : ''; ?>
	    <?php $shortcode_hidden_fields = null; ?>

	    <?php foreach( $instance as $instance_key => $instance_value ) : ?>
	    	<?php if ( substr( $instance_key, 0, 5 ) === "hide_" ) : ?>
	    		<?php $shortcode_hidden_fields .= $instance_key . '=' . '"on" '; ?>
	    	<?php endif; ?>
	    <?php endforeach; ?>

	    <?php $shortcode = "[listing_manager_filter
	    	{$shortcode_title}
	    	{$shortcode_return_url}
	    	{$shortcode_input_titles}
	    	{$shortcode_sort}
	    	{$shortcode_autosubmit}
	    	{$shortcode_hidden_fields}
	    	{$shortcode_button_text}]"; ?>

		<?php echo do_shortcode( $shortcode ); ?>
	</div>

<?php echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) ); ?>