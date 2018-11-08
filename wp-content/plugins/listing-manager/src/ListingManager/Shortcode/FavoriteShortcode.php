<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;

class FavoriteShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_favorites', [ 'ListingManager\Shortcode\FavoriteShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        if ( ! is_user_logged_in() ) {
            echo wc_get_template_html( 'listing-manager/messages/not-allowed.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
            return;
        }

        $paged = ( get_query_var( 'paged' )) ? get_query_var( 'paged' ) : 1;
        $favorites = get_user_meta( get_current_user_id(), 'favorites', true );
        if ( ! is_array( $favorites ) ||  count( $favorites ) == 0 ) {
            $favorites = [ '' ];
        }

        query_posts( [
            'post_type'     => 'product',
            'paged'         => $paged,
            'post__in'		=> $favorites,
            'post_status'   => 'publish',
        ] );

        $output = wc_get_template_html( 'listing-manager/favorites.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
        wp_reset_query();
        return $output;
    }
}