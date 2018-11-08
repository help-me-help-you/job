<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;
use ListingManager\Product\PackageProduct;

class PackageShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_packages', [ 'ListingManager\Shortcode\PackageShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/packages.php', [
            'packages' => PackageProduct::get_packages(),
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}