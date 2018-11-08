<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;
use ListingManager\Annotation\Filter;
use ListingManager\Product\PackageProduct;
use ListingManager\Utilities;

class SubmissionLogic {
	/**
	 * @Filter(name="listing_manager_submission_forms")
	 */
	public static function add_forms( $labels ) {
		$labels['general'] = esc_html__( 'General', 'listing-manager' );
		$labels['property'] = esc_html__( 'Property', 'listing-manager' );
		$labels['event'] = esc_html__( 'Event', 'listing-manager' );
		$labels['car'] = esc_html__( 'Car', 'listing-manager' );
		$labels['job'] = esc_html__( 'Job', 'listing-manager' );

		return $labels;
	}

	/**
	 * @Filter(name="listing_manager_submission_forms", priority=100)
	 */
	public static function disable_forms( $labels ) {
		if ( is_admin() ) {
			return $labels;
		}

		$forms = get_theme_mod( 'listing_manager_submission_forms', [] );

		if ( is_array( $forms ) ) {
			foreach ( $forms as $form ) {
				unset( $labels[ $form ] );
			}
		}

		return $labels;
	}

    /**
     * @Filter(name="listing_manager_submission_fields", priority=9, accepted_args=1)
     */
    public static function add_general_fields( $fields ) {
        $fields[] = [
        	'forms'             => [ 'general', 'property', 'event', 'job', 'car' ],
            'type' 				=> 'fieldset',
            'id'                => 'general',
            'legend'            => esc_html__( 'General Information', 'listing-manager' ),
            'fields'			=> [
                [
                    'id' 		=> 'post_title',
                    'type'		=> 'text',
                    'label' 	=> esc_html__( 'Title', 'listing-manager' ),
                    'required' 	=> true,
                ],
                [
                    'id' 		=> 'post_content',
                    'type'		=> 'textarea',
                    'label' 	=> esc_html__( 'Description', 'listing-manager' ),
                    'required' 	=> true,
                    'rows'		=> 5,
                ],
                [
                    'id' 		=> 'featured_image',
                    'type'		=> 'file',
                    'label' 	=> esc_html__( 'Featured Image', 'listing-manager' ),
                    'required' 	=> false,
                ],
            ],
        ];

        $fields[] = [
        	'forms'             => ['general', 'property', 'event', 'job', 'car' ],
            'type'				=> 'fieldset',
            'id'                => 'gallery',
            'legend'			=> esc_html__( 'Gallery', 'listing-manager' ),
            'fields'			=> [
                [
                    'id'        => '_product_image_gallery',
                    'type'      => 'files',
                    'label'		=> esc_html__( 'Gallery', 'listing-manager' ),
                    'required' 	=> false,
                ],
            ],
        ];

        $fields[] = [
	        'forms'             => ['general', 'event', 'property', 'job', 'car' ],
            'type'				=> 'fieldset',
            'id'                => 'taxonomies',
            'legend'			=> esc_html__( 'Taxonomies', 'listing-manager' ),
            'fields'			=> [
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'product_tag',
                    'type'      => 'taxonomy',
                    'taxonomy'  => 'product_tag',
                    'label'     => esc_html__( 'Tags', 'listing-manager' ),
                    'required' 	=> false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'amenities',
                    'type'      => 'taxonomy',
                    'taxonomy'  => 'amenities',
                    'label'     => esc_html__( 'Amenities', 'listing-manager' ),
                    'required' 	=> false,
                ],
                [
                    'id'        => LISTING_MANAGER_LISTING_PREFIX . 'product_cat',
                    'type'      => 'taxonomy',
                    'taxonomy'  => 'product_cat',
                    'label'     => esc_html__( 'Categories', 'listing-manager' ),
                    'required' 	=> false,
                    'chained'   => true,
                ],
            ],
        ];

