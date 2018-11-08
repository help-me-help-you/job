<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use WP_Query;

class StatisticLogic {
	/**
	 * @Action(name="admin_menu", priority=40)
	 */
	public static function menu() {
		add_submenu_page(
			'listing-manager',
			esc_attr__( 'Statistics', 'listing-manager' ),
			esc_attr__( 'Statistics', 'listing-manager' ),
			'manage_options',
			'listing_manager_statistics',
			[ __CLASS__, 'template' ]
		);
	}


    /**
     * @Action(name="pre_get_posts")
     */
    public static function save_search_queries( $query ) {
        global $wpdb;

        $query_logging = get_theme_mod( 'listing_manager_statistics_enable_query_logging', false );

        if ( ! $query_logging ) {
            return;
        }

        $suppress_filters = ! empty( $query->query_vars['suppress_filters'] ) ? $query->query_vars['suppress_filters'] : '';

        if ( ! is_post_type_archive( 'listing' ) || ! $query->is_main_query() || is_admin() || $suppress_filters ) {
            return;
        }

        if ( is_array( $_GET ) && count( $_GET ) > 0 ) {
            foreach ( $_GET as $key => $value ) {
                if ( substr( $key, 0, strlen( 'filter-' ) ) === 'filter-' && ! empty( $value ) ) {
                    $key = str_replace( [ 'filter-', '-' ], [ '', '_' ], $key);

                    if ( is_array( $value ) ) {
                        $value = serialize( $value );
                    }

                    $wpdb->insert( $wpdb->prefix . 'listing_manager_query_stats', [
                        'key'       => $key,
                        'value'     => $value,
                        'created'   => date( 'Y-m-d H:i:s' ),
                    ] );
                }
            }

            $wpdb->insert( $wpdb->prefix . 'listing_manager_query_stats', [
                'key'       => 'filter',
                'value'     => $_SERVER['REMOTE_ADDR'],
                'created'   => date( 'Y-m-d H:i:s' ),
            ] );
        }
    }

    /**
     * @Filter(name="the_content")
     */
    public static function save_listing_views( $content ) {
        global $wpdb;

        $post_id = get_the_ID();

        if ( get_theme_mod( 'listing_manager_statistics_enable_listing_logging' ) && is_singular( 'product' ) ) {
            $sql = 'SELECT * FROM ' . $wpdb->prefix . 'listing_manager_listing_stats
            WHERE `key` = "' . $post_id . '" AND
                  `value` = "' . session_id() . '" AND
                  `created` > DATE_SUB(NOW(), INTERVAL 15 MINUTE)';
            $results = $wpdb->get_results( $sql );

            if ( 0 === count( $results ) ) {
                $wpdb->insert( $wpdb->prefix . 'listing_manager_listing_stats', [
                    'key'       => $post_id,
                    'value'     => session_id(),
                    'ip'        => $_SERVER['REMOTE_ADDR'],
                    'created'   => current_time( 'mysql' ),
                ] );

                // update total views: we need to to be able sort posts by popularity
                update_post_meta( $post_id, LISTING_MANAGER_STATISTICS_TOTAL_VIEWS_META, self::listing_views_get_total( $post_id ) );
            }
        }

        return $content;
    }

