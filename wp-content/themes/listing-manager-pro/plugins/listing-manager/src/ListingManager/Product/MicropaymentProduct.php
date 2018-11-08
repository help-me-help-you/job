<?php

namespace ListingManager\Product;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use WP_Query;

class MicropaymentProduct {
    /**
     * @Action(name="woocommerce_init")
     */
    public static function definition() {
        require_once LISTING_MANAGER_DIR . 'src/ListingManager/ProductType/MicropaymentProductType.php';
    }

	public static function product_class( $classname, $product_type, $post_type, $product_id ) {
		if ( 'micropayment' === $product_type ) {
			return 'Listing_Manager_Product_Type_Micropayment';
		}

		return $classname;
	}

    /**
     * @Filter(name="product_type_selector")
     */
    public static function product_types( $types ) {
        $types['micropayment'] = esc_html__( 'Micropayment', 'listing-manager' );
        return $types;
    }

    /**
     * @Filter(name="views_edit-product")
     */
    public static function add_action_filter( $view ) {
        global $wp_query;

        $title = esc_html__( 'Micropayments', 'listing-manager' );
        $class = ( isset( $wp_query->query['product_type'] ) && $wp_query->query['product_type'] == 'micropayment' ) ? 'current' : '';
        $query_string = remove_query_arg( [ 'post_status', ] );
        $query_string = add_query_arg( 'product_type', 'micropayment', $query_string );

        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'tax_query'         => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'micropayment',
                ],
            ],
        ] );

        $view['micropayments'] =
            sprintf( '<a href="%s" class="%s">%s <span class="count">(%s)</span></a>', esc_url( $query_string ), $class, $title, $query->post_count);
        return $view;
    }

    /**
     * @Filter(name="woocommerce_cart_item_name", priority=10, accepted_args=3)
     */
    public static function set_cart_product_name( $product_name, $values, $cart_item_key ) {
        if ( ! empty( $values['micropayment'] ) ) {
            $listing = get_post( $values['listing_id'] );
            $message = null;

            if ( 'feature' === $values['micropayment'] ) {
                $message = sprintf( '<p>%s <a href="%s">%s</a></p>',
                    esc_attr__( 'Featuring listing', 'listing-manager' ), get_permalink( $listing->ID ),  $listing->post_title );
            } elseif ( 'claim' === $values['micropayment'] ) {
                $message = sprintf( '<p>%s <a href="%s">%s</a></p>',
                    esc_attr__( 'Claim listing', 'listing-manager' ), get_permalink( $listing->ID ),  $listing->post_title );
            } elseif ( 'publish' === $values['micropayment'] ) {
                $message = sprintf( '<p>%s <a href="%s">%s</a></p>',
                    esc_attr__( 'Publish listing', 'listing-manager' ), get_permalink( $listing->ID ),  $listing->post_title );
            }


            return $product_name . $message;
        }

        return $product_name;
    }

    /**
     * @Action(name="woocommerce_add_order_item_meta", priority=10, accepted_args=2)
     */
    public static function set_order_meta_fields( $item_id, $values ) {
        if ( ! empty( $values['micropayment'] ) ) {
            wc_add_order_item_meta( $item_id, '_micropayment', $values['micropayment']);
        }

        if ( ! empty( $values['listing_id'] ) ) {
            wc_add_order_item_meta( $item_id, '_listing_id', $values['listing_id'] );
        }
    }

    /**
     * @Action(name="woocommerce_order_status_changed", priority=10, accepted_args=3)
     */
    public static function change_listing( $order_id, $old_status, $new_status ) {
        if ( 'completed' == $new_status ) {
            $order = wc_get_order( $order_id );

            foreach ( $order->get_items() as $item_id => $item ) {
                $micropayment = wc_get_order_item_meta( $item_id, '_micropayment', true );
                $listing_id = wc_get_order_item_meta( $item_id, '_listing_id', true );

                // Feature listing
                if ( ! empty( $micropayment ) && 'feature' == $micropayment ) {
                    update_post_meta( $listing_id, '_featured', 'yes' );
                }

                // Publish listing
                if ( ! empty( $micropayment ) && 'publish' == $micropayment ) {
                    wp_publish_post( $listing_id );
                }

                // Claim listing
                // It is not required to do any action because we will display order status in claims table
            }
        }
    }

    /**
     * @Filter(name="remove_quantity_field", priority=10, accepted_args=2)
     */
    public static function remove_quantity_field( $return, $product ) {
        if ( is_object_in_term( $product->get_id(), 'product_type', 'micropayment' ) ) {
            return true;
        }

        return $return;
    }

    /**
     * @Action(name="wp_loaded")
     */
    public static function process_feature() {
        global $woocommerce;

        if ( empty( $_GET['action'] ) || 'feature-listing' != $_GET['action'] || empty( $_GET['id'] ) ) {
            return;
        }

        $feature_id = get_theme_mod( 'listing_manager_micropayments_feature', null );

        if ( empty( $feature_id ) ) {
            return;
        }

        $woocommerce->cart->add_to_cart( $feature_id, 1, 0, [], [
            'micropayment' => 'feature',
            'listing_id'    => $_GET['id'],
        ] );

        wc_add_notice( wp_kses( __( 'Feature payment has been successfully added to cart.', 'listing-manager' ), wp_kses_allowed_html( 'post' ) ), 'success' );

        $redirect = home_url( '/' );
        $listing_list = get_theme_mod( 'listing_manager_pages_listing_list', null );

        if ( ! empty( $listing_list ) ) {
            $redirect = get_permalink( $listing_list );
        }

        wp_redirect( $redirect );
        exit();
    }

    /**
     * @Action(name="wp_loaded")
     */
    public static function process_publish() {
        global $woocommerce;

        if ( empty( $_GET['action'] ) || 'publish-listing' != $_GET['action'] || empty( $_GET['id'] ) ) {
            return;
        }

        $publish_id = get_theme_mod( 'listing_manager_micropayments_publish', null );

        if ( empty( $publish_id ) ) {
            return;
        }

        $woocommerce->cart->add_to_cart( $publish_id, 1, 0, [], [
            'micropayment' => 'publish',
            'listing_id'    => $_GET['id'],
        ] );

        wc_add_notice( wp_kses( __( 'Publish payment has been successfully added to cart.', 'listing-manager' ), wp_kses_allowed_html( 'post' ) ), 'success' );

        $redirect = home_url( '/' );
        $listing_list = get_theme_mod( 'listing_manager_pages_listing_list', null );

        if ( ! empty( $listing_list ) ) {
            $redirect = get_permalink( $listing_list );
        }

        wp_redirect( $redirect );
        exit();
    }

    /**
     * @Action(name="listing_manager_claim_form_saved")
     */
    public static function process_claim( $claim_id ) {
        global $woocommerce;
        $claim_micropayment_id = get_theme_mod( 'listing_manager_micropayments_claim', null );

        if ( empty( $claim_micropayment_id ) ) {
            return;
        }

        $woocommerce->cart->add_to_cart( $claim_micropayment_id, 1, 0, [], [
            'micropayment' => 'claim',
            'listing_id' => get_post_meta( $claim_id, LISTING_MANAGER_CLAIM_PREFIX . 'listing_id', true ),
        ] );

        wc_add_notice( wp_kses( __( 'Claim payment has been successfully added to cart.', 'listing-manager' ), wp_kses_allowed_html( 'post' ) ), 'success' );
    }

    /**
     * Get list of all micropayment products
     *
     * @access public
     * @return array
     */
    public static function get_all() {
        $result = [];
        $query = new WP_Query( [
            'post_type'         => 'product',
            'posts_per_page'    => -1,
            'tax_query'         => [
            	[
	                'taxonomy'      => 'product_type',
	                'field'         => 'slug',
	                'terms'         => [ 'micropayment', ],
	                'operator'	    => 'IN',
                ]
            ]
        ] );

        if ( ! empty( $query->posts ) && is_array( $query->posts ) && count( $query->posts ) > 0 ) {
            foreach( $query->posts as $post ) {
                $result[ $post->ID ] = $post->post_title;
            }
        }

        return $result;
    }
}