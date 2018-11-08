<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class CompanyWidget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'companies',
            esc_html__( 'Listing Manager: Companies', 'listing-manager' ),
            [ 'description' => esc_html__( 'Displays companies.', 'listing-manager' ), ]
        );
    }

    /**
     * @Action(name="widgets_init")
     */
    public static function init() {
        register_widget( 'ListingManager\Widget\CompanyWidget' );
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
            'post_type'         => 'company',
            'posts_per_page'    => ! empty( $instance['count'] ) ? $instance['count'] : 3,
        ] );

        wc_get_template( 'listing-manager/widgets/companies.php', [
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
        wc_get_template( 'listing-manager/widgets/companies-form.php', [
            'widget' 	=> $this,
            'instance' 	=> $instance,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}