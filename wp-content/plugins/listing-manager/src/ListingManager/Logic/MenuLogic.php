<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;

class MenuLogic {
    /**
     * @Action(name="init")
     */
    public static function taxonomy() {
        register_taxonomy( 'archive_pages', 'nav_menu_item', [
            'labels'            => [
                'name'          => esc_attr__( 'Archive Pages', 'listing-manager' ),
                'singular_name' => esc_attr__( 'Archive Page', 'listing-manager' ),
            ],
            'show_ui'           => false,
            'show_in_nav_menus' => true,
            'query_var'         => false,
            'rewrite'           => false,
        ] );
    }

    /**
     * @Action(name="init", priority=20)
     */
    public static function terms() {
        static $terms_created = false;

        if ( ! $terms_created ) {
            $post_types = get_post_types( [
                'publicly_queryable'    => true,
                '_builtin'              => false,
            ], 'objects' );

            $taxonomy = 'archive_pages';

            foreach ( $post_types as $term_name => $term ) {
                if ( term_exists( $term_name, $taxonomy ) ) {
                    continue;
                }

                wp_insert_term( $term->label, $taxonomy, [ 'slug' => $term_name ] );
            }

            $terms_created = true;
        }
    }

    /**
     * @Filter(name="term_link", priority=20, accepted_args=3)
     */
    public static function term_link( $link, $term, $taxonomy ) {
        if ( 'archive_pages' !== $taxonomy ) {
            return $link;
        }

        $terms = self::get_archive_page_terms();
        $found_term = array_filter( $terms, function ( $current_term ) use ( $term ) {
            if ( $term->slug !== $current_term['name'] ) {
                return false;
            }

            return true;
        } );

        if ( ! empty( $found_term ) && ! empty( $found_term[ $term->slug ]['link'] ) ) {
            $link = $found_term[ $term->slug ]['link'];
        }

        return $link;
    }

    /**
     * @Filter(name="wp_get_nav_menu_items", priority=10, accepted_args=3)
     */
    public static function current_menu_item( $items, $menu, $args ) {
        foreach ( $items as &$item ) {
            if ( 'archive_pages' !== $item->object ) {
                continue;
            }

            $term = get_term( $item->object_id, 'archive_pages' );
            if ( get_query_var( 'post_type' ) == $term->slug || ( $term->slug == 'listing' && get_query_var( 'post_type' ) == 'product' ) ) {
                $item->classes[] = 'current-menu-item';
                $item->current = true;
                $parent_id = $item->menu_item_parent;
            }

            if ( ! empty( $parent_id ) ) {
                foreach ( $items as &$item ) {
                    if ( $item->ID == $parent_id ) {
                        $item->classes[] = 'current-menu-item';
                        $item->current = true;
                    }
                }

                $parent_id = null;
            }
        }


        return $items;
    }

    public static function get_archive_page_terms() {
        if ( $terms = wp_cache_get( 'namespace_archive_page_terms' ) ) {
            return maybe_unserialize( $terms );
        }

        $post_types = get_post_types( [ 'public' => true ], 'names' );
        $terms = array_map( function ( $post_type ) {
            return [
                'name' => $post_type,
                'link' => get_post_type_archive_link( $post_type ),
            ];
        }, $post_types );

        wp_cache_set( 'namespace_archive_page_terms', maybe_serialize( $terms ), false, DAY_IN_SECONDS );

        return $terms;
    }
}
