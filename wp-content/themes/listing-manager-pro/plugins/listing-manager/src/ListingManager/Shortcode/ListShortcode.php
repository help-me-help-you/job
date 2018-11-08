<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Logic\UserLogic;

class ListShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_list', [ 'ListingManager\Shortcode\ListShortcode', 'execute' ] );
    }

	/**
	 * @Action(name="wp")
	 */
    public static function message( $wp ) {
    	global $post;

	    if ( ! is_user_logged_in() || ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
		    if ( is_object( $post ) && ! is_search() ) {
                if ( false !== strpos( $post->post_content, '[listing_manager_list' ) ) {
				    if ( ! is_user_logged_in() || ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
					    $login_page_id    = get_theme_mod( 'listing_manager_pages_login', null );
					    $register_page_id = get_theme_mod( 'listing_manager_pages_register', null );
					    $message          = sprintf( __( 'Please <a href="%s?next=%s">log in</a> before accessing this page. If you don\'t have an account <a href="%s">register</a>.', 'listing-manager' ),
						    get_permalink( $login_page_id ), get_permalink(), get_permalink( $register_page_id ) );
					    wc_add_notice( $message, 'error' );
				    }
                }
		    }
	    }
    }

    public static function execute( $atts ) {
    	$atts = shortcode_atts([
    		'message' => null,
	    ], $atts );

        if ( ! is_user_logged_in() || ! UserLogic::has_permission_front_end( wp_get_current_user() ) ) {
			return;
        }

        $paged = ( get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
        query_posts( [
            'post_type' 	=> 'product',
            'author'		=> get_current_user_id(),
            'paged'			=> $paged,
            'post_status' 	=> 'publish,pending,draft,private',
            'tax_query' 	=> [
                [
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'listing',
                ],
            ],
        ] );

        $output = wc_get_template_html( 'listing-manager/listing-list.php', [], '', LISTING_MANAGER_DIR . 'templates/' );

        wp_reset_query();
        return $output;    }
}