<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class FieldsShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_fields', [ 'ListingManager\Shortcode\FieldsShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        return wc_get_template_html( 'listing-manager/fields.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}