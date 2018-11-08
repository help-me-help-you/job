<?php

namespace ListingManager\Admin;

use ListingManager\Annotation\Action;

class ActionsAdmin {
	/**
	 * @Action(name="admin_bar_menu", priority=100)
	 */
	public static function add_actions() {
		global $wp_admin_bar;

		if ( ! is_super_admin() ) {
			return;
		}

		$menu_id = 'listing-manager';

		$wp_admin_bar->add_menu( [
			'id'        => $menu_id,
			'title'     => esc_html__( 'Listing Manager', 'listing-manager-' ),
			'href'      => '' ] );

		$wp_admin_bar->add_menu( [
			'parent'    => $menu_id,
			'title'     => esc_html__( 'Listings', 'listing-manager' ),
			'id'        => 'listing-manager-listings',
			'href'      => get_admin_url() . 'edit.php?post_type=product&product_type=listing',
		] );

		$wp_admin_bar->add_menu( [
			'parent'    => $menu_id,
			'title'     => esc_html__( 'Packages', 'listing-manager' ),
			'id'        => 'listing-manager-packages',
			'href'      => get_admin_url() . 'edit.php?post_type=product&product_type=package',
		] );

		$wp_admin_bar->add_menu( [
			'parent'    => $menu_id,
			'title'     => esc_html__( 'Micropayments', 'listing-manager' ),
			'id'        => 'listing-manager-micropayments',
			'href'      => get_admin_url() . 'edit.php?post_type=product&product_type=micropayment',
		] );

		$wp_admin_bar->add_menu( [
			'parent'    => $menu_id,
			'title'     => esc_html__( 'Front End Fields', 'listing-manager' ),
			'id'        => 'listing_manager_front_end_fields',
			'href'      => get_admin_url() . 'admin.php?page=listing_manager_front_end_fields',
		] );

		$wp_admin_bar->add_menu( [
			'parent'    => $menu_id,
			'title'     => esc_html__( 'Cron', 'listing-manager' ),
			'id'        => 'listing_manager_cron',
			'href'      => get_admin_url() . 'admin.php?page=listing_manager_cron',
		] );

		$wp_admin_bar->add_menu( [
			'parent'    => $menu_id,
			'title'     => esc_html__( 'Statistics', 'listing-manager' ),
			'id'        => 'listing_manager_statistics',
			'href'      => get_admin_url() . 'admin.php?page=listing_manager_statistics',
		] );
	}
}