<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class StreamShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_stream', [ 'ListingManager\Shortcode\StreamShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        $args = [
            'post_type' 		=> 'product',
            'post_status'   	=> 'publish',
            'posts_per_page'	=> -1,
            'tax_query' 		=> [
                [
                    'taxonomy' 	=> 'product_type',
                    'field'		=> 'slug',
                    'terms' 	=> [ 'listing', ],
                ],
            ],
        ];

        if ( ! empty( $atts['count'] ) ) {
            $args['posts_per_page'] = $atts['count'];
        }

        if ( ! empty( $atts['orderby'] ) && 'event_date' == $atts['orderby'] ) {
            $args['orderby'] = LISTING_MANAGER_LISTING_PREFIX . 'event_date';
            $args['meta_key'] = LISTING_MANAGER_LISTING_PREFIX . 'event_date';
        }

        if ( ! empty( $atts['order'] ) ) {
            $args['order'] = $atts['order'];
        }

        $atts['query'] = $args;

        return wc_get_template_html( 'listing-manager/stream.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}