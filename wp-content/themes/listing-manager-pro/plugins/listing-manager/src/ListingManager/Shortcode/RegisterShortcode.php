<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class RegisterShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_register', [ 'ListingManager\Shortcode\RegisterShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/accounts/register.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}