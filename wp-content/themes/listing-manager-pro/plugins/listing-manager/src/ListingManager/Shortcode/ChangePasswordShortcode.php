<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;

class ChangePasswordShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_change_password', [ 'ListingManager\Shortcode\ChangePasswordShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        if ( ! is_user_logged_in() ) {
            return wc_get_template_html( 'listing-manager/messages/not-allowed', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
        }

        return wc_get_template_html( 'listing-manager/accounts/password.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}