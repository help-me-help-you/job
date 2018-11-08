<?php

namespace ListingManager\Page;

use ListingManager\Annotation\Action;

class FrontEndFieldsPage {
	/**
	 * @Action(name="admin_menu", priority=50)
	 */
	public static function admin_menu() {
		add_submenu_page(
			'listing-manager',
			esc_html__('Front End Fields', 'listing-manager' ),
			esc_html__('Front End Fields', 'listing-manager' ),
			'manage_options',
			'listing_manager_front_end_fields',
			[ __CLASS__, 'template' ]
		);
	}

	public static function template() {
		wc_get_template( 'listing-manager/pages/front-end-fields.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
	}
}