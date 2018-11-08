<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use WC_Shortcode_My_Account;

class UserLogic {
    /**
     * @Filter(name="listing_manager_submission_fields", priority=11)
     */
    public static function add_registration_fields( $fields = [] ) {
        // Anonymous users without "Anyone can register" are now allowed to use these fields
        if ( ! is_user_logged_in() && ! get_option( 'users_can_register' ) ) {
            return $fields;
        }

        // Authenticated users are not required to fill these fields
        if ( is_user_logged_in() ) {
            return $fields;
        }

        // Login link
        $login = get_theme_mod( 'listing_manager_pages_login', null );

        if ( ! empty( $login ) ) {
            $legend = wp_kses( __( 'Create New Account <a href="' . get_permalink( $login ) . '">Already have an account?</a>', 'listing-manager' ), wp_kses_allowed_html( 'post') );
        } else {
            $legend = esc_html__( 'Create New Account', 'listing-manager' );
        }

        $registration_fields = [
            'type' 		=> 'fieldset',
            'id'        => 'user',
            'legend'	=> $legend,
            'fields'	=> [
                [
                    'id' 		=> 'register_form',
                    'type' 		=> 'hidden',
                    'value'     => 1,
                ],
                [
                    'id' 		=> LISTING_MANAGER_USER_PREFIX . 'username',
                    'type' 		=> 'text',
                    'label'		=> esc_html__( 'Username', 'listing-manager' ),
                    'required' 	=> true,
                ],
                [
                    'id' 		=> LISTING_MANAGER_USER_PREFIX . 'email',
                    'type' 		=> 'email',
                    'label'		=> esc_html__( 'E-mail', 'listing-manager' ),
                    'required' 	=> true,
                ],
                [
                    'id' 		=> LISTING_MANAGER_USER_PREFIX . 'password',
                    'type' 		=> 'password',
                    'label'		=> esc_html__( 'Password', 'listing-manager' ),
                    'required' 	=> true,
                ],
                [
                    'id' 		=> LISTING_MANAGER_USER_PREFIX . 'password_retype',
                    'type' 		=> 'password',
                    'label'		=> esc_html__( 'Retype password', 'listing-manager' ),
                    'required' 	=> true,
                ],
            ],
        ];

        // Add terms and condition checkbox
        $page_terms_id = get_theme_mod( 'listing_manager_pages_terms', null );
        if ( ! empty( $page_terms_id ) ) {
            $message = __( 'I accept <a href="%s" target="_blank">terms and conditions</a>', 'listing-manager' );

            $registration_fields['fields'][] = [
                'id' 		=> LISTING_MANAGER_USER_PREFIX . 'terms',
                'type' 		=> 'checkbox',
                'label'		=> sprintf( $message, get_the_permalink( $page_terms_id ) ),
                'required' 	=> false,
            ];
        }

        $user_fields = apply_filters( 'listing_manager_registration_fields', $registration_fields );

        array_unshift( $fields, $user_fields );
        return $fields;
    }

    /**
     * @Action(name="init")
     */
    public static function process_change_password_form() {
        if ( ! isset( $_POST['change_password_form'] ) ) {
            return;
        }

        $old_password = $_POST['old_password'];
        $new_password = $_POST['new_password'];
        $retype_password = $_POST['retype_password'];

        if ( empty( $old_password ) || empty( $new_password ) || empty( $retype_password ) ) {
            wc_add_notice( esc_html__( 'All fields are required.', 'listing-manager' ), 'error' );
            return;
        }

        if ( $new_password != $retype_password ) {
            wc_add_notice( esc_html__( 'New and retyped password are not same.', 'listing-manager' ), 'error' );
            return;
        }

        $user = wp_get_current_user();

        if ( ! wp_check_password( $old_password, $user->data->user_pass, $user->ID ) ) {
            wc_add_notice( esc_html__( 'Your old password is not correct.', 'listing-manager' ), 'error' );
            return;
        }

        wp_set_password( $new_password, $user->ID );
        wc_add_notice( esc_html__( 'Your password has been successfully changed.', 'listing-manager' ), 'success' );
    }

