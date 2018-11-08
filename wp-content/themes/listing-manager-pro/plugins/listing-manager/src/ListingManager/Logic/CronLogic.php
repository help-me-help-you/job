<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Product\PackageProduct;

use WC_Order;
use WP_Post;
use WP_Query;

class CronLogic {
	/**
	 * @Action(name="wp_loaded")
	 */
	public static function notify_before_expiration_notice() {
		if ( ! is_user_logged_in() ) {
			return;
		}

		// If free submission type is used we don't have to check for expired submissions
		if ( 'packages' !== get_theme_mod( 'listing_manager_submission_type', 'free' ) ) {
			return;
		}

		if ( is_admin() ) {
			return;
		}

		$orders = new WP_Query( [
			'post_type'         => 'shop_order',
			'meta_key'          => '_customer_user',
			'meta_value'        => get_current_user_id(),
			'post_status'       => 'wc-completed',
			'posts_per_page'    => -1,
		] );

		if ( is_array( $orders->posts ) ) {
			foreach ( $orders->posts as $order ) {
				$package_id = PackageProduct::get_order_package_id( $order->ID );

				if ( PackageProduct::is_base_package( $order->ID, $package_id ) && PackageProduct::is_going_to_expire( $order->ID, $package_id ) ) {
					$notices = wc_get_notices();
					$same_notice_found = false;

					$message = sprintf(
						'Package <strong title="Order ID: #%s">%s</strong> is going to expire. <a href="?action=listing-manager-extend&amp;order-id=%s&amp;package-id=%s">Click here to extend.</a>',
						$order->ID, get_the_title( $package_id ), $order->ID, $package_id );

					if ( ! empty( $notices ) && ! empty( $notices['notice'] ) ) {
						foreach ( $notices['notice'] as $notice ) {
							if ( $notice === $message ) {
								$same_notice_found = true;
							}
						}
					}

					if ( ! $same_notice_found ) {
						wc_add_notice( wp_kses( $message, wp_kses_allowed_html( 'post' ) ), 'notice' );
					}

				}
			}
		}
	}

	/**
	 * @Action(name="wp_ajax_notify_before_expiration_email")
	 * @Action(name="wp_ajax_nopriv_notify_before_expiration_email")
	 */
	public static function notify_before_expiration_email() {
		// If free submission type is used we don't have to check for expired submissions
		if ( 'packages' !== get_theme_mod( 'listing_manager_submission_type', 'free' ) ) {
			return;
		}

		$orders = new WP_Query( [
			'post_type'         => 'shop_order',
			'post_status'       => 'wc-completed',
			'posts_per_page'    => -1,
		] );

		if ( is_array( $orders->posts ) ) {
			foreach ( $orders->posts as $order ) {
				$package_id = PackageProduct::get_order_package_id( $order->ID );

				if ( PackageProduct::is_going_to_expire( $order->ID, $package_id ) ) {
					// We want to send notification email only once
					$notified = get_post_meta( $order->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'expiration_notified', true );
					if ( ! empty( $notified ) ) {
						continue;
					}

					$email = get_the_author_meta( 'email', $order->post_author );
					$subject = esc_html__( 'Your package is going to expire', 'listing-manager' );
					$headers = sprintf( 'Content-type: text/html' );
					$message = wc_get_template_html( 'listing-manager/mails/expiring.php', [
						'package_title'     => get_the_title( $package_id ),
						'expiration_date'   => PackageProduct::get_expiration_formatted( $order->ID, $package_id ),
					], '', LISTING_MANAGER_DIR . 'templates/' );

					wp_mail( $email, $subject, $message, $headers );
					update_post_meta( $order->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'expiration_notified', true );
				}
			}
		}
	}

	/**
	 * @Action(name="wp_ajax_check_for_expired")
	 * @Action(name="wp_ajax_nopriv_check_for_expired")
	 */
    public static function check_for_expired() {
        // If free submission type is used we don't have to check for expired submissions
        if ( 'packages' !== get_theme_mod( 'listing_manager_submission_type', 'free' ) ) {
            return;
        }

        $orders = new WP_Query( [
            'post_type'         => 'shop_order',
            'post_status'       => 'wc-completed',
            'posts_per_page'    => -1,
        ] );

        if ( is_array( $orders->posts ) ) {
            foreach ( $orders->posts as $order ) {
                $package_id = PackageProduct::get_order_package_id( $order->ID );

                if ( PackageProduct::is_base_package( $order->ID, $package_id ) && PackageProduct::is_expired( $order->ID, $package_id ) ) {
                    $listings = PackageProduct::get_listings_for_order( $order->ID );

                    foreach ( $listings as $listing ) {
                        $listing->post_status = 'draft';
                        wp_update_post( $listing );
                    }
                }
            }
        }
    }

	/**
	 * @Action(name="wp_ajax_unpublish_passed_events")
	 * @Action(name="wp_ajax_nopriv_unpublish_passed_events")
	 */
    public static function unpublish_passed_events() {
        $unpublish_passed_events = get_theme_mod( 'listing_manager_events_unpublish_passed', false );

        if ( 1 == $unpublish_passed_events ) {
            $events = new WP_Query( [
                'post_type' 		=> 'product',
                'post_status'		=> 'publish',
                'posts_per_page' 	=> -1,
                'meta_query'		=> [
                    [
                        'key'		=> LISTING_MANAGER_LISTING_PREFIX . 'event_date',
                        'value'		=> '',
                        'compare' 	=> '!=',
                    ],
                ],
            ] );

            if ( is_array( $events->posts ) ) {
                /** @var WP_Post $event */
                foreach( $events->posts as $event ) {
                    $event_date_start = get_post_meta( $event->ID, LISTING_MANAGER_LISTING_PREFIX . 'event_date', true );
                    $event_date_end = get_post_meta( $event->ID, LISTING_MANAGER_LISTING_PREFIX . 'event_date_end', true );

                    if ( ! empty( $event_date_start ) && ! empty( $event_date_end ) && strtotime( $event_date_end ) < strtotime( date('Y-m-d') ) ) {
                        wp_update_post( [
                            'ID' 			=> $event->ID,
                            'post_status' 	=> 'private',
                        ] );
                    } elseif ( ! empty( $event_date_start ) && strtotime( $event_date_start) < strtotime( date('Y-m-d') ) ) {
                        wp_update_post( [
                            'ID' 			=> $event->ID,
                            'post_status' 	=> 'private',
                        ] );
                    }
                }
            }
        }
    }
}
