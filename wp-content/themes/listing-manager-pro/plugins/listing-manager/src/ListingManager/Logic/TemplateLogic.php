<?php

namespace ListingManager\Logic;

use Exception;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use ListingManager\Product\PackageProduct;
use ListingManager\Utilities;

class TemplateLogic {
	/**
	 * @Filter(name="template_include")
	 */
	public static function templates( $template ) {
		global $wp_query;

		// Archive
		$obj = get_queried_object();

		if ( ! empty( $obj ) ) {
			$post_types        = [ 'agent', 'company' ];
			$current_post_type = is_post_type_archive( $obj->name );

			if ( ! empty( $obj ) && is_post_type_archive( $obj->name ) && in_array( $current_post_type, $post_types ) ) {
				try {
					return self::locate( 'archive-' . $wp_query->query['post_type'] );
				} catch ( Exception $e ) {
					try {
						return self::locate( 'archive' );
					} catch ( Exception $e ) {
						return self::locate( 'index' );
					}
				}
			}
		}

		// Single
		if ( is_singular( [ 'agent', 'company' ] ) ) {
			return self::locate( 'single-' . $wp_query->query['post_type'] );
		}

		return $template;
	}

	/**
	 * Get full path to template
	 *
	 * @param string $name
	 * @param string $plugin_dir
	 * @return string
	 * @throws \Exception
	 */
	public static function locate( $name, $plugin_dir = LISTING_MANAGER_DIR ) {
		$template = '';

		// Current theme base dir
		if ( ! empty( $name ) ) {
			$template = locate_template( "{$name}.php" );
		}

		// Child theme
		if ( ! $template && ! empty( $name ) && file_exists( get_stylesheet_directory() . "/{$name}.php" ) ) {
			$template = get_stylesheet_directory() . "/templates/{$name}.php";
		}

		// Original theme
		if ( ! $template && ! empty( $name ) && file_exists( get_template_directory() . "/{$name}.php" ) ) {
			$template = get_template_directory() . "/templates/{$name}.php";
		}

		// Current Plugin
		if ( ! $template && ! empty( $name ) && file_exists( $plugin_dir . "templates/listing-manager/{$name}.php" ) ) {
			$template = $plugin_dir . "/templates/listing-manager/{$name}.php";
		}

		// Nothing found
		if ( empty( $template ) ) {
			throw new Exception( "Template {$name}.php in plugin dir {$plugin_dir} not found." );
		}

		return $template;
	}
}