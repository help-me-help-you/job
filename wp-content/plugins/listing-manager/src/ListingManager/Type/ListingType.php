<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use ListingManager\Utilities;

class ListingType {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'                  => esc_html__( 'Listings', 'listing-manager' ),
            'singular_name'         => esc_html__( 'Listing', 'listing-manager' ),
            'add_new'               => esc_html__( 'Add New Listing', 'listing-manager' ),
            'add_new_item'          => esc_html__( 'Add New Listing', 'listing-manager' ),
            'edit_item'             => esc_html__( 'Edit Listing', 'listing-manager' ),
            'new_item'              => esc_html__( 'New Listing', 'listing-manager' ),
            'all_items'             => esc_html__( 'Listings', 'listing-manager' ),
            'view_item'             => esc_html__( 'View Listing', 'listing-manager' ),
            'search_items'          => esc_html__( 'Search Listing', 'listing-manager' ),
            'not_found'             => esc_html__( 'No Listings found', 'listing-manager' ),
            'not_found_in_trash'    => esc_html__( 'No Listings Found in Trash', 'listing-manager' ),
            'parent_item_colon'     => '',
            'menu_name'             => esc_html__( 'Listings', 'listing-manager' ),
        ];

        $args = [
            'labels'            	=> $labels,
            'supports'          	=> [],
            'public'            	=> true,
            'capability_type'   	=> 'product',
            'map_meta_cap'        	=> true,
            'publicly_queryable'  	=> true,
            'exclude_from_search' 	=> true,
            'hierarchical'        	=> false,
            'has_archive'       	=> ( $listings_uri = get_theme_mod( 'listing_manager_pages_listings', null ) ) ? $listings_uri : esc_html__( 'listings', 'listing-manager' ),
            'show_ui'           	=> false,
            'query_var'           	=> true,
            'categories'        	=> [],
            'show_in_nav_menus'   	=> false,
        ];

        register_post_type( 'listing', $args );
    }

    /**
     * @Filter(name="woocommerce_page_title")
     */
    public static function title( $page_title ) {
        $custom_title = get_theme_mod( 'listing_manager_pages_listings_title', null );

        if ( Utilities::is_listing_archive() && ! empty( $custom_title ) ) {
            return esc_html__( $custom_title );
        }

        return $page_title;
    }

    /**
     * @Filter(name="document_title_parts")
     */
    public static function page_title( $title ) {
        $custom_title = get_theme_mod( 'listing_manager_pages_listings_title', null );

        if ( Utilities::is_listing_archive() && ! empty( $custom_title ) ) {
            $title['title'] = esc_html( $custom_title );
        }

        return $title;
    }

	/**
	 * Loads into main loop products with product type listing
	 *
	 * @return void
	 */
    public static function query() {        
        $args = [
            'post_type' 		=> 'product',
            'paged'				=> ( get_query_var('paged') ) ? get_query_var('paged') : 1,
            'tax_query' 		=> [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => [ 'listing' ],
                    'operator'	=> 'IN',
                ],
            ],
        ];

        query_posts( $args );
    }

	/**
	 * Simple helper for resseting main loop
	 *
	 * @return void
	 */
    public static function reset_query() {
        wp_reset_query();
    }
}