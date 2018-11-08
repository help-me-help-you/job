<?php

namespace ListingManager\VisualComposer;

use ListingManager\Annotation\Action;
use ListingManager\Logic\FilterLogic;

class FilterVisualComposer {
    /**
     * @Action(name="vc_before_init")
     */
    public static function handle() {
        $params = [
            [
                'type' 			=> 'textfield',
                'heading' 		=> esc_html__( 'Button text', 'listing-manager' ),
                'param_name' 	=> 'button_title',
                'std'			=> ''
            ],
            [
                'type' 			=> 'textfield',
                'heading' 		=> esc_html__( 'Return URL', 'listing-manager' ),
                'param_name' 	=> 'return_url',
                'std'			=> '',
            ],
            [
                'type' 			=> 'dropdown',
                'heading' 		=> esc_html__( 'Input titles', 'listing-manager' ),
                'param_name' 	=> 'input_titles',
                'value'			=> [
                    esc_html__( 'Labels', 'listing-manager' ) 		=> 'labels',
                    esc_html__( 'Placeholders', 'listing-manager' ) => 'placeholders',
                ],
                'std'			=> 'labels'
            ],
            [
                'type' 			=> 'css_editor',
                'heading' 		=> esc_html__( 'CSS', 'listing-manager' ),
                'param_name' 	=> 'css',
                'group' 		=> esc_html__( 'Design options', 'listing-manager' ),
            ],
        ];

        $fields = FilterLogic::get_fields();
        if ( is_array( $fields ) ) {
            foreach ( $fields as $field_key => $field_value ) {
                $params[] = [
                    'type' 			=> 'checkbox',
                    'param_name' 	=> 'hide_' . $field_key,
                    'value'			=> [
                        esc_html__( 'Hide', 'listing-manager' ) . ' ' . $field_value  => '1',
                    ],
                    'std'			=> ''
                ];
            }
        }


        vc_map( [
            'name'			=> esc_html__( 'Filter', 'listing-manager' ),
            'category'		=> esc_html__( 'Listing Manager', 'listing-manager' ),
            'description'	=> esc_html__( 'Show filter.', 'listing-manager' ),
            'base'			=> 'listing_manager_filter',
            'params'			=> $params
        ] );
    }
}