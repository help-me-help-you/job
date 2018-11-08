<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class PurchaseWidget extends WP_Widget {
	function __construct() {
		parent::__construct(
			'purchase',
			esc_html__( 'Listing Manager: Purchase', 'listing-manager' ),
			[ 'description' => esc_html__( 'Displays add to cart form. Make sure that widget is displayed on product page.', 'listing-manager' ), ]
		);
	}

	/**
	 * @Action(name="widgets_init")
	 */
	public static function init() {
		register_widget( 'ListingManager\Widget\PurchaseWidget' );
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
		global $product;

		if ( ! is_singular( [ 'product', ] ) ) {
			return;
		}


		if ( empty( $product ) || ! is_object( $product ) ) {
		    return;
		}

		if ( ! $product->is_purchasable() ) {
		    return;
		}

		wc_get_template( 'listing-manager/widgets/purchase.php', [
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
		wc_get_template( 'listing-manager/widgets/purchase-form.php', [
			'widget' 	=> $this,
			'instance' 	=> $instance,
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}