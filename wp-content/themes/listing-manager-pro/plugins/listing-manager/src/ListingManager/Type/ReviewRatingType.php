<?php

namespace ListingManager\Type;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class ReviewRatingType {
	/**
	 * @Action(name="init")
	 */
	public static function definition() {
		$labels = [
			'name'                  => esc_html__( 'Review Rating', 'listing-manager' ),
			'singular_name'         => esc_html__( 'Review Rating', 'listing-manager' ),
			'add_new'               => esc_html__( 'Add New Review Rating', 'listing-manager' ),
			'add_new_item'          => esc_html__( 'Add New Review Rating', 'listing-manager' ),
			'edit_item'             => esc_html__( 'Edit Review Rating', 'listing-manager' ),
			'new_item'              => esc_html__( 'New Review Rating', 'listing-manager' ),
			'all_items'             => esc_html__( 'Review Ratings', 'listing-manager' ),
			'view_item'             => esc_html__( 'View Review Rating', 'listing-manager' ),
			'search_items'          => esc_html__( 'Search Review Rating', 'listing-manager' ),
			'not_found'             => esc_html__( 'No Review Ratings found', 'listing-manager' ),
			'not_found_in_trash'    => esc_html__( 'No Review Ratings Found in Trash', 'listing-manager' ),
			'parent_item_colon'     => '',
			'menu_name'             => esc_html__( 'Review Ratings', 'listing-manager' ),
		];

		register_post_type( 'review_rating', [
			'labels'            => $labels,
			'show_in_menu'	    => 'listing-manager',
			'supports'          => [ 'title', 'author' ],
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
		$metaboxes[ LISTING_MANAGER_REVIEW_PREFIX . 'general' ] = [
			'id'              => LISTING_MANAGER_REVIEW_PREFIX. 'general',
			'title'           => esc_html__( 'General Options', 'listing-manager' ),
			'object_types'    => [ 'review_rating' ],
			'context'         => 'normal',
			'priority'        => 'high',
			'show_names'      => true,
			'fields'          => [
				[
					'id'                => LISTING_MANAGER_REVIEW_PREFIX . 'id',
					'name'              => esc_html__( 'ID', 'listing-manager' ),
					'type'              => 'text',
				],
				[
					'id'                => LISTING_MANAGER_REVIEW_PREFIX . 'title',
					'name'              => esc_html__( 'Title', 'listing-manager' ),
					'type'              => 'text',
				],
				[
					'id'                => LISTING_MANAGER_REVIEW_PREFIX . 'max',
					'name'              => esc_html__( 'No. of stars', 'listing-manager' ),
					'type'              => 'text',

				],
				[
					'id'                => LISTING_MANAGER_REVIEW_PREFIX . 'required',
					'name'              => esc_html__( 'Required', 'listing-manager' ),
					'type'              => 'checkbox',
				],
			]
		];

		return $metaboxes;
	}
}