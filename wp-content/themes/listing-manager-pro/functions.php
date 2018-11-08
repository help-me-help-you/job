<?php
/**
 * Constants
 */
define( 'LISTING_MANAGER_FRONT_PRODUCT_EXCERPT_LENGTH', 20 );
define( 'LISTING_MANAGER_FRONT_POST_EXCERPT_LENGTH', 20 );

/**
 * Libraries
 */
require_once get_template_directory() . '/assets/libraries/class-tgm-plugin-activation.php';

/**
 * Register fonts
 *
 * Translators: If there are characters in your language that are not supported
 * by chosen font(s), translate this to 'off'. Do not translate into your own language.
 *
 * @see https://gist.github.com/kailoon/e2dc2a04a8bd5034682c
 * @return string
 */
function listing_manager_pro_fonts() {
	$font_url = '';

	if ( 'off' !== _x( 'on', 'Google font: on or off', 'listing-manager-pro' ) ) {
		$font_url = add_query_arg( 'family', urlencode(  'Roboto:300,400,500,600,700&subset=latin,latin-ext' ), '//fonts.googleapis.com/css' );
	}

	return $font_url;
}

/**
 * Enqueue scripts & styles
 *
 * @see wp_enqueue_scripts
 * @return void
 */
function listing_manager_pro_enqueue() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.min.css' );
	wp_enqueue_style( 'listing-manager-pro-fonts', listing_manager_pro_fonts(), [], '1.0.0' );
	wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/js/slick/slick.css' );
	wp_enqueue_style( 'slick-theme', get_template_directory_uri() . '/assets/js/slick/slick-theme.css' );
	wp_enqueue_style( 'silk', get_template_directory_uri() . '/assets/fonts/Silk/style.css' );
	wp_enqueue_style( 'trackpad-scroll-emulator', get_template_directory_uri() . '/assets/css/trackpad-scroll-emulator.css' );
	wp_enqueue_style( 'listing-manager-pro-icons', plugins_url( '/listing-manager/assets/fonts/listing-manager/style.css' ) );
	$stylesheet = get_theme_mod( 'listing_manager_pro_general_style', 'listing-manager-pro' );
	wp_enqueue_style( 'listing-manager-pro', get_template_directory_uri() . '/assets/css/' . $stylesheet . '.css');
	wp_enqueue_style( 'listing-manager-pro-style', get_stylesheet_directory_uri() . '/style.css' );

	wp_enqueue_script( 'listing-manager-pro', get_template_directory_uri() . '/assets/js/listing-manager-pro.js', [ 'jquery' ] );
	wp_enqueue_script( 'images-loaded', get_template_directory_uri() . '/assets/js/images-loaded.min.js', [ 'jquery' ] );
	wp_enqueue_script( 'masonry', get_template_directory_uri() . '/assets/js/masonry.min.js', [ 'jquery' ] );
	wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/js/slick/slick.js', [ 'jquery' ] );
	wp_enqueue_script( 'scrollTo', get_template_directory_uri() . '/assets/js/jquery.scrollTo.min.js', [ 'jquery' ] );
	wp_enqueue_script( 'trackpad-scroll-emulator', get_template_directory_uri() . '/assets/js/jquery.trackpad-scroll-emulator.min.js', [ 'jquery' ] );

	if ( is_singular() ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( ! isset( $content_width ) ) {
		$content_width = 1170;
	}
}
add_action( 'wp_enqueue_scripts', 'listing_manager_pro_enqueue' );

/**
 * Custom widget areas
 *
 * @see widgets_init
 * @return void
 */
