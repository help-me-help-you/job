<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use WP_Customize_Manager;

class StatisticCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section( 'listing_manager_statistics', [
            'title'     => esc_html__( 'Listing Manager Statistics', 'listing-manager' ),
            'priority'  => 15,
        ] );

        // Query logging
        $wp_customize->add_setting( 'listing_manager_statistics_enable_query_logging', [
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_statistics_enable_query_logging', [
            'type'     => 'checkbox',
            'label'    => esc_html__( 'Enable Search Query Logging', 'listing-manager' ),
            'section'  => 'listing_manager_statistics',
            'settings' => 'listing_manager_statistics_enable_query_logging',
        ] );

        // Listing logging
        $wp_customize->add_setting( 'listing_manager_statistics_enable_listing_logging', [
            'default'           => false,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_statistics_enable_listing_logging', [
            'type'     => 'checkbox',
            'label'    => esc_html__( 'Enable Listing Views Logging', 'listing-manager' ),
            'section'  => 'listing_manager_statistics',
            'settings' => 'listing_manager_statistics_enable_listing_logging',
        ] );

	    // Listing views
	    $wp_customize->add_setting( 'listing_manager_statistics_show_listing_views', [
		    'default'           => false,
		    'capability'        => 'edit_theme_options',
		    'sanitize_callback' => 'sanitize_text_field',
	    ] );

	    $wp_customize->add_control( 'listing_manager_statistics_show_listing_views', [
		    'type'     => 'checkbox',
		    'label'    => esc_html__( 'Show Listing Detail Views', 'listing-manager' ),
		    'section'  => 'listing_manager_statistics',
		    'settings' => 'listing_manager_statistics_show_listing_views',
	    ] );
    }
}