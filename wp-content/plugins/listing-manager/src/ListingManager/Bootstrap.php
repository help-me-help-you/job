<?php

namespace ListingManager;

use Symfony\Component\ClassLoader\ClassMapGenerator;
use ListingManager\Annotation\Action;
use ListingManager\Annotation\Handler\ActionHandler;
use ListingManager\Annotation\Handler\FilterHandler;

class Bootstrap {
    public $dir;

    public function bootstrap($dir) {
	    $this->dir = $dir;
        $this->constants();

	    // Custom customizer controls
	    add_action( 'customize_register', function() {
		    require_once LISTING_MANAGER_DIR . 'src/ListingManager/Customization/CheckboxMultipleControlCustomization.php';
	    } );

        $this->annotations();

	    // Check for updates
	    $is_listing_manager = ! empty( $_GET['action'] ) && strpos( $_GET['action'], 'listing-manager', 0 );
	    if ( defined( 'DOING_AJAX' ) && false === $is_listing_manager )  {
		    if ( class_exists( 'ListingManager\Admin\UpdateAdmin' ) ) {
			    add_action( 'site_transient_update_plugins', [ 'ListingManager\Admin\UpdateAdmin', 'check_update' ] );
		    }
	    }

        // Installation hooks
        register_activation_hook( LISTING_MANAGER_FILE, [ 'ListingManager\Logic\StatisticLogic', 'install_search_queries' ] );
        register_activation_hook( LISTING_MANAGER_FILE, [ 'ListingManager\Logic\StatisticLogic', 'install_listing_views' ] );

        // Translations
        load_plugin_textdomain( 'listing-manager', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
    }

    public function constants() {
        define( 'LISTING_MANAGER_DIR', $this->dir . '/' );
        define( 'LISTING_MANAGER_FILE', $this->dir . '/listing-manager.php' );
        define( 'LISTING_MANAGER_LISTING_PREFIX', 'listing_' );
        define( 'LISTING_MANAGER_AGENT_PREFIX', 'agent_' );
        define( 'LISTING_MANAGER_COMPANY_PREFIX', 'company_' );
        define( 'LISTING_MANAGER_PACKAGE_PREFIX', 'package_' );
        define( 'LISTING_MANAGER_USER_PREFIX', 'user_' );
        define( 'LISTING_MANAGER_REPORT_PREFIX', 'report_' );
	    define( 'LISTING_MANAGER_REVIEW_PREFIX', 'review_' );
	    define( 'LISTING_MANAGER_FORM_PREFIX', 'form_' );
	    define( 'LISTING_MANAGER_FIELDSET_PREFIX', 'fieldset_' );
	    define( 'LISTING_MANAGER_FIELD_PREFIX', 'field_' );
        define( 'LISTING_MANAGER_CLAIM_PREFIX', 'claim_' );
	    define( 'LISTING_MANAGER_MEMBERSHIP_PREFIX', 'membership_' );
        define( 'LISTING_MANAGER_STATISTICS_TOTAL_VIEWS_META', 'listing_manager_statistics_post_total_views' );
        define( 'LISTING_MANAGER_COMPARE_MAX', 3 );

        if ( defined( 'LISTING_MANAGER_API_DEBUG_URL' ) ) {
            define( 'LISTING_MANAGER_API_PRODUCTS_URL', LISTING_MANAGER_API_DEBUG_URL . '/api/v1/products/' );
            define( 'LISTING_MANAGER_API_VERIFY_URL', LISTING_MANAGER_API_DEBUG_URL . '/api/v1/verify/' );
        } else {
            define( 'LISTING_MANAGER_API_PRODUCTS_URL', 'http://wplistingmanager.com/api/v1/products/' );
            define( 'LISTING_MANAGER_API_VERIFY_URL', 'http://wplistingmanager.com/api/v1/verify/' );
        }
    }

    public function annotations() {
        $classes = ClassMapGenerator::createMap( LISTING_MANAGER_DIR . '/src' );

        foreach ( $classes as $class_name => $class_file ) {
            $action_handler = new ActionHandler();
            $action_handler->handle( $class_name );

            $filter_handler = new FilterHandler();
            $filter_handler->handle( $class_name );
        }
    }

    /**
     * @Action(name="tgmpa_register")
     */
    public static function requirements() {
        $plugins = [
            [
                'name'      => 'WooCommerce',
                'slug'      => 'woocommerce',
                'required'  => true,
            ]
        ];

        tgmpa( $plugins );
    }

    /**
     * @Action(name="init")
     */
    public static function start_session() {
        if ( ! session_id() ) {
            session_start();
        }
    }
}
