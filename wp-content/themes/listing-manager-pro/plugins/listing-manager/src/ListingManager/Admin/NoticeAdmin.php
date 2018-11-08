<?php

namespace ListingManager\Admin;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class NoticeAdmin {
    /**
     * @Action(name="admin_notices")
     */
    public static function missing_purchase_code() {
        $purchase_code = get_theme_mod( 'listing_manager_purchase_code', null );

        if ( empty( $purchase_code ) ) {
            wc_get_template( 'listing-manager/admin/missing-purchase-code.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
        }
    }
}