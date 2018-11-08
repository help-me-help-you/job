<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class CtaWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'cta',
			esc_html__( 'Listing Manager: Call to action', 'listing-manager' ),
			[ 'description' => esc_html__( 'Displays call to action.', 'listing-manager' ), ]
		);
	}

	/**
	 * @Action(name="widgets_init")
	 */
	public static function init() {
		register_widget( 'ListingManager\Widget\CtaWidget' );
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
		wc_get_template( 'listing-manager/widgets/cta.php', [
			'args' 		=> $args,
			'instance' 	=> $instance,
		], '', LISTING_MANAGER_DIR . 'templates/' );
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
		wc_get_template( 'listing-manager/widgets/cta-form.php', [
			'widget' 	=> $this,
			'instance' 	=> $instance,
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}