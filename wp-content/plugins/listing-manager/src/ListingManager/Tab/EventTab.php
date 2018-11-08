<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class EventTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['event'] = [
            'label'		=> esc_html__( 'Event', 'listing-manager' ),
            'target'	=> 'event',
            'class'		=> [ 'show_if_listing' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/event.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        $fields = [ 'date', 'time', 'date_end', 'time_end' ];

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_LISTING_PREFIX . 'event_' . $field;
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
	        'forms'             => ['event', ],
            'type'              => 'fieldset',
            'id'                => 'event',
            'legend'            => esc_html__( 'Event', 'listing-manager' ),
            'collapsible'       => true,
            'fields'            => [
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'event_date',
                    'type'      => 'date',
                    'label'     => esc_html__( 'Start Date', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'event_time',
                    'type'      => 'time',
                    'label'     => esc_html__( 'Start Time', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'event_date_end',
                    'type'      => 'date',
                    'label'     => esc_html__( 'End Date', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'event_time_end',
                    'type'      => 'time',
                    'label'     => esc_html__( 'End Time', 'listing-manager' ),
                    'required'  => false,
                ],
            ]
        ];

        return $fields;
    }
}