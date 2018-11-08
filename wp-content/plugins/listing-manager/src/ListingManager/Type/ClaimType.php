<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class ClaimType {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'                  => esc_html__( 'Claims', 'listing-manager' ),
            'singular_name'         => esc_html__( 'Claim', 'listing-manager' ),
            'add_new'               => esc_html__( 'Add New Claim', 'listing-manager' ),
            'add_new_item'          => esc_html__( 'Add New Claim', 'listing-manager' ),
            'edit_item'             => esc_html__( 'Edit Claim', 'listing-manager' ),
            'new_item'              => esc_html__( 'New Claim', 'listing-manager' ),
            'all_items'             => esc_html__( 'Claims', 'listing-manager' ),
            'view_item'             => esc_html__( 'View Claim', 'listing-manager' ),
            'search_items'          => esc_html__( 'Search Claim', 'listing-manager' ),
            'not_found'             => esc_html__( 'No Claims found', 'listing-manager' ),
            'not_found_in_trash'    => esc_html__( 'No Claims Found in Trash', 'listing-manager' ),
            'parent_item_colon'     => '',
            'menu_name'             => esc_html__( 'Claims', 'listing-manager' ),
        ];

        register_post_type( 'claim', [
            'labels'            => $labels,
            'show_in_menu'      => 'listing-manager',
            'supports'          => [ 'author' ],
            'public'            => false,
            'has_archive'       => false,
            'show_ui'           => true,
            'categories'        => [],
        ] );
    }

    /**
     * @Filter(name="cmb2_meta_boxes")
     */
    public static function fields( array $metaboxes ) {
        $metaboxes[ LISTING_MANAGER_CLAIM_PREFIX . 'general' ] = [
            'id'              => LISTING_MANAGER_CLAIM_PREFIX. 'general',
            'title'           => esc_html__( 'General Options', 'listing-manager' ),
            'object_types'    => [ 'claim' ],
            'context'         => 'normal',
            'priority'        => 'high',
            'show_names'      => true,
            'fields'          => [
                [
                    'id'                => LISTING_MANAGER_CLAIM_PREFIX . 'listing_id',
                    'name'              => esc_html__( 'Listing ID', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_CLAIM_PREFIX . 'name',
                    'name'              => esc_html__( 'Name', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_CLAIM_PREFIX . 'email',
                    'name'              => esc_html__( 'E-mail', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_CLAIM_PREFIX . 'phone',
                    'name'              => esc_html__( 'Phone', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_CLAIM_PREFIX . 'message',
                    'name'              => esc_html__( 'Messsage', 'listing-manager' ),
                    'type'              => 'textarea',
                ],
            ]
        ];

        return $metaboxes;
    }

    /**
     * @Filter(name="manage_edit-claim_columns")
     */
    public static function custom_columns() {
        return [
            'cb' 				=> '<input type="checkbox" />',
            'title' 		    => esc_html__( 'Title', 'listing-manager' ),
            'listing' 		    => esc_html__( 'Listing', 'listing-manager' ),
            'payment' 		    => esc_html__( 'Payment', 'listing-manager' ),
            'author' 			=> esc_html__( 'Author', 'listing-manager' ),
            'date' 			    => esc_html__( 'Date', 'listing-manager' ),
        ];
    }

    /**
     * @Action(name="manage_claim_posts_custom_column")
     */
    public static function custom_columns_manage( $column ) {
        switch ( $column ) {
            case 'listing':
                $listing_id = get_post_meta( get_the_ID(), LISTING_MANAGER_CLAIM_PREFIX . 'listing_id', true );
                echo get_the_title($listing_id);
                break;
            case 'payment':
                $current_listing_id = get_post_meta( get_the_ID(), LISTING_MANAGER_CLAIM_PREFIX . 'listing_id', true );
                $found = false;
                $orders = wc_get_orders( [ 'posts_per_page' => -1 ] );

                foreach ($orders as $order) {
                    foreach ( $order->get_items() as $item_id => $item ) {
                        $micropayment = wc_get_order_item_meta( $item_id, '_micropayment', true );
                        $listing_id = wc_get_order_item_meta( $item_id, '_listing_id', true );

                        if ( ! empty( $micropayment ) && 'claim' == $micropayment && $listing_id == $current_listing_id ) {
                            echo sprintf( '%s - %s', esc_attr__( 'Order found', 'listing-manager'), $order->status );
                            $found = true;
                            break;
                        }
                    }
                }

                if ( ! $found ) {
                    echo esc_attr__( 'Order not found', 'listing-manager' );
                }

                break;
        }
    }
}