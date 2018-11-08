<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class LocationTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['location'] = [
            'label'		=> esc_html__( 'Location', 'listing-manager' ),
            'target'	=> 'location',
            'class'		=> [ 'show_if_listing' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/location.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        $fields = [ 'latitude', 'longitude' ];

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_LISTING_PREFIX . 'location_' . $field;
            if ( isset( $_POST[ $id ] ) ) {
                update_post_meta( $post_id, $id, sanitize_text_field( $_POST[ $id ] ) );
            }
        }
    }

    /**
     * @Filter(name="listing_manager_submission_fields")
     */
    public static function front_fields( $fields ) {
        $fields[] = [
	        'forms'             => ['general', 'event', 'property' ],
            'type'              => 'fieldset',
            'id'                => 'location',
            'legend'            => esc_html__( 'Location', 'listing-manager' ),
            'collapsible'       => true,
            'fields'            => [
                [
                	'id'        => LISTING_MANAGER_LISTING_PREFIX . 'location',
                    'type'      => 'google-map',
                    'label'     => esc_html__( 'Search by address', 'listing-manager' ),
                    'required'  => false,
                ],
//                [
//                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'location_latitude',
//                    'type'      => 'text',
//                    'label'     => esc_html__( 'Latitude', 'listing-manager' ),
//                    'required'  => false,
//                ],
//                [
//                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'location_longitude',
//                    'type'      => 'text',
//                    'label'     => esc_html__( 'Longitude', 'listing-manager' ),
//                    'required'  => false,
//                ],
	            [
		            'id'        => LISTING_MANAGER_LISTING_PREFIX . 'locations',
		            'type'      => 'taxonomy',
		            'taxonomy'  => 'locations',
		            'label'     => esc_html__( 'Locations', 'listing-manager' ),
		            'required' 	=> false,
		            'chained'   => true,
	            ],
            ]
        ];

        return $fields;
    }

    /**
     * Basic information for product tabs
     *
     * @access public
     * @return array
     */
    public static function product_tab_info() {
        return [
            'id'    => 'location',
            'title' => esc_html__( 'Location', 'listing-manager' )
        ];
    }

    /**
     * @Filter(name="woocommerce_product_tabs")
     */
    public static function product_tab( $tabs ) {
        $empty = true;

        $latitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true );
        $longitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true );

        if ( ! empty( $latitude ) && ! empty( $longitude ) ) {
            $empty = false;
        }

        if ( ! $empty ) {
            $info = self::product_tab_info();

            $tabs[ $info['id'] ] = [
                'title'    => $info['title'],
                'callback' => [ __CLASS__, 'product_tab_content' ],
                'priority' => 20,
            ];
        }

        return $tabs;
    }

    /**
     * Product tab content
     *
     * @access public
     * @return void
     */
    public static function product_tab_content() {
        wc_get_template( 'listing-manager/tabs/location.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}