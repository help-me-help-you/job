<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class JobTab {
	/**
	 * @Filter(name="woocommerce_product_data_tabs")
	 */
	public static function tab( $tabs ) {
		$tabs['job'] = [
			'label'		=> esc_html__( 'Job', 'listing-manager' ),
			'target'	=> 'job',
			'class'		=> [ 'show_if_listing' ],
		];

		return $tabs;
	}

	/**
	 * @Action(name="woocommerce_product_data_panels")
	 */
	public static function panel() {
		wc_get_template( 'listing-manager/panels/job.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}

	/**
	 * @Action(name="woocommerce_process_product_meta_listing")
	 */
	public static function save( $post_id ) {
		$info = self::product_tab_info();
		$fields = $info['fields'];

		foreach ( $fields as $field ) {
			$id = LISTING_MANAGER_LISTING_PREFIX . 'job_' . $field;
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
			'forms'             => ['job', ],
			'type'              => 'fieldset',
			'id'                => 'job',
			'legend'            => esc_html__( 'Job', 'listing-manager' ),
			'collapsible'       => true,
			'fields'            => [
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'job_start',
					'type'      => 'text',
					'label'     => esc_html__( 'Start', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'job_contract',
					'type'      => 'text',
					'label'     => esc_html__( 'Contract', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'job_position',
					'type'      => 'text',
					'label'     => esc_html__( 'Position', 'listing-manager' ),
					'required'  => false,
				],
				[
					'id'        => LISTING_MANAGER_LISTING_PREFIX . 'job_skills',
					'type'      => 'text',
					'label'     => esc_html__( 'Position', 'listing-manager' ),
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
			'id'    	=> 'job',
			'title' 	=> esc_html__( 'Job Attributes', 'listing-manager' ),
			'fields'	=> [ 'start', 'contract', 'position', 'skills', ],
		];
	}

	/**
	 * @Filter(name="woocommerce_product_tabs")
	 */
	public static function product_tab( $tabs ) {
		$empty = true;
		$info = self::product_tab_info();

		foreach ( $info['fields'] as $field ) {
			$value = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'job_' . $field, true );

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
		wc_get_template( 'listing-manager/tabs/job.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}