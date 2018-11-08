<?php

namespace ListingManager\VisualComposer;

use ListingManager\Annotation\Action;

class ListingVisualComposer {
    /**
     * @Action(name="vc_before_init")
     */
    public static function handle() {
        vc_map( [
            'name'			=> esc_html__( 'Listings', 'listing-manager' ),
            'category'		=> esc_html__( 'Listing Manager', 'listing-manager' ),
            'description'	=> esc_html__( 'Show listings grid.', 'listing-manager' ),
            'base'			=> 'listing_manager_product_attribute',
            'params'			=> [
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Per page', 'listing-manager' ),
                    'param_name' 	=> 'per_page',
                    'std'			=> ''
                ],
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Columns', 'listing-manager' ),
                    'param_name' 	=> 'columns',
                    'std'			=> ''
                ],
	            [
		            'type' 			=> 'dropdown',
		            'heading' 		=> esc_html__( 'Orderby', 'listing-manager' ),
		            'param_name' 	=> 'orderby',
		            'value'			=> [
			            esc_html__( 'Title', 'listing-manager' ) 		=> 'title',
			            esc_html__( 'Date', 'listing-manager' ) 		=> 'date',
			            esc_html__( 'Event date', 'listing-manager' )   => 'event_date',
		            ],
		            'std'			=> 'labels'
	            ],
                [
                    'type' 			=> 'checkbox',
                    'param_name' 	=> 'featured',
                    'value'			=> [
                        esc_html__( 'Featured', 'listing-manager' ) => '1'
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