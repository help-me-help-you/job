<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use ListingManager\Logic\GoogleMapLogic;
use WP_Customize_Manager;

class GoogleMapCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section( 'listing_manager_google_maps', [
            'title' 	=> esc_html__( 'Listing Manager Google Maps', 'listing-manager' ),
            'priority' 	=> 15,
        ] );

        // Google Maps API key
        $wp_customize->add_setting( 'listing_manager_google_maps_api_key', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_google_maps_api_key', [
            'type'          => 'text',
            'label'         => esc_html__( 'Google Maps API Key', 'listing-manager' ),
            'section'       => 'listing_manager_google_maps',
            'settings'      => 'listing_manager_google_maps_api_key',
            'description'   => wp_kses( __( 'Get an API key from <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">here</a>', 'listing-manager' ), wp_kses_allowed_html( 'post' ) ),
        ] );

        // Style
        $items = [];
        foreach ( GoogleMapLogic::get_styles() as $style ) {
            $items[ $style->slug ] = $style->name;
        }

        $wp_customize->add_setting( 'listing_manager_google_maps_style', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_google_maps_style', [
            'type'          => 'select',
            'label'         => esc_html__( 'Style', 'listing-manager' ),
            'section'       => 'listing_manager_google_maps',
            'settings'      => 'listing_manager_google_maps_style',
            'choices'       => $items,
        ] );
    }
}