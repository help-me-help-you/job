<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class ListingInfoShortcode {
	/**
	 * @Action(name="init")
	 */
	public static function initialize() {
		add_shortcode( 'listing_manager_listing_info', [ 'ListingManager\Shortcode\ListingInfoShortcode', 'execute' ] );
	}

	public static function execute( $atts ) {
		$atts = shortcode_atts( [
			'id'  	=> get_the_ID(),
		], $atts );
		return wc_get_template_html( 'listing-manager/listing-info.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
	}
}