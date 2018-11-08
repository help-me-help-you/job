<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class ContactTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['contact'] = [
            'label'		=> esc_html__( 'Contact', 'listing-manager' ),
            'target'	=> 'contact',
            'class'		=> [ 'show_if_listing' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/contact.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        $fields = [ 'email', 'phone', 'website', 'address' ];

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_LISTING_PREFIX . 'contact_' . $field;
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
	        'forms'             => ['general', 'property'],
            'type'              => 'fieldset',
            'id'                => 'contact',
            'legend'            => esc_html__( 'Contact', 'listing-manager' ),
            'collapsible'       => true,
            'fields'            => [
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'contact_email',
                    'type'      => 'email',
                    'label'     => esc_html__( 'E-mail', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'contact_phone',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Phone', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'contact_website',
                    'type'      => 'url',
                    'label'     => esc_html__( 'Website', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'contact_address',
                    'type'      => 'textarea',
                    'label'     => esc_html__( 'Address', 'listing-manager' ),
                    'required'  => false,
                    'rows'      => 5,
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
        $fields = [ 'email', 'phone', 'website', 'address' ];


        foreach ( $fields as $field ) {
            $value = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'contact_' . $field, true );

            if ( ! empty( $value ) ) {
                $empty = false;
            }
        }

        if ( ! $empty ) {
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
            'id'    => 'contact',
            'title' => esc_html__( 'Contact', 'listing-manager' )
        ];
    }

    /**
     * Product tab content
     *
     * @access public
     * @return void
     */
    public static function product_tab_content() {
        wc_get_template( 'listing-manager/tabs/contact.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}