<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class InquireShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_inquire', [ 'ListingManager\Shortcode\InquireShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/inquire-form.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}