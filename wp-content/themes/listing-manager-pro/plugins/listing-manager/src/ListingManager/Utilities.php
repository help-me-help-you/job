<?php

namespace ListingManager;

use WP_Query;

class Utilities {
    /**
     * Checks if the WooCommerce is active
     *
     * @access public
     * @return bool
     */
    public static function is_woocommerce_active() {
        return self::is_plugin_active( 'woocommerce.php' );
    }

    /**
     * Checks if the plugin is active
     *
     * @access public
     * @param string $plugin_name
     * @return bool
     */
    public static function is_plugin_active( $plugin_name ) {
        $plugins = get_option( 'active_plugins', [] );

        foreach ( $plugins as $plugin ) {
            if ( strpos( $plugin, '/' . $plugin_name ) ) { return true; }
        }

        return false;
    }

    /**
     * Gets all pages list
     *
     * @access public
     * @return array
     */
    public static function get_pages() {
        $pages = [];
        $pages[] = esc_html__( 'Not set', 'listing-manager' );

        foreach ( get_pages() as $page ) {
            $pages[ $page->ID ] = $page->post_title;
        }

        return $pages;
    }

    /**
     * Checks if user allowed to remove post
     *
     * @access public
     * @param $user_id int
     * @param $item_id int
     * @return bool
     */
    public static function is_allowed_to_access( $user_id, $item_id ) {
        $item = get_post( $item_id );

        if ( ! empty( $item->post_author ) ) {
            if ( $item->post_author == $user_id ) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get weekdays array
     *
     * @access public
     * @return array
     */
    public static function get_days() {
        return [
            'monday' 	=> esc_html__( 'Monday', 'listing-manager' ),
            'tuesday' 	=> esc_html__( 'Tuesday', 'listing-manager' ),
            'wednesday' => esc_html__( 'Wednesday', 'listing-manager' ),
            'thursday' 	=> esc_html__( 'Thursday', 'listing-manager' ),
            'friday' 	=> esc_html__( 'Friday', 'listing-manager' ),
            'saturday' 	=> esc_html__( 'Saturday', 'listing-manager' ),
            'sunday' 	=> esc_html__( 'Sunday', 'listing-manager' ),
        ];
    }

    /**
     * Gets current URL address
     *
     * @access public
     * @return string
     */
    public static function get_current_url() {
	    global $wp;

	    $result = home_url( add_query_arg( [], $wp->request ) );
	    $query = $_SERVER['QUERY_STRING'];

	    if ( ! empty( $query ) ) {
	    	$result = $result . '?' . $query;
	    }

	    return $result;
    }


    /**
     * Gets listings page URI
     *
     * @access public
     * @return string
     */
    public static function get_listings_url() {
        return network_site_url() . '/' . get_theme_mod( 'listing_manager_pages_listings', __( 'listings', 'listing-manager' ) );
    }

    /**
     * Loads image from external source
     *
     * @access public
     * @param $filename
     * @param $post_id
     * @return int
     */
    public static function save_file( $filename, $post_id ) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';

        $filetype = wp_check_filetype( basename( $filename ), null );
        $wp_upload_dir = wp_upload_dir();
        $args = [
            'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ),
            'post_mime_type' => $filetype['type'],
            'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content'   => '',
            'post_status'    => 'inherit',
        ];

        $attachment_id = wp_insert_attachment( $args, $filename , $post_id );
        $attachment_data = wp_generate_attachment_metadata( $attachment_id, $filename );

        wp_update_attachment_metadata( $attachment_id, $attachment_data );

        return $attachment_id;
    }

    /**
     * Process multiple files upload
     *
     * @access public
     * @param int $post_id
     * @param string $key
     * @param array $value
     * @return void
     */
    public static function process_files( $post_id, $key, $value ) {
        $files = self::prepare_files( $value );

        if ( is_array( $files ) ) {
            foreach ( $files as $file ) {
                self::process_file( $post_id, $key, $file, true );
            }
        }
    }

    /**
     * Uploads and process file
     *
     * @access public
     * @param int $post_id
     * @param string $key
     * @param array $value
     * @param bool $add
     * @return void
     */
    public static function process_file( $post_id, $key, $value, $add = false ) {
        $overrides = [ 'test_form' => false ];
        $file = wp_handle_upload( $value, $overrides );

        if ( ! empty( $file ) && ! isset( $file['error'] ) ) {
            $attachment_id = self::save_file( $file['file'], $post_id );

            if ( $add ) {
                $existing = get_post_meta( $post_id, $key, true );

                if ( empty( $existing ) ) {
                    $existing .= $attachment_id;
                } else {
                    $existing .= ',' . $attachment_id;
                }

                $attachment_id = $existing;
            }

            update_post_meta( $post_id, $key, $attachment_id );

            // Set featured image for post
            if ( 'featured_image' === $key ) {
                set_post_thumbnail( $post_id, $attachment_id );
            }
        } else {
            wc_add_notice( $file['error'], 'error' );
        }
    }

    /**
     * Create better $_FILES array if the input has multiple
     *
     * @access public
     * @param array $form_input
     * @return array
     */
    public static function prepare_files( $form_input ) {
        $files = [];

        foreach ( $form_input as $key => $values ) {
            foreach ( $values as $index => $value ) {
                $files[ $index ][ $key ] = $value;
            }
        }

        return $files;
    }

    /**
     * Get UUID
     *
     * @access public
     * @param string $prefix
     * @return string
     */
    public static function get_uuid() {
        $chars = md5( uniqid( rand() ) );
        $uuid  = substr( $chars, 0, 8 ) . '-';
        $uuid .= substr( $chars, 8, 4 ) . '-';
        $uuid .= substr( $chars, 12, 4 ) . '-';
        $uuid .= substr( $chars, 16, 4 ) . '-';
        $uuid .= substr( $chars, 20, 12 );
        return $uuid;
    }

    /**
     * Short UUID
     *
     * @access public
     * @param string $prefix
     * @return string
     */
    public static function get_short_uuid( $prefix = '' ) {
        $uuid = self::get_uuid();
        $parts = explode( '-', $uuid );
        return $prefix . $parts[0];
    }

    /**
     * Checks if current page is listing archive page
     *
     * @access public
     * @return bool
     */
    public static function is_listing_archive() {
        global $wp_query;

        if ( class_exists( 'WooCommerce' ) && is_shop() && ! empty( $wp_query->query['post_type'] ) && 'listing' === $wp_query->query['post_type'] ) {
            return true;
        }

        return false;
    }

    /**
     * Gets company agents IDs
     *
     * @access public
     * @param int $company_id
     * @return array
     */
    public static function get_company_agent_ids( $company_id ) {
        $result = [];
        $query = new WP_Query( [
            'post_type' 		=> 'agent',
            'posts_per_page' 	=> -1,
        ] );

        if ( ! empty( $query->posts ) && is_array( $query->posts ) && count( $query->posts ) > 0 ) {
            foreach( $query->posts as $agent ) {
                $companies = get_post_meta( $agent->ID, LISTING_MANAGER_AGENT_PREFIX . 'companies', true );

                if ( is_array( $companies ) ) {
                    foreach( $companies as $company ) {
                        if ( $company == $company_id ) {
                            $result[] = $agent->ID;
                        }
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Gets agents properties
     *
     * @access public
     * @param int $agent_id
     * @return array
     */
    public static function get_agent_listings( $agent_id ) {
        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'meta_query'        => [
                [
                    'key'       => LISTING_MANAGER_LISTING_PREFIX . 'agent',
                    'value'     => get_the_ID(),
                ],
            ],
            'tax_query'     	=> [
                [
                    'taxonomy' 	=> 'product_type',
                    'field'    	=> 'slug',
                    'terms'    	=> 'listing',
                ],
            ],
        ] );

        return $query->posts;
    }

    /**
     * Get company listings
     *
     * @access public
     * @param int $company_id
     * @return array
     */
    public static function get_company_listings( $company_id ) {        
        $agents = self::get_company_agent_ids( get_the_ID() );

        if (  is_array( $agents )  && 0 === count( $agents ) ) {
            return null;
        }

        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'meta_query'        => [
                [
                    'key'       => LISTING_MANAGER_LISTING_PREFIX . 'agent',
                    'value'     => $agents,
                    'type'      => 'NUMERIC',
                ],
            ],
            'tax_query'         => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'listing',
                ],
            ],
        ] );

        return $query->posts;
    }

