<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class PackageTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['package'] = [
            'label'		=> esc_html__( 'Package', 'listing-manager' ),
            'target'	=> 'package',
            'class'		=> [ 'show_if_package' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/package.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_package")
     */
    public static function save( $post_id ) {
        $fields = [ 'duration', 'limit', 'class' ];

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_PACKAGE_PREFIX . $field;
            if ( isset( $_POST[ $id ] ) ) {
                update_post_meta( $post_id, $id, $_POST[ $id ] );
            }
        }

        $id = LISTING_MANAGER_PACKAGE_PREFIX . 'exclude';
        if ( isset( $_POST[ $id ] ) && '1' === $_POST[ $id ] ) {
            update_post_meta( $post_id, $id, sanitize_text_field( '1' ) );
        } else {
            delete_post_meta( $post_id, $id );
        }
    }
}