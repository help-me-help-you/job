<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use ListingManager\Product\MicropaymentProduct;
use WP_Customize_Manager;

class MicropaymentCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $micropayments = MicropaymentProduct::get_all();

        $wp_customize->add_section( 'listing_manager_micropayments', [
            'title'     => esc_html__( 'Listing Manager Micropayments', 'listing-manager' ),
            'priority'  => 13,
            'description'   => esc_attr__( 'Create new WooCommerce products with product type Micropayment.', 'listing-manager' ),
        ] );

        // Feature
        $wp_customize->add_setting( 'listing_manager_micropayments_feature', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_micropayments_feature', [
            'type'          => 'select',
            'label'         => esc_html__( 'Feature Listing', 'listing-manager' ),
            'section'       => 'listing_manager_micropayments',
            'settings'      => 'listing_manager_micropayments_feature',
            'choices'       => $micropayments,
            'description'   => esc_attr__( 'Assign micropayment product type for featuring a listing.', 'listing-manager' ),
        ] );

        // Publish
        $wp_customize->add_setting( 'listing_manager_micropayments_publish', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_micropayments_publish', [
            'type'          => 'select',
            'label'         => esc_html__( 'Publish Listing', 'listing-manager' ),
            'section'       => 'listing_manager_micropayments',
            'settings'      => 'listing_manager_micropayments_publish',
            'choices'       => $micropayments,
            'description'   => esc_attr__( 'Assign micropayment product type for publishing a listing.', 'listing-manager' ),
        ] );

        // Claim Listing
        $wp_customize->add_setting( 'listing_manager_micropayments_claim', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_micropayments_claim', [
            'type'          => 'select',
            'label'         => esc_html__( 'Claim Listing', 'listing-manager' ),
            'section'       => 'listing_manager_micropayments',
            'settings'      => 'listing_manager_micropayments_claim',
            'choices'       => $micropayments,
            'description'   => esc_attr__( 'Assign micropayment product type for claiming a listing.', 'listing-manager' ),
        ] );
    }
}