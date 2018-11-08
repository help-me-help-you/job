<?php

namespace ListingManager\VisualComposer;

use ListingManager\Annotation\Action;

class CompanyVisualComposer {
    /**
     * @Action(name="vc_before_init")
     */
    public static function handle() {
        vc_map( [
            'name'			=> esc_html__( 'Companies', 'listing-manager' ),
            'category'		=> esc_html__( 'Listing Manager', 'listing-manager' ),
            'description'	=> esc_html__( 'Show agents.', 'listing-manager' ),
            'base'			=> 'listing_manager_companies',
            'params'			=> [
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Per page', 'listing-manager' ),
                    'param_name' 	=> 'per_page',
                    'std'			=> '4'
                ],
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Columns', 'listing-manager' ),
                    'param_name' 	=> 'columns',
                    'std'			=> '4'
                ],
                [
                    'type' 			=> 'css_editor',
                    'heading' 		=> esc_html__( 'CSS', 'listing-manager' ),
                    'param_name' 	=> 'css',
                    'group' 		=> esc_html__( 'Design options', 'listing-manager' ),
                ],
            ]
        ] );
    }
}