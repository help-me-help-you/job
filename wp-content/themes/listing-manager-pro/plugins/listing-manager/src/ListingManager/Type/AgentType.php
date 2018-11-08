<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

use WP_Query;

class AgentType {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'                  => esc_html__( 'Agents', 'listing-manager' ),
            'singular_name'         => esc_html__( 'Agent', 'listing-manager' ),
            'add_new'               => esc_html__( 'Add New Agent', 'listing-manager' ),
            'add_new_item'          => esc_html__( 'Add New Agent', 'listing-manager' ),
            'edit_item'             => esc_html__( 'Edit Agent', 'listing-manager' ),
            'new_item'              => esc_html__( 'New Agent', 'listing-manager' ),
            'all_items'             => esc_html__( 'Agents', 'listing-manager' ),
            'view_item'             => esc_html__( 'View Agent', 'listing-manager' ),
            'search_items'          => esc_html__( 'Search Agent', 'listing-manager' ),
            'not_found'             => esc_html__( 'No Agents found', 'listing-manager' ),
            'not_found_in_trash'    => esc_html__( 'No Agents Found in Trash', 'listing-manager' ),
            'parent_item_colon'     => '',
            'menu_name'             => esc_html__( 'Agents', 'listing-manager' ),
        ];

        register_post_type( 'agent', [
            'labels'            => $labels,
            'show_in_menu'      => 'listing-manager',
            'supports'          => [ 'title', 'editor', 'thumbnail', 'author' ],
            'public'            => true,
            'has_archive'       => true,
            'show_ui'           => true,
            'rewrite'       	=> [ 'slug' => esc_attr__( 'agents', 'listing-manager' ) ],
            'categories'        => [],
        ] );
    }

    /**
     * @Filter(name="cmb2_meta_boxes")
     */
    public static function fields( array $metaboxes ) {
        $companies = [];
        $companies_objects = new WP_Query( [
            'post_type' 		=> 'company',
            'posts_per_page'	=> -1,
        ] );

        if ( ! empty( $companies_objects->posts ) && is_array( $companies_objects->posts ) ) {
            foreach ( $companies_objects->posts as $object ) {
                $companies[ $object->ID ] = $object->post_title;
            }
        }

        $metaboxes[ LISTING_MANAGER_AGENT_PREFIX . 'general' ] = [
            'id'              => LISTING_MANAGER_AGENT_PREFIX. 'general',
            'title'           => esc_html__( 'General Options', 'listing-manager' ),
            'object_types'    => [ 'agent' ],
            'context'         => 'normal',
            'priority'        => 'high',
            'show_names'      => true,
            'fields'          => [
                [
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'email',
                    'name'              => esc_html__( 'E-mail', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'web',
                    'name'              => esc_html__( 'Web', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'phone',
                    'name'              => esc_html__( 'Phone', 'listing-manager' ),
                    'type'              => 'text',
                ],
                [
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'address',
                    'name'              => esc_html__( 'Address', 'listing-manager' ),
                    'type'              => 'textarea',
                ],
                [
                    'name'              => esc_html__( 'Companies', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'companies',
                    'type'              => 'multicheck',
                    'options'           => $companies,
                ],
                [
                    'name'              => esc_html__( 'Facebook', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'social_facebook',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'Twitter', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'social_twitter',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'Facebook', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'social_facebook',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'LinkedIn', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'social_linkedin',
                    'type'              => 'text',
                ],
                [
                    'name'              => esc_html__( 'Google', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_AGENT_PREFIX . 'social_google',
                    'type'              => 'text',
                ],
            ]
        ];

        return $metaboxes;
    }
}