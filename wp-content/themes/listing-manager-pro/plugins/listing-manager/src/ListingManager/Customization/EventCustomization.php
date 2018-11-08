<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use WP_Customize_Manager;

class EventCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section( 'listing_manager_events', [
            'title'     => esc_html__( 'Listing Manager Events', 'listing-manager' ),
            'priority'  => 17,
        ] );

        $wp_customize->add_setting( 'listing_manager_events_unpublish_passed', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_events_unpublish_passed', [
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Unpublish passed events', 'listing-manager' ),
            'section'       => 'listing_manager_events',
            'settings'      => 'listing_manager_events_unpublish_passed',
        ] );
    }
}