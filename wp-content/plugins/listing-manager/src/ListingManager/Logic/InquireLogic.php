<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class InquireLogic {
    /**
     * @Action(name="init", priority=9999)
     */
    public static function process_inquire_form() {

        if ( ! isset( $_POST['inquire_form'] ) || empty( $_POST['post_id'] ) ) {
            return;
        }

        $inquire = get_theme_mod( 'listing_manager_inquire_authenticated', null );        

        if ( ! empty( $inquire ) && ! is_user_logged_in() ) {            
            wc_add_notice( esc_html__( 'Please sign in before posting inquire.', 'listing-manager' ), 'error' );
            return;
        }

        $post = get_post( $_POST['post_id'] );
        $email = esc_html( $_POST['email'] );
        $name = esc_html( $_POST['name'] );

        if ( ! empty( $_POST['subject'] ) ) {
            $subject = $_POST['subject'];
        } else {
            $subject = esc_html__( 'Message from enquire form', 'listing-manager' );
        }

        $headers = sprintf( "From: %s <%s>\r\n Content-type: text/html", $name, $email );

        $message = wc_get_template_html( 'listing-manager/mails/inquire.php', [
            'post'      => $post,
            'email'     => $email,
            'name'      => $name,
        ], '', LISTING_MANAGER_DIR . 'templates/' );

        $emails = [];

        // Author
        $emails[] = get_the_author_meta( 'user_email', $post->post_author );

        // Admin
        $emails[] = get_bloginfo( 'admin_email' );

        // Listing email
        $email = get_post_meta( $_POST['post_id'], LISTING_MANAGER_LISTING_PREFIX . 'contact_email', true );

        if ( ! empty( $email ) ) {
            $emails[] = $email;
        }

        // User email
        $emails[] = get_the_author_meta( 'user_email', $post->post_author );

        $emails = array_unique( $emails );

        foreach ( $emails as $email ) {
            $status = wp_mail( $email, $subject, $message, $headers );
        }

        $success = ! empty( $status ) && 1 == $status;

        do_action( 'listing_manager_inquire_message_sent', $success,
            $_POST['post_id'], $_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']
        );

        if ( $success ) {
            wc_add_notice( esc_html__( 'Message has been successfully sent.', 'listing-manager' ), 'success' );
        } else {
            wc_add_notice( esc_html__( 'Unable to send a message.', 'listing-manager' ), 'error' );
        }

        wp_redirect( $_POST['next'] );
        exit();
    }
}
