<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class FormType {
	/**
	 * @Action(name="init")
	 */
	public static function definition() {
		$labels = [
			'name'                  => esc_html__( 'Forms', 'listing-manager' ),
			'singular_name'         => esc_html__( 'Form', 'listing-manager' ),
			'add_new'               => esc_html__( 'Add New Form', 'listing-manager' ),
			'add_new_item'          => esc_html__( 'Add New Form', 'listing-manager' ),
			'edit_item'             => esc_html__( 'Edit Form', 'listing-manager' ),
			'new_item'              => esc_html__( 'New Form', 'listing-manager' ),
			'all_items'             => esc_html__( 'Forms', 'listing-manager' ),
			'view_item'             => esc_html__( 'View Form', 'listing-manager' ),
			'search_items'          => esc_html__( 'Search Form', 'listing-manager' ),
			'not_found'             => esc_html__( 'No Forms found', 'listing-manager' ),
			'not_found_in_trash'    => esc_html__( 'No Forms Found in Trash', 'listing-manager' ),
			'parent_item_colon'     => '',
			'menu_name'             => esc_html__( 'Forms', 'listing-manager' ),
		];

		register_post_type( 'form', [
			'labels'            => $labels,
			'show_in_menu'	    => 'listing-manager',
			'supports'          => [ 'title', ],
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
		$metaboxes[ LISTING_MANAGER_FORM_PREFIX . 'general' ] = [
			'id'              => LISTING_MANAGER_FORM_PREFIX. 'general',
			'title'           => esc_html__( 'General Options', 'listing-manager' ),
			'object_types'    => [ 'form', ],
			'context'         => 'normal',
			'priority'        => 'high',
			'show_names'      => true,
			'fields'          => [
				[
					'id'        => LISTING_MANAGER_FORM_PREFIX . 'slug',
					'name'     => esc_html__( 'Slug', 'listing-manager' ),
					'type'      => 'text',
				],
				[
					'id'        => LISTING_MANAGER_FORM_PREFIX . 'title',
					'name'     => esc_html__( 'Title', 'listing-manager' ),
					'type'      => 'text',
				],
			]
		];

		return $metaboxes;
	}
}