    /**
     * @Action(name="init")
     */
    public static function process_login_form() {
        if ( ! isset( $_POST['login_form'] ) ) {
            return;
        }

        $redirect = site_url();
        if ( ! empty( $_SERVER['HTTP_REFERER'] ) ) {
            $redirect = $_SERVER['HTTP_REFERER'];
        }

        if ( empty( $_POST['login'] ) || empty( $_POST['password'] ) ) {
            wc_add_notice( esc_html__( 'Login and password are required.', 'listing-manager' ), 'error' );
            return;
        }

        $user = wp_signon( [
            'user_login'        => $_POST['login'],
            'user_password'     => $_POST['password'],
        ], false );

        if ( is_wp_error( $user ) ) {
            wc_add_notice( $user->get_error_message(), 'error' );
            return;
        }

        // login page
        $login_required_page = get_theme_mod( 'listing_manager_pages_login' );
        $login_required_page_url = $login_required_page ? get_permalink( $login_required_page ) : site_url();

        // after login page
        $after_login_page = get_theme_mod( 'listing_manager_pages_login_after' );
        $after_login_page_url = $after_login_page ? get_permalink( $after_login_page ) : site_url();

        // if user logs in at login page, redirect him to after login page. Otherwise, redirect him back to previous URL.
        $protocol = is_ssl() ? 'https://' : 'http://';
        $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $after_login_url = $current_url == $login_required_page_url ? $after_login_page_url : $current_url;

        if ( ! empty( $_GET['next'] ) ) {
            $after_login_url = esc_html( $_GET['next'] );
        }

        wp_redirect( $after_login_url );
        exit();
    }

    /**
     * @Action(name="init")
     */
    public static function process_reset_password_form() {
        if ( ! isset( $_POST['reset_form'] ) ) {
            return;
        }

        WC_Shortcode_My_Account::retrieve_password();
    }

    /**
     * @Action(name="init")
     */
    public static function process_register_form() {
        if ( ! isset( $_POST['register_form'] ) || ! get_option( 'users_can_register' ) || isset( $_POST['submit_listing'] ) ) {
            return;
        }


        if ( empty( $_POST[ LISTING_MANAGER_USER_PREFIX . 'username' ] ) || empty( $_POST[ LISTING_MANAGER_USER_PREFIX . 'email' ] ) ) {
            wc_add_notice( esc_html__( 'Username and e-mail are required.', 'listing-manager' ), 'error' );
            return;
        }

        $user_id = username_exists( $_POST[ LISTING_MANAGER_USER_PREFIX . 'username' ] );
        if ( ! empty( $user_id ) ) {
            wc_add_notice( esc_html__( 'Username already exists.', 'listing-manager' ), 'error' );
            return;
        }

        $user_id = email_exists( $_POST[ LISTING_MANAGER_USER_PREFIX .  'email' ] );
        if ( ! empty( $user_id ) ) {
            wc_add_notice( esc_html__( 'Email already exists.', 'listing-manager' ), 'error' );
            return;
        }

        if ( $_POST[ LISTING_MANAGER_USER_PREFIX .  'password' ] != $_POST[ LISTING_MANAGER_USER_PREFIX .  'password_retype' ] ) {
            wc_add_notice( esc_html__( 'Passwords must be same.', 'listing-manager' ), 'error' );
            return;
        }

        $terms_id = get_theme_mod( 'listing_manager_pages_terms', false );

        if ( $terms_id && empty( $_POST[ LISTING_MANAGER_USER_PREFIX . 'terms' ] ) ) {
            wc_add_notice( esc_html__( 'You must agree terms &amp; conditions.', 'listing-manager' ), 'error' );
            return;
        }

        if ( $_POST[ LISTING_MANAGER_USER_PREFIX . 'password' ] != $_POST[ LISTING_MANAGER_USER_PREFIX . 'password_retype' ] ) {
            wc_add_notice( esc_html__( 'Passwords must be same.', 'listing-manager' ), 'error' );
            return;
        }

        $user_login = $_POST[ LISTING_MANAGER_USER_PREFIX . 'username'];
        $user_id = wp_create_user( $user_login, $_POST[ LISTING_MANAGER_USER_PREFIX . 'password' ], $_POST[ LISTING_MANAGER_USER_PREFIX . 'email'] );

        wp_new_user_notification( $user_id, null, 'both' );

        if ( is_wp_error( $user_id ) ) {
            wc_add_notice( $user_id->get_error_message(), 'error' );
            return;
        }

        wc_add_notice( esc_html__( 'You have been successfully registered.', 'listing-manager' ), 'success' );
        $user = get_user_by( 'login', $user_login );
        $log_in_after_registration = get_theme_mod( 'listing_manager_login_after_registration', false );

        // automatic user log in
        if ( $user && $log_in_after_registration ) {
            wp_set_current_user( $user->ID, $user_login );
            wp_set_auth_cookie( $user->ID );
            do_action( 'wp_login', $user_login, $user );
        }

        // registration page
        $registration_page = get_theme_mod( 'listing_manager_pages_register' );
        $registration_page_url = $registration_page ? get_permalink( $registration_page ) : site_url();

        // after register page
        $after_register_page = get_theme_mod( 'listing_manager_pages_register_after' );
        $after_register_page_url = $after_register_page ? get_permalink( $after_register_page ) : site_url();

        // if user registers at registration page, redirect him to after register page. Otherwise, redirect him back to previous URL.
        $protocol = is_ssl() ? 'https://' : 'http://';
        $current_url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

        $after_register_url = $current_url == $registration_page_url ? $after_register_page_url : $current_url;

        wp_redirect( $after_register_url );
        exit();
    }

