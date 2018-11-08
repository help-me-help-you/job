<?php

namespace ListingManager\Product;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

use DateTime;
use Exception;
use WC_Order;
use WP_Query;

class PackageProduct {
    /**
     * @Action(name="woocommerce_init")
     */
    public static function definition() {
        require_once LISTING_MANAGER_DIR . 'src/ListingManager/ProductType/PackageProductType.php';
    }

    /**
     * @Filter(name="product_type_selector")
     */
    public static function product_types( $types ) {
        $types['package'] = esc_html__( 'Package', 'listing-manager' );
        return $types;
    }

    /**
     * @Filter(name="views_edit-product")
     */
    public static function add_action_filter( $view ) {
        global $wp_query;

        $title = esc_html__( 'Packages', 'listing-manager' );
        $class = ( isset( $wp_query->query['product_type'] ) && $wp_query->query['product_type'] == 'package' ) ? 'current' : '';

        $query_string = remove_query_arg( [ 'post_status', ] );
        $query_string = add_query_arg( 'product_type', 'package', $query_string );

        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'tax_query'         => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'package',
                ],
            ],
        ] );

        $view['packages'] =
            sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', esc_url( $query_string ), $class, $title, $query->post_count);
        return $view;
    }

    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tabs( $tabs ) {
        if ( ! empty( $tabs['general'] ) ) {
            $tabs['general']['class'] = array_merge( $tabs['general']['class'], [ 'show_if_package' ] );
        }

        if ( ! empty( $tabs['shipping'] ) ) {
            $tabs['shipping']['class'] = array_merge( $tabs['shipping']['class'], [ 'hide_if_package' ] );
        }

        if ( ! empty( $tabs['linked_product'] ) ) {
            $tabs['linked_product']['class'] = array_merge( $tabs['linked_product']['class'], [ 'hide_if_package' ] );
        }

        if ( ! empty( $tabs['advanced'] ) ) {
            $tabs['advanced']['class'] = array_merge( $tabs['advanced']['class'], [ 'hide_if_package' ] );
        }

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_order_status_completed")
     */
    public static function order_completed( $order_id ) {
        $order = new WC_Order( $order_id );
        $package_id = self::get_order_package_id( $order_id );

        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'post_status'       => 'draft',
            'post_author'       => $order->get_user_id(),
            'meta_query'        => [
                [
                    'key'       => LISTING_MANAGER_LISTING_PREFIX . 'package',
                    'value'     => $package_id,
                    'type'      => 'NUMERIC',
                ],
                [
                    'key'       => LISTING_MANAGER_LISTING_PREFIX . 'package_order',
                    'value'     => '',
                    'compare'   => 'NOT EXISTS',
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

        foreach ( $query->posts as $post ) {
            if ( self::get_remaining_posts( $order_id ) > 0 ) {
                $post->post_status = 'publish';
                wp_update_post( $post );
                update_post_meta( $post->ID, LISTING_MANAGER_LISTING_PREFIX . 'package_order', $order_id );
            }
        }
    }

    /**
     * @Filter(name="woocommerce_add_cart_item_data", priority=10, accepted_args=3)
     */
    public static function force_one_package_in_cart( $cart_item_data, $product_id, $variation_id ) {
        $items = WC()->cart->get_cart();
        $counter = 0;

        // If we are adding the package into cart
        if ( is_object_in_term( $product_id, 'product_type', 'package' ) ) {
            foreach ( $items as $item ) {
                if ( is_object_in_term( $item['product_id'], 'product_type', 'package' ) ) {
                    $counter++;
                }

                if ( $counter > 0 ) {
                    throw new Exception(
                        esc_html__( 'You are not allowed to purchase more than one package in single order.', 'listing-manager' )
                    );
                }
            }
        }

        return $cart_item_data;
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
                jQuery('.options_group.pricing').addClass('show_if_package').show();
            });
        </script>
        <?php
    }

	/**
	 * @Action(name="wp_loaded")
	 */
    public static function extend_package() {
        global $woocommerce;

        if ( ! empty( $_GET['action'] ) && 'listing-manager-extend' === $_GET['action'] ) {
            if ( empty( $_GET['order-id'] ) || empty( $_GET['package-id'] ) ) {
                wc_add_notice( esc_html__( 'You are missing required attributes for extending the package.', 'listing-manager' ), 'error' );
            } else {
	            $woocommerce->cart->add_to_cart( $_GET['package-id'], 1, 0, [], [
		            'package_id'  => $_GET['package-id'],
		            'order_id'    => $_GET['order-id'],
	            ] );
            }

            wp_redirect( wc_get_cart_url() );
            die();
        }
    }

	/**
	 * @Filter(name="woocommerce_cart_item_name", priority=10, accepted_args=3)
	 */
	public static function set_cart_product_name( $product_name, $values, $cart_item_key ) {
		if ( ! empty( $values['order_id'] ) && ! empty( $values['package_id'] ) ) {
			$message = null;

            $message = sprintf( '<p>%s</p>',
                esc_attr__( 'Extending package', 'listing-manager' ) );

			return $product_name . $message;
		}

		return $product_name;
	}

	/**
	 * @Action(name="woocommerce_add_order_item_meta", priority=10, accepted_args=2)
	 */
	public static function set_order_meta_fields( $item_id, $values ) {
		if ( ! empty( $values['order_id'] ) ) {
			wc_add_order_item_meta( $item_id, '_order_id', $values['order_id']);
		}

		if ( ! empty( $values['package_id'] ) ) {
			wc_add_order_item_meta( $item_id, '_package_id', $values['package_id'] );
		}
	}

    /**
     * Gets template for packages
     *
     * @access public
     * @return string
     */
    public static function get_submission_packages() {
        echo wc_get_template_html(
            'listing-manager/listing-form-packages.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * Gets list of all available packages
     *
     * @access public
     * @return null|array
     */
    public static function get_packages() {
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

        if ( ! empty( $query->posts ) ) {
            return $query->posts;
        }

        return null;
    }

    /**
     * Gets the first package from an order
     *
     * @access public
     * @param int $order_id
     * @return mixed
     */
    public static function get_order_package_id( $order_id ) {
        $order = new WC_Order( $order_id );
        $items = $order->get_items();
        $package = array_shift( $items );
        return $package['product_id'];
    }

    /**
     * Gets purchased packages
     *
     * @access public
     * @return array
     */
    public static function get_purchased_packages( $user_id = null ) {
        if ( empty( $user_id ) ) {
            $user_id = get_current_user_id();
        }

        $purchased_packages = [];

        $orders = new WP_Query( [
            'posts_per_page'    => -1,
            'meta_key'          => '_customer_user',
            'meta_value'        => $user_id,
            'post_type'         => wc_get_order_types(),
            'post_status'       => 'wc-completed',
        ] );

        foreach ( $orders->posts as $post ) {
            $order = new WC_Order( $post->ID );
            $items = $order->get_items();

            foreach ( $items as $item ) {
                $product_types = get_the_terms( $item['product_id'], 'product_type' );
                $product_type = array_shift( $product_types );

                if ( 'package' === $product_type->slug ) {
	                $order_id = wc_get_order_item_meta( $item->get_id(), '_order_id', true );

                    if ( empty( $order_id ) ) {
	                    $purchased_packages[] = [
		                    'order_id'      => $post->ID,
		                    'product_id'    => $item['product_id'],
	                    ];
                    }
                }
            }
        }

        return $purchased_packages;
    }

    /**
     * Get WP_Query for order listings
     *
     * @access public
     * @param int $order_id
     * @return WP_Query
     */
    public static function get_listings_query_for_order( $order_id ) {
        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'meta_query'        => [
                [
                    'key'       => LISTING_MANAGER_LISTING_PREFIX . 'package_order',
                    'value'     => $order_id,
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

        return $query;
    }

    /**
     * Get listings which belongs to order
     *
     * @access public
     * @param int $order_id
     * @return array
     */
    public static function get_listings_for_order( $order_id ) {
        $query = self::get_listings_query_for_order( $order_id );
        return $query->posts;
    }

    /**
     * Gets number of listings per package in order
     *
     * @access public
     * @param int $order_id
     * @return int
     */
    public static function get_listing_count_for_order( $order_id ) {
        $query = self::get_listings_query_for_order( $order_id );
        return $query->post_count;
    }

    /**
     * Gets formatted duration value
     *
     * @access public
     * @param int|null $package_id
     * @return string
     */
    public static function get_duration_formatted( $package_id = null ) {
        if ( empty( $package_id ) ) {
            $package_id = get_the_ID();
        }

        $duration = get_post_meta( $package_id, LISTING_MANAGER_PACKAGE_PREFIX . 'duration', true );

        if ( 1 == $duration ) {
            return esc_html( $duration ) .  ' '.  esc_html__( 'day', 'listing-manager' );
        } elseif ( -1 == $duration ) {
            return esc_html__( 'Unlimited', 'listing-manager' );
        }

        return esc_html( $duration ) . ' ' . esc_html__( 'days', 'listing-manager' );
    }

    /**
     * Gets formatted expiration date
     *
     * @access public
     * @param $order_id
     * @param $package_id
     * @return string
     */
    public static function get_expiration_formatted( $order_id, $package_id ) {
        $duration = get_post_meta( $package_id, LISTING_MANAGER_PACKAGE_PREFIX . 'duration', true );

        if ( -1 == $duration ) {
            return esc_html__( 'Never expires.', 'listing-manager' );
        }

        if ( self::is_expired( $order_id, $package_id ) ) {
            return esc_html__( 'Package expired.', 'listing-manager' );
        }

	    $date_valid = self::get_expiration_timestamp( $order_id, $package_id );

	    $valid = new DateTime();
	    $valid->setTimestamp( $date_valid );
	    $diff = $valid->diff( new DateTime( 'now' ) );

        if ( 1 === $diff->days) {
	        return sprintf( '%s (%s day left)', date( get_option( 'date_format' ), $date_valid ), $diff->days );
        }

        return sprintf( '%s (%s days left)', date( get_option( 'date_format' ), $date_valid ), $diff->days );
    }

    public static function is_base_package( $order_id, $package_id ) {
	    $order = new WC_Order( $order_id );
	    $items = $order->get_items();

	    foreach ( $items as $item ) {
		    $product_types = get_the_terms( $item['product_id'], 'product_type' );
		    $product_type  = array_shift( $product_types );

		    if ( 'package' === $product_type->slug ) {
			    $order_parent = wc_get_order_item_meta( $item->get_id(), '_order_id', true );

			    if ( ! empty( $order_parent ) ) {
			        return false;
                }

		    }
	    }

	    return true;
    }

    public static function get_expiration_timestamp( $order_id, $package_id ) {
	    $date_valid = 0;

	    $extensions = new WP_Query( [
		    'posts_per_page'    => -1,
		    'post_type'         => wc_get_order_types(),
		    'post_status'       => 'wc-completed',
            'orderby'           => 'date',
            'order'             => 'ASC',
	    ] );


	    // If there are any extenstions
	    if ( ! empty( $extensions->posts ) ) {
		    // Go through all extensions
		    foreach ( $extensions->posts as $extension ) {
			    $order = new WC_Order( $extension->ID );
			    $items = $order->get_items();

			    foreach ( $items as $item ) {
				    $has_order_id = wc_get_order_item_meta( $item->get_id(), '_order_id', true );

				    // We found an order which extended our original order
				    if ( ! empty( $has_order_id ) && $order_id == $has_order_id ) {
					    $product_types = get_the_terms( $item['product_id'], 'product_type' );
					    $product_type  = array_shift( $product_types );

					    // Check if the product in order has proper product_type
					    if ( 'package' === $product_type->slug ) {
						    $duration = get_post_meta( $item['product_id'], LISTING_MANAGER_PACKAGE_PREFIX . 'duration', true );
                            $post_date = strtotime( get_post_field( 'post_date', $order->get_id() ) );

                            if ( 0 !== $date_valid && $post_date < $date_valid && $date_valid < strtotime( '+' . $duration . ' day', $post_date ) ) {
                                $date = strtotime( '+' . $duration . ' day', $date_valid );
                            } else {
	                            $date = strtotime( '+' . $duration . ' day', $post_date );
                            }

						    if ( $date > $date_valid ) {
							    $date_valid = $date;
						    }
					    }
				    }
			    }
		    }
	    }

	    // No extensions found so we can check original order
	    if ( 0 === $date_valid ) {
		    $duration = get_post_meta( $package_id, LISTING_MANAGER_PACKAGE_PREFIX . 'duration', true );
		    $order = get_post( $order_id );
		    $date_valid = strtotime( '+' . $duration . ' day', strtotime( $order->post_date ) );
	    }

	    return $date_valid;
    }

    /**
     * Checks if the package expired
     *
     * @access public
     * @param $order_id
     * @param $package_id
     * @return bool
     */
    public static function is_expired( $order_id, $package_id ) {
        $date_valid = self::get_expiration_timestamp( $order_id, $package_id );

        if ( time() > $date_valid ) {
            return true;
        }

        return false;
    }

	/**
	 * Checks if the package is going to expire
	 *
	 * @access public
	 * @param $order_id
	 * @param $package_id
	 * @return bool
	 */
    public static function is_going_to_expire( $order_id, $package_id ) {
	    $date_valid = self::get_expiration_timestamp( $order_id, $package_id );
        $hours = get_theme_mod( 'listing_manager_notifications_expiring', 48 );

	    if ( ( $date_valid - 60 * 60 * $hours ) < time() && time() < $date_valid ) {
		    return true;
	    }

	    return false;
    }

    /**
     * Gets remaining listings for post
     *
     * @access public
     * @param int $order_id
     * @return mixed
     */
    public static function get_remaining_posts( $order_id ) {
        $limit = get_post_meta( self::get_order_package_id( $order_id ), LISTING_MANAGER_PACKAGE_PREFIX . 'limit', true );

        // If there it is unlimited number of listings
        if ( -1 == $limit ) {
            return 99999;
        }

        return  $limit - self::get_listing_count_for_order( $order_id );
    }

    /**
     * Gets formatted limit value
     *
     * @access public
     * @param int|null $package_id
     * @return string
     */
    public static function get_limit_formatted( $package_id = null ) {
        if ( empty( $package_id ) ) {
            $package_id = get_the_ID();
        }

        $limit = get_post_meta( $package_id, LISTING_MANAGER_PACKAGE_PREFIX . 'limit', true );

        if ( 1 == $limit ) {
            return esc_html( $limit ) . ' ' . esc_html__( 'listing', 'listing-manager' );
        } elseif ( -1 == $limit ) {
            return esc_html__( 'Unlimited', 'listing-manager' );
        }

        return esc_html( $limit ) . ' ' . esc_html__( 'listings', 'listing-manager' );
    }
}