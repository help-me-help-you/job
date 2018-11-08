<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;

use WP_Customize_Manager;

class SubmissionCustomization {
    /**
     * @Action(name="customize_register");
     */
    public static function customizations( WP_Customize_Manager $wp_customize ) {
        $wp_customize->add_section( 'listing_manager_submission', [
            'title' 	=> esc_html__( 'Listing Manager Submission', 'listing-manager' ),
            'priority' 	=> 12,
        ] );

        // Submission type
        $wp_customize->add_setting( 'listing_manager_submission_type', [
            'default'           => 'free',
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

	    $submissions = [
		    'free' 		    => esc_html__( 'Free', 'listing-manager' ),
		    'packages' 	    => esc_html__( 'Packages', 'listing-manager' ),
	    ];

	    if ( class_exists( 'WC_Memberships' ) ) {
	    	$submissions['memberships'] = esc_html__( 'Memberships', 'listing-manager' );
	    }

        $wp_customize->add_control( 'listing_manager_submission_type', [
            'type'          => 'select',
            'label'         => esc_html__( 'Type', 'listing-manager' ),
            'section'       => 'listing_manager_submission',
            'settings'      => 'listing_manager_submission_type',
            'choices'       => $submissions,
            'description'   => esc_html__( 'Select if you want to use free for all front end submission, package system or memberships (WooCommerce Memberships plugin required).', 'listing-manager' ),
        ] );

        // Review before
        $wp_customize->add_setting( 'listing_manager_submission_review_before', [
            'default'           => null,
            'capability'        => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        ] );

        $wp_customize->add_control( 'listing_manager_submission_review_before', [
            'type'          => 'checkbox',
            'label'         => esc_html__( 'Review before', 'listing-manager' ),
            'section'       => 'listing_manager_submission',
            'settings'      => 'listing_manager_submission_review_before',
        ] );

        // Roles
	    $default_roles = array_keys( wp_roles()->get_names() );
	    $wp_customize->add_setting( 'listing_manager_submission_roles', [
		    'default'           => $default_roles,
		    'capability'        => 'edit_theme_options',
		    'sanitize_callback' => [ 'CheckboxMultipleControlCustomization', 'sanitize' ],
	    ] );

	    $wp_customize->add_control( new \CheckboxMultipleControlCustomization( $wp_customize, 'listing_manager_submission_roles', [
		    'section'       => 'listing_manager_submission',
		    'label'         => esc_html__( 'Roles', 'listing-manager' ),
		    'choices'       => wp_roles()->get_names(),
		    'description'   => esc_html__( 'Roles allowed to edit listings on front end.', 'listing-manager' ),
	    ] ) );

        // Forms
	    $forms = apply_filters( 'listing_manager_submission_forms', [] );

	    $wp_customize->add_setting( 'listing_manager_submission_forms', [
		    'default'           => $forms,
		    'capability'        => 'edit_theme_options',
		    'sanitize_callback' => [ 'CheckboxMultipleControlCustomization', 'sanitize' ],
	    ] );

	    $wp_customize->add_control( new \CheckboxMultipleControlCustomization( $wp_customize, 'listing_manager_submission_forms', [
		    'section'       => 'listing_manager_submission',
		    'label'         => esc_html__( 'Disabled forms', 'listing-manager' ),
		    'choices'       => $forms,
		    'description'   => esc_html__( 'After adding new form you must allow it here.', 'listing-manager' ),
	    ] ) );
    }
}