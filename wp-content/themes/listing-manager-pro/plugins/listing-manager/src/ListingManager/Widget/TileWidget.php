<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class TileWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'tiles',
			esc_html__( 'Listing Manager: Tiles', 'listing-manager' ),
			[ 'description' => esc_html__( 'Displays listings as tiles.', 'listing-manager' ), ]
		);
	}

	/**
	 * @Action(name="widgets_init")
	 */
	public static function init() {
		register_widget( 'ListingManager\Widget\TileWidget' );
	}

	/**
	 * Frontend
	 *
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	function widget( $args, $instance ) {
		wc_get_template( 'listing-manager/widgets/tiles.php', [
			'args' 		=> $args,
			'instance' 	=> $instance,
		], '', LISTING_MANAGER_DIR . 'templates/' );

		wp_reset_query();
	}
	/**
	 * Update
	 *
	 * @access public
	 * @param array $new_instance
	 * @param array $old_instance
	 * @return array
	 */
	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}
	/**
	 * Backend
	 *
	 * @access public
	 * @param array $instance
	 * @return void
	 */
	function form( $instance ) {
		wc_get_template( 'listing-manager/widgets/tiles-form.php', [
			'widget' 	=> $this,
			'instance' 	=> $instance,
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}