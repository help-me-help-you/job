<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class ListingInfoWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'listing-info',
			esc_html__( 'Listing Manager: Listing Info', 'listing-manager' ),
			[ 'description' => esc_html__( 'Displays listing information.', 'listing-manager' ), ]
		);
	}

	/**
	 * @Action(name="widgets_init")
	 */
	public static function init() {
		register_widget( 'ListingManager\Widget\ListingInfoWidget' );
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
		if ( ! is_singular( [ 'product', ] ) ) {
			return;
		}

		$agent_id = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'agent', true );

		if ( empty( $agent_id ) ) {
			return;
		}
		
		wc_get_template( 'listing-manager/widgets/listing-info.php', [
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
		wc_get_template( 'listing-manager/widgets/listing-info-form.php', [
			'widget' 	=> $this,
			'instance' 	=> $instance,
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}