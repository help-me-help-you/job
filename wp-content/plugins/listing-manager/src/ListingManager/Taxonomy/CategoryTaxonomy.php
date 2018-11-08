<?php

namespace ListingManager\Taxonomy;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class CategoryTaxonomy {
	/**
	 * @Action(name="cmb2_admin_init")
	 */
	public static function fields() {
		$cmb = new_cmb2_box( [
			'id'               => 'product_font_icon',
			'title'            => esc_html__( 'Font Icon', 'listing-manager' ),
			'object_types'     => [ 'term' ],
			'taxonomies'       => [ 'product_cat' ],
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
	 * @Action(name="listing_manager_categories_parent_item_title_before")
	 */
	public static function add_font_icon( $term ) {
		$font_icon = get_term_meta( $term->term_id, 'font_icon', true );

		if ( ! empty( $font_icon ) ) {
			echo $font_icon;
		}
	}
}