    /**
     * Validates user registration form
     *
     * @access public
     * @return bool
     */
    public static function validate_user_fields() {
        if ( is_user_logged_in() ) {
            return true;
        }

        $error = false;

        // Username is unique
        $user_id = username_exists( $_POST[ LISTING_MANAGER_USER_PREFIX . 'username' ] );
        if ( ! empty( $user_id ) ) {
            $_SESSION['form_errors'][ LISTING_MANAGER_USER_PREFIX . 'username' ][]
                = esc_html__( 'Username already exists. Please choose another one.', 'listing-manager' );
            $error = true;
        }

        // Email address is unique
        $user_id = email_exists( $_POST[ LISTING_MANAGER_USER_PREFIX . 'email' ] );
        if ( ! empty( $user_id ) ) {
            $_SESSION['form_errors'][ LISTING_MANAGER_USER_PREFIX . 'email' ][]
                = esc_html__( 'E-mail address already exists. Please choose another one.', 'listing-manager' );
            $error = true;
        }

        // Checks if the passwords are same
        if ( $_POST[ LISTING_MANAGER_USER_PREFIX .'password' ] != $_POST[ LISTING_MANAGER_USER_PREFIX . 'password_retype' ] ) {
            $_SESSION['form_errors'][ LISTING_MANAGER_USER_PREFIX . 'password_retype' ][]
                = esc_html__( 'Passwords must be same.', 'listing-manager' );
            $error = true;
        }

        // Accepted terms and conditions
        $terms_id = get_theme_mod( 'listing_manager_pages_terms', null );

        if ( ! empty( $terms_id ) && empty( $_POST[ LISTING_MANAGER_USER_PREFIX . 'terms' ] ) ) {
            $_SESSION['form_errors'][ LISTING_MANAGER_USER_PREFIX . 'terms' ][]
                = esc_html__( 'You must agree terms &amp; conditions.', 'listing-manager' );
            $error = true;
        }

        if ( $error ) {
            return false;
        }

        return true;
    }

    /**
     * Process register form
     *
     * @access public
     * @return bool|int
     */
    public static function register_user() {
        if ( ! isset( $_POST['register_form'] ) || ! get_option( 'users_can_register' ) ) {
            return false;
        }

        $user_login = $_POST[ LISTING_MANAGER_USER_PREFIX . 'username' ];
        $user_id = wp_create_user(
            $user_login,
            $_POST[ LISTING_MANAGER_USER_PREFIX  . 'password' ],
            $_POST[ LISTING_MANAGER_USER_PREFIX  . 'email' ] );

        if ( is_wp_error( $user_id ) ) {
            wc_add_notice( $user_id->get_error_message(), 'error' );
            return false;
        }

        wp_new_user_notification( $user_id );
        wc_add_notice( esc_html__( 'You have been successfully registered.', 'listing-manager' ), 'success' );

        // Automatically authenticate user
        $user = get_user_by( 'login', $user_login );
        wp_set_current_user( $user->ID, $user_login );
        wp_set_auth_cookie( $user->ID );
        do_action( 'wp_login', $user_login, $user );

        return $user_id;
    }

	/**
	 * Checks if user has permission to access front end forms
	 *
	 * @param $user
	 * @return bool
	 */
    public static function has_permission_front_end( $user ) {
    	$default_roles = array_keys( wp_roles()->get_names() );
	    $roles = (array) get_theme_mod( 'listing_manager_submission_roles', $default_roles );
	    $intersect = array_intersect( $user->roles, $roles );

	    if ( 0 !== count( $intersect ) ) {
	    	return true;
	    }

	    return false;
    }
}