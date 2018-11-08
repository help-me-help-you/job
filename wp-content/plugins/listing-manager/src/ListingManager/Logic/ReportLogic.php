<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class ReportLogic {
    /**
     * @Action(name="init", priority=9999)
     */
    public static function process_report_form() {
        if ( ! isset( $_POST['report_form'] ) || empty( $_POST['listing_id'] ) ) {
            return;
        }

        $listing = get_post( $_POST['listing_id'] );
        $reason = esc_html( $_POST['reason'] );
        $email = esc_html( $_POST['email'] );
        $name = esc_html( $_POST['name'] );
        $message = esc_html( $_POST['message'] );

        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $email );

        // template args
        $template_args = [
            'listing' => get_the_title( $listing ),
            'url' => get_permalink( $listing->ID ),
            'name' => $name,
            'email' => $email,
            'reason' => $reason,
            'message' => $message,
        ];

        // subject
        $subject = __( sprintf( '%s has been reported', get_the_title( $listing ) ), 'listing-manager' );
        $subject = apply_filters( 'listing_manager_report_mail_subject', $subject, $template_args );

        // body
        $body = '';
        $body = apply_filters( 'listing_manager_report_mail_body', $body, $template_args );

        if ( empty( $body ) ) {
            $atts = [
                'listing'   => $listing,
                'name'      => $name,
                'email'     => $email,
                'reason'    => $reason,
                'message'   => $message,
            ];
            $body = wc_get_template_html( 'listing-manager/mails/report.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
        }

        // recipients
        $emails = [];

        // admin
        $emails[] = get_bloginfo( 'admin_email' );
        $emails = array_unique( $emails );

        foreach ( $emails as $email ) {
            $status = wp_mail( $email, $subject, $body, $headers );
        }

        if ( ! empty( $status ) && 1 == $status ) {
            self::save_report( $listing->ID, get_current_user_id(), $reason, $name, $email, $message );
            wc_add_notice( esc_html__( 'Listing was reported. Please, wait for admin review.', 'listing-manager' ), 'success' );
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

        $report = get_theme_mod( 'listing_manager_pages_report', null );

        if ( ! empty( $report ) ) {
            $atts = [
                'report' => $report,
            ];

            wc_get_template( 'listing-manager/report.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
        }
    }

    /**
     * Gets report link
     *
     * @return string|null
     */
    public static function get_link( $post_id ) {
        $post_id = null;

        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        if ( ! has_term( 'listing', 'product_type', $post_id ) ) {
            return null;
        }

        $report = get_theme_mod( 'listing_manager_pages_report', null );

        if ( ! empty( $report ) ) {
            return get_permalink( $report ) . '?id=' . $post_id;
        }

        return null;
    }

    /**
     * Saves report
     *
     * @access public
     * @param $listing_id int
     * @param $user_id int
     * @param $name string
     * @param $email string
     * @param $message string
     * @return int
     */
    public static function save_report( $listing_id, $user_id, $reason, $name, $email, $message ) {
        $report_id = wp_insert_post( [
            'post_type'     => 'report',
            'post_status'   => 'pending',
            'post_author'   => $user_id,
            'post_title'    => get_the_title( $listing_id ),
        ] );

        update_post_meta( $report_id, LISTING_MANAGER_REPORT_PREFIX. 'listing_id', $listing_id );
        update_post_meta( $report_id, LISTING_MANAGER_REPORT_PREFIX. 'name', $name );
        update_post_meta( $report_id, LISTING_MANAGER_REPORT_PREFIX. 'email', $email );
        update_post_meta( $report_id, LISTING_MANAGER_REPORT_PREFIX. 'reason', $reason );
        update_post_meta( $report_id, LISTING_MANAGER_REPORT_PREFIX. 'message', $message );

        return $report_id;
    }
}
