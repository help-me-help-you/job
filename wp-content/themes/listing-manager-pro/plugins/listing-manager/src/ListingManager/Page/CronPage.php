<?php

namespace ListingManager\Page;

use ListingManager\Annotation\Action;

class CronPage {
	/**
	 * @Action(name="admin_menu", priority=60)
	 */
	public static function admin_menu() {
		add_submenu_page(
			'listing-manager',
			esc_html__('Cron', 'listing-manager' ),
			esc_html__('Cron', 'listing-manager' ),
			'manage_options',
			'listing_manager_cron',
			[ __CLASS__, 'template' ]
		);
	}

	public static function template() {
		wc_get_template( 'listing-manager/pages/cron.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}