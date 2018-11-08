<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;

class AgentShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_agents', [ 'ListingManager\Shortcode\AgentShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        $atts = shortcode_atts( [
            'per_page'  => '4',
            'columns'   => '4',
        ], $atts );

        query_posts( [
            'post_type'			=> 'agent',
            'posts_per_page' 	=> $atts['per_page'],
        ] );

        $result = wc_get_template_html( 'listing-manager/agents.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );

        wp_reset_query();

        return $result;
    }
}