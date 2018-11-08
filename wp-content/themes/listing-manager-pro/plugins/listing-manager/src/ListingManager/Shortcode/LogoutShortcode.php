<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class LogoutShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_logout', [ 'ListingManager\Shortcode\LogoutShortcode', 'execute' ] );
    }

    /**
     * @Action(name="wp")
     */
    public static function check_logout( $wp ) {
        $post = get_post();

        if ( is_object( $post ) && ! is_search() ) {
            if ( false !== strpos( $post->post_content, '[listing_manager_logout]' ) ) {
                wc_add_notice( esc_html__( 'You have been successfully logged out.', 'listing-manager' ), 'success' );
                wp_redirect( html_entity_decode( wp_logout_url( home_url( '/' ) ) ) );
                exit();
            }
        }
    }

    public static function execute( $atts ) {
    }
}