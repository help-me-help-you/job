<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class ResetPasswordShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_reset_password', [ 'ListingManager\Shortcode\ResetPasswordShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/accounts/reset.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}