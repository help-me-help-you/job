<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class GoogleMapShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_google_map', [ 'ListingManager\Shortcode\GoogleMapShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/google-map/google-map.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}