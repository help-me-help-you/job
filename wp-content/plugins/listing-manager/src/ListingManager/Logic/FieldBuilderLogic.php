<?php

namespace ListingManager\Logic;

use WP_Query;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class FieldBuilderLogic {
	/**
	 * @Filter(name="listing_manager_submission_forms")
	 */
	public static function add_forms( $labels ) {
		$query = new WP_Query( [
			'post_type'         => 'form',
			'posts_per_page'    => -1,
		] );

		foreach ( $query->posts as $form ) {
			$slug = get_post_meta( $form->ID, LISTING_MANAGER_FORM_PREFIX . 'slug', true );
			$title = get_post_meta( $form->ID, LISTING_MANAGER_FORM_PREFIX . 'title', true );
			$labels[ $slug ] = $title;
		}

		return $labels;
	}

	/**
	 * @Filter(name="listing_manager_submission_fields", priority=100)
	 */
	public static function add_fieldsets( $fields ) {
		$query = new WP_Query( [
			'post_type'         => 'fieldset',
			'posts_per_page'    => -1,
		] );

		foreach ( $query->posts as $fieldset ) {
			$forms = get_post_meta( $fieldset->ID, LISTING_MANAGER_FIELDSET_PREFIX . 'forms', true );
			$slug = get_post_meta( $fieldset->ID, LISTING_MANAGER_FIELDSET_PREFIX . 'slug', true );
			$legend = get_post_meta( $fieldset->ID, LISTING_MANAGER_FIELDSET_PREFIX . 'legend', true );

			$fields[] = [
				'forms'             => $forms,
				'type' 				=> 'fieldset',
				'id'                => $slug,
				'legend'            => $legend,
				'fields'			=> []
			];
		}

		return $fields;
	}

	/**
	 * @Filter(name="listing_manager_submission_fields", priority=110)
	 */
	public static function add_fields( $fields ) {
		$query = new WP_Query( [
			'post_type'         => 'field',
			'posts_per_page'    => -1,
		] );

		foreach ( $query->posts as $field ) {
			$fieldset = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'fieldset_id', true );
			$slug = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'slug', true );
			$label = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'label', true );
			$type = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'type', true );
			$taxonomy = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'taxonomy', true );
			$chained = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'taxonomy_chained', true );
			$multiple = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'taxonomy_multiple', true );			
			$required = get_post_meta( $field->ID, LISTING_MANAGER_FIELD_PREFIX . 'required', true );			

			foreach( $fields as $key => $value ) {
				if ( $fieldset === $fields[ $key ]['id'] ) {
					$args = [
						'id'        => $slug,
						'label'     => $label,
						'type'      => $type,
						'multiple'  => ( 'on' === $multiple ) ? true : false, 
						'chained'  => ( 'on' === $chained ) ? true : false, 
						'required'  => ( 'on' === $required ) ? true : false,
					];

					if ( ! empty( $taxonomy) ) {
						$args['taxonomy'] = $taxonomy;
					}

					$fields[ $key ]['fields'][] = $args;
				}
			}
		}

		return $fields;
	}
}