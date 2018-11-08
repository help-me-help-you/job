<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use ListingManager\Utilities;

class OpeningHoursTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['opening_hours'] = [
            'label'  => esc_html__( 'Opening Hours', 'listing-manager' ),
            'target' => 'opening_hours',
            'class'  => [ 'show_if_listing' ],
        ];
        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/opening-hours.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        foreach ( Utilities::get_days() as $key => $value ) {
            $field_from = LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_from';
            if ( isset( $_POST[ $field_from ] ) ) {
                update_post_meta( $post_id, $field_from, sanitize_text_field( $_POST[ $field_from ] ) );
            }

            $field_to = LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_to';
            if ( isset( $_POST[ $field_from ] ) ) {
                update_post_meta( $post_id, $field_to, sanitize_text_field( $_POST[ $field_to ] ) );
            }

            $field_custom = LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_custom';
            if ( isset( $_POST[ $field_custom ] ) ) {
                update_post_meta( $post_id, $field_custom, sanitize_text_field( $_POST[ $field_custom ] ) );
            }
        }
    }

    /**
     * @Filter(name="listing_manager_submission_fields")
     */
    public static function front_fields( $fields ) {
        $fields[] = [
	        'forms'             => ['general', ],
            'type'              => 'fieldset',
            'id'                => 'opening-hours',
            'legend'            => esc_html__( 'Opening hours', 'listing-manager' ),
            'collapsible'       => true,
            'fields'            => [
                [
                    'label' 	=> esc_html__( 'Opening hours', 'listing-manager' ),
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'opening_hour',
                    'type'      => 'opening-hours',
                ],
            ]
        ];

        return $fields;
    }

    /**
     * @Filter(name="woocommerce_product_tabs")
     */
    public static function product_tab( $tabs ) {
        $empty = true;

        foreach ( Utilities::get_days() as $key => $value ) {
            $from = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_from', true );

            if ( ! empty( $from ) ) {
                $empty = false;
                break;
            }

            $to = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_to', true );

            if ( ! empty( $to ) ) {
                $to = false;
                break;
            }

            $custom = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'opening_hour_' . $key . '_custom', true );

            if ( ! empty( $custom ) ) {
                $empty = false;
                break;
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
     * Basic information for product tabs
     *
     * @access public
     * @return array
     */
    public static function product_tab_info() {
        return [
            'id'    => 'opening_hours',
            'title' => esc_html__( 'Opening Hours', 'listing-manager' )
        ];
    }

    /**
     * Product tab content
     *
     * @access public
     * @return void
     */
    public static function product_tab_content() {
        wc_get_template( 'listing-manager/tabs/opening_hours.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}