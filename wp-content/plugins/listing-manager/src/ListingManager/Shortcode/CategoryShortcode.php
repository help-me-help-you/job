<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;

class CategoryShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_categories', [ 'ListingManager\Shortcode\CategoryShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        $atts = shortcode_atts( [
            'parent_count' => null,
            'child_count'  => null,
            'include'      => null,
            'exclude'      => null,
        ], $atts );

        return wc_get_template_html( 'listing-manager/categories.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}