        $fields[] = [
	        'forms'             => ['general', 'event', 'property', 'job', 'car' ],
            'type'				=> 'fieldset',
            'id'                => 'price',
            'legend'			=> esc_html__( 'Price Options', 'listing-manager' ),
            'collapsible'       => true,
            'fields'			=> [
                [
                    'id' 		=> '_regular_price',
                    'type'		=> 'text',
                    'label' 	=> esc_html__( 'Regular Price', 'listing-manager' ),
	                'suffix'    => get_woocommerce_currency_symbol(),
                    'required' 	=> false,
                ],
                [
                    'id' 		=> '_sale_price',
                    'type'		=> 'text',
                    'label' 	=> esc_html__( 'Sale Price', 'listing-manager' ),
                    'suffix'    => get_woocommerce_currency_symbol(),
                    'required' 	=> false,
                ],
            ],
        ];

        return $fields;
    }

    /**
     * @Filter(name="listing_manager_file_fields")
     */
    public static function file_fields( $fields ) {
        $fields[] = 'featured_image';
        $fields[] = '_product_image_gallery';
        return $fields;
    }

    /**
     * @Action(name="init", priority=9999)
     */
    public static function process_remove_form() {
        if ( ! isset( $_POST['remove_listing_form'] ) || empty( $_POST['listing_id'] ) ) {
            return;
        }

        if ( wp_delete_post( $_POST['listing_id'] ) ) {
            wc_add_notice( esc_html__( 'Listing has been successfully removed.', 'listing-manager' ), 'success' );
        } else {
            wc_add_notice( esc_html__( 'An error occurred when removing listing.', 'listing-manager' ), 'error' );
        }
    }

    /**
     * @Action(name="init", priority=9999)
     */
    public static function process_remove_attachment() {
        if ( empty( $_GET['id'] ) || empty( $_GET['remove_attachment_id'] ) ) {
            return;
        }

        if ( ! is_user_logged_in() || empty( $_GET['id'] ) || empty( $_GET['remove_attachment_id'] ) ) {
            wc_add_notice( esc_html__( 'You are not allowed to do this.', 'listing-manager' ), 'error' );
            return;
        }

        if ( ! Utilities::is_allowed_to_access( get_current_user_id(), $_GET['id'] ) ) {
            wc_add_notice( esc_html__( 'You are not owner of this listing.', 'listing-manager' ), 'error' );
            return;
        }

        $attachment = get_post( $_GET['remove_attachment_id'] );

        if ( empty( $attachment ) ) {
            wc_add_notice( esc_html__( 'Attachment does not exist.', 'listing-manager' ), 'error' );
            return;
        }

        if ( get_current_user_id() != $attachment->post_author ) {
            wc_add_notice( esc_html__( 'You are not an owner of this attachment file.', 'listing-manager' ), 'error' );
            return;
        }

        if ( true == wp_delete_attachment( $_GET['remove_attachment_id'] ) ) {
            wc_add_notice( esc_html__( 'Attachment has been successfully removed.', 'listing-manager' ), 'success' );

            $fieldsets = self::get_fields();

            /**
             * Gets all defined fields and then loop through them looking for
             * array of ids. If an array is found remove an attachment ID and
             * save new array.
             */
            if ( is_array( $fieldsets ) ) {
                foreach ( $fieldsets as $fieldset ) {
                    if ( is_array( $fieldset ) ) {
                        foreach( $fieldset['fields'] as $field ) {
                            $ids = explode( ',', get_post_meta( $_GET['id'], $field['id'], true ) );

                            // Allowed types are file and files
                            if ( in_array( $field['type'], [ 'file', 'files' ] ) && is_array( $ids ) && ! empty( $ids[0] ) ) {
                                $okay = [];
                                foreach ( $ids as $id ) {
                                    // Here we check if attachment already exists
                                    if ( $id != $_GET['remove_attachment_id'] && wp_get_attachment_url( $id ) ) {
                                        $okay[] = $id;
                                    }
                                }

                                if ( count( $okay ) > 0 ) {
                                    update_post_meta( $_GET['id'], $field['id'], implode( ',', $okay ) );
                                } else {
                                    delete_post_meta( $_GET['id'], $field['id'] );
                                }
                            }
                        }
                    }
                }
            }

            $listing_edit = get_theme_mod( 'listing_manager_pages_listing_edit', null );
            $form = get_post_meta( $_GET['id'], 'form', true );

            if ( ! empty( $listing_edit ) ) {
                $args = '?id=' . $_GET['id'];

                if ( ! empty( $form ) ) {
                    $args .= '&form=' . $form;
                }

                $url = get_permalink( $listing_edit ) . $args;
            } else {
                $url = site_url();
            }

            wp_redirect( $url );
            exit();
        } else {
            wc_add_notice( esc_html__( 'There was an error when removing an attachment.', 'listing-manager' ), 'error' );
        }
    }

    /**
     * @Action(name="wp_loaded")
     */
    public static function process_submission_form() {
        if ( empty( $_POST['submit_listing'] ) ) {
            return;
        }

        if ( self::validate_submission_type() && self::validate_fields() && UserLogic::validate_user_fields() ) {
            if ( $result = self::save_listing() ) {
                $listing_edit = get_theme_mod( 'listing_manager_pages_listing_edit', null );
                $listing_list = get_theme_mod( 'listing_manager_pages_listing_list', null );
                $listing_create_after = get_theme_mod( 'listing_manager_pages_listing_create_after' , null );

                if ( 'create' === $result['action'] && ! empty( $listing_create_after ) ) {
                    $url = get_permalink( $listing_create_after );
                } elseif ( is_int( $result['post_id'] ) && ! empty( $listing_edit ) && ! empty( $_POST['form'] ) ) {
                	$args = [ 'id' => $result['post_id'], ];
                	$args['form'] = $_POST['form'];
                	$query = http_build_query( $args );
                    $url = get_permalink( $listing_edit ) . '?' . $query;
                } elseif ( ! empty( $listing_list ) ) {
                    $url = get_permalink( $listing_list );
                } else {
                    $url = home_url();
                }

                wp_redirect( $url );
                exit();
            }
        } else {
	        wc_add_notice( esc_html__( 'An error occurred when validating listing submission.', 'listing-manager' ), 'error' );
        }
    }

    /**
     * Validates chosen package
     *
     * @access public
     * @return bool
     */
    public static function validate_submission_type() {
	    $submission_type = get_theme_mod( 'listing_manager_submission_type', 'free' );

        if ( 'free' === $submission_type ) {
            return true;
        } elseif ( 'packages' === $submission_type ) {
	        if ( empty( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ] ) &&
	             empty( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package_order' ] ) ) {
		        wc_add_notice( esc_html__( 'Please select the package.', 'listing-manager' ), 'error' );
		        return false;
	        }

	        return true;
        }

        return apply_filters( 'listing_manager_submission_validate_type', false, $_POST, $submission_type );
    }

    /**
     * Create new listing post type
     *
     * @access public
     * @return bool|array
     */
    public static function save_listing() {
        // Set proper status
        if ( 'packages' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) {
	        $order_id = empty( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package_order' ] ) ? null : $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package_order' ];
	        $package_id = empty( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ] ) ? null : $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ];

	        // If user selected already purchased package
	        if ( ! empty( $order_id ) ) {
		        $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ] = PackageProduct::get_order_package_id( $order_id );
	        } elseif ( empty( $order_id ) && ! empty( $package_id ) ) {
		        $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package_order' ] = '';
	        }

            if ( empty( $order_id ) ) {
                $status = 'draft';
            } elseif ( ! PackageProduct::is_expired( $order_id, PackageProduct::get_order_package_id( $order_id ) ) ) {
                if ( PackageProduct::get_remaining_posts( $order_id ) > 0 ) {
                    $review_before = get_theme_mod( 'listing_manager_submission_review_before', false );

                    if ( ! empty( $review_before ) ) {
                        $status = 'pending';
                    } else {
                        $status = 'publish';
                    }
                } else {
                    $status = 'draft';
                    wc_add_notice( esc_html__( 'No enough available listings for the selected package.' ), 'error' );
                }
            } else {
                $status = 'draft';
            }
        } else {
            $review_before = get_theme_mod( 'listing_manager_submission_review_before', false );

            if ( ! empty( $review_before ) ) {
                $status = 'pending';
            } else {
                $status = 'publish';
            }
        }

        // Register user if needed
        if ( true === UserLogic::register_user() ) {
            wc_add_notice( esc_html__( 'You have been successfully registered.', 'listing-manager' ), 'success' );
        }

        $args = [
            'post_title' 	=> ! empty( $_POST['post_title'] ) ? $_POST['post_title'] : esc_html__( 'Empty Listing Title', 'listing-manager' ),
            'post_content' 	=> ! empty( $_POST['post_content'] ) ? $_POST['post_content'] : '',
            'post_type'		=> 'product',
            'post_status'	=> $status,
            'post_author'	=> get_current_user_id(),
        ];

        if ( ! empty( $_GET['id'] ) ) {
            $args['ID'] = $_GET['id'];
            $post_id = wp_update_post( $args );
        } else {
            $post_id = wp_insert_post( $args );
        }

        if ( ! empty( $_POST['form'] ) ) {
            update_post_meta( $post_id, 'form', $_POST['form'] );
        }

        if ( is_int( $post_id ) ) {
            // Set proper product type
            wp_set_object_terms( $post_id, 'listing', 'product_type' );

            // Add new package into cart if the user selected new package
            if ( 'packages' === get_theme_mod( 'listing_manager_submission_type', 'free' ) && empty( $order_id ) ) {
                $result = WC()->cart->add_to_cart( $_POST[ LISTING_MANAGER_LISTING_PREFIX . 'package' ] );

                if ( false !== $result ) {
	                $message = __( 'Package has been added into <a href="%s">cart</a>. Please purchase it before your listing will be published.', 'listing-manager' );
	                $message = sprintf( $message, wc_get_cart_url() );
                    wc_add_notice( $message, 'success' );
                }
            }

            // Save all post meta beginning with listing prefix or underscore
            if ( ! empty( $_POST ) ) {
                foreach ( $_POST as $key => $value ) {
                    if ( '_' === substr( $key, 0, strlen( '_' ) ) ||
                        LISTING_MANAGER_LISTING_PREFIX === substr( $key, 0, strlen( LISTING_MANAGER_LISTING_PREFIX ) )
                    ) {
                        $definition = self::get_field_definition( $key );

                        if ( 'taxonomy' === $definition['type'] ) {
                            $ids = [];

                            if ( is_array( $value ) ) {
                                foreach ( $value as $index => $id ) {
                                    $ids[] = (int) $id;
                                }
                            }

                            wp_set_object_terms( $post_id, $ids, $definition['taxonomy'] );
                        } else {
                            if ( ! empty( $value ) ) {
                                update_post_meta( $post_id, $key, $value );

                                // For WooCommerce regular price save the custom _price field as well
                                if ( '_regular_price' === $key ) {
	                                update_post_meta( $post_id, '_price', $value );
                                }
                            } else {
                                delete_post_meta( $post_id, $key );
                            }
                        }
                    }
                }
            }

            // Save all media files
            if ( ! empty( $_FILES ) ) {
                require_once ABSPATH . 'wp-admin/includes/file.php';

                foreach ( $_FILES as $key => $value ) {
                    // input[type=file]
                    if ( empty( $value['name'] ) || 0 === $value['size'] ) {
                        continue;
                    }

                    // input[type=files] - multiple files
                    if ( is_array( $value['name'] ) && is_array( $value['size'] ) && empty( $value['name'][0] ) && 0 === $value['size'][0] ) {
                        continue;
                    }

                    if ( is_array( $value['name'] ) ) {
                        Utilities::process_files( $post_id, $key, $value );
                    } else {
                        Utilities::process_file( $post_id, $key, $value );
                    }
                }
            }

            // Set the visibility
            update_post_meta( $post_id, '_visibility', 'visible' );

            // Generate proper message
            if ( ! empty( $_GET['id'] ) ) {
                $action = 'update';
                wc_add_notice( esc_html__( 'Listing has been successfully updated.', 'listing-manager' ), 'success' );
            } else {
                $action = 'create';
                wc_add_notice( esc_html__( 'Listing has been successfully added.', 'listing-manager' ), 'success' );
            }

            return [
                'action' 	=> $action,
                'post_id' 	=> $post_id
            ];
        }

        wc_add_notice( esc_html__( 'There was an error when saving the listing.' ), 'error' );
        return false;
    }

    /**
     * Gets list of all required fields in submission form
     *
     * @access public
     * @param array $fields
     * @param array $ids
     * @return array
     */
    public static function get_required_fields( $fields, $ids = [] ) {
        foreach ( $fields as $field ) {
			if ( ! empty( $field['forms'] ) && ! in_array( $_POST['form'], $field['forms'] ) ) {
				continue;
			}

            if ( ! empty( $field['required'] ) && true === $field['required'] ) {
                $ids[] = [
                	'id'    => $field['id'],
	                'label' => $field['label'],
	                'type'  => $field['type'],
                ];
            }

            if ( 'fieldset' === $field['type'] ) {
            	if ( ! empty( $_GET['form'] ) && ! empty( $field['forms'] ) ) {
					if ( ! in_array( $_GET['form'], $field['forms'] ) ) {
						continue;
					}
	            }

                $ids = self::get_required_fields( $field['fields'], $ids );
            }
        }

        return $ids;
    }

    /**
     * Gets field params
     *
     * @access public
     * @param string $key
     * @param array $fields
     * @return array
     */
    public static function get_field_definition( $key, $fields = null ) {
        if ( empty( $fields ) ) {
            $fields = self::get_fields();
        }

        foreach ( $fields as $field ) {
            if ( 'fieldset' === $field['type'] ) {
            	if ( is_array( $field['fields'] ) ) {
		            foreach ( $field['fields'] as $subfield ) {
			            if ( ! empty( $subfield['id'] ) && $subfield['id'] == $key ) {
				            return $subfield;
			            }
		            }
	            }

                if ( ! empty( $result ) ) {
                    return $result;
                }
            }

            if ( ! empty( $field['id'] ) && $field['id'] == $key ) {
                return $field;
            }
        }

        return null;
    }

    /**
     * Validate submission for fields
     *
     * @access public
     * @return bool|array
     */
    public static function validate_fields() {
        $fields = self::get_required_fields( self::get_fields() );

        foreach ( $fields as $field ) {
        	if ( 'google-map' === $field['type'] ) {
				if ( empty( $_POST[ $field['id'] . '_latitude'] ) ) {
					$_SESSION['form_errors'][ $field['id'] . '_latitude' ][] = esc_html__( 'Field latitude is required.', 'listing-manager' );
				}

		        if ( empty( $_POST[ $field['id'] . '_latitude'] ) ) {
			        $_SESSION['form_errors'][ $field['id'] . '_longitude' ][] = esc_html__( 'Field longitude is required.', 'listing-manager' );
		        }

	        } elseif ( empty( $_POST[ $field['id'] ] ) && empty( $_FILES[ $field['id'] ] ) ) {
	            wc_add_notice( wp_kses( __( sprintf( 'Field <strong>%s</strong> is required.', $field['label'] ), 'listing-manager' ) , wp_kses_allowed_html('post') ), 'error' );
                $_SESSION['form_errors'][ $field['id'] ][] = esc_html__( 'Field is required.', 'listing-manager' );
            }
        }

        if ( ! empty( $_SESSION['form_errors'] ) && count( $_SESSION['form_errors'] ) > 0 ) {
            return false;
        }

        return true;
    }

    /**
     * Remove all validation errors
     *
     * @access public
     * @return void
     */
    public static function clean_validation_errors() {
        unset( $_SESSION['form_errors'] );
    }

    /**
     * Gets fields
     *
     * @access public
     * @return array
     */
    public static function get_fields() {
	    return apply_filters( 'listing_manager_submission_fields', [] );
    }

	/**
	 * Gets all registered forms
	 *
	 * @return array
	 */
    public static function get_submission_forms() {
		return apply_filters( 'listing_manager_submission_forms', [] );
    }

	/**
	 * Get only forms which already have fields
	 *
	 * @return array
	 */
    public static function get_available_forms() {
    	$form_slugs = [];
    	$results = [];
    	$forms = self::get_submission_forms();

	    foreach( self::get_fields() as $field ) {
		    if ( ! empty( $field['forms'] ) ) {
			    $form_slugs = array_unique( array_merge( $form_slugs, $field['forms'] ) );
		    }
	    }

	    foreach( $form_slugs as $slug ) {
	    	if ( ! empty( $forms[ $slug ] ) ) {
			    $results[ $slug ] = $forms[ $slug ];
		    }
	    }

	    return $results;
    }

    /**
     * Render form fields
     *
     * @access public
     * @param array $fields
     * @param bool $update
     * @param string $category
     * @return string
     */
    public static function render_fields( $fields = null, $update = false, $category = null ) {
        $output = '';

        if ( null === $fields ) {
            $fields = self::get_fields();
        }

        if ( is_array( $fields ) ) {
            foreach ( $fields as $field ) {
                if ( 'fieldset' === $field['type'] ) {
                	if ( ! empty( $category ) && 'user' !== $field['id'] ) {
                		if ( empty( $field['forms'] ) || ! in_array( $category, $field['forms'] ) ) {
                			continue;
		                }
	                }

                    $atts = [];

                    if ( ! empty( $field['fields'] ) ) {
                        $atts['content'] = self::render_fields( $field['fields'], $update );
                    } else {
                        $atts['content'] = esc_html__( 'No fields defined.', 'listing-manager' );
                    }

                    $atts['collapsible'] = ! empty( $field['collapsible'] ) ? true : false;
                    $atts['id'] = ! empty( $field['id'] ) ? $field['id'] : null;

                    if ( ! empty( $field['legend'] ) ) {
                        $atts['legend'] = $field['legend'];
                    }

                    $output .= wc_get_template_html( 'listing-manager/fields/fieldset.php', $atts, '', LISTING_MANAGER_DIR . 'templates/' );
                } else {
                    $output .= self::render_field( $field, $update );
                }
            }
        }

        return $output;
    }

    /**
     * Gets template for field
     *
     * @access public
     * @param array $field
     * @param bool $update
     * @return string
     */
    public static function render_field( $field, $update = false ) {
        $id = ! empty( $_GET['id'] ) ? $_GET['id'] : null;
        $field['value'] = self::get_field_value( $id, $field );
        
        return wc_get_template_html( 'listing-manager/fields/' . $field['type'] . '.php',
            $field, '', LISTING_MANAGER_DIR . 'templates/' );
    }

    /**
     * Gets value for field
     *
     * @access public
     * @param int $post_id
     * @param array $field
     * @return string|null
     */
    public static function get_field_value( $post_id, $field ) {
        if ( empty( $field['id'] ) ) {
            return null;
        }

        if ( ! empty( $_POST[ $field['id'] ] ) ) {
            return $_POST[ $field['id'] ];
        }

        if ( ! empty( $field['value'] ) ) {
            return $field['value'];
        }

        if ( empty( $post_id ) ) {
            return null;
        }

        // Process special fields
        if ( 'post_title' === $field['id'] ) {
            return get_the_title( $post_id );
        } elseif ( 'post_content' === $field['id'] ) {
            $post = get_post( $post_id );
            return $post->post_content;
        }

        // Fallback check the field meta value
        return get_post_meta( $post_id, $field['id'], true );
    }
}
