<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class GoogleMapLogic {
    /**
     * @Action(name="save_post")
     */
    public static function invalidate_cache() {
        global $wpdb;

        $wpdb->query( "DELETE FROM $wpdb->options WHERE option_name LIKE 'listing_manager_map_ajax_%'" );
    }

    /**
     * @Action(name="wp_ajax_nopriv_listing_manager_filter_listings")
     * @Action(name="wp_ajax_listing_manager_filter_listings")
     */
    public static function filter() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        $uri = md5( $_SERVER['REQUEST_URI'] );
        $cache = get_option( "listing_manager_map_ajax_{$uri}", 0 );
        if ( $cache && false === WP_DEBUG) {
            echo $cache;
            exit();
        }

        $property_groups = [];
        $data = [];

        $args = [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'post_status'       => 'publish',
            'tax_query'         => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'listing',
                ],
            ],
        ];

        // Term
        if ( ! empty( $_GET['term'] ) && ! empty( $_GET['term-taxonomy'] ) ) {
            $_GET[ 'filter-' . $_GET['term-taxonomy'] ] = $_GET['term'];
        }

        // Order by
        if ( ! empty( $_GET['orderby'] ) ) {
            if ( 'rand' == $_GET['orderby'] ) {
                $args['orderby'] = 'rand';
            }
        }
        // Apply custom filter        
        if ( ! empty( $_GET['ids'] ) ) {            
            query_posts( [
                'post__in' 			=> explode( ',', $_GET['ids'] ),
                'post_type'			=> 'product',
                'posts_per_page'	=> -1
            ] );
        } elseif ( FilterLogic::has_filter( ) ) {
            global $wp_query;
            $query = FilterLogic::filter_query( $wp_query );
            $query->posts = $query->get_posts();
            $wp_query = $query;
        } else {
            query_posts( $args );
        }

        if ( have_posts() ) {
            $index = 0;
            if ( ! empty( $_GET['max-pins'] ) ) {
                $max_pins = $_GET['max-pins'];
            }

            while ( have_posts() && ( empty( $max_pins ) || ( ! empty( $max_pins ) && $index < $max_pins ) ) ) {
                the_post();

                // Property GPS positions. We will use these values
                // for genearating unique md5 hash for property groups.
                $latitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true );
                $longitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true );

                // Build on array of property groups. We need to know how
                // many and which properties are at the same position.
                if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
                    $hash = sha1( $latitude . $longitude );
                    $property_groups[ $hash ][] = get_the_ID();
                    $index++;
                }
            }
        }

        wp_reset_query();

        foreach ( $property_groups as $group ) {
            $args = [
                'post_type'         => 'product',
                'posts_per_page'    => -1,
                'post_status'       => 'publish',
                'post__in'          => $group,
                'tax_query'         => [
                	[
                        'taxonomy'  => 'product_type',
                        'field'     => 'slug',
                        'terms'     => 'listing',
                    ],
                ],
            ];

            query_posts( $args );
            if ( have_posts() ) {
                // Group of properties at the same position so we will process
                // property loop inside the template.
                if ( count( $group ) > 1 ) {
                    $latitude = get_post_meta( $group[0], LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true );
                    $longitude = get_post_meta( $group[0], LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true );

                    // Infowindow
                    $output = wc_get_template_html( 'listing-manager/google-map/google-map-infowindow-group.php', [ 'group' => $group ], '', LISTING_MANAGER_DIR . 'templates/' );
                    $content = str_replace( [ "\r\n", "\n", "\t" ], '', $output );

                    // Marker
                    $output = wc_get_template_html( 'listing-manager/google-map/google-map-marker-group.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
                    $marker_content = str_replace( [ "\r\n", "\n", "\t" ], '', $output );
                } else {
                    the_post();
                    $latitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true );
                    $longitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true );
                    $content = str_replace( [ "\r\n", "\n", "\t" ], '', wc_get_template_html( 'listing-manager/google-map/google-map-infowindow.php', [], '', LISTING_MANAGER_DIR . 'templates/' ) );
                    $marker_content = str_replace( [ "\r\n", "\n", "\t" ], '', wc_get_template_html( 'listing-manager/google-map/google-map-marker.php', [], '', LISTING_MANAGER_DIR . 'templates/' ) );
                }

                // Array of values passed into markers[] array
                $data[] = [
                	'id'        => get_the_ID(),
                    'latitude'  => $latitude,
                    'longitude' => $longitude,
                    'infobox'   => $content,
                    'marker'    => $marker_content,
                ];
            }

            wp_reset_query();
        }

        $data = json_encode( $data );
        update_option( "listing_manager_map_ajax_{$uri}", $data );
        echo $data;
        exit();
    }

    /**
     * Gets all defined styles
     *
     * @access public
     * @return array
     */
    public static function get_styles() {
        $handler = fopen( LISTING_MANAGER_DIR . 'assets/data/google-maps-styles.json', 'r' );
        $file = file_get_contents( LISTING_MANAGER_DIR . 'assets/data/google-maps-styles.json' );
        return json_decode( $file );
    }

    /**
     * @access public
     * @param string $slug
     * @return string|null
     */
    public static function get_style( $slug = null) {
    	if ( empty( $slug ) ) {
		    $slug = get_theme_mod( 'listing_manager_google_maps_style', null );
	    }

        if ( ! empty( $slug ) ) {
            foreach( self::get_styles() as $value ) {
                if ( $value->slug == $slug ) {
                    return $value->styles;
                }
            }
        }

        return null;
    }
}