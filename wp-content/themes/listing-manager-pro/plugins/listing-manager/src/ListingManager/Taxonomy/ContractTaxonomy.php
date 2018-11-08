<?php

namespace ListingManager\Taxonomy;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class ContractTaxonomy {
    /**
     * @Action(name="init")
     */
    public static function definition() {
        $labels = [
            'name'              => esc_html__( 'Contracts', 'listing-manager' ),
            'singular_name'     => esc_html__( 'Contract', 'listing-manager' ),
            'search_items'      => esc_html__( 'Search Contract', 'listing-manager' ),
            'all_items'         => esc_html__( 'All Contracts', 'listing-manager' ),
            'parent_item'       => esc_html__( 'Parent Contract', 'listing-manager' ),
            'parent_item_colon' => esc_html__( 'Parent Contract:', 'listing-manager' ),
            'edit_item'         => esc_html__( 'Edit Contract', 'listing-manager' ),
            'update_itm'        => esc_html__( 'Update Contract', 'listing-manager' ),
            'add_new_item'      => esc_html__( 'Add New Contract', 'listing-manager' ),
            'new_item_name'     => esc_html__( 'New Contract', 'listing-manager' ),
            'menu_name'         => esc_html__( 'Contracts', 'listing-manager' ),
            'not_found'         => esc_html__( 'No contracts found.', 'listing-manager' ),
        ];

        register_taxonomy( 'contracts', 'product', [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => esc_html__( 'contract', 'listing-manager' ), 'hierarchical' => false ],
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

        if ( 'contracts' == $taxonomy ) {
            return 'listing-manager';
        }

        return $parent_file;
    }
}