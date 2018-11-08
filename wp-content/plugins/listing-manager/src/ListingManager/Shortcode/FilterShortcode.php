<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class FilterShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_filter', [ 'ListingManager\Shortcode\FilterShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/filter-form.php', [
            'atts' => $atts,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}