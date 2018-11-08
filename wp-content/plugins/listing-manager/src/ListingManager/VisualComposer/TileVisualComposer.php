<?php

namespace ListingManager\VisualComposer;

use ListingManager\Annotation\Action;

class TileVisualComposer {
    /**
     * @Action(name="vc_before_init")
     */
    public static function handle() {
        vc_map( [
            'name'			=> esc_html__( 'Tiles', 'listing-manager' ),
            'category'		=> esc_html__( 'Listing Manager', 'listing-manager' ),
            'description'	=> esc_html__( 'Show listing tiles.', 'listing-manager' ),
            'base'			=> 'listing_manager_tiles',
            'params'			=> [
                [
                    'type' 			=> 'textfield',
                    'heading' 		=> esc_html__( 'Layout', 'listing-manager' ),
                    'param_name' 	=> 'layout',
                    'std'			=> ''
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