function listing_manager_pro_sidebars() {
	$sidebars = [
		'sidebar-1' 			=> esc_html__( 'Primary', 'listing-manager-pro' ),
		'topbar-left' 			=> esc_html__( 'Topbar Left', 'listing-manager-pro' ),
		'topbar-right' 			=> esc_html__( 'Topbar Right', 'listing-manager-pro' ),
        'main-top' 			    => esc_html__( 'Main Top', 'listing-manager-pro' ),
		'content-top' 			=> esc_html__( 'Content Top', 'listing-manager-pro' ),
		'product' 				=> esc_html__( 'Product', 'listing-manager-pro' ),
		'page-map' 				=> esc_html__( 'Page Map', 'listing-manager-pro' ),
		'header-minimal' 		=> esc_html__( 'Header Minimal', 'listing-manager-pro' ),
		'footer-top-first' 		=> esc_html__( 'Footer First', 'listing-manager-pro' ),
		'footer-top-second' 	=> esc_html__( 'Footer Second', 'listing-manager-pro' ),
		'footer-top-third' 		=> esc_html__( 'Footer Third', 'listing-manager-pro' ),
		'footer-left' 		    => esc_html__( 'Footer Left', 'listing-manager-pro' ),
		'footer-right' 		    => esc_html__( 'Footer Right', 'listing-manager-pro' ),
	];

	foreach ( $sidebars as $key => $value ) {
		register_sidebar( [
			'name' 			=> $value,
			'id' 			=> $key,
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' 	=> '</div>'
		] );
	}
}
add_action( 'widgets_init', 'listing_manager_pro_sidebars' );

/**
 * Comments template
 *
 * @param string $comment Comment message.
 * @param array  $args Arguments.
 * @param int    $depth Depth.
 * @return void
 */
function listing_manager_pro_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	extract( $args, EXTR_SKIP );
	include get_template_directory() . '/templates/content-comment.php';
}

/**
 * Body classes
 *
 * @see body_class
 * @param array $body_class
 * @return array
 */
function listing_manager_pro_body_classes( $body_class ) {
	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$body_class[] = 'has-sidebar';
	}

	if ( is_active_sidebar( 'main-top' ) ) {
	    $body_class[] = 'has-main-top';
    }

	if ( class_exists( 'WooCommerce' ) ) {
		$body_class[] = 'woocommerce';

		if ( is_cart() && 0 === count( WC()->cart->cart_contents ) ) {
			$body_class[] = 'empty-cart';
		}
	}

	return $body_class;
}
add_filter( 'body_class', 'listing_manager_pro_body_classes' );

/**
 * Additional after theme setup functions
 *
 * @see after_setup_theme
 * @return void
 */
function listing_manager_pro_after_theme_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'menus' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'listing_manager_pro_after_theme_setup' );

/**
 * Enable theme translation
 *
 * @see after_setup_theme
 * @return void
 */
