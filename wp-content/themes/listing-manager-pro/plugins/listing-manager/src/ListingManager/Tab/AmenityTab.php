<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class AmenityTab {
    /**
     * @Filter(name="woocommerce_product_tabs")
     */
    public static function product_tab( $tabs ) {
        $terms = get_the_terms( get_the_ID(), 'amenities' );

        if ( is_array( $terms ) ) {
            $info = self::product_tab_info();

            $tabs[ $info['id'] ] = [
                'title'     => $info['title'],
                'callback'  => [ __CLASS__, 'product_tab_content' ],
                'priority'  => 20,
            ];
        }

        return $tabs;
    }

    /**
     * Basic information for product tabs
     *
     * @access public
     * @return array
     */
    public static function product_tab_info() {
        return [
            'id'    => 'amenities',
            'title' => esc_html__( 'Amenities', 'listing-manager' )
        ];
    }

    /**
     * Product tab content
     *
     * @access public
     * @return void
     */
    public static function product_tab_content() {
        wc_get_template( 'listing-manager/tabs/amenities.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}