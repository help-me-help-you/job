<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class AgentWidget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'agents',
            esc_html__( 'Listing Manager: Agents', 'listing-manager' ),
            [ 'description' => esc_html__( 'Displays agents.', 'listing-manager' ), ]
        );
    }

    /**
     * @Action(name="widgets_init")
     */
    public static function init() {
        register_widget( 'ListingManager\Widget\AgentWidget' );
    }

    /**
     * Frontend
     *
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        query_posts( [
            'post_type'         => 'agent',
            'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 3,
        ] );

        wc_get_template( 'listing-manager/widgets/agents.php', [
            'args' 		=> $args,
            'instance' 	=> $instance,
        ], '', LISTING_MANAGER_DIR . 'templates/' );

        wp_reset_query();
    }
    /**
     * Update
     *
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
    /**
     * Backend
     *
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {
        wc_get_template( 'listing-manager/widgets/agents-form.php', [
            'widget' 	=> $this,
            'instance' 	=> $instance,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}