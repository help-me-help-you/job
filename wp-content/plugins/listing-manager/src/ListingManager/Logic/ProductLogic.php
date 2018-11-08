<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class ProductLogic {
    /**
     * @Action(name="transition_post_status", priority=10, accepted_args=3)
     */
    public static function product_status_changed( $new_status, $old_status, $post ) {
        if ( $new_status != $old_status ) {
            if ( 'product' === $post->post_type ) {
                $taxonomies = [ 'locations', 'contracts', 'amenities', 'product_cat' ];

                foreach( $taxonomies as $taxonomy ) {
                    if ( taxonomy_exists( $taxonomy ) ) {
                        $terms = wp_get_post_terms( $post->ID, $taxonomy );
                        $taxonomy_obj = get_taxonomy( $taxonomy );
                        _update_post_term_count( $terms, $taxonomy_obj );
                    }
                }
            }
        }
    }
}
