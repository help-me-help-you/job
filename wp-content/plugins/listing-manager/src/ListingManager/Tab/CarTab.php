<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class CarTab {
	/**
	 * @Filter(name="woocommerce_product_data_tabs")
	 */
	public static function tab( $tabs ) {
		$tabs['car'] = [
			'label'		=> esc_html__( 'Car', 'listing-manager' ),
			'target'	=> 'car',
			'class'		=> [ 'show_if_listing' ],
		];

		return $tabs;
	}

	/**
	 * @Action(name="woocommerce_product_data_panels")
	 */
	public static function panel() {
		wc_get_template( 'listing-manager/panels/car.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}

	/**
	 * @Action(name="woocommerce_process_product_meta_listing")
	 */
	public static function save( $post_id ) {
		$info = self::product_tab_info();
		$fields = $info['fields'];

		foreach ( $fields as $field ) {
			$id = LISTING_MANAGER_LISTING_PREFIX . 'car_' . $field;
			if ( isset( $_POST[ $id ] ) ) {
				update_post_meta( $post_id, $id, sanitize_text_field( $_POST[ $id ] ) );
			}
		}
	}

	/**
	 * @Filter(name="listing_manager_submission_fields")
	 */
	public static function front_fields( $fields ) {
		$fields[] = [
			'forms'             => ['car', ],
			'type'              => 'fieldset',
			'id'                => 'car',
			'legend'            => esc_html__( 'Car', 'listing-manager' ),
			'collapsible'       => true,
			'fields'            => [
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'car_engine',
					'type'      => 'text',
					'label'     => esc_html__( 'Engine', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'car_model',
					'type'      => 'text',
					'label'     => esc_html__( 'Model', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'car_year',
					'type'      => 'text',
					'label'     => esc_html__( 'Year', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'car_mileage',
					'type'      => 'text',
					'label'     => esc_html__( 'Mileage', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'car_color',
					'type'      => 'text',
					'label'     => esc_html__( 'Color', 'listing-manager' ),
					'required'  => false,
				],
			]
		];

		return $fields;
	}

	/**
	 * Basic information for product tabs
	 *
	 * @access public
	 * @return array
	 */
	public static function product_tab_info() {
		return [
			'id'    	=> 'car',
			'title' 	=> esc_html__( 'Car Attributes', 'listing-manager' ),
			'fields'	=> [ 'engine', 'model', 'year', 'mileage', 'color' ],
		];
	}

	/**
	 * @Filter(name="woocommerce_product_tabs")
	 */
	public static function product_tab( $tabs ) {
		$empty = true;
		$info = self::product_tab_info();

		foreach ( $info['fields'] as $field ) {
			$value = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'car_' . $field, true );

			if ( ! empty( $value ) ) {
				$empty = false;
			}
		}

		if ( ! $empty ) {
			$info = self::product_tab_info();

			$tabs[ $info['id'] ] = [
				'title'    => $info['title'],
				'callback' => [ __CLASS__, 'product_tab_content' ],
				'priority' => 20,
			];
		}

		return $tabs;
	}

	/**
	 * Product tab content
	 *
	 * @access public
	 * @return void
	 */
	public static function product_tab_content() {
		wc_get_template( 'listing-manager/tabs/car.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}