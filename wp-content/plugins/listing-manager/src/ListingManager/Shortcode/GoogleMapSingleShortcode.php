<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class GoogleMapSingleShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_google_map_single', [ 'ListingManager\Shortcode\GoogleMapSingleShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/google-map/google-map-single.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}