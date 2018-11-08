<?php

namespace ListingManager\Widget;

use ListingManager\Annotation\Action;
use WP_Widget;

class GoogleMapWidget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'google-map',
            esc_html__( 'Listing Manager: Google Map', 'listing-manager' ),
            [ 'description' => esc_html__( 'Displays Google Map.', 'listing-manager' ), ]
        );
    }

    /**
     * @Action(name="widgets_init")
     */
    public static function init() {
        register_widget( 'ListingManager\Widget\GoogleMapWidget' );
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
        wc_get_template( 'listing-manager/widgets/google-map.php', [
            'args'      => $args,
            'instance'  => $instance,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
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
        wc_get_template( 'listing-manager/widgets/google-map-form.php', [
            'widget' 	=> $this,
            'instance' 	=> $instance,
        ], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}
