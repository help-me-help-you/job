<?php

namespace ListingManager\Shortcode;

use ListingManager\Annotation\Action;
use ListingManager\Utilities;
use WP_Query;

class ProductAttributeShortcode {
    /**
     * @Action(name="init")
     */
    public static function initialize() {
        add_shortcode( 'listing_manager_product_attribute', [ 'ListingManager\Shortcode\ProductAttributeShortcode', 'execute' ] );
    }

    public static function execute( $atts ) {
        $standard_array = [ 'menu_order', 'title',' date', 'rand', 'id'];

        $atts = shortcode_atts( [
            'featured'	      => false,
            'per_page'        => '12',
            'columns'         => '4',
            'orderby'         => 'title',
            'order'           => 'asc',
            'attribute'       => 'product_type',
            'filter'          => 'listing',
            'category'        => null,
            'location'        => null,
            'show_pagination' => false,
        ], $atts );

        $tax_query = [
            [
                'taxonomy' => sanitize_title( $atts['attribute'] ),
                'terms'    => array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ),
                'field'    => 'slug',
            ],
        ];

        if ( ! empty( $atts['location'] ) ) {
            $tax_query[] = [
                'taxonomy' 	=> 'locations',
                'field'		=> 'slug',
                'terms' 	=> [ $atts['location'], ],
            ];
        }

        if ( ! empty( $atts['category'] ) ) {
            $tax_query[] = [
                'taxonomy' 	=> 'product_cat',
                'field'		=> 'slug',
                'terms' 	=> [ $atts['category'], ],
            ];
        }

        $meta_query = WC()->query->get_meta_query();

        if ( ! empty( $atts['featured'] ) ) {
            $meta_query[] = [
                'key' 		=> '_featured',
                'value'		=> 'yes',
                'compare' 	=> '=',
            ];
        }

        $args = [
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $atts['per_page'],
            'orderby'             => $atts['orderby'],
            'order'               => $atts['order'],
            'meta_query'          => $meta_query,
            'tax_query'           => $tax_query,
        ];

        if( isset( $args['orderby'] ) && ! in_array( $args['orderby'], $standard_array ) ) {
            $args['meta_key'] = $args['orderby'];
            $args['orderby']  = 'meta_value_num';
        }

        if ( ! empty( $atts['orderby'] ) && 'event_date' == $atts['orderby'] ) {
            $args['orderby'] = LISTING_MANAGER_LISTING_PREFIX . 'event_date';
            $args['meta_key'] = LISTING_MANAGER_LISTING_PREFIX . 'event_date';
        }

        return self::product_loop( $args, $atts, 'product_attribute' );
    }

    /**
     * Loop over found products.
     *
     * @param  array $query_args
     * @param  array $atts
     * @param  string $loop_name
     * @return string
     */
    private static function product_loop( $query_args, $atts, $loop_name ) {
        global $woocommerce_loop;

	    $args                        = apply_filters( 'woocommerce_shortcode_products_query', $query_args, $atts, $loop_name );
        $columns                     = absint( $atts['columns'] );
        $woocommerce_loop['columns'] = $columns;
        $woocommerce_loop['name']    = $loop_name;

	    query_posts( $args );
        ob_start();

        if ( have_posts() ) {
            ?>

            <?php do_action( "woocommerce_shortcode_before_{$loop_name}_loop" ); ?>

            <?php woocommerce_product_loop_start(); ?>

            <?php while ( have_posts() ) : the_post(); ?>
                <?php wc_get_template_part( 'content', 'product' ); ?>
            <?php endwhile; // end of the loop. ?>


            <?php do_action( "woocommerce_shortcode_after_{$loop_name}_loop" ); ?>

	        <?php woocommerce_product_loop_end(); ?>

	        <?php if ( ! empty( $atts['show_pagination'] ) && 'on' === $atts['show_pagination'] ) : ?>
		        <?php woocommerce_pagination(); ?>
	        <?php endif; ?>
            <?php
        } else {
            do_action( "woocommerce_shortcode_{$loop_name}_loop_no_results" );
        }

        wp_reset_query();

        return '<div class="woocommerce columns-' . $columns . '">' . ob_get_clean() . '</div>';
    }
}