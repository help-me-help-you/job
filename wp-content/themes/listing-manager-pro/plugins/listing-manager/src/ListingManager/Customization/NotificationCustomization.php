<?php

namespace ListingManager\Customization;

use ListingManager\Annotation\Action;
use WP_Customize_Manager;

class NotificationCustomization {
	/**
	 * @Action(name="customize_register");
	 */
	public static function customizations( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_section( 'listing_manager_notifications', [
			'title'     => esc_html__( 'Listing Manager Notifications', 'listing-manager' ),
			'priority'  => 17,
		] );

		$wp_customize->add_setting( 'listing_manager_notifications_expiring', [
			'default'           => 48,
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field',
		] );

		$wp_customize->add_control( 'listing_manager_notifications_expiring', [
			'type'          => 'text',
			'label'         => esc_html__( 'Expiring package', 'listing-manager' ),
			'description'   => esc_html__( 'How many hours before the package expiration the notification should be send.', 'listing-manager' ),
			'section'       => 'listing_manager_notifications',
			'settings'      => 'listing_manager_notifications_expiring',
		] );
	}
}