<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class LoadTemplateShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_load_template', [ 'ListingManager\Shortcode\LoadTemplateShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        if ( ! empty( $atts['path'] ) ) {
            return wc_get_template_html( $atts['path'] );
        }
    }
}