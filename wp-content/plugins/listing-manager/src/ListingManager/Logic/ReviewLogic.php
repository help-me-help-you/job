<?php

namespace ListingManager\Logic;

use WC_Comments;
use WP_Query;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class ReviewLogic {
	/**
	 * @Action(name="woocommerce_review_comment_text", priority=100)
	 */
	public static function display() {
		$product_types = wp_get_object_terms( get_the_ID(), 'product_type' );
		$product_type = array_shift( $product_types );

		if ( 'listing' !== $product_type->name ) {
			return;
		}

		wc_get_template( 'listing-manager/reviews/display.php', [
			'fields' => self::get_fields(),
		], '', LISTING_MANAGER_DIR . 'templates/' );
	}

	/**
	 * @Filter(name="woocommerce_product_review_comment_form_args")
	 */
	public static function form_args( $comment_form ) {
		$product_types = wp_get_object_terms( get_the_ID(), 'product_type' );
		$product_type = array_shift( $product_types );
		if ( 'listing' !== $product_type->name ) {
			return $comment_form;
		}

		$fields = self::get_fields();
		if ( ! empty( $fields ) ) {
			$comment_form['comment_field'] .= '<div class="comment-form-ratings">';

			foreach ( $fields as $field ) {
				$comment_form['comment_field'] .= wc_get_template_html( 'listing-manager/reviews/field.php',
					(array) $field, '', LISTING_MANAGER_DIR . 'templates/' );
			}

			$comment_form['comment_field'] .= '</div>';
		}
		
		$comment_form['label_submit'] = esc_html__( 'Submit Review', 'listing-manager' );		
		return $comment_form;
	}


	/**
	 * @Filter(name="comment_post")
	 */
	public static function add_ratings( $comment_id ) {
		$post_id = $_POST['comment_post_ID'];
		if ( 'product' === get_post_type( $post_id ) ) {

			$product_types = wp_get_object_terms( $post_id, 'product_type' );
			$product_type = array_shift( $product_types );
			if ( 'listing' !== $product_type->name ) {
				return;
			}

			$average = 0;
			$base = 5;
			$count = 0;

			foreach ( self::get_fields() as $field ) {
				$field = (array) $field;
				$key = LISTING_MANAGER_REVIEW_PREFIX . $field['id'];
				$value = $_POST[ $key ];

				if ( ! empty( $value ) && $value > 0 && $value <= $field['stars'] ) {
					$ratio = $field['stars'] / $base;
					$average += $value * $ratio;
					$count++;

					add_comment_meta( $comment_id, $key, (int) esc_attr( $_POST[ $key ] ), true );
				}
			}

			if ( 0 != $count ) {
				update_comment_meta( $comment_id, 'rating', $average / $count );
			}

			$product = wc_get_product( $post_id );
			$counts = WC_Comments::get_rating_counts_for_product( $product );
			update_post_meta( $post_id, '_wc_rating_count', $counts );

			$average = WC_Comments::get_average_rating_for_product( $product );
			update_post_meta( $post_id, '_wc_average_rating', $average );
		}
	}

	public static function has_rating( $id ) {
		$fields = self::get_fields();

		if ( is_array( $fields ) ) {
			foreach( $fields as $field ) {
				$rating = get_comment_meta( $id, LISTING_MANAGER_REVIEW_PREFIX . $field['id'], true );

				if ( ! empty( $rating ) ) {
					return true;
				}
			}
		}

		return false;
	}

	public static function get_fields() {
		$result = [];
		$ratings = new WP_Query( [
			'post_type'         => 'review_rating',
			'posts_per_page'    => -1,
		] );

		foreach ( $ratings->posts as $rating ) {
			$id = get_post_meta( $rating->ID, LISTING_MANAGER_REVIEW_PREFIX . 'id', true );
			$title = get_post_meta( $rating->ID, LISTING_MANAGER_REVIEW_PREFIX . 'title', true );
			$required = get_post_meta( $rating->ID, LISTING_MANAGER_REVIEW_PREFIX . 'required', true );
			$max = get_post_meta( $rating->ID, LISTING_MANAGER_REVIEW_PREFIX . 'max', true );

			$result[] = [
				'id'            => $id,
				'title'         => $title,
				'stars'         => (int) $max,
				'required'      => ! empty( $required) ? true : false,
			];
		}

		return apply_filters( 'listing_manager_ratings_fields', $result );
	}
}