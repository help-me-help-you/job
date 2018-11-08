<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class TileShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_tiles', [ 'ListingManager\Shortcode\TileShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        $atts = shortcode_atts( [
            'layout'  	=> '1/2-1/1/1-2/1',
            'category'  => null,
            'location'  => null,
        ], $atts );

        $args = [
            'post_type' 		=> 'product',
            'post_status'   	=> 'publish',
            'meta_query'        => [
	            [
		            'key'       => '_thumbnail_id',
		            'compare'   => 'EXISTS'
	            ],
            ],
            'tax_query' 		=> [
                [
                    'taxonomy' 	=> 'product_type',
                    'field'		=> 'slug',
                    'terms' 	=> [ 'listing', ],
                ],
            ],
        ];

        if ( ! empty( $atts['location'] ) ) {
            $args['tax_query'][] = [
                'taxonomy' 	=> 'locations',
                'field'		=> 'slug',
                'terms' 	=> [ $atts['location'], ],
            ];
        }

        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'][] = [
                'taxonomy' 	=> 'product_cat',
                'field'		=> 'slug',
                'terms' 	=> [ $atts['category'], ],
            ];
        }

        $structure = [];
        $rows = explode( '-', $atts['layout'] );

        foreach ( $rows as $row ) {
            $cols = explode( '/', $row );

            $col_count = 0;
            foreach ( $cols as $col ) {
                $col_count += $col;
            }

            $i = 0;
            foreach ( $cols as $col ) {
                $structure[] = [
                    'count' => $col_count,
                    'cols' 	=> $col,
                    'class' => ( $i === 0 ) ? 'first' : ( ( $i === sizeof( $cols ) - 1 ) ? 'last' : null ),
                ];

                $i++;
            }
        }

        $args['posts_per_page'] = count( $structure );
        $atts['structure'] = $structure;
        $atts['query'] = $args;

        return wc_get_template_html( 'listing-manager/tiles.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
    }
}