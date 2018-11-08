<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;

class ClaimShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_claim', [ 'ListingManager\Shortcode\ClaimShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        if ( ! is_user_logged_in() ) {
            wc_get_template( 'listing-manager/messages/not-allowed.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
            return;
        }

        if ( empty( $_GET['id'] ) ) {
            wc_get_template( 'listing-manager/messages/not-exist.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
            return;
        }

        $atts = [
            'listing' => get_post( $_GET['id'] ),
        ];

        return wc_get_template_html( 'listing-manager/claim-form.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}