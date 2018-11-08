<?php

namespace ListingManager\Admin;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class MenuAdmin {
    /**
     * @Action(name="custom_menu_order")
     */
    public static function custom_menu_order() {
        return true;
    }

    /**
     * @Action(name="admin_menu")
     */
    public static function admin_menu() {
        add_menu_page( esc_attr__( 'Listing Manager', 'listing-manager' ), esc_attr__( 'Listing Manager', 'listing-manager' ), 'edit_posts', 'listing-manager', null, null, '56' );
        add_submenu_page( 'listing-manager', esc_attr__( 'Locations', 'listing-manager' ), esc_attr__( 'Locations', 'listing-manager' ), 'edit_posts', 'edit-tags.php?taxonomy=locations', false );
        add_submenu_page( 'listing-manager', esc_attr__( 'Amenities', 'listing-manager' ), esc_attr__( 'Amenities', 'listing-manager' ), 'edit_posts', 'edit-tags.php?taxonomy=amenities', false );
        add_submenu_page( 'listing-manager', esc_attr__( 'Contracts', 'listing-manager' ), esc_attr__( 'Contracts', 'listing-manager' ), 'edit_posts', 'edit-tags.php?taxonomy=contracts', false );
        remove_submenu_page( 'listing-manager', 'listing-manager' );
    }

    /**
     * @Filter(name="menu_order")
     */
    public static function menu_reorder( $menu_order ) {
        global $submenu;

        $menu_slugs = [ 'listing-manager', ];

        if ( ! empty( $submenu ) && ! empty( $menu_slugs ) && is_array( $menu_slugs ) ) {
            foreach( $menu_slugs as $slug ) {
                if ( ! empty( $submenu[ $slug ] ) ) {
                    usort( $submenu[ $slug ], [ __CLASS__, 'sort_alphabet' ] );
                }
            }
        }

        return $menu_order;
    }

    public static function sort_alphabet( $a, $b ) {
        return strnatcmp( $a[0], $b[0] );
    }
}