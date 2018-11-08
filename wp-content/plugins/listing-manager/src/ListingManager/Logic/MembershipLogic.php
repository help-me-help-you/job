<?php

namespace ListingManager\Logic;

use \WP_Query;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class MembershipLogic {
	/**
	 * Get template for selecting submission plan
	 *
	 * @return string
	 */
	public static function get_submission_plans() {
		return wc_get_template_html( 'listing-manager/memberships/plans.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}

	/**
	 * Get listings assigned to plan
     *
	 * @param $plan_id
	 * @return array
	 */
	public static function get_listings_in_plan( $plan_id ) {
		$query = new WP_Query( [
			'post_type'         => 'product',
			'posts_per_page'    => -1,
			'meta_query'        => [
				[
					'key'       => LISTING_MANAGER_LISTING_PREFIX . 'membership',
					'value'     => $plan_id,
					'type'      => 'NUMERIC'
				],
			],
			'tax_query'         => [
				[
					'taxonomy'  => 'product_type',
					'field'     => 'slug',
					'terms'     => 'listing',
				],
			],
		] );

		return $query->posts;
	}

	/**
	 * @Filter(name="listing_manager_submission_validate_type", accepted_args=3)
	 */
	public static function validate_submission_type( $return, $post_data, $submission_type ) {
		if ( 'memberships' !== $submission_type ) {
			return $return;
		}

		if ( empty( $post_data[ LISTING_MANAGER_LISTING_PREFIX . 'membership' ] ) ) {
			wc_add_notice( esc_html__( 'Please select membership plan.', 'listing-manager' ), 'error' );
			return false;
		}

		$membership_id = $post_data[ LISTING_MANAGER_LISTING_PREFIX . 'membership'];
		$membership = wc_memberships_get_user_membership( $membership_id );
		$max = get_post_meta( $membership->plan->id, LISTING_MANAGER_MEMBERSHIP_PREFIX . 'max', true );
		$count = count( self::get_listings_in_plan( LISTING_MANAGER_LISTING_PREFIX . 'membership' ) );

		if ( $max == $count ) {
			wc_add_notice( esc_html__( 'Your membership max. number of listings plan is reached.', 'listing-manager' ), 'error' );
			return false;
		}

		return true;
	}

	/**
	 * @Filter(name="wc_membership_plan_data_tabs")
	 */
	public static function tab( $tabs ) {
		$tabs['listing-manager'] = [
			'label'  => esc_html__( 'Listing Manager', 'listing-manager' ),
			'target' => 'listing-manager',
		];

		return $tabs;
	}

	/**
	 * @Action(name="wc_membership_plan_data_panels")
	 */
	public static function panel() {
		wc_get_template( 'listing-manager/memberships/panel.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}

	/**
	 * @Action(name="save_post")
	 */
	public static function save( $post_id ) {
		global $post;

		if ( ! isset( $_POST['listing-manager-nonce'] ) || ! wp_verify_nonce( $_POST['listing-manager-nonce'], 'listing-manager-membership-plan' ) ) {
			return $post_id;
		}


		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}


		if ( 'wc_membership_plan' === $post->post_type ) {
			update_post_meta( $post_id, LISTING_MANAGER_MEMBERSHIP_PREFIX . 'max', $_POST[ LISTING_MANAGER_MEMBERSHIP_PREFIX . 'max' ] );
		}

		return $post_id;
	}

	/**
	 * @Action(name="wp_loaded")
	 */
	public static function check_listings() {
		if ( 'memberships' !== get_theme_mod( 'listing_manager_submission_type', 'free' ) ) {
			return;
		}

		$query = new WP_Query( [
			'post_type'         => 'product',
			'post_status'       => ['publish', 'draft', ],
			'posts_per_page'    => -1,
			'meta_query'        => [
				[
					'key'       => LISTING_MANAGER_LISTING_PREFIX . 'membership',
					'compare'   => 'EXISTS',
				],
			],
			'tax_query'         => [
				[
					'taxonomy'  => 'product_type',
					'field'     => 'slug',
					'terms'     => 'listing',
				],
			],
		] );

		$draft = [ 'delayed', 'paused', 'expired', 'cancelled', ];
		$publish = [ 'active', 'free_trial', 'complimentary', 'pending', ];

		if ( is_array( $query->posts ) ) {
			foreach( $query->posts as $listing ) {
				$membership_id = get_post_meta( $listing->ID, LISTING_MANAGER_LISTING_PREFIX . 'membership', true );
				$membership = wc_memberships_get_user_membership( $membership_id );

				if ( $membership ) {
					if ( in_array( $membership->get_status(), $publish ) && 'draft' === $listing->post_status ) {
						wp_update_post( [ 'ID' => $listing->ID, 'post_status' => 'publish' ] );
					} elseif ( in_array( $membership->get_status(), $draft ) && 'publish' === $listing->post_status ) {
						wp_update_post( [ 'ID' => $listing->ID, 'post_status' => 'draft' ] );
					}
				}
			}
		}
	}
}