    /**
     * Template
     *
     * @access public
     * @return void
     */
    public static function template() {
        wc_get_template( 'listing-manager/statistics.php', [
            'popular_listings'      => self::get_popular_listings(),
            'popular_locations'     => self::get_popular_locations(),
            'popular_categories'    => self::get_popular_categories(),
            'users'                 => self::get_users_count(),
            'listings'              => self::get_listings_count(),
            'packages'              => self::get_packages_count(),
            'searches'              => self::get_searches_count(),
            'views'                 => self::get_views_count(),
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * Gets listing total views
     *
     * @access public
     * @param null $post_id
     * @return int
     */
    public static function listing_views_get_total( $post_id = null ) {
        global $wpdb;

        if ( null === $post_id ) {
            $post_id = get_the_ID();
        }

        $sql = 'SELECT `key`, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_manager_listing_stats
                WHERE `key` = "' . $post_id . '"
                GROUP BY `key`';

        $results = $wpdb->get_results( $sql );
        if ( is_array( $results ) && count( $results ) > 0 ) {
            return $results[0]->count;
        }

        return 0;
    }


    /**
     * Installs search query table
     *
     * @access public
     * @return void
     */
    public static function install_search_queries() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'listing_manager_query_stats';

        if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name )  {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = 'CREATE TABLE `'. $table_name .'` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `key` varchar(200) NOT NULL DEFAULT \'\',
                `value` text NOT NULL,
                `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `key` (`key`)
            ) ' . $charset_collate . ';';

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    /**
     * Installs listing views table
     *
     * @access public
     * @return void
     */
    public static function install_listing_views() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'listing_manager_listing_stats';

        if( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) != $table_name )  {
            $charset_collate = $wpdb->get_charset_collate();

            $sql = 'CREATE TABLE `'. $table_name .'` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `key` varchar(200) NOT NULL DEFAULT \'\',
                `value` text NOT NULL,
                `ip` varchar(200) NOT NULL DEFAULT \'\',
                `created` timestamp NOT NULL DEFAULT \'0000-00-00 00:00:00\' ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `key` (`key`)
            ) ' . $charset_collate . ';';

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );
        }
    }

    /**
     * Gets users count
     *
     * @access public
     * @return int
     */
    public static function get_users_count() {
        $users = count_users();
        return $users['total_users'];
    }

    /**
     * Gets packages count
     *
     * @access public
     * @return int
     */
    public static function get_packages_count() {
        $query = new WP_Query( [
            'post_type' => 'product',
            'tax_query' => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'package',
                ],
            ],
        ] );

        return $query->post_count;
    }

    /**
     * Gets listings count
     *
     * @access public
     * @return int
     */
    public static function get_listings_count() {
        $query = new WP_Query( [
            'post_type' => 'product',
            'tax_query' => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'listing',
                ],
            ],
        ] );

        return $query->post_count;
    }

    /**
     * Gets searches count
     *
     * @access public
     * @return int
     */
    public static function get_searches_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'listing_manager_query_stats';

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
            $sql = 'SELECT `key`, COUNT(*) as count FROM ' . $table_name . ' WHERE `key` = "filter"';
            $results = $wpdb->get_results( $sql, ARRAY_A );
            return $results[0]['count'];
        }

        return 0;
    }

    /**
     * Gets views count
     *
     * @access public
     * @return int
     */
    public static function get_views_count() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'listing_manager_listing_stats';

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
            $sql = 'SELECT COUNT(*) as count FROM ' . $table_name;
            $results = $wpdb->get_results( $sql, ARRAY_A );
            return $results[0]['count'];
        }

        return 0;
    }

    /**
     * Listing views popular statistics
     *
     * @access public
     * @param int $count
     * @return mixed
     */
    public static function get_popular_listings( $count = 10 ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'listing_manager_listing_stats';

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {
            $sql = 'SELECT `key`, post_title, COUNT(*) as count FROM ' . $table_name . '
                    LEFT JOIN ' . $wpdb->prefix . 'posts ON ' . $wpdb->prefix . 'posts.ID=' . $wpdb->prefix . 'listing_manager_listing_stats.key
                    GROUP BY `key`
                    ORDER BY count DESC;';

            $results = $wpdb->get_results( $sql );
            foreach( $results as $key => $result ) {
            	$post = get_post( $result->key );

            	if ( empty( $post ) || empty( $result->post_title ) ) {
            		unset( $results[ $key ] );
	            }
            }

			return array_slice( $results, 0, $count - 1 );
        }

        return null;
    }

    /**
     * Listing views popular locations statistics
     *
     * @access public
     * @param int $count
     * @return mixed
     */
    public static function get_popular_locations( $count = 10 ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'listing_manager_query_stats';
        $categories = [];

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {

            $sql = sprintf( 'SELECT * FROM %s WHERE `key` = \'%s\';', $table_name, 'locations' );
            $results =  $wpdb->get_results( $sql );

            if ( is_array( $results ) ) {
                foreach ( $results as $line ) {
                    if ( is_numeric( $line->value ) ) {
                        $categories[ $line->value ] = ! empty( $categories[ $line->value ] ) ? $categories[ $line->value ] + 1 : 1;
                    } else {
                        $values = unserialize( $line->value );
						if ( is_array( $values ) ) {
							foreach ( $values as $key => $value ) {
								if ( ! empty( $value ) ) {
									$categories[ $value ] = ! empty( $categories[ $value ] ) ? $categories[ $value ] + 1 : 1;
								}
							}
						}
                    }
                }
            }
        }

        arsort( $categories );

        foreach( $categories as $key => $value ) {
            $term = get_term( $key, 'locations' );

            if ( empty( $term ) ) {
                unset( $categories[ $key ] );
            }
        }

        return array_slice( $categories, 0, $count - 1, true );
    }

    /**
     * Listing views popular categories statistics
     *
     * @access public
     * @param int $count
     * @return mixed
     */
    public static function get_popular_categories( $count = 10 ) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'listing_manager_query_stats';
        $categories = [];

        if ( $wpdb->get_var( "SHOW TABLES LIKE '$table_name'" ) == $table_name ) {

            $sql = sprintf( 'SELECT * FROM %s WHERE `key` = \'%s\';', $table_name, 'listing_categories' );
            $results =  $wpdb->get_results( $sql );

            if ( is_array( $results ) ) {
                foreach ( $results as $line ) {
                    if ( is_numeric( $line->value ) ) {
                        $categories[ $line->value ] = ! empty( $categories[ $line->value ] ) ? $categories[ $line->value ] + 1 : 1;
                    } else {
                        $values = unserialize( $line->value );

                        foreach ( $values as $key => $value ) {
                            if ( ! empty( $value ) ) {
                                $categories[ $value ] = ! empty( $categories[ $value ] ) ? $categories[ $value ] + 1 : 1;
                            }
                        }
                    }
                }
            }
        }

        arsort( $categories );

        foreach( $categories as $key => $value ) {
            $term = get_term( $key, 'product_cat' );

            if ( empty( $term ) ) {
                unset( $categories[ $key ] );
            }
        }

        return array_slice( $categories, 0, $count - 1, true );
    }
}