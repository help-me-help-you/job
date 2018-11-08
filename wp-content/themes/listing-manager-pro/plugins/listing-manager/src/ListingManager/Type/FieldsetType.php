<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class FieldsetType {
	/**
	 * @Action(name="init")
	 */
	public static function definition() {
		$labels = [
			'name'                  => esc_html__( 'Fieldsets', 'listing-manager' ),
			'singular_name'         => esc_html__( 'Fieldset', 'listing-manager' ),
			'add_new'               => esc_html__( 'Add New Fieldset', 'listing-manager' ),
			'add_new_item'          => esc_html__( 'Add New Fieldset', 'listing-manager' ),
			'edit_item'             => esc_html__( 'Edit Fieldset', 'listing-manager' ),
			'new_item'              => esc_html__( 'New Fieldset', 'listing-manager' ),
			'all_items'             => esc_html__( 'Fieldsets', 'listing-manager' ),
			'view_item'             => esc_html__( 'View Fieldset', 'listing-manager' ),
			'search_items'          => esc_html__( 'Search Fieldset', 'listing-manager' ),
			'not_found'             => esc_html__( 'No Fieldsets found', 'listing-manager' ),
			'not_found_in_trash'    => esc_html__( 'No Fieldsets Found in Trash', 'listing-manager' ),
			'parent_item_colon'     => '',
			'menu_name'             => esc_html__( 'Fieldsets', 'listing-manager' ),
		];

		register_post_type( 'fieldset', [
			'labels'            => $labels,
			'show_in_menu'	    => 'listing-manager',
			'supports'          => [ 'title' ],
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
		$forms = \ListingManager\Logic\SubmissionLogic::get_submission_forms();

		$metaboxes[ LISTING_MANAGER_FIELDSET_PREFIX . 'general' ] = [
			'id'                        => LISTING_MANAGER_FIELDSET_PREFIX. 'general',
			'title'                     => esc_html__( 'General Options', 'listing-manager' ),
			'object_types'              => [ 'fieldset' ],
			'context'                   => 'normal',
			'priority'                  => 'high',
			'show_names'                => true,
			'fields'                    => [
				[
					'id'                => LISTING_MANAGER_FIELDSET_PREFIX . 'slug',
					'name'              => esc_html__( 'Slug', 'listing-manager' ),
					'type'              => 'text',
				],
				[
					'id'                => LISTING_MANAGER_FIELDSET_PREFIX . 'legend',
					'name'              => esc_html__( 'Legend', 'listing-manager' ),
					'type'              => 'text',
				],
				[
					'id'                => LISTING_MANAGER_FIELDSET_PREFIX . 'forms',
					'name'              => esc_html__( 'Forms', 'listing-manager' ),
					'type'              => 'multicheck',
					'select_all_button' => false,
					'options'           => $forms
				],
			]
		];

		return $metaboxes;
	}
}