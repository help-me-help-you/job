<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class DashboardShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_dashboard', [ 'ListingManager\Shortcode\DashboardShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        if ( ! is_user_logged_in() ) {
            wc_get_template( 'listing-manager/messages/not-allowed.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
            return;
        }

        return wc_get_template_html( 'listing-manager/dashboard.php', [
            
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}