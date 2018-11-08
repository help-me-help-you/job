<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;
use WP_Customize_Manager;

class PageCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $pages = Utilities::get_pages();

        $wp_customize->add_section( 'listing_manager_pages', [
            'title'     => esc_html__( 'Listing Manager Pages', 'listing-manager' ),
            'priority'  => 11,
        ] );

        // Listings page
        $wp_customize->add_setting( 'listing_manager_pages_listings', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listings', [
            'type'          => 'text',
            'label'         => esc_html__( 'Listings', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listings',
            'description'   => esc_html__( 'Separate page for listings. WooCommerce regular products and listings will be displayed at different pages. Please do not forget to visit "Settings - Permalinks" after changing this value.', 'listing-manager' ),
        ] );

        // Listings page title
        $wp_customize->add_setting( 'listing_manager_pages_listings_title', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listings_title', [
            'type'          => 'text',
            'label'         => esc_html__( 'Listings Page Title', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listings_title',
        ] );

	    // Dashboard
	    $wp_customize->add_setting( 'listing_manager_pages_dashboard', [
		    'default'           => null,
		    'capability'        => 'edit_theme_options',
		    'sanitize_callback' => 'sanitize_text_field',
	    ] );

	    $wp_customize->add_control( 'listing_manager_pages_dashboard', [
		    'type'          => 'select',
		    'label'         => esc_html__( 'Dashboard', 'listing-manager' ),
		    'section'       => 'listing_manager_pages',
		    'settings'      => 'listing_manager_pages_dashboard',
		    'description'   => esc_html__( 'Page containing [listing_manager_dashboard] shortcode.', 'listing-manager' ),
		    'choices'       => $pages,
	    ] );

        // Add listing
        $wp_customize->add_setting( 'listing_manager_pages_listing_add', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listing_add', [
            'type'          => 'select',
            'label'         => esc_html__( 'Add Listing', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listing_add',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_add] shortcode.', 'listing-manager' ),
        ] );

        // List listings
        $wp_customize->add_setting( 'listing_manager_pages_listing_list', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listing_list', [
            'type'          => 'select',
            'label'         => esc_html__( 'List Listings', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listing_list',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_list] shortcode.', 'listing-manager' ),
        ] );

        // Remove listing
        $wp_customize->add_setting( 'listing_manager_pages_listing_remove', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listing_remove', [
            'type'          => 'select',
            'label'         => esc_html__( 'Remove Listing', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listing_remove',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_remove] shortcode.', 'listing-manager' ),
        ] );

        // Edit listing
        $wp_customize->add_setting( 'listing_manager_pages_listing_edit', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listing_edit', [
            'type'          => 'select',
            'label'         => esc_html__( 'Edit Listing', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listing_edit',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_edit] shortcode.', 'listing-manager' ),
        ] );

        // Terms and conditions
        $wp_customize->add_setting( 'listing_manager_pages_terms', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_terms', [
            'type'          => 'select',
            'label'         => esc_html__( 'Terms &amp; Conditions', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_terms',
            'choices'       => $pages,
        ] );

        // Claim
        $wp_customize->add_setting( 'listing_manager_pages_claim', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_claim', [
            'type'          => 'select',
            'label'         => esc_html__( 'Claim', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_claim',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_claim] shortcode.', 'listing-manager' ),
        ] );

        // Report
        $wp_customize->add_setting( 'listing_manager_pages_report', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_report', [
            'type'          => 'select',
            'label'         => esc_html__( 'Report', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_report',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_report] shortcode.', 'listing-manager' ),
        ] );

        // Compare
        $wp_customize->add_setting( 'listing_manager_pages_compare', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_compare', [
            'type'          => 'select',
            'label'         => esc_html__( 'Compare', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_compare',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_compare] shortcode.', 'listing-manager' ),
        ] );

        // Login
        $wp_customize->add_setting( 'listing_manager_pages_login', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_login', [
            'type'          => 'select',
            'label'         => esc_html__( 'Login', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_login',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_login] shortcode.', 'listing-manager' ),
        ] );

        // After Login
        $wp_customize->add_setting( 'listing_manager_pages_login_after', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_login_after', [
            'type'          => 'select',
            'label'         => esc_html__( 'After login', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_login_after',
            'choices'       => $pages,
            'description'   => esc_html__( 'User will be redirected at this page after successful login.', 'listing-manager' ),
        ] );

        // After successful listing creation
        $wp_customize->add_setting( 'listing_manager_pages_listing_create_after', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_listing_create_after', [
            'type'          => 'select',
            'label'         => esc_html__( 'After listing creation', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_listing_create_after',
            'choices'       => $pages,
            'description'   => esc_html__( 'User will be redirected at this page after successful listing creation.', 'listing-manager' ),
        ] );


        // Register
        $wp_customize->add_setting( 'listing_manager_pages_register', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_register', [
            'type'          => 'select',
            'label'         => esc_html__( 'Register', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_register',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_register] shortcode.', 'listing-manager' ),
        ] );

        // After register
        $wp_customize->add_setting( 'listing_manager_pages_register_after', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_register_after', [
            'type'          => 'select',
            'label'         => esc_html__( 'After register', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_register_after',
            'choices'       => $pages,
            'description'   => esc_html__( 'User will be redirected at this page after successful registration.', 'listing-manager' ),
        ] );

        // Reset password
        $wp_customize->add_setting( 'listing_manager_pages_password_reset', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_password_reset', [
            'type'          => 'select',
            'label'         => esc_html__( 'Reset password', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_password_reset',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_reset_password] shortcode.', 'listing-manager' ),
        ] );

        // Change password
        $wp_customize->add_setting( 'listing_manager_pages_password_change', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_pages_password_change', [
            'type'          => 'select',
            'label'         => esc_html__( 'Change password', 'listing-manager' ),
            'section'       => 'listing_manager_pages',
            'settings'      => 'listing_manager_pages_password_change',
            'choices'       => $pages,
            'description'   => esc_html__( 'Page containing [listing_manager_change_password] shortcode.', 'listing-manager' ),
        ] );

	    // Favorites
	    $wp_customize->add_setting( 'listing_manager_pages_favorites', [
		    'default'           => null,
		    'capability'        => 'edit_theme_options',
		    'sanitize_callback' => 'sanitize_text_field',
	    ] );

	    $wp_customize->add_control( 'listing_manager_pages_favorites', [
		    'type'          => 'select',
		    'label'         => esc_html__( 'Favorites', 'listing-manager' ),
		    'section'       => 'listing_manager_pages',
		    'settings'      => 'listing_manager_pages_favorites',
		    'choices'       => $pages,
		    'description'   => esc_html__( 'Page containing [listing_manager_favorites] shortcode.', 'listing-manager' ),
	    ] );
    }
}
