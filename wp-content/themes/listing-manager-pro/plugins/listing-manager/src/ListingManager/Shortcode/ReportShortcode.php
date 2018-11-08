<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class ReportShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_report', [ 'ListingManager\Shortcode\ReportShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        if ( empty( $_GET['id'] ) ) {
            wc_get_template( 'listing-manager/messages/not-exist.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
            return;
        }

        $atts = [
            'listing' => get_post( $_GET['id'] ),
        ];

        return wc_get_template_html( 'listing-manager/report-form.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}