<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class ReportType {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'                  => esc_html__( 'Reports', 'listing-manager' ),
            'singular_name'         => esc_html__( 'Report', 'listing-manager' ),
            'add_new'               => esc_html__( 'Add New Report', 'listing-manager' ),
            'add_new_item'          => esc_html__( 'Add New Report', 'listing-manager' ),
            'edit_item'             => esc_html__( 'Edit Report', 'listing-manager' ),
            'new_item'              => esc_html__( 'New Report', 'listing-manager' ),
            'all_items'             => esc_html__( 'Reports', 'listing-manager' ),
            'view_item'             => esc_html__( 'View Report', 'listing-manager' ),
            'search_items'          => esc_html__( 'Search Report', 'listing-manager' ),
            'not_found'             => esc_html__( 'No Reports found', 'listing-manager' ),
            'not_found_in_trash'    => esc_html__( 'No Reports Found in Trash', 'listing-manager' ),
            'parent_item_colon'     => '',
            'menu_name'             => esc_html__( 'Reports', 'listing-manager' ),
        ];

        register_post_type( 'report', [
            'labels'            => $labels,
            'show_in_menu'	    => 'listing-manager',
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
        $metaboxes[ LISTING_MANAGER_REPORT_PREFIX . 'general' ] = [
            'id'              => LISTING_MANAGER_REPORT_PREFIX. 'general',
            'title'           => esc_html__( 'General Options', 'listing-manager' ),
            'object_types'    => [ 'report' ],
            'context'         => 'normal',
            'priority'        => 'high',
            'show_names'      => true,
            'fields'          => [
                [
                    'id'                => LISTING_MANAGER_REPORT_PREFIX . 'listing_id',
                    'name'              => esc_html__( 'Listing ID', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_REPORT_PREFIX . 'name',
                    'name'              => esc_html__( 'Name', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_REPORT_PREFIX . 'email',
                    'name'              => esc_html__( 'E-mail', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_REPORT_PREFIX . 'reason',
                    'name'              => esc_html__( 'Reason', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_REPORT_PREFIX . 'message',
                    'name'              => esc_html__( 'Messsage', 'listing-manager' ),
                    'type'              => 'textarea',
                ],
            ]
        ];

        return $metaboxes;
    }

    /**
     * @Filter(name="manage_edit-report_columns")
     */
    public static function custom_columns() {
        $fields = [
            'cb' 				=> '<input type="checkbox" />',
            'title' 		    => esc_html__( 'Title', 'listing-manager' ),
            'listing' 		    => esc_html__( 'Listing', 'listing-manager' ),
            'reason' 		    => esc_html__( 'Reason', 'listing-manager' ),
            'author' 			=> esc_html__( 'Author', 'listing-manager' ),
            'date' 			    => esc_html__( 'Date', 'listing-manager' ),
        ];
        return $fields;
    }

    /**
     * @Filter(name="manage_report_posts_custom_column")
     */
    public static function custom_columns_manage( $column ) {
        switch ( $column ) {
            case 'listing':
                $listing_id = get_post_meta( get_the_ID(), LISTING_MANAGER_REPORT_PREFIX . 'listing_id', true );
                echo get_the_title( $listing_id );
                break;
            case 'reason':
                $reason = get_post_meta( get_the_ID(), LISTING_MANAGER_REPORT_PREFIX . 'reason', true );
                echo $reason;
                break;
        }
    }
}