<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use ListingManager\Logic\SubmissionLogic;

class FieldType {
	/**
	 * @Action(name="init")
	 */
	public static function definition() {
		$labels = [
			'name'                  => esc_html__( 'Fields', 'listing-manager' ),
			'singular_name'         => esc_html__( 'Field', 'listing-manager' ),
			'add_new'               => esc_html__( 'Add New Field', 'listing-manager' ),
			'add_new_item'          => esc_html__( 'Add New Field', 'listing-manager' ),
			'edit_item'             => esc_html__( 'Edit Field', 'listing-manager' ),
			'new_item'              => esc_html__( 'New Field', 'listing-manager' ),
			'all_items'             => esc_html__( 'Fields', 'listing-manager' ),
			'view_item'             => esc_html__( 'View Field', 'listing-manager' ),
			'search_items'          => esc_html__( 'Search Field', 'listing-manager' ),
			'not_found'             => esc_html__( 'No Fields found', 'listing-manager' ),
			'not_found_in_trash'    => esc_html__( 'No Fields Found in Trash', 'listing-manager' ),
			'parent_item_colon'     => '',
			'menu_name'             => esc_html__( 'Fields', 'listing-manager' ),
		];

		register_post_type( 'field', [
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
		$taxonomies = [];
		foreach ( get_taxonomies() as $key => $value ) {
			$taxonomy           = get_taxonomy( $key );
			$taxonomies[ $key ] = $taxonomy->labels->name . ' (' . $key . ')';
		}

		$fieldsets = [];
		foreach ( SubmissionLogic::get_fields() as $field ) {
			if ( 'fieldset' === $field['type'] ) {
				$legend = $field['legend'];

				if ( ! empty( $field['forms'] ) ) {
					$legend .= ' (' . implode( ', ', $field['forms'] ) . ')';
				} else {
					$legend .= ' (' . esc_html__( 'Undefined', 'listing-manager' ) . ')';
				}

				$fieldsets[ $field['id'] ] = $legend ;
			}
		}

		$slug_description = sprintf(
			'Please make sure that slug starts with prefix <strong>%s</strong> otherwise it will be NOT saved. Exceptions: %s',
			LISTING_MANAGER_LISTING_PREFIX,
			'post_title, post_content, featured_image, _product_image_gallery, _regular_price, _sale_price' );

		$metaboxes[ LISTING_MANAGER_FIELD_PREFIX . 'general' ] = [
			'id'              => LISTING_MANAGER_FIELD_PREFIX. 'general',
			'title'           => esc_html__( 'General Options', 'listing-manager' ),
			'object_types'    => [ 'field', ],
			'context'         => 'normal',
			'priority'        => 'high',
			'show_names'      => true,
			'fields'          => [
				[
					'name'              => esc_html__( 'Fieldset', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX . 'fieldset_id',
					'type'              => 'select',
					'options'           => $fieldsets,
				],
				[
					'name'              => esc_html__( 'Label', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'label',
					'type'              => 'text',
				],
				[
					'name'              => esc_html__( 'Slug', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'slug',
					'type'              => 'text',
					'description'       => wp_kses( __( $slug_description, 'listing-manager' ), wp_kses_allowed_html( 'post' ) ),
				],
				[
					'name'              => esc_html__( 'Required', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'required',
					'type'              => 'checkbox',
				],
                [
                    'name'              => esc_html__( 'Show in custom field', 'listing-manager' ),
                    'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'show_custom_field',
                    'type'              => 'checkbox',
                    'description'       => esc_html__( 'When selected field value will appear in custom fields widget or shortcode.', 'listing-manager' ),
                ],
				[
					'name'              => esc_html__( 'Type', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'type',
					'type'              => 'select',
					'select_all_button' => false,
					'options'           => [
						'text'          => esc_html__( 'Text', 'listing_manager' ),
						'email'         => esc_html__( 'E-mail', 'listing_manager' ),
						'url'           => esc_html__( 'URL', 'listing_manager' ),
						'date'          => esc_html__( 'Date', 'listing_manager' ),
						'time'          => esc_html__( 'Time', 'listing_manager' ),
						'textarea'      => esc_html__( 'Textarea', 'listing_manager' ),
						'taxonomy'      => esc_html__( 'Taxonomy', 'listing_manager' ),
						'file'          => esc_html__( 'File', 'listing_manager' ),
						'files'         => esc_html__( 'Files', 'listing_manager' ),
						'google-map'    => esc_html__( 'Google Map', 'listing_manager' ),
						'opening-hours' => esc_html__( 'Opening Hours', 'listing_manager' ),
					],
				],
				[
					'name'              => esc_html__( 'Taxonomy', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'taxonomy',
					'type'              => 'select',
					'show_option_none'  => true,
					'options'           => $taxonomies
				],
				[
					'name'              => esc_html__( 'Chained Taxonomy', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'taxonomy_chained',
					'type'              => 'checkbox',
					'description'       => esc_html__( 'Max depth is 3 levels.', 'listing-manager' ),
				],
				[
					'name'              => esc_html__( 'Multiple Taxonomy', 'listing-manager' ),
					'id'                => LISTING_MANAGER_FIELD_PREFIX  . 'taxonomy_multiple',
					'type'              => 'checkbox',
					'description'       => esc_html__( 'Display select tag with "multiple". Does not apply on chained selects.', 'listing-manager' ),
				],								
			]
		];

		return $metaboxes;
	}
}