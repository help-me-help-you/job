<?php

/**
 * Plugin Name: Listing Manager
 * Version: 2.5.12
 * Description: Directory & listings WordPress plugin based on WooCommerce.
 * Author: Code Vision
 * Author URI: http://wearecodevision.com
 * Plugin URI: http://wplistingmanager.com
 * Text Domain: listing-manager
 * Domain Path: /languages/
 * License: http://themeforest.net/licenses
 * License URI: http://themeforest.net/licenses
 *
 * @package ListingManager
 */

use Doctrine\Common\Annotations\AnnotationRegistry;
use ListingManager\Bootstrap;

// Start class autoloader
require_once 'vendor/autoload.php';
require_once( ABSPATH . 'wp-admin/includes/plugin.php' );

AnnotationRegistry::registerLoader('class_exists');

if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
	add_action( 'tgmpa_register', [ 'ListingManager\Bootstrap', 'requirements'] );
} else {
	$app = new Bootstrap();
	$app->bootstrap( __DIR__ );
}
