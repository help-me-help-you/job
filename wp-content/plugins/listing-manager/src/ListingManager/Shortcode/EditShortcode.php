<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Logic\UserLogic;
use ListingManager\Utilities;

class EditShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_edit', [ 'ListingManager\Shortcode\EditShortcode', 'execute' ] );
    }

	/**
	 * @Action(name="wp")
	 */
    public static function message( $wp ) {
		global $post;

	    if ( ! empty( $post ) && ! is_admin() && false !== strpos( $post->post_content, '[listing_manager_edit' ) ) {
		    if ( ! is_user_logged_in() || empty( $_GET['id'] ) || ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
			    wc_add_notice( esc_html__( 'You are not allowed to access this page.', 'listing-manager' ), 'error' );
		    } elseif ( empty( get_post( $_GET['id'] ) ) ) {
			    wc_add_notice( esc_html__( 'Listing does not exist.', 'listing-manager' ), 'error' );
		    } elseif ( ! Utilities::is_allowed_to_access( get_current_user_id(), $_GET['id'] ) ) {
			    wc_add_notice( esc_html__( 'You are not allowed to access this listing.', 'listing-manager' ), 'error' );
		    }
	    }
    }

    public static function execute( $atts ) {
        if ( ! is_user_logged_in() || empty( $_GET['id'] ) || ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
            return;
        } elseif ( empty( get_post( $_GET['id'] ) ) ) {
            return;
        } elseif ( ! Utilities::is_allowed_to_access( get_current_user_id(), $_GET['id'] ) ) {
            return;
        }

        return wc_get_template_html( 'listing-manager/listing-form.php', [
            'update' => true,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}