function listing_manager_pro_load_textdomain() {
	load_theme_textdomain( 'listing-manager-pro', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'listing_manager_pro_after_theme_setup' );

/**
 * Register navigations
 *
 * @see init
 * @return void
 */
function listing_manager_pro_menu() {
	register_nav_menu( 'primary', esc_html__( 'Primary', 'listing-manager-pro' ) );
	register_nav_menu( 'authenticated', esc_html__( 'Authenticated', 'listing-manager-pro' ) );
}
add_action( 'init', 'listing_manager_pro_menu' );

/**
 * Custom excerpt length
 *
 * @see excerpt_length
 * @param int $length String length.
 * @return int
 */
function listing_manager_pro_excerpt_length( $length ) {
	global $post;

	if ( 'post' === $post->post_type ) {
		return LISTING_MANAGER_FRONT_POST_EXCERPT_LENGTH;
	} elseif ( 'product' === $post->post_type ) {
		return LISTING_MANAGER_FRONT_PRODUCT_EXCERPT_LENGTH;
	}

	return $length;
}
add_filter( 'excerpt_length', 'listing_manager_pro_excerpt_length' );

/**
 * Custom read more
 *
 * @see excerpt_more
 * @param string $more Read more string.
 * @return string
 */
function listing_manager_pro_excerpt_more( $more ) {
	global $post;

	if ( 'product' === $post->post_type ) {
		return null;
	}

	return '<div class="read-more-wrapper"><a href="' . get_the_permalink(). '" class="button button-primary read-more">' . esc_html__( 'Read More', 'listing-manager-pro' ) . '</a></div>';
}
add_filter( 'excerpt_more', 'listing_manager_pro_excerpt_more' );


/**
 * Disable admin's bar top margin
 *
 * @see get_header
 * @return void
 */
function listing_manager_pro_disable_admin_bar_top_margin() {
	remove_action( 'wp_head', '_admin_bar_bump_cb' );
}
add_action( 'get_header', 'listing_manager_pro_disable_admin_bar_top_margin' );

/**
 * Adds wrapper around content and sidebar
 *
 * @see listing_manager_pro_before_main
 * @return void
 */
function listing_manager_pro_add_main_before() {
	if ( is_page_template( 'page-promo-page.php') ) {
		return;
	}

	get_template_part( 'templates/content', 'main-before' );
}
add_action( 'listing_manager_pro_before_main', 'listing_manager_pro_add_main_before' );

/**
 * Adds wrapper around content and sidebar
 *
 * @see listing_manager_pro_after_main
 * @return void
 */
function listing_manager_pro_add_main_after() {
	if ( is_page_template( 'page-promo-page.php') ) {
		return;
	}

	get_template_part( 'templates/content', 'main-after' );
}
add_action( 'listing_manager_pro_after_main', 'listing_manager_pro_add_main_after' );

/**
 * Adds woocommerce_after_main_content
 *
 * @see listing_manager_pro_before_main
 * @return void
 */
function listing_manager_pro_woocommerce_before_main_content() {
	echo '<div class="content">';
}
add_action( 'woocommerce_before_main_content', 'listing_manager_pro_woocommerce_before_main_content', 1 );

/**
 * Adds wrapper around content
 *
 * @see woocommerce_after_main_content
 * @return void
 */
function listing_manager_pro_woocommerce_after_main_content() {
	echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'listing_manager_pro_woocommerce_after_main_content', 1);

/**
 * Change the breadcrumb position
 *
 * @see init
 * @return void
 */
function listing_manager_pro_woocommerce_breadcrumb() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}
add_action( 'init', 'listing_manager_pro_woocommerce_breadcrumb' );

/**
 * Change WooCommerce breadcrumb values
 *
 * @see woocommerce_breadcrumb_defaults
 * @param array $args
 * @return array
 */
function listing_manager_pro_woocommerce_breadcrumb_defaults( $args ) {
	$args['delimiter'] = '<span class="separator">/</span>';
	return $args;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'listing_manager_pro_woocommerce_breadcrumb_defaults' );

/**
 * Removes add to cart button from the loop page
 *
 * @see init
 * @return void
 */
function listing_manager_pro_woocommerce_remove_loop_button(){
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
}
add_action( 'init','listing_manager_pro_woocommerce_remove_loop_button' );

/**
 * Removes WooCommerce title
 *
 * @see woocommerce_show_page_title
 * @return bool
 */
function listing_manager_pro_woocommerce_show_page_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'listing_manager_pro_woocommerce_show_page_title' );

/**
 * Adds favorite button after title
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_pro_woocommerce_loop_add_options() {
	if ( has_term( 'listing', 'product_type' ) ) {
		get_template_part( 'templates/content', 'product-loop-options' );
	}
}
add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_pro_woocommerce_loop_add_options' );

/**
 * Adds location after shop title in loop
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_pro_woocommerce_loop_add_location() {
	if ( defined( 'LISTING_MANAGER_LISTING_PREFIX' ) ) {
		$name = ListingManager\Product\ListingProduct::get_location_name();

		if ( ! empty( $name ) ) {
			echo '<div class="product-location">' . ListingManager\Product\ListingProduct::get_location_name() . '</div>';
		}
	}
}
add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_pro_woocommerce_loop_add_location' );

/**
 * Adds excerpt after shop title in loop
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_pro_woocommerce_loop_add_excerpt() {
	woocommerce_template_single_excerpt();
}
add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_pro_woocommerce_loop_add_excerpt' );

/**
 * Custom implementation of excerpt size for WooCommerce products
 *
 * @see woocommerce_short_description
 * @param string $excerpt
 * @return string
 */
function listing_manager_pro_woocommerce_short_description( $excerpt ) {
	return null;
}
add_filter ( 'woocommerce_short_description', 'listing_manager_pro_woocommerce_short_description');

/**
 * Adds event after product in loop
 *
 * @see woocommerce_after_shop_loop_item_title
 * @return void
 */
function listing_manager_pro_woocommerce_loop_add_event() {
	if ( defined( 'LISTING_MANAGER_LISTING_PREFIX' ) ) {
		$date = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'event_date', true );

		if ( ! empty( $date ) && strtotime( $date ) > strtotime( 'now' ) ) {
			echo '<div class="event-countdown" data-date="' . esc_attr( $date ) . '"></div>';
		}
	}
}
add_action( 'woocommerce_after_shop_loop_item_title', 'listing_manager_pro_woocommerce_loop_add_event' );

/**
 * Adds product loop gallery template
 *
 * @return void
 */
function listing_manager_pro_product_loop_gallery() {
	get_template_part( 'templates/content', 'product-loop-gallery' );
}
add_action( 'woocommerce_before_shop_loop_item_title', 'listing_manager_pro_product_loop_gallery', 10 );


/**
 * Better product loop title with inner link pointing at product detail
 *
 * @return void
 */
function listing_manager_pro_product_loop_title() {
	echo '<h2 class="woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
}
add_action( 'woocommerce_shop_loop_item_title', 'listing_manager_pro_product_loop_title', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

/**
 * Custom rating formatting
 *
 * @param string $rating_html
 * @param float $rating
 * @return string
 */
function listing_manager_pro_product_rating_html( $rating_html, $rating ) {
	return wc_get_template_html( 'templates/content-product-rating.php', [
		'rating_html' 	=> $rating_html,
		'rating'		=> $rating,
	] );
}
add_filter( 'woocommerce_product_get_rating_html', 'listing_manager_pro_product_rating_html', 10, 2 );

/**
 * Reorder rating stars in product loop
 */
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

/**
 * Change WooCommerce pagination values
 *
 * @see woocommerce_pagination_args
 * @param array $args
 * @return array
 */
function listing_manager_pro_woocommerce_pagination_args( $args ) {
	$args['prev_text'] = '<i class="silk silk-chevron-left"></i>';
	$args['next_text'] = '<i class="silk silk-chevron-right"></i>';
	return $args;
}
add_filter( 'woocommerce_pagination_args', 'listing_manager_pro_woocommerce_pagination_args' );

/**
 * Adds next/prev posts links
 *
 * @see woocommerce_after_single_product_summary
 * @return void
 */
function listing_manager_pro_woocommerce_add_next_prev() {
	get_template_part( 'templates/content', 'next-prev-links' );
}
add_action( 'woocommerce_after_single_product_summary', 'listing_manager_pro_woocommerce_add_next_prev', 100 );

/**
 * Limits max number of related products
 *
 * @see woocommerce_output_related_products_args
 * @param array $args
 * @return array
 */
function listing_manager_pro_max_number_of_related( $args ) {
	$args['posts_per_page'] = 3;
	$args['columns'] = 3;
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'listing_manager_pro_max_number_of_related' );

/**
 * Posts pagination
 *
 * @return void
 */
function listing_manager_pro_pagination() {
	the_posts_pagination( [
		'prev_text'  => esc_html__( 'Previous', 'listing-manager-pro' ),
		'next_text'  => esc_html__( 'Next', 'listing-manager-pro' ),
		'mid_size'   => 2,
	] );
}

/**
 * Register plugins
 *
 * @see tgmpa_register
 * @return void
 */
function listing_manager_pro_register_required_plugins() {
	$plugins = [
		[
            'name'                  => esc_html__( 'Listing Manager', 'listing-manager-pro' ),
            'slug'                  => 'listing-manager',
            'source'                => listing_manager_pro_get_plugin_package( 'listing-manager' ),
            'required'              => false,
            'force_deactivation'    => true,
            'is_automatic'          => true,
            'version'               => listing_manager_pro_get_plugin_version( 'listing-manager' ),
		],	
		[
			'name'      			=> esc_html__( 'WooCommerce', 'listing-manager-pro'),
			'slug'      			=> 'woocommerce',
			'is_automatic'          => true,
			'required'  			=> false,
		],
		[
			'name'      			=> esc_html__( 'Page Builder by SiteOrigin', 'listing-manager-pro' ),
			'slug'      			=> 'siteorigin-panels',
			'is_automatic'          => true,
			'required'  			=> false,
		],
		[
			'name'      			=> esc_html__( 'One Click', 'listing-manager-pro' ),
			'slug'      			=> 'one-click',
			'is_automatic'          => true,
			'required'  			=> false,
			'source'				=> get_template_directory() . '/plugins/one-click-master.zip',
		],
        [
            'name'      			=> esc_html__( 'Envato Market', 'listing-manager-pro' ),
            'slug'      			=> 'envato-market',
            'is_automatic'          => true,
            'required'  			=> false,
            'source'                => get_template_directory() . '/plugins/envato-market.zip',
        ],		
        [
            'name'                  => esc_html__( 'Widget Logic', 'listing-manager-pro' ),
            'slug'                  => 'widget-logic',
            'is_automatic'          => true,
            'required'              => false,
        ],
        [
            'name'                  => esc_html__( 'WordPress Importer', 'listing-manager-pro' ),
            'slug'                  => 'wordpress-importer',
            'is_automatic'          => false,
            'required'              => false,
        ],                
	];

	tgmpa( $plugins );
}
add_action( 'tgmpa_register', 'listing_manager_pro_register_required_plugins' );

/**
 * Gets plugins version
 *
 * @param string $plugin_slug
 * @return string
 */
function listing_manager_pro_get_plugin_version( $plugin_slug ) {
    $filename = listing_manager_pro_get_plugin_package( $plugin_slug );
    $parts = explode( '/', $filename );
    $filename = $parts[ count( $parts ) - 1 ];

    // Remove ZIP
    $name = substr( $filename, 0, -4 );

    // Get last string path after "-"
    $parts = explode( '-', $name );
    $version = $parts[ count( $parts ) - 1 ];

    // If the last part can be exploded by dot and have 3 items in array
    if ( 3 === count( explode( '.', $version ) ) ) {
        return $version;
    }

    return '0.1.0';
}

/**
 * Gets plugins package filepath
 *
 * @param string $plugin_slug
 * @return string
 */
function listing_manager_pro_get_plugin_package( $plugin_slug ) {
    $prefix = get_template_directory() . '/plugins/';
    $files = glob( $prefix . '*.zip' );

    foreach ( $files as $file ) {
        $parts = explode( '/', $file );
        $filename = $parts[ count( $parts ) - 1];

        if ( substr( $filename, 0, strlen( $plugin_slug ) ) === $plugin_slug ) {
            return $prefix . $filename;
        }
    }
    return $prefix . $plugin_slug . '.zip';
}

/**
 * Implements basic placeholders for filter fields
 *
 * @param $value
 * @param $key
 * @param $atts
 * @return string
 */
function listing_manager_pro_filter_placeholder( $value, $key, $atts ) {
	if ( 'labels' === $atts['input_titles'] ) {
		if ( 'keyword' === $key ) {
			return esc_html__( 'Type the phrase', 'listing-manager-pro' );
		} elseif ( 'price_to' === $key ) {
			return esc_html__( 'Max. value', 'listing-manager-pro' );
		} elseif ( 'price_from' === $key ) {
			return esc_html__( 'Min. value', 'listing-manager-pro' );
		}
	}

	return $value;
}
add_filter( 'listing_manager_filter_placeholder', 'listing_manager_pro_filter_placeholder', 10, 3 );

/**
 * Reorders single product tabs
 *
 * @param array $tabs
 * @return array
 */
function listing_manager_pro_woocommerce_product_tabs( $tabs ) {
	if ( ! empty( $tabs['location'] ) ) {
		unset( $tabs['location'] );
	}

	if ( ! empty( $tabs['amenities'] ) ) {
		$tabs['amenities']['priority'] = 1;
	}

	if ( ! empty( $tabs['social'] ) ) {
		$tabs['social']['priority'] = 100;
	}

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'listing_manager_pro_woocommerce_product_tabs' );

/**
 * Adds content after stream item
 *
 * @return void
 */
function listing_manager_pro_stream_item() {
	get_template_part( 'templates/content', 'stream-item' );
}
add_action( 'listing_manager_stream_item_content_after', 'listing_manager_pro_stream_item' );

/**
 * Remove 'Archives:' from post type archive title
 *
 * @see get_the_archive_title
 * @param string $title
 * @return string
 */
function listing_manager_pro_update_archive_title( $title ) {
	if ( is_post_type_archive() ) {
		return post_type_archive_title( '', false );
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'listing_manager_pro_update_archive_title' );

/**
 * Customizations
 *
 * @see customize_register
 * @param $wp_customize
 * @return void
 */
function listing_manager_pro_customizations( $wp_customize ) {
	$wp_customize->add_section( 'listing_manager_pro_general', [ 'title' => esc_html__( 'Listing Manager Pro General', 'listing-manager-pro' ),  'priority' => 0 ] );

	// Style.
	$wp_customize->add_setting( 'listing_manager_pro_general_style', [
		'default'           => 'listing-manager-pro',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'sanitize_key',
	] );

	$wp_customize->add_control( 'listing_manager_pro_general_style', [
		'label'    => esc_html__( 'Style', 'listing-manager-pro' ),
		'section'  => 'listing_manager_pro_general',
		'settings' => 'listing_manager_pro_general_style',
		'type'     => 'select',
		'choices'  => [
			'listing-manager-pro'           => esc_html__( 'Pink (Default)', 'listing-manager-pro' ),
			'listing-manager-pro-blue'      => esc_html__( 'Blue', 'listing-manager-pro' ),
			'listing-manager-pro-turquoise' => esc_html__( 'Turquoise', 'listing-manager-pro' ),
			'listing-manager-pro-purple'    => esc_html__( 'Purple', 'listing-manager-pro' ),
			'listing-manager-pro-green'     => esc_html__( 'Green', 'listing-manager-pro' ),
		]
	] );
}
add_action( 'customize_register', 'listing_manager_pro_customizations' );

/**
 * Define product actions
 */
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

if ( defined( 'LISTING_MANAGER_LISTING_PREFIX' ) ) {
	add_action( 'listing_manager_pro_product_actions', [ 'ListingManager\Logic\ReportLogic', 'render_button' ] );
	add_action( 'listing_manager_pro_product_actions', [ 'ListingManager\Logic\FavoriteLogic', 'render_button' ] );
	add_action( 'listing_manager_pro_product_actions', [ 'ListingManager\Logic\ClaimLogic', 'render_button' ] );
	add_action( 'listing_manager_pro_product_actions', [ 'ListingManager\Logic\CompareLogic', 'render_button' ] );

	remove_action( 'woocommerce_after_single_product', [ 'ListingManager\Logic\ReportLogic', 'render_button' ] );
	remove_action( 'woocommerce_after_single_product', [ 'ListingManager\Logic\ClaimLogic', 'render_button' ] );
	remove_action( 'woocommerce_after_single_product', [ 'ListingManager\Logic\CompareLogic', 'render_button' ] );
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating' );
