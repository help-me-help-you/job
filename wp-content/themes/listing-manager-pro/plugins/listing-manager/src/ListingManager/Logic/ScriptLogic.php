<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class ScriptLogic {
    /**
     * @Action(name="wp_enqueue_scripts", priority=100)
     */
    public static function enqueue_frontend() {
        global $wp_scripts;

        $queryui = $wp_scripts->query( 'jquery-ui-core' );
        $url = '//ajax.googleapis.com/ajax/libs/jqueryui/' . $queryui->ver . '/themes/smoothness/jquery-ui.css';

        wp_enqueue_style( 'jquery-ui-smoothness', $url, false, null );

        $style = get_theme_mod( 'listing_manager_style', 'none' );
        if ( 'default' === $style ) {
            wp_enqueue_style( 'listing-manager', plugins_url( '/listing-manager/assets/css/listing-manager.css' ) );
        }

	    wp_enqueue_style( 'listing-manager-rating', plugins_url( '/listing-manager/assets/css/listing-manager-rating.css' ) );
	    wp_enqueue_style( 'listing-manager-map', plugins_url( '/listing-manager/assets/css/listing-manager-map.css' ) );

        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script( 'jquery-chained', plugins_url( '/listing-manager/assets/js/jquery.chained.min.js' ), [ 'jquery' ] );
	    wp_enqueue_script( 'jquery-barrating', plugins_url( '/listing-manager/assets/js/jquery.barrating.min.js' ), [ 'jquery' ] );

        $autocomplete = get_theme_mod( 'listing_manager_autocomplete', false );
        if ( ! empty( $autocomplete ) ) {
            wp_enqueue_script( 'typehead', plugins_url( '/listing-manager/assets/js/typeahead.min.js' ), [ 'jquery' ] );
        }

        wp_enqueue_script( 'listing-manager', plugins_url( '/listing-manager/assets/js/listing-manager.js' ), [ 'jquery', 'jquery-ui-datepicker' ] );

        $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null );
        if ( ! empty( $api_key ) ) {
            wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=' . $api_key );
            wp_enqueue_script( 'google-maps-infobox', plugins_url( '/listing-manager/assets/js/google-maps/infobox.js' ), [ 'jquery' ] );
            wp_enqueue_script( 'google-maps-richmarker', plugins_url( '/listing-manager/assets/js/google-maps/richmarker.js' ), [ 'jquery' ] );
            wp_enqueue_script( 'google-maps-markerclusterer', plugins_url( '/listing-manager/assets/js/google-maps/markerclusterer.js' ), [ 'jquery' ] );
            wp_enqueue_script( 'google-maps-maps', plugins_url( '/listing-manager/assets/js/google-maps/maps.js' ), [ 'jquery' ] );
	        wp_enqueue_script( 'google-maps-search', plugins_url( '/listing-manager/assets/js/google-maps/search.js' ), [ 'jquery' ] );
        }
    }

    /**
     * @Action(name="admin_enqueue_scripts")
     */
    public static function enqueue_backend() {
        wp_enqueue_style( 'timepicker', plugins_url( '/listing-manager/assets/css/jquery.timepicker.css' ) );
        wp_enqueue_style( 'listing-manager-admin', plugins_url( '/listing-manager/assets/css/listing-manager-admin.css' ) );
        wp_enqueue_style( 'listing-manager-icons', plugins_url( '/listing-manager/assets/fonts/listing-manager/style.css' ) );

        wp_enqueue_script( 'cookie', plugins_url( '/listing-manager/assets/js/jquery.cookie.js' ), [ 'jquery' ] );
        wp_enqueue_script( 'timepicker', plugins_url( '/listing-manager/assets/js/jquery.timepicker.min.js' ), [ 'jquery' ] );
        wp_enqueue_script( 'listing-manager-admin', plugins_url( '/listing-manager/assets/js/listing-manager-admin.js' ), [ 'jquery' ] );        

        $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null );
        if ( ! empty( $api_key ) ) {
            wp_enqueue_script( 'google-maps', '//maps.googleapis.com/maps/api/js?libraries=weather,geometry,visualization,places,drawing&key=' . $api_key);
            wp_enqueue_script( 'google-maps-search', plugins_url( '/listing-manager/assets/js/google-maps/search-admin.js' ), [ 'jquery' ] );
        }
    }
}