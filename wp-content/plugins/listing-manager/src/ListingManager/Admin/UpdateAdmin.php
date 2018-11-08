<?php

namespace ListingManager\Admin;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use stdClass;
use WP_Error;

class UpdateAdmin {
    public static $plugins = [];

    /**
     * @Filter(name="pre_set_site_transient_update_plugins")
     */
    public static function check_update( $transient ) {
	    if ( empty( $transient->checked['listing-manager/listing-manager.php'] ) ) {
		    return $transient;
	    }

	    if ( ! empty( $transient->last_checked ) ) {
			if ( $transient->last_checked > current_time( 'timestamp' ) - (24 * 60 * 60) ) {
				return $transient;
			}
	    }

        $purchase_code = get_theme_mod( 'listing_manager_purchase_code', null );
        $theme = wp_get_theme();

        $args = [
            'theme-name'        => $theme->get('Name'),
            'theme-version'     => $theme->get('Version'),
            'theme-stylesheet'  => $theme->stylesheet,
            'theme-template'    => $theme->template,
        ];

        if ( ! empty( $purchase_code ) ) {
            $args['purchase-code'] = $purchase_code;
        }

        $query = http_build_query( $args );

        if ( 0 === count( self::$plugins ) ) {
            $response = wp_remote_get( LISTING_MANAGER_API_PRODUCTS_URL . '?' . $query );

            if ( $response instanceof WP_Error ) {
                return $transient;
            }

            self::$plugins = json_decode( $response['body'] );
        }

        if ( ! empty( self::$plugins ) && is_array( self::$plugins->results ) ) {
            foreach ( self::$plugins->results as $plugin ) {
                $plugin_name = sprintf( '%s/%s.php', $plugin->slug, $plugin->slug );

                if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_name ) ) {
                    continue;
                }

                if ( empty( $plugin->current_version ) ) {
                    continue;
                }

                $plugin_data = get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin_name );
                $version     = version_compare( $plugin_data['Version'], $plugin->current_version, '<' );

                if ( $version ) {
                    $obj                 = new stdClass();
                    $obj->id             = 0;
                    $obj->slug           = $plugin->slug;
                    $obj->plugin         = $plugin->slug;
                    $obj->new_version    = $plugin->current_version;
                    $obj->upgrade_notice = $plugin->information;

                    // Purchase code is valid so the package is available
                    if ( ! empty( $plugin->package ) && ! empty( $purchase_code ) ) {
                        $obj->package = sprintf('%s?purchase-code=%s', $plugin->package, $purchase_code );
                    }
                    $transient->response[ $plugin_name ] = $obj;
                }
            }
        }

	    $transient->last_checked = current_time( 'timestamp' );
        return $transient;
    }

    /**
     * @Action(name="wp")
     */
    public static function check_purchase_code() {
        $transient = get_site_transient( 'update_plugins' );
        $purchase_code = get_theme_mod( 'listing_manager_purchase_code', null );

        if ( empty( $purchase_code ) && ! empty( $transient ) ) {
            if ( is_array( $transient->no_update ) ) {
                foreach ( $transient->no_update as $key => $value ) {
                    if ( 'listing-manager' === substr( $key, 0, strlen( 'listing-manager' ) ) ) {
                        if ( ! empty( $value['package'] ) ) {
                            $transient->no_update[$value]['package'];
                        }
                    }
                }
            }
        }

        set_site_transient('update_plugins', $transient );
    }

    /**
     * @Action(name="wp_ajax_listing_manager_verify_purchase_code");
     */
    public static function verify_purchase_code() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        // Missing purchase code
        if ( empty( $_GET['purchase-code'] ) ) {
            echo json_encode( [
                'valid' => false,
            ] );

            exit;
        }

        // Check the purchase code on server
        $response = wp_remote_get( LISTING_MANAGER_API_VERIFY_URL . '?purchase-code=' . $_GET['purchase-code'] );

        // Server is not responding or an error occurred
        if ( $response instanceof WP_Error ) {
            echo json_encode( [
                'valid' => false,
            ] );

            exit();
        }

        $result = json_decode( $response['body'] );

        // Purchase code is valid
        if ( '1' == $result->valid ) {
            set_theme_mod( 'listing_manager_purchase_code', $_GET['purchase-code'] );

            echo json_encode( [
                'valid' => true,
            ] );

            exit();
        }

        echo json_encode( [
            'valid' => false,
        ] );

        exit();
    }
}