<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class FavoriteLogic {
    /**
     * @Action(name="init")
     */
    public static function process_add() {
        if ( empty( $_GET['listing-manager-add-favorite'] ) ) {
            return;
        }

        if ( ! is_user_logged_in() ) {
            wc_add_notice( esc_html__( 'You need to log in at first.', 'listing-manager' ), 'error' );
        }

        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
        $favorites = ! is_array( $favorites ) ? [] : $favorites;

        if ( empty( $favorites ) ) {
            $favorites = [];
        }

        $post = get_post( $_GET['listing-manager-add-favorite'] );
        $post_type = get_post_type( $post->ID );

        if ( 'product' !== $post_type ) {
            wc_add_notice( esc_html__( 'This is not listing ID.', 'listing-manager' ), 'error' );
        } else {
            $found = false;

            foreach ( $favorites as $listing_id ) {
                if ( $listing_id == $_GET['listing-manager-add-favorite'] ) {
                    $found = true;
                    break;
                }
            }

            if ( ! $found ) {
                $favorites[] = $post->ID;
                update_user_meta( get_current_user_id(), 'favorites', $favorites );
                wc_add_notice( esc_html__( 'Listing successfully added to favorites.', 'listing-manager' ), 'success' );
            } else {
                wc_add_notice( esc_html__( 'Listing is already in list.', 'listing-manager' ), 'error' );
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
    public static function process_remove() {
        if ( empty( $_GET['listing-manager-remove-favorite'] ) ) {
            return;
        }

        if ( ! is_user_logged_in() ) {
            wc_add_notice( esc_html__( 'You need to log in at first.', 'listing-manager' ), 'error' );
        }

        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
        $favorites = ! is_array( $favorites ) ? [] : $favorites;

        if ( empty( $favorites ) ) {
            $favorites = [];
        }

        $post = get_post( $_GET['listing-manager-remove-favorite'] );
        $post_type = get_post_type( $post->ID );

        if ( 'product' !== $post_type ) {
            wc_add_notice( esc_html__( 'This is not listing ID.', 'listing-manager' ), 'error' );
        } else {
            $found = false;        
            $index = 0;
            
            foreach ( $favorites as $listing_id ) {
                if ( $listing_id == $_GET['listing-manager-remove-favorite'] ) {
                    $found = true;
                    unset( $favorites[ $index ] );
                    break;
                }

                $index++;
            }

            if ( $found ) {
                update_user_meta( get_current_user_id(), 'favorites', $favorites );
                wc_add_notice( esc_html__( 'Listing has been successfully removed from favorites.', 'listing-manager' ), 'success' );
            } else {
                wc_add_notice( esc_html__( 'Listing not found in favorite list.', 'listing-manager' ), 'error' );
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
     * @Action(name="wp_ajax_nopriv_listing_manager_favorite_remove")
     * @Action(name="wp_ajax_listing_manager_favorite_remove")
     */
    public static function remove_favorite() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        if ( ! is_user_logged_in() ) {
            $data = [
                'success' => false,
                'message' => esc_html__( 'You need to log in at first.', 'listing-manager' ),
            ];
        } else if ( ! empty( $_GET['id'] ) ) {
            $favorites = get_user_meta( get_current_user_id(), 'favorites', true );

            if ( ! empty( $favorites ) && is_array( $favorites ) ) {
                foreach ( $favorites as $key => $listing_id ) {
                    if ( $listing_id == $_GET['id'] ) {
                        unset( $favorites[ $key ] );
                    }
                }

                update_user_meta( get_current_user_id(), 'favorites', $favorites );

                $data = [
                    'success' => true,
                ];
            } else {
                $data = [
                    'success' => false,
                    'message' => esc_html__( 'No listings found in favorites.', 'listing-manager' ),
                ];
            }
        } else {
            $data = [
                'success' => false,
                'message' => __( 'Listing ID is missing.', 'listing-manager' ),
            ];
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * @Action(name="wp_ajax_nopriv_listing_manager_favorite_add")
     * @Action(name="wp_ajax_listing_manager_favorite_add")
     */
    public static function add_favorite() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        if ( ! is_user_logged_in() ) {
            $data = [
                'success' => false,
                'message' => esc_html__( 'You need to log in at first.', 'listing-manager' ),
            ];
        } elseif ( ! empty( $_GET['id'] ) ) {
            $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
            $favorites = ! is_array( $favorites ) ? [] : $favorites;

            if ( empty( $favorites ) ) {
                $favorites = [];
            }

            $post = get_post( $_GET['id'] );
            $post_type = get_post_type( $post->ID );

            if ( 'product' != $post_type ) {
                $data = [
                    'success' => false,
                    'message' => esc_html__( 'This is not listing ID.', 'listing-manager' ),
                ];
            } else {
                $found = false;

                foreach ( $favorites as $listing_id ) {
                    if ( $listing_id == $_GET['id'] ) {
                        $found = true;
                        break;
                    }
                }

                if ( ! $found ) {
                    $favorites[] = $post->ID;
                    update_user_meta( get_current_user_id(), 'favorites', $favorites );

                    $data = [
                        'success' => true,
                    ];
                } else {
                    $data = [
                        'success' => false,
                        'message' => esc_html__( 'Listing is already in list', 'listing-manager' ),
                    ];
                }
            }
        } else {
            $data = [
                'success' => false,
                'message' => esc_html__( 'Listing ID is missing.', 'listing-manager' ),
            ];
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * Renders report button
     *
     * @access public
     * @param int $post_id
     * @param array $content
     * @return void
     */
    public static function render_button( $post_id = null, array $content = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return;
        }

        wc_get_template( 'listing-manager/favorite.php', [
            'id' 		=> $post_id,
            'content' 	=> $content,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }

	/**
	 * Get link for adding post into favorites
	 *
	 * @access public
	 * @param int|null $post_id
	 * @return string|null
	 */
    public static function get_link( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return null;
        }

        return '?listing-manager-add-favorite=' . $post_id;
    }

    /**
     * Checks if listing is in user favorites
     *
     * @access public
     * @param $post_id
     * @return bool
     */
    public static function is_my_favorite( $post_id ) {
        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );

        if ( ! empty( $favorites ) && is_array( $favorites ) ) {
            return in_array( $post_id, $favorites );
        }
        return false;
    }
}
