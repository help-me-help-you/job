<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Logic\UserLogic;

class AddShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_add', [ 'ListingManager\Shortcode\AddShortcode', 'execute' ] );
    }

	/**
	 * @Action(name="wp")
	 */
	public static function message( $wp ) {
		global $post;

		if ( ! empty( $post ) && ! is_admin() && false !== strpos( $post->post_content, '[listing_manager_add' ) ) {
			if ( ( is_user_logged_in() && ! get_option( 'users_can_register' ) ) && ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
				wc_add_notice( esc_html__( 'You are not allowed to access this page.', 'listing-manager' ), 'error' );
			}
		}
	}

    public static function execute( $atts ) {
        if ( ( is_user_logged_in() && ! get_option( 'users_can_register' ) ) && ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
            return;
        }

        return wc_get_template_html( 'listing-manager/listing-form.php', [
            'update' => false,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}