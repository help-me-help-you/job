<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class BrandingTab {
    /**
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['branding'] = [
            'label'		=> esc_html__( 'Branding', 'listing-manager' ),
            'target'	=> 'branding',
            'class'		=> [ 'show_if_listing' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/branding.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        $fields = array( 'name', 'slogan', 'color', 'logo_urls', 'logo_names' );

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_LISTING_PREFIX . 'branding_' . $field;
            if ( isset( $_POST[ $id ] ) ) {
                update_post_meta( $post_id, $id, $_POST[ $id ] );
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
            'id'                => 'branding',
            'legend'            => esc_html__( 'Branding', 'listing-manager' ),
            'collapsible'       => true,
            'fields'            => [
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'branding_name',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Name', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'branding_slogan',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Slogan', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'branding_color',
                    'type'      => 'text',
                    'label'     => esc_html__( 'Color', 'listing-manager' ),
                    'required'  => false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'branding_logo',
                    'type'      => 'file',
                    'label'     => esc_html__( 'Logo', 'listing-manager' ),
                    'required'  => false,
                    'rows'      => 5,
                ],
            ]
        ];

        return $fields;
    }

    /**
     * @Filter(name="listing_manager_file_fields")
     */
    public static function file_fields( $fields ) {
        $fields[] = LISTING_MANAGER_LISTING_PREFIX . 'branding_logo';
        return $fields;
    }

    /**
     * @Filter(name="woocommerce_product_tabs")
     */
    public static function product_tab( $tabs ) {
        $empty = true;
        $fields = [ 'name', 'slogan', 'color', 'logo_urls', 'logo_names' ];

        foreach ( $fields as $field ) {
            $value = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'branding_' . $field, true );

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
     * Basic information for product tabs
     *
     * @access public
     * @return array
     */
    public static function product_tab_info() {
        return [
            'id'    => 'branding',
            'title' => esc_html__( 'Branding', 'listing-manager' )
        ];
    }

    /**
     * Product tab content
     *
     * @access public
     * @return void
     */
    public static function product_tab_content() {
        wc_get_template( 'listing-manager/tabs/branding.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }
}