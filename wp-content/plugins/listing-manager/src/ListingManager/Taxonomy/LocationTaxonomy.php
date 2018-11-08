<?php

namespace ListingManager\Taxonomy;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class LocationTaxonomy {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'              => esc_html__( 'Locations', 'listing-manager' ),
            'singular_name'     => esc_html__( 'Location', 'listing-manager' ),
            'search_items'      => esc_html__( 'Search Location', 'listing-manager' ),
            'all_items'         => esc_html__( 'All Locations', 'listing-manager' ),
            'parent_item'       => esc_html__( 'Parent Location', 'listing-manager' ),
            'parent_item_colon' => esc_html__( 'Parent Location:', 'listing-manager' ),
            'edit_item'         => esc_html__( 'Edit Location', 'listing-manager' ),
            'update_itm'        => esc_html__( 'Update Location', 'listing-manager' ),
            'add_new_item'      => esc_html__( 'Add New Location', 'listing-manager' ),
            'new_item_name'     => esc_html__( 'New Location', 'listing-manager' ),
            'menu_name'         => esc_html__( 'Locations', 'listing-manager' ),
            'not_found'         => esc_html__( 'No locations found.', 'listing-manager' ),
        ];

        register_taxonomy( 'locations', 'product', [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => esc_html__( 'location', 'listing-manager' ), 'hierarchical' => true ],
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => false,
            'show_in_nav_menus' => true,
            'show_admin_column' => false,
        ] );
    }

    /**
     * @Action(name="parent_file")
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'locations' == $taxonomy ) {
            return 'listing-manager';
        }

        return $parent_file;
    }
}