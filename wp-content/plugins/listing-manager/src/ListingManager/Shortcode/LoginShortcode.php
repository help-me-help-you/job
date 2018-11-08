<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class LoginShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_login', [ 'ListingManager\Shortcode\LoginShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/accounts/login.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}