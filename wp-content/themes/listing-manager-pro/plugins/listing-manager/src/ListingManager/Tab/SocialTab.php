<?php

namespace ListingManager\Tab;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class SocialTab {
    /**
     * @Filter(name="woocommerce_product_tabs")
     */
    public static function product_tab( $tabs ) {
        $networks = self::get_networks();
        $empty = true;

        foreach( $networks as $key => $value ) {
            $meta = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'social_' . $key, true );
            if ( ! empty( $meta ) ) {
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
     * @Filter(name="woocommerce_product_data_tabs")
     */
    public static function tab( $tabs ) {
        $tabs['social'] = [
            'label'		=> esc_html__( 'Social', 'listing-manager' ),
            'target'	=> 'social',
            'class'		=> [ 'show_if_listing' ],
        ];

        return $tabs;
    }

    /**
     * @Action(name="woocommerce_product_data_panels")
     */
    public static function panel() {
        wc_get_template( 'listing-manager/panels/social.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * @Action(name="woocommerce_process_product_meta_listing")
     */
    public static function save( $post_id ) {
        $networks = self::get_networks();
        $fields = [];

        if ( is_array( $networks ) ) {
            foreach ( $networks as $key => $value ) {
                $fields[] = $key;
            }
        }

        foreach ( $fields as $field ) {
            $id = LISTING_MANAGER_LISTING_PREFIX . 'social_' . $field;
            if ( isset( $_POST[ $id ] ) ) {
                update_post_meta( $post_id, $id, $_POST[ $id ] );
            }
        }
    }

    /**
     * @Filter(name="listing_manager_submission_fields")
     */
    public static function front_fields( $fields ) {
        $networks = self::get_networks();
        $result = [];

        if ( is_array( $networks ) ) {
            foreach ( $networks as $key => $value ) {
                $result[] = [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'social_' . $key,
                    'type'      => 'url',
                    'label'     => $value,
                    'required'  => false,
                ];
            }
        }

        $fields[] = [
	        'forms'         => ['general', 'event', ],
            'type'          => 'fieldset',
            'id'            => 'social',
            'legend'        => esc_html__( 'Social', 'listing-manager' ),
            'collapsible'   => true,
            'fields'        => $result,
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
            'id'    => 'social',
            'title' => esc_html__( 'Social', 'listing-manager' )
        ];
    }

    /**
     * Product tab content
     *
     * @access public
     * @return void
     */
    public static function product_tab_content() {
        wc_get_template( 'listing-manager/tabs/social.php', [], '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * Get all supported networks
     *
     * @access public
     * @return array
     */
    public static function get_networks() {
        return [
            'facebook' 		=> esc_html__( 'Facebook', 'listing-manager' ),
            'twitter' 		=> esc_html__( 'Twitter', 'listing-manager' ),
            'linkedin' 		=> esc_html__( 'Linkedin', 'listing-manager' ),
            'google' 		=> esc_html__( 'Google+', 'listing-manager' ),
            'youtube' 		=> esc_html__( 'YouTube', 'listing-manager' ),
            'vimeo' 		=> esc_html__( 'Vimeo', 'listing-manager' ),
            'foursquare' 	=> esc_html__( 'Foursquare', 'listing-manager' ),
            'skype' 		=> esc_html__( 'Skype', 'listing-manager' ),
            'dribbble' 		=> esc_html__( 'Dribbble', 'listing-manager' ),
            'behance' 		=> esc_html__( 'Behance', 'listing-manager' ),
            'instagram' 	=> esc_html__( 'Instagram', 'listing-manager' ),
            'pinterest' 	=> esc_html__( 'Pinterest', 'listing-manager' ),
        ];
    }
}