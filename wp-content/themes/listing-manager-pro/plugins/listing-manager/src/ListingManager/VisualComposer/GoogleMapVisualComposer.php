<?php

namespace ListingManager\VisualComposer;

use ListingManager\Annotation\Action;

class GoogleMapVisualComposer {
    /**
     * @Action(name="vc_before_init")
     */
    public static function handle() {
        vc_map( [
            'name'			=> esc_html__( 'Google Map', 'listing-manager' ),
            'category'		=> esc_html__( 'Listing Manager', 'listing-manager' ),
            'description'	=> esc_html__( 'Map showing listing posts.', 'listing-manager' ),
            'base'			=> 'listing_manager_google_map',
            'params'			=> [
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Latitude', 'listing-manager' ),
                    'param_name' 	=> 'latitude',
                    'std'			=> ''
                ],
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Longitude', 'listing-manager' ),
                    'param_name' 	=> 'longitude',
                    'std'			=> ''
                ],
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Zoom', 'listing-manager' ),
                    'param_name' 	=> 'zoom',
                    'std'			=> ''
                ],
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Height', 'listing-manager' ),
                    'param_name' 	=> 'height',
                    'std'			=> '500'
                ],
                [
                    'type' 			=> 'checkbox',
                    'param_name' 	=> 'map_geolocation',
                    'value'			=> [
                        esc_html__( 'Enable geolocation', 'listing-manager' ) => '1'
                    ],
                    'std'			=> ''
                ],
	            [
		            'type' 			=> 'checkbox',
		            'param_name' 	=> 'fitbounds',
		            'value'			=> [
			            esc_html__( 'Enable fitbounds', 'listing-manager' ) => '1'
		            ],
		            'std'			=> ''
	            ],
	            [
		            'type' 			=> 'checkbox',
		            'param_name' 	=> 'map_types',
		            'value'			=> [
			            esc_html__( 'Enable map types', 'listing-manager' ) => '1'
		            ],
		            'std'			=> ''
	            ],
	            [
		            'type' 			=> 'checkbox',
		            'param_name' 	=> 'map_zoom',
		            'value'			=> [
			            esc_html__( 'Enable map zoom', 'listing-manager' ) => '1'
		            ],
		            'std'			=> ''
	            ],
                [
                    'type' 			=> 'css_editor',
                    'heading' 		=> esc_html__( 'CSS', 'listing-manager' ),
                    'param_name' 	=> 'css',
                    'group' 		=> esc_html__( 'Design options', 'listing-manager' ),
                ],
            ],
        ] );
    }
}