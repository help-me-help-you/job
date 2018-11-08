<?php

namespace ListingManager\Product;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use WP_Query;

class ListingProduct {
    /**
     * @Action(name="woocommerce_init")
     */
    public static function definition() {
        require_once LISTING_MANAGER_DIR . 'src/ListingManager/ProductType/ListingProductType.php';
    }

    /**
     * @Filter(name="product_type_selector")
     */
    public static function product_types( $types ) {
        $types['listing'] = esc_html__( 'Listing', 'listing-manager' );
        return $types;
    }

	/**
	 * @Filter(name="woocommerce_product_class", priority=20, accepted_args=4)
	 */
    public static function product_class( $classname, $product_type, $post_type, $product_id ) {
        if ( 'listing' == $product_type ) {
            return 'ListingProductType';
        }

        if ( 'micropayment' === $product_type ) {
	        return 'MicropaymentProductType';
        }

        if ( 'package' === $product_type ) {
	        return 'PackageProductType';
        }

        return $classname;
    }

	/**
	 * @Action(name="woocommerce_after_single_product_summary", priority=20)
	 */
	public static function detail_statistics() {
		global $wpdb;

        $enabled = get_theme_mod( 'listing_manager_statistics_show_listing_views', false );
		if ( empty( $enabled )  ) {
		    return;
        }

        if ( ! has_term( 'listing', 'product_type' ) ) {
            return;
        }

		$data = [];
        $max = 0;

		$sql = 'SELECT DATE(created) as date, COUNT(*) as count FROM ' . $wpdb->prefix . 'listing_manager_listing_stats
		        WHERE `key` = \'' . get_the_ID() . '\' AND `created` >= DATE_SUB(NOW(), INTERVAL 2 WEEK)
                GROUP BY date
                ORDER BY date';

		$results = $wpdb->get_results( $sql );

		for ( $i = 13; $i >= 0 ; $i-- ) {
			$date = date( 'Y-m-d', strtotime( '-' . $i . ' days' ) );
			$data[] = [ 13 - $i, $date, 0 ];
		}

		$index = 1;
		foreach ( $results as $result ) {
			foreach ( $data as $key => $value ) {
				if ( $value[1] === $result->date ) {
					$data[$key] = [
						$key, $result->date, (int) $result->count
					];

					$max = ((int) $result->count > $max) ? (int) $result->count : $max;
				}
			}

			$index++;
		}

		wc_get_template( 'listing-manager/listing-views.php', [
            'data'  => $data,
            'max'   => $max,
            'step'  => (0 != $max ) ? 100 / $max : 0,
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}

    /**
     * @Filter(name="views_edit-product")
     */
    public static function add_action_filter( $view ) {
        global $wp_query;

        $title = esc_html__( 'Listings', 'listing-manager' );
        $class = ( isset( $wp_query->query['product_type'] ) && 'listing' === $wp_query->query['product_type'] ) ? 'current' : '';

        $query_string = remove_query_arg( [ 'post_status', ] );
        $query_string = add_query_arg( 'product_type', 'listing', $query_string );

        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'tax_query' 		=> [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'listing',
                ],
            ],
        ] );