    public static function opening_hours_status( $post_id ) {
        $opening_hours = [];

        foreach( self::get_days() as $key => $value ) {
            $from = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX  . 'opening_hour_' .  $key . '_from', true );
            $to = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX  . 'opening_hour_' .  $key . '_to', true );

            if ( ! empty( $from ) && ! empty( $to ) ) {
                $opening_hours[$key] = [
                    'from' => $from,
                    'to' => $to,
                ];
            }
        }

        if ( empty( $opening_hours ) ) {
            return 'unknown';
        }

        $week = [ 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY' ];
        $previous_timezone = date_default_timezone_get();
        $wordpress_timezone = get_option('timezone_string');

        // set timezone
        if ( ! empty( $wordpress_timezone ) ) {
            date_default_timezone_set( $wordpress_timezone );
        }

        // current time
        $now = time() + ( get_option( 'gmt_offset' ) * 60 * 60 );

        // week day
        $today_index = date( 'N' );
        $week_day = $week[ $today_index - 1 ];

        // default status
        $status = 'closed';

        // find opening hours for today
        foreach ( $opening_hours as $opening_key => $opening_day ) {
            if ( strtoupper( $opening_key ) == $week_day ) {
                if ( ! empty( $opening_day['from'] ) && ! empty( $opening_day['to'] ) ) {
                    $time_from = strtotime( $opening_day['from'] );
                    $time_to = strtotime( $opening_day['to'] );
                    $status = $time_from <= $now && $now <= $time_to ? 'open' : 'closed';
                    break;
                }
            }
        }

        // set back previous timezone
        if ( ! empty( $previous_timezone ) ) {
            date_default_timezone_set( $previous_timezone );
        }

        // return status
        return $status;
    }

    /**
     * Wrapper function
     *
     * @access public
     * @return void
     */
    public static function reset_query() {
        wp_reset_query();
    }

    public static function build_taxonomy_selects( $taxonomy ) {
        $terms = get_terms( $taxonomy, [
            'hide_empty' 	=> false,
        ] );

        return self::parse_taxonomy( $terms, $taxonomy );
    }

    public static function parse_taxonomy( $terms, $taxonomy, $parent = 0, $level = 0, $selects = [] ) {

        if ( ! empty( $terms ) ) {
            foreach ( $terms as $term ) {
                if ( $parent != $term->parent ) {
                    continue;
                }

                $selects[ 'level-' . $level ][] = [
                    'value'		=> $term->term_id,
                    'name' 		=> $term->name,
                    'parent' 	=> $term->parent,
                ];

                $selects = self::parse_taxonomy( $terms, $taxonomy, $term->term_id, $level + 1, $selects );
            }
        }

        return $selects;
    }
}
