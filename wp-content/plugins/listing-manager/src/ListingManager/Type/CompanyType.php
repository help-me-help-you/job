<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class CompanyType {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'                  => esc_html__( 'Companies', 'listing-manager' ),
            'singular_name'         => esc_html__( 'Company', 'listing-manager' ),
            'add_new'               => esc_html__( 'Add New Company', 'listing-manager' ),
            'add_new_item'          => esc_html__( 'Add New Company', 'listing-manager' ),
            'edit_item'             => esc_html__( 'Edit Company', 'listing-manager' ),
            'new_item'              => esc_html__( 'New Company', 'listing-manager' ),
            'all_items'             => esc_html__( 'Companies', 'listing-manager' ),
            'view_item'             => esc_html__( 'View Company', 'listing-manager' ),
            'search_items'          => esc_html__( 'Search Company', 'listing-manager' ),
            'not_found'             => esc_html__( 'No Companies found', 'listing-manager' ),
            'not_found_in_trash'    => esc_html__( 'No Companies Found in Trash', 'listing-manager' ),
            'parent_item_colon'     => '',
            'menu_name'             => esc_html__( 'Companies', 'listing-manager' ),
        ];

        register_post_type( 'company', [
            'labels'            => $labels,
            'show_in_menu'      => 'listing-manager',
            'supports'          => [ 'title', 'editor', 'thumbnail', 'author' ],
            'public'            => true,
            'has_archive'       => true,
            'show_ui'           => true,
            'rewrite'       	=> [ 'slug' => esc_attr__( 'companies', 'listing-manager' ) ],
            'categories'        => [],
        ] );
    }

    /**
     * @Filter(name="cmb2_meta_boxes")
     */
    public static function fields( array $metaboxes ) {
        $metaboxes[ LISTING_MANAGER_COMPANY_PREFIX . 'general' ] = [
            'id'              => LISTING_MANAGER_COMPANY_PREFIX. 'general',
            'title'           => esc_html__( 'General Options', 'listing-manager' ),
            'object_types'    => [ 'company' ],
            'context'         => 'normal',
            'priority'        => 'high',
            'show_names'      => true,
            'fields'          => [
                [
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'email',
                    'name'              => esc_html__( 'E-mail', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'web',
                    'name'              => esc_html__( 'Web', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'phone',
                    'name'              => esc_html__( 'Phone', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'address',
                    'name'              => esc_html__( 'Address', 'listing-manager' ),
                    'type'              => 'textarea',
                ],
                [
                    'name'              => esc_html__( 'Facebook', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'social_facebook',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'Twitter', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'social_twitter',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'LinkedIn', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'social_linkedin',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'Google', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_COMPANY_PREFIX . 'social_google',
                    'type'              => 'text',
                ],
            ]
        ];

        return $metaboxes;
    }
}