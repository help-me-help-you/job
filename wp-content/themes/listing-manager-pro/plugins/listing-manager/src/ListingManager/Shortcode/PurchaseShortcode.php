<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class PurchaseShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_purchase', [ 'ListingManager\Shortcode\PurchaseShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/purchase.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}