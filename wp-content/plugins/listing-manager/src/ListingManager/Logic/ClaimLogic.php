<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use WP_Query;

class ClaimLogic {
    /**
     * @Action(name="wp_ajax_nopriv_listing_manager_ajax_can_claim")
     * @Action(name="wp_ajax_listing_manager_ajax_can_claim")
     */
    public static function ajax_can_claim() {
        header( 'HTTP/1.0 200 OK' );
        header( 'Content-Type: application/json' );

        if ( ! empty( $_GET['id'] ) ) {
            $listing_already_verified = self::listing_is_verified( $_GET['id'] );

            if ( $listing_already_verified ) {
                $data = [
                    'success' => false,
                    'message' => esc_html__( 'Listing is already verified.', 'listing-manager' ),
                ];
            } else {
                $user_already_claimed = self::user_already_claimed( $_GET['id'], get_current_user_id() );

                if ( $user_already_claimed ) {
                    $data = [
                        'success' => false,
                        'message' => esc_html__( 'You already claimed this listing.', 'listing-manager' ),
                    ];
                } else {
                    $data = [
                        'success' => true,
                    ];
                }
            }
        } else {
            $data = [
                'success' => false,
                'message' => esc_html__( 'Listing ID is missing.', 'listing-manager' ),
            ];
        }

        echo json_encode( $data );
        exit();
    }

    /**
     * @Action(name="transition_post_status", priority=10, accepted_args=3)
     */
    public static function claim_transition( $new_status, $old_status, $post ) {
        $post_type = get_post_type( $post );

        if ( 'claim' != $post_type ) {
            return;
        }

        if ( 'publish' != $new_status || ! in_array( $old_status, [ 'new', 'auto-draft', 'draft', 'pending', 'future' ] ) ) {
            return;
        }

        $verified = get_post_meta( get_the_ID(), LISTING_MANAGER_CLAIM_PREFIX . 'verified', true );
        if ( $verified ) {
            return;
        }

        self::mail_claim_approved( $post );

        $claim_author = $post->post_author;
        $listing_id = get_post_meta( $post->ID, LISTING_MANAGER_CLAIM_PREFIX . 'listing_id', true );
        $listing = get_post( $listing_id );
        $listing->post_author = $claim_author;
        wp_update_post( $listing );
        update_post_meta( $listing->ID, LISTING_MANAGER_CLAIM_PREFIX. 'verified', true );
    }

    /**
     * @Action(name="wp_loaded")
     */
    public static function process_claim_form() {
        if ( ! isset( $_POST['claim_form'] ) || empty( $_POST['listing_id'] ) ) {
            return;
        }

        $user_already_claimed = self::user_already_claimed( $_POST['listing_id'], get_current_user_id() );

        if ( $user_already_claimed ) {
            wc_add_notice( esc_html__( 'You already claimed this listing.', 'listing-manager' ), 'danger' );
            return;
        }

        $listing = get_post( $_POST['listing_id'] );
        $email = esc_html( $_POST['email'] );
        $phone = esc_html( $_POST['phone'] );
        $name = esc_html( $_POST['name'] );
        $message = esc_html( $_POST['message'] );

        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $email );

        $template_args = [
            'listing' => get_the_title( $listing ),
            'url' => get_permalink( $listing->ID ),
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'message' => $message,
        ];

        $subject = esc_html__( sprintf( '%s has been claimed', get_the_title( $listing ) ), 'listing-manager' );
        $subject = apply_filters( 'listing_manger_claim_mail_subject', $subject, $template_args );

        $body = '';
        $body = apply_filters( 'listing_manager_claim_mail_body', $body, $template_args );

        if ( empty( $body ) ) {
            $body = wc_get_template_html( 'listing-manager/claim.php', $template_args, '', LISTING_MANAGER_DIR . 'templates/' );
        }

        $emails = [];
        $emails[] = get_the_author_meta( 'user_email', $listing->post_author );
        $emails[] = get_bloginfo( 'admin_email' );
        $emails = array_unique( $emails );

        foreach ( $emails as $email ) {
            $status = wp_mail( $email, $subject, $body, $headers );
        }

        if ( ! empty( $status ) && 1 == $status ) {
            self::save_claim( $listing->ID, get_current_user_id(), $name, $email, $phone, $message );
            wc_add_notice( esc_html__( 'Message has been successfully sent. Please, wait for admin review.', 'listing-manager' ), 'success' );
        } else {
            wc_add_notice( esc_html__( 'Unable to send a message.', 'listing-manager' ), 'error' );
        }
    }

    /**
     * @Action(name="woocommerce_after_single_product")
     */
    public static function render_button( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return;
        }

        $page = get_theme_mod( 'listing_manager_pages_claim', null );
        $verified = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'verified', true );

        if ( empty( $page ) ) {
            return;
        }

        if ( $verified ) {
            $verified_string = '<span class="listing-manager-listing-verified">' . esc_attr__( 'Verified', 'listing-manager' ) . '</span>';
        } else {
            $verified = self::listing_is_verified( $post_id );

            $atts = [
                'listing_id'    => $post_id,
                'claim_page'    => $page,
                'is_verified'   => $verified,
            ];

            $verified_string = wc_get_template_html( 'listing-manager/claim.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
        }

        echo $verified_string;
    }

    public static function get_link( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return;
        }

        $page = get_theme_mod( 'listing_manager_pages_claim', null );
        $verified = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'verified', true );

        if ( empty( $page ) ) {
            return null;
        }

        if ( $verified ) {
            return null;
        } else {
            return get_permalink( $page ) . '?id=' . $post_id;
        }

        return null;
    }

    /**
     * Saves claim
     *
     * @access public
     * @param $listing_id int
     * @param $user_id int
     * @param $name string
     * @param $email string
     * @param $phone string
     * @param $message string
     * @return int
     */
    public static function save_claim( $listing_id, $user_id, $name, $email, $phone, $message ) {
        $claim_id = wp_insert_post( [
            'post_type'     => 'claim',
            'post_status'   => 'pending',
            'post_author'   => $user_id,
            'post_title'    => get_the_title( $listing_id ),
        ] );

        update_post_meta( $claim_id, LISTING_MANAGER_CLAIM_PREFIX . 'listing_id', $listing_id );
        update_post_meta( $claim_id, LISTING_MANAGER_CLAIM_PREFIX . 'name', $name );
        update_post_meta( $claim_id, LISTING_MANAGER_CLAIM_PREFIX . 'email', $email );
        update_post_meta( $claim_id, LISTING_MANAGER_CLAIM_PREFIX . 'phone', $phone );
        update_post_meta( $claim_id, LISTING_MANAGER_CLAIM_PREFIX . 'message', $message );

        do_action( 'listing_manager_claim_form_saved', $claim_id );

        return $claim_id;
    }

    /**
     * Returns claim by user_id and listing_id
     *
     * @access public
     * @param $listing_id int
     * @param $user_id int
     * @return object
     */
    public static function get_claim( $listing_id, $user_id ) {
        $wp_query = new WP_Query( [
            'post_type'         => 'claim',
            'post_status'       => 'any',
            'author'            => $user_id,
            'meta_query'        => [
                [
                    'key'       => LISTING_MANAGER_CLAIM_PREFIX    . 'listing_id',
                    'value'     => $listing_id,
                ],
            ],
        ] );

        if ( $wp_query->post_count <= 0 ) {
            return null;
        }

        return $wp_query->posts[0];
    }

    /**
     * Checks if listing is already verified
     *
     * @access public
     * @param $listing_id int
     * @return bool
     */
    public static function listing_is_verified( $listing_id ) {
        $verified = get_post_meta( $listing_id, LISTING_MANAGER_CLAIM_PREFIX . 'verified', true );
        return $verified;
    }

    /**
     * Checks if user already claimed for specified listing
     *
     * @access public
     * @param $listing_id int
     * @param $user_id int
     * @return bool
     */
    public static function user_already_claimed( $listing_id, $user_id ) {
        $claim = self::get_claim( $listing_id, $user_id );
        return ( ! empty( $claim ) );
    }

    /**
     * Gets user claims
     *
     * @access public
     * @param int $user_id
     * @return WP_Query
     */
    public static function get_claims_by_user( $user_id = null ) {
        return new WP_Query( [
            'post_type'         => 'claim',
            'author'		    => $user_id,
            'post_status'       => 'any',
        ] );
    }

    /**
     * Sends emails about approved claim to old and new listing author
     *
     * @access public
     * @param $claim
     * @return void
     */
    public static function mail_claim_approved( $claim ) {
        $listing_id = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'listing_id', true );
        $listing = get_post( $listing_id );
        $listing_title = get_the_title( $listing_id );

        # listing author
        $listing_author = $listing->post_author;
        $listing_author_email = get_the_author_meta( 'email', $listing_author );
        $listing_author_name = get_the_author_meta( 'nicename', $listing_author );

        # claim author
        $claim_author = $claim->post_author;
        $claim_author_email = get_the_author_meta( 'email', $claim_author );
        $claim_author_name = get_the_author_meta( 'nicename', $claim_author );

        # template args
        $template_args = [
            'listing' 				=> $listing_title,
            'url' 					=> get_permalink( $listing->ID ),
            'listing_author_name'  	=> $listing_author_name,
            'listing_author_email' 	=> $listing_author_email,
            'claim_author_name'  	=> $claim_author_name,
            'claim_author_email' 	=> $claim_author_email,
        ];

        # subject
        $subject = esc_html__( sprintf( 'Claim of %s approved', $listing_title ), 'listing-manager' );
        $subject = apply_filters( 'listing_manager_claim_mail_subject', $subject, $template_args );

        # message
        $body = esc_html__( sprintf( 'New author of listing %s is %s', $listing_title, $claim_author_name ), 'listing-manager' );
        $body = apply_filters( 'listing_manager_claim_mail_body', $body, $template_args );

        # admin
        $admin_email = get_bloginfo( 'admin_email' );
        $admin = get_user_by( 'email', $admin_email );
        $admin_name = $admin->user_nicename;

        # recipients
        $recipients = [ $listing_author_email, $claim_author_email, $admin_email ];
        $recipients = array_unique( $recipients );

        # headers
        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $admin_name, $admin_email );

        foreach ( $recipients as $email ) {
            wp_mail( $email, $subject, $body, $headers );
        }
    }
}
