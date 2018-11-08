<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use WP_Customize_Manager;

class GeneralCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section( 'listing_manager_general', [
            'title' 	=> esc_html__( 'Listing Manager General', 'listing-manager' ),
            'priority' 	=> 10,
        ] );

        // Purchase code
        $wp_customize->add_setting( 'listing_manager_purchase_code', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_purchase_code', [
            'type'          => 'text',
            'label'         => esc_html__( 'Purchase code', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_purchase_code',
        ] );

        // Style
        $wp_customize->add_setting( 'listing_manager_style', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_style', [
            'type'          => 'select',
            'label'         => esc_html__( 'Style', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_style',
            'choices'       => [
                'none'      => esc_attr__( 'None', 'listing-manager' ),
                'default'   => esc_attr__( 'Default', 'listing-manager' ),
            ],
        ] );

        // Login after registration
        $wp_customize->add_setting( 'listing_manager_login_after_registration', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_login_after_registration', [
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Automatically login user after registration', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_login_after_registration',
        ] );

        // Inquire for authenticated
        $wp_customize->add_setting( 'listing_manager_inquire_authenticated', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_inquire_authenticated', [
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Inquire for authenticated', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_inquire_authenticated',
        ] );

        // Contact tab for authenticated
        $wp_customize->add_setting( 'listing_manager_contact_authenticated', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_contact_authenticated', [
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Contact information for authenticated', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_contact_authenticated',
        ] );

        // Autocomplete
        $wp_customize->add_setting( 'listing_manager_autocomplete', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_autocomplete', [
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Autocomplete', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_autocomplete',
        ] );

        // Allow Order Featured
        // $wp_customize->add_setting( 'listing_manager_allow_order_featured', [
        //     'default'           => null,
        //     'capability'        => 'edit_theme_options',
        //     'sanitize_callback' => 'sanitize_text_field',
        // ] );

        // $wp_customize->add_control( 'listing_manager_allow_order_featured', [
        //     'type'          => 'checkbox',
        //     'label'         => esc_html__( 'Allow order featured', 'listing-manager' ),
        //     'section'       => 'listing_manager_general',
        //     'settings'      => 'listing_manager_allow_order_featured',
        // ] );

        // Distance unit long
        $wp_customize->add_setting( 'listing_manager_distance_unit_long', [
            'default'           => 'mi',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_distance_unit_long', [
            'label'         => esc_html__( 'Long Distance Unit', 'listing-manager' ),
            'section'       => 'listing_manager_general',
            'settings'      => 'listing_manager_distance_unit_long',
            'description'   => esc_html__( 'Example: "mi" or "km"', 'listing-manager' ),
        ] );
    }
}