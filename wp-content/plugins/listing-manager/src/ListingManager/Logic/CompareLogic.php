<?php

namespace ListingManager\Logic;

use WP_Query;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class CompareLogic {
	public static function is_compared( $listing_id ) {
        if ( ! empty( $_SESSION['compare'] ) ) {
            foreach ( $_SESSION['compare'] as $key => $value ) {
                if ( $value == $listing_id ) {
                    return true;
                }
            }
        }

        return false;
	}

    public static function get_link( $post_id = null, $remove_link = false ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return;
        }

		if ( $remove_link ) {
			return '?listing-manager-compare-remove-id=' . $post_id;
		}

        return '?listing-manager-compare-add-id=' . $post_id;
    }

    /**
     * @Action(name="woocommerce_after_single_product")
     */
    public static function render_button( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return;
        }

        wc_get_template( 'listing-manager/compare-button.php', [
            'id' 		=> $post_id,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }

	/**
	 * @Action(name="woocommerce_before_main_content")
	 */
	public static function render() {

		wc_get_template( 'listing-manager/compare-status.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}

	/**
	 * @Action(name="init")
	 */
	public static function add() {
		if ( empty( $_GET['listing-manager-compare-add-id'] ) ) {
			return;
		}

        if ( ! empty( $_SESSION['compare'] ) && is_array( $_SESSION['compare'] ) ) {
            if ( count( $_SESSION['compare'] ) >= LISTING_MANAGER_COMPARE_MAX ) {
				wc_add_notice( sprintf( __( 'You can have max %s listings.', 'listing-manager' ), LISTING_MANAGER_COMPARE_MAX ), 'error' );
				return;
            }
        }

        if ( empty( $_SESSION['compare'] ) ) {
            $_SESSION['compare'] = [];
        }

        $post = get_post( $_GET['listing-manager-compare-add-id'] );
        $found = false;
        $compare_id = get_theme_mod( 'listing_manager_pages_compare');

        foreach ( $_SESSION['compare'] as $property_id ) {
            if ( $property_id == $_GET['listing-manager-compare-add-id'] ) {
                $found = true;
                break;
            }
        }

        if ( ! $found ) {
			$_SESSION['compare'][] = $post->ID;

            if ( ! empty( $compare_id ) ) {
                $message = sprintf( __( 'Listing successfully added into <a href="%s">compare list</a>.', 'listing-manager' ), get_the_permalink( $compare_id ) );
                wc_add_notice( wp_kses( $message, wp_kses_allowed_html( 'post' ), 'success' ) );                
            } else {
                wc_add_notice( esc_html__( 'Listing successfully added into compare.', 'listing-manager' ), 'success' );
            }			
        } else {
            if ( ! empty( $compare_id ) ) {
                $message = sprintf( __( 'Listing is already i <a href="%s">compare list</a>.', 'listing-manager' ), get_the_permalink( $compare_id ) );
                wc_add_notice( wp_kses( $message, wp_kses_allowed_html( 'post' ), 'error' ) );                
            } else {
                wc_add_notice( esc_html__( 'Listing is already in compare list.', 'listing-manager' ), 'error' );
            }			
        }

        if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
            wp_redirect( $_SERVER['HTTP_REFERER'] );
            exit();
        }

        wp_redirect( site_url( '/' ) );
        exit();
	}

	/**
	 * @Action(name="init")
	 */
	public static function remove() {
		if ( empty( $_GET['listing-manager-compare-remove-id'] ) ) {
			return;
		}

        $compare_id = get_theme_mod( 'listing_manager_pages_compare');

        if ( ! empty( $_SESSION['compare'] ) && is_array( $_SESSION['compare'] ) ) {
            foreach( $_SESSION['compare'] as $key => $listing_id ) {
                if ( $listing_id == $_GET['listing-manager-compare-remove-id'] ) {
                    unset( $_SESSION['compare'][ $key ] );
                }
            }

            if ( ! empty( $compare_id ) ) {
                $message = sprintf( __( 'Listing removed from <a href="%s">compare list</a>.', 'listing-manager' ), get_the_permalink( $compare_id ) );
                wc_add_notice( wp_kses( $message, wp_kses_allowed_html( 'post' ), 'success' ) );
            } else {
                wc_add_notice( esc_html__( 'Listing removed from compare list.', 'listing-manager' ), 'success' );
            }            
        } else {
            if ( ! empty( $compare_id ) ) {
                $message = sprintf( __( 'No listings found in <a href="%s">compare list</a>.', 'listing-manager' ), get_the_permalink( $compare_id ) );
                wc_add_notice( wp_kses( $message, wp_kses_allowed_html( 'post' ), 'error' ) );
            } else {
                wc_add_notice( esc_html__( 'No listings found in compare list.', 'listing-manager' ), 'error' );
            }			
        }

        if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
            wp_redirect( $_SERVER['HTTP_REFERER'] );
            exit();
        }

        wp_redirect( site_url( '/' ) );
        exit();
	}

	/**
	 * @Action(name="listing_manager_compare_field_keys")
	 */
	public static function field_keys() {
		$terms = get_terms( 'amenities', [
			'hide_empty' => false,
		] );

		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				echo '<li>' . $term->name . '</li>';
			}
		}
	}

	/**
	 * @Action(name="listing_manager_compare_field_values")
	 */
	public static function field_values( $listing_id) {
		$terms = get_terms( 'amenities', [
			'hide_empty' => false,
		] );

		if ( is_array( $terms ) ) {
			foreach ( $terms as $term ) {
				if ( has_term( $term->term_id, 'amenities', $listing_id ) ) {
					echo '<li class="yes">' . esc_html__( 'yes', 'listing-manager' ) . '</li>';
				} else {
					echo '<li class="no">' . esc_html__( 'no', 'listing-manager' ) . '</li>';
				}
			}
		}
	}
}