        $view['listings'] =
            sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', esc_url( $query_string ), $class, $title, $query->post_count);
        return $view;
    }

    /**
     * @Filter(name="woocommerce_is_purchasable", priority=10, accepted_args=2)
     */
    public static function is_purchasable( $is_purchasable, $object ) {
        if ( has_term( 'listing', 'product_type' ) ) {
            $purchasable = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'is_purchasable', true );

            if ( empty( $purchasable ) ) {
                return false;
            }

            return true;
        }

        return $is_purchasable;
    }

    /**
     * @Action(name="woocommerce_product_options_advanced")
     */
    public static function add_purchasable_checkbox() {
        if ( has_term( 'listing', 'product_type' ) ) {
            woocommerce_wp_checkbox( [
                'id' 			=> LISTING_MANAGER_LISTING_PREFIX . 'is_purchasable',
                'label' 		=> esc_html__( 'Purchasable', 'listing-manager' ),
                'wrapper_class'	=> 'options_group',
                'cbvalue' 		=> 'open'
            ] );
        }
    }

	/**
	 * @Action(name="woocommerce_product_options_advanced")
	 */
	public static function add_verified_checkbox() {
		if ( has_term( 'listing', 'product_type' ) ) {
			woocommerce_wp_checkbox( [
				'id' 			=> LISTING_MANAGER_LISTING_PREFIX . 'is_verified',
				'label' 		=> esc_html__( 'Verified', 'listing-manager' ),
				'wrapper_class'	=> 'options_group',
				'cbvalue' 		=> 'open'
			] );
		}
	}

    /**
     * @Action(name="woocommerce_product_options_advanced")
     */
    public static function add_agent_select() {
        if ( has_term( 'listing', 'product_type' ) ) {
            $agents = [
                '' => esc_attr__( 'Not set', 'listing-manager' ),
            ];

            $query = new WP_Query( [
                'post_type' 		=> 'agent',
                'posts_per_page'	=> -1,
            ] );

            if ( is_array( $query->posts ) && count( $query->posts ) > 0 ) {
                foreach( $query->posts as $agent ) {
                    $agents[ $agent->ID ] = $agent->post_title;
                }
            }

            woocommerce_wp_select( [
                'id' 			=> LISTING_MANAGER_LISTING_PREFIX . 'agent',
                'label' 		=> esc_html__( 'Agent', 'listing-manager' ),
                'wrapper_class'	=> 'options_group',
                'options' 		=> $agents,
            ] );
        }
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        // Verified
	    $is_verified_id = LISTING_MANAGER_LISTING_PREFIX . 'is_verified';
	    if ( isset( $_POST[ $is_verified_id ] ) && 'open' === $_POST[ $is_verified_id ] ) {
		    update_post_meta( $post_id, $is_verified_id, sanitize_text_field( 'open' ) );
	    } else {
		    delete_post_meta( $post_id, $is_verified_id );
	    }

	    // Purchasable
        $is_purchasable_id = LISTING_MANAGER_LISTING_PREFIX . 'is_purchasable';

        if ( isset( $_POST[ $is_purchasable_id ] ) && 'open' === $_POST[ $is_purchasable_id ] ) {
            update_post_meta( $post_id, $is_purchasable_id, sanitize_text_field( 'open' ) );
        } else {
            delete_post_meta( $post_id, $is_purchasable_id );
        }

        // Agent
        $agent_id = LISTING_MANAGER_LISTING_PREFIX . 'agent';
        if ( isset( $_POST[ $agent_id ] ) ) {
            update_post_meta( $post_id, $agent_id, $_POST[ $agent_id ] );
        } else {
            delete_post_meta( $post_id, $agent_id );
        }
    }

    /**
     * @Action(name="admin_footer")
     */
    public static function enable_price() {
        if ( 'product' != get_post_type() ) {
            return;
        }

        ?>
        <script type='text/javascript'>
            jQuery(document).ready( function() {
                jQuery('.options_group.pricing').addClass('show_if_listing').show();
                jQuery('._manage_stock_field').addClass('show_if_listing').show();
            });
        </script>
        <?php
    }

    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tabs( $tabs ) {
        if ( ! empty( $tabs['general'] ) ) {
            $tabs['general']['class'] = array_merge( $tabs['general']['class'], [ 'show_if_listing' ] );
        }

	    if ( ! empty( $tabs['general'] ) ) {
		    $tabs['inventory']['class'] = array_merge( $tabs['inventory']['class'], [ 'show_if_listing' ] );
	    }

        if ( ! empty( $tabs['shipping'] ) ) {
            $tabs['shipping']['class'] = array_merge( $tabs['shipping']['class'], [ 'hide_if_listing' ] );
        }

        if ( ! empty( $tabs['linked_product'] ) ) {
            $tabs['linked_product']['class'] = array_merge( $tabs['linked_product']['class'], [ 'hide_if_listing' ] );
        }

        return $tabs;
    }

    /**
     * Gets listing location name
     *
     * @access public
     * @param null   $post_id
     * @param string $separator
     * @return bool|string
     */
    public static function get_location_name( $post_id = null, $separator = '/', $hierarchical = true ) {
        if ( null == $post_id ) {
            $post_id = get_the_ID();
        }

        if ( ! empty( $listing_locations[ $post_id ] ) ) {
            return $listing_locations[ $post_id ];
        }

        $locations = wp_get_post_terms( $post_id, 'locations', [
            'orderby'   => 'parent',
            'order'     => 'ASC',
            'number'    => 1,
        ] );

        if ( is_array( $locations ) && count( $locations ) > 0 ) {
            $output = '';

            if ( true === $hierarchical ) {
                foreach ( $locations as $key => $location ) {
                    $output .= $location->name;

                    if ( array_key_exists( $key + 1, $locations ) ) {
                        $output .= ' <span class="separator">' . $separator . '</span> ';
                    }
                }
            } else {
                $output = end( $locations )->name;
            }

            $listing_locations[ $post_id ] = $output;
            return $output;
        }

        return false;
    }

    public static function get_category_name( $post_id = null ) {
	    if ( null == $post_id ) {
		    $post_id = get_the_ID();
	    }

	    $cats = wp_get_post_terms( get_the_ID(), 'product_cat' );

	    if ( empty( $cats ) || 0 === count( $cats ) ) {
	        return null;
        }

        $cat = array_shift( $cats );
        return $cat->name;
    }
}