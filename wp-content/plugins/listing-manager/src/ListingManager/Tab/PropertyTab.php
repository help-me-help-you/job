<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class PropertyTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['property'] = [
            'label'		=> esc_html__( 'Property', 'listing-manager' ),
            'target'	=> 'property',
            'class'		=> [ 'show_if_listing' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/property.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        $info = self::product_tab_info();
        $fields = $info['fields'];

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_LISTING_PREFIX . 'property_' . $field;
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
	        'forms'             => ['property', ],
            'type'              => 'fieldset',
            'id'                => 'property',
            'legend'            => esc_html__( 'Property', 'listing-manager' ),
            'collapsible'       => true,
            'fields'            => [
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_reference',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Reference', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_year_built',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Year built', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_contract',
                    'type'      => 'taxonomy',
                    'taxonomy'  => 'contracts',
                    'label'     => esc_html__( 'Contract', 'listing-manager' ),
                    'required' 	=> false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_rooms',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Rooms', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_bathrooms',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Bathrooms', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_bedrooms',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Bedrooms', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_garages',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Garages', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_parking_slots',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Parking slots', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_home_area',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Home area', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_lot_area',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Lot area', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'property_lot_dimensions',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Lot dimensions', 'listing-manager' ),
                    'required'  => false,
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
            'id'    	=> 'property',
            'title' 	=> esc_html__( 'Property Attributes', 'listing-manager' ),
            'fields'	=> [ 'reference', 'year_built', 'contract', 'rooms', 'bathrooms', 'bedrooms', 'garages', 'parking_slots', 'home_area', 'lot_area', 'lot_dimensions' ],
        ];
    }

	/**
	 * @Filter(name="woocommerce_product_tabs")
	 */
    public static function product_tab( $tabs ) {
        $empty = true;
        $info = self::product_tab_info();

        foreach ( $info['fields'] as $field ) {
            $value = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'property_' . $field, true );

            if ( ! empty( $value ) ) {
                $empty = false;
            }
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
        wc_get_template( 'listing-manager/tabs/property.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}