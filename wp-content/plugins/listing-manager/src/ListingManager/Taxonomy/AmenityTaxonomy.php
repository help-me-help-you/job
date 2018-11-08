<?php

namespace ListingManager\Taxonomy;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class AmenityTaxonomy {
    /**
     * @Action(name="init", priority=12)
     */
    public static function definition() {
        $labels = [
            'name'              => esc_html__( 'Amenities', 'listing-manager' ),
            'singular_name'     => esc_html__( 'Amenity', 'listing-manager' ),
            'search_items'      => esc_html__( 'Search Amenity', 'listing-manager' ),
            'all_items'         => esc_html__( 'All Amenities', 'listing-manager' ),
            'parent_item'       => esc_html__( 'Parent Amenity', 'listing-manager' ),
            'parent_item_colon' => esc_html__( 'Parent Amenity:', 'listing-manager' ),
            'edit_item'         => esc_html__( 'Edit Amenity', 'listing-manager' ),
            'update_itm'        => esc_html__( 'Update Amenity', 'listing-manager' ),
            'add_new_item'      => esc_html__( 'Add New Amenity', 'listing-manager' ),
            'new_item_name'     => esc_html__( 'New Amenity', 'listing-manager' ),
            'menu_name'         => esc_html__( 'Amenities', 'listing-manager' ),
            'not_found'         => esc_html__( 'No amenities found.', 'listing-manager' ),
        ];

        register_taxonomy( 'amenities', 'product', [
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => true,
            'rewrite'           => [ 'slug' => esc_html__( 'amenity', 'listing-manager' ) ],
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

        if ( 'amenities' == $taxonomy ) {
            return 'listing-manager';
        }

        return $parent_file;
    }

	/**
	 * @Action(name="cmb2_admin_init")
	 */
	public static function fields() {
		$cmb = new_cmb2_box( [
			'id'               => 'amenities_font_icon',
			'title'            => esc_html__( 'Font Icon', 'listing-manager' ),
			'object_types'     => [ 'term' ],
			'taxonomies'       => [ 'amenities' ],
			'new_term_section' => true,
		] );

		$cmb->add_field( [
			'id'                => 'font_icon',
			'name'              => esc_html__( 'Font Icon', 'listing-manager' ),
			'desc'              => esc_html__( 'Example: &lt;i class="fa fa-home"&gt;&lt;/i&gt;', 'listing-manager' ),
			'type'              => 'text',
			'sanitization_cb'   => [ __CLASS__, 'sanitize' ],
		] );
	}

	public static function sanitize( $value, $field_args, $field ) {
		return $value;
	}

	/**
	 * @Action(name="listing_manager_amenities_title_before")
	 */
	public static function add_font_icon( $term ) {
		$font_icon = get_term_meta( $term->term_id, 'font_icon', true );

		if ( ! empty( $font_icon ) ) {
			echo $font_icon;
		}
	}
}