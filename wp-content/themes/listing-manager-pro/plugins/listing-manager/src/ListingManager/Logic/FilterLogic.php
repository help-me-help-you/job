<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use WP_Query;

class FilterLogic {
    /**
     * @Filter(name="woocommerce_get_catalog_ordering_args")
     */
    public static function orderby_args( $args ) {
        $orderby_value = isset( $_GET['orderby'] ) ?
            wc_clean( $_GET['orderby'] ) :
            apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

        if ( 'event_date' === $orderby_value ) {
            $args['orderby'] = 'meta_value';
            $args['order'] = 'ASC';
            $args['meta_key'] = LISTING_MANAGER_LISTING_PREFIX . 'event_date';
        }

        return $args;
    }

    /**
     * @Filter(name="woocommerce_catalog_orderby")
     * @Filter(name="woocommerce_default_catalog_orderby_options")
     */
    public static function orderby_event_start( $sortby ) {
        $sortby['event_date'] = esc_attr__( 'Sort by event date', 'listing-manager' );
        return $sortby;
    }

    /**
     * @Action(name="wp_ajax_nopriv_listing_manager_autocomplete")
     * @Action(name="wp_ajax_listing_manager_autocomplete")
     */
    public static function autocomplete() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        $results = [];

        query_posts( [
            's'					=> $_GET['query'],
            'post_type'			=> 'product',
            'posts_per_page' 	=> -1,
            'post_status'		=> 'publish',
            'tax_query'			=> [
            	[
	                'taxonomy'  	=> 'product_type',
	                'field'     	=> 'slug',
	                'terms'     	=> [ 'listing' ],
                ],
            ],
        ] );

        if ( have_posts() ) {
            while( have_posts() ) {
                the_post();

                $results[] = [
                    'id' 		=> get_the_ID(),
                    'name' 		=> get_the_title(),
                    'image' 	=> get_the_post_thumbnail_url(),
                    'link'		=> get_the_permalink(),
                ];
            }
        }
        wp_reset_query();

        echo json_encode( $results );
        exit();
    }

    /**
     * @Filter(name="listing_manager_filter_fields")
     */
    public static function default_fields() {
        return [
            // General search fields
            'title'                 => esc_html__( 'Title', 'listing-manager' ),
            'description'           => esc_html__( 'Description', 'listing-manager' ),
            'keyword'               => esc_html__( 'Keyword', 'listing-manager' ),
            'distance'              => esc_html__( 'Distance', 'listing-manager' ),
            'price'                 => esc_html__( 'Price', 'listing-manager' ),
            'geolocation'           => esc_html__( 'Geolocation', 'listing-manager' ),
            'locations'             => esc_html__( 'Locations', 'listing-manager' ),
            'listing_categories'    => esc_html__( 'Categories', 'listing-manager' ),
            'event_date'    		=> esc_html__( 'Event Date', 'listing-manager' ),

            // Property related search fields
            'reference'    			=> esc_html__( 'Reference', 'listing-manager' ),
            'year_built'    		=> esc_html__( 'Year Built', 'listing-manager' ),
            'contract'    			=> esc_html__( 'Contract', 'listing-manager' ),
            'rooms'    				=> esc_html__( 'Rooms', 'listing-manager' ),
            'bathrooms'    			=> esc_html__( 'Bathrooms', 'listing-manager' ),
            'bedrooms'    			=> esc_html__( 'Bedrooms', 'listing-manager' ),
            'garages'    			=> esc_html__( 'Garages', 'listing-manager' ),
            'parking_slots'    		=> esc_html__( 'Parking slots', 'listing-manager' ),
            'home_area'    			=> esc_html__( 'Home area', 'listing-manager' ),
        ];
    }

    /**
     * Returns list of available filter fields templates
     *
     * @access public
     * @return array
     */
    public static function get_fields() {
        return apply_filters( 'listing_manager_filter_fields', [] );
    }

    /**
     * Checks if in URI are filter conditions
     *
     * @access public
     * @return bool
     */
    public static function has_filter( $not_empty = false ) {
        if ( ! empty( $_GET ) && is_array( $_GET ) ) {
            foreach ( $_GET as $key => $value ) {
                if ( false !== strrpos( $key, 'filter-', -strlen( $key ) ) ) {
                    if ( ! empty( $value ) || $not_empty ) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Gets filter form action
     *
     * @access public
     * @return false|string
     */
    public static function get_filter_action() {
        return get_post_type_archive_link( 'product' );
    }

    /**
     * @Action(name="pre_get_posts", priority=10)
     */
    public static function archive( WP_Query $query ) {
        if ( $query->is_main_query() && ! is_admin() ) {
            $shop_page = get_option( 'woocommerce_shop_page_id' );

            if ( is_post_type_archive( 'listing' ) ) {                
                return self::filter_query( $query );
            } else if ( is_post_type_archive( 'product' ) || $query->queried_object_id == $shop_page ) {
                $query->set( 'tax_query', [ [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => [ 'package', 'listing', 'micropayment' ],
                    'operator'	=> 'NOT IN',
                ] ] );
            }
        }

        return $query;
    }

    /**
     * Add params into query object
     *
     * @access public
     * @param $query
     * @param $params array
     * @return mixed
     */
    public static function filter_query( $query = null, $params = null ) {
        global $wpdb;
        global $wp_query;

        if ( empty( $query ) ) {
            $query = $wp_query;
        }

        if ( empty( $params ) ) {
            $params = $_GET;
        }

        $meta = [];
        $taxonomies = [];
        $ids = null;

        if ( get_theme_mod( 'listing_manager_allow_order_featured', false ) && ( empty( $params['orderby'] ) || 'menu_order' === $params['orderby'] ) && empty( $params ) ) {            
            // $query->set( 'orderby', 'meta_value' );
            // $query->set( 'order', 'DESC' );            
            // $query->set( 'meta_key', '_featured' );
            // add_filter( 'get_meta_sql', [ __CLASS__, 'filter_get_meta_sql_19653' ] );
        } elseif ( ! empty( $params['orderby'] ) && 'event_date' === $params['orderby'] ) {
            $query->set( 'orderby', 'meta_value' );
            $query->set( 'order', 'ASC' );
            $query->set( 'meta_key', LISTING_MANAGER_LISTING_PREFIX . 'event_date' );
        }

        $taxonomies[] = [
            'taxonomy'  => 'product_type',
            'field'     => 'slug',
            'terms'     => [ 'listing' ],
            'operator'	=> 'IN',
        ];

        // Location
        if ( ! empty( $params['filter-locations'] ) ) {
            if ( is_array( $params['filter-locations'] ) ) {
                foreach ( $params['filter-locations'] as $value ) {
                    if ( empty( $value ) ) {
                        continue;
                    }

                    $taxonomies[] = [
                        'taxonomy'  => 'locations',
                        'field'     => 'id',
                        'terms'     => $value,
                    ];
                }
            } else {
                $taxonomies[] = [
                    'taxonomy'  => 'locations',
                    'field'     => 'id',
                    'terms'     => $params['filter-locations'],
                ];
            }
        }

        // Category
        if ( ! empty( $params['filter-listing-categories'] ) ) {
            if ( is_array( $params['filter-listing-categories'] ) ) {
                foreach ( $params['filter-listing-categories'] as $value ) {
                    if ( empty( $value ) ) {
                        continue;
                    }

                    $taxonomies[] = [
                        'taxonomy'  => 'product_cat',
                        'field'     => 'id',
                        'terms'     => $value,
                    ];
                }
            } else {
                $taxonomies[] = [
                    'taxonomy'  => 'product_cat',
                    'field'     => 'id',
                    'terms'     => $params['filter-listing-categories'],
                ];
            }
        }

        // Contract
        if ( ! empty( $params['filter-contract'] ) ) {
            $taxonomies[] = [
                'taxonomy'  => 'contracts',
                'field'     => 'id',
                'terms'     => $params['filter-contract'],
            ];
        }

        // Title
        if ( ! empty( $params['filter-title'] ) ) {
            $title_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_title LIKE '%s'", '%' . $params['filter-title'] . '%' ) );
            $ids = self::build_post_ids( $ids, $title_ids );
        }

        // Description
        if ( ! empty( $params['filter-description'] ) ) {
            $description_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_content LIKE '%s'", '%' . $params['filter-description'] . '%' ) );
            $ids = self::build_post_ids( $ids, $description_ids );
        }

        // Keyword
        if ( ! empty( $params['filter-keyword'] ) ) {
            $keyword_ids = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_status = \"publish\" AND post_content LIKE '%s' OR post_title LIKE '%s'",
                '%' . $params['filter-keyword'] . '%',  '%' . $params['filter-keyword'] . '%' ) );
            $ids = self::build_post_ids( $ids, $keyword_ids );
        }

        // Custom filtering
        $ids = apply_filters( 'listing_manager_filter_query', $ids, $params );

        // Distance
        if ( empty( $params['filter-distance'] ) ) {
            $params['filter-distance'] = 999999;
        }

        if ( ! empty( $params['filter-distance-latitude'] ) && ! empty( $params['filter-distance-longitude'] ) && ! empty( $params['filter-distance'] ) ) {
            $distance_ids = [];
            $rows = self::filter_by_distance( $params['filter-distance-latitude'], $params['filter-distance-longitude'], $params['filter-distance'] );
            foreach ( $rows as $row ) {
                $distance_ids[] = $row->ID;
            }
            $ids = self::build_post_ids( $ids, $distance_ids );
        }

        // Price from
        if ( ! empty( $params['filter-price-from'] ) ) {
            $meta[] = [
                'key'       => '_regular_price',
                'value'     => $params['filter-price-from'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Price to
        if ( ! empty( $params['filter-price-to'] ) ) {
            $meta[] = [
                'key'       => '_regular_price',
                'value'     => $params['filter-price-to'],
                'compare'   => '<=',
                'type'      => 'NUMERIC',
            ];
        }

        // Event date from
        if ( ! empty( $params['filter-event-date-from'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'event_date',
                'value'     => $params['filter-event-date-from'],
                'compare'   => '>=',
                'type'      => 'DATE',
            ];
        }

        // Event date to
        if ( ! empty( $params['filter-event-date-to'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'event_date',
                'value'     => $params['filter-event-date-to'],
                'compare'   => '<=',
                'type'      => 'DATE',
            ];
        }

        // Reference
        if ( ! empty( $params['filter-reference'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_reference',
                'value'     => $params['filter-reference'],
            ];
        }

        // Year built
        if ( ! empty( $params['filter-year_built'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_year_built',
                'value'     => $params['filter-year_built'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Rooms
        if ( ! empty( $params['filter-rooms'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_rooms',
                'value'     => $params['filter-rooms'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Bathrooms
        if ( ! empty( $params['filter-bathrooms'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_bathrooms',
                'value'     => $params['filter-bathrooms'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Bedrooms
        if ( ! empty( $params['filter-bedrooms'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_bedrooms',
                'value'     => $params['filter-bedrooms'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Garages
        if ( ! empty( $params['filter-garages'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_garages',
                'value'     => $params['filter-garages'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Parking slots
        if ( ! empty( $params['filter-parking_slots'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_parking_slots',
                'value'     => $params['filter-parking_slots'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Home area
        if ( ! empty( $params['filter-home_area'] ) ) {
            $meta[] = [
                'key'       => LISTING_MANAGER_LISTING_PREFIX . 'property_home_area',
                'value'     => $params['filter-home_area'],
                'compare'   => '>=',
                'type'      => 'NUMERIC',
            ];
        }

        // Post IDs
        if ( is_array( $ids ) ) {
            if ( count( $ids ) > 0 ) {
                $query->set( 'post__in', $ids );
            } else {
                $query->set( 'post__in', [ 0 ] );
            }
        }

        $meta = apply_filters( 'listing_manager_filter_meta', $meta );
        $taxonomies = apply_filters( 'listing_manager_filter_taxonomies', $taxonomies );

        $query->set( 'post_type', 'product' );
        $query->set( 'post_status', 'publish' );
        $query->set( 'meta_query', $meta );
        $query->set( 'tax_query', $taxonomies );        
        return $query;
    }

    /**
     * Tweak for displaying posts without value instead of ignoring them
     * Read more about it here: https://core.trac.wordpress.org/ticket/19653
     *
     * @access public
     * @param $clauses
     * @return mixed
     */
    public static function filter_get_meta_sql_19653( $clauses ) {
        remove_filter( 'get_meta_sql', [ __CLASS__, 'filter_get_meta_sql_19653' ] );

        // Change the inner join to a left join,
        // and change the where so it is applied to the join, not the results of the query.
        $clauses['join']  = str_replace( 'INNER JOIN', 'LEFT JOIN', $clauses['join'] ) . $clauses['where'];
        $clauses['where'] = '';

        return $clauses;
    }

    /**
     * Helper method to build an array of post ids
     *
     * Purpose is to build proper array of post ids which will be used in WP_Query. For certain queries we need
     * an array for post__in so we have to make array intersect, new array or just return null (post__in is not required).
     *
     * @access public
     * @param null|array $haystack
     * @param array $ids
     * @return null|array
     */
    public static function build_post_ids( $haystack, array $ids ) {
        if ( ! is_array( $haystack ) ) {
            $haystack = [];
        }

        if ( is_array( $haystack ) && count( $haystack ) > 0 ) {
            return array_intersect( $haystack, $ids );
        } else {
            $haystack = $ids;
        }

        return $haystack;
    }

    /**
     * Find listings by GPS position matching the distance
     *
     * @access public
     * @param $latitude
     * @param $longitude
     * @param $distance
     *
     * @return mixed
     */
    public static function filter_by_distance( $latitude, $longitude, $distance ) {
        global $wpdb;

        $radius_km = 6371;
        $radius_mi = 3959;
        $radius = $radius_mi;

        if ( 'km' == get_theme_mod( 'listing_manager_distance_unit_long', 'mi' ) ) {
            $radius = $radius_km;
        }

        $sql = 'SELECT SQL_CALC_FOUND_ROWS ID, ( ' . $radius . ' * acos( cos( radians(' . $latitude . ') ) * cos(radians( latitude.meta_value ) ) * cos( radians( longitude.meta_value ) - radians(' . $longitude . ') ) + sin( radians(' . $latitude . ') ) * sin( radians( latitude.meta_value ) ) ) ) AS distance
    				FROM ' . $wpdb->prefix . 'posts
                    INNER JOIN ' . $wpdb->prefix . 'postmeta ON (' . $wpdb->prefix . 'posts.ID = ' . $wpdb->prefix . 'postmeta.post_id)
                    INNER JOIN ' . $wpdb->prefix . 'postmeta AS latitude ON ' . $wpdb->prefix . 'posts.ID = latitude.post_id
                    INNER JOIN ' . $wpdb->prefix . 'postmeta AS longitude ON ' . $wpdb->prefix . 'posts.ID = longitude.post_id
                    WHERE ' . $wpdb->prefix . 'posts.post_type = "product"
                        AND ' . $wpdb->prefix . 'posts.post_status = "publish"
                        AND latitude.meta_key="' . LISTING_MANAGER_LISTING_PREFIX . 'location_latitude"
                        AND longitude.meta_key="' . LISTING_MANAGER_LISTING_PREFIX . 'location_longitude"
					GROUP BY ' . $wpdb->prefix . 'posts.ID HAVING distance <= ' . $distance . ';';

        return $wpdb->get_results( $sql );
    }
}
