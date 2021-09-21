<?php
/**
 * Require the Vendor Title and Description to be non-empty on Vendor Post create/edit
 *
 * @param WP_Post
 */
function affcoups_admin_force_vendor_post_title_and_description( $post ) {

    $post_types = array(
        AFFCOUPS_VENDOR_POST_TYPE
    );

    if ( ! in_array( $post->post_type, $post_types ) ) {
        return;
    }
    ?>
    <script type='text/javascript'>
        (function($) {
            $( document ).ready( function() {
                if ( $("#titlewrap #title").length ) {

                    // "#affcoups-title-required-msj" is our custom
                    function affcoupsTitleRequiredMsj() {
                        if ( $( "#affcoups-title-required-msj" ).length )
                            return;

                        $( "#titlewrap" )
                            .append( '<p id="affcoups-title-required-msj">'+ affcoups_admin_post.title_is_required +'</p>' )
                            .css({
                                "color": "#dc3232"
                            })
                        ;
                    }

                    // Origin "#rwmb-validation-message" comes from metabox lib. But we add the same custom if it wasn't set yet
                    function affcoupsRequiredFieldsMsj() {
                        if ( $( "#rwmb-validation-message" ).length )
                            return;

                        $( "form#post" ).before( '<div id="rwmb-validation-message" class="notice notice-error is-dismissible"><p>'+ affcoups_admin_post.rwmb_validation_message +'</p></div>' );
                    }

                    $( 'body' )
                        // On post "Save/Update"
                        .on( 'click', '#post #publish', function(e) {

                            // If Vendor Description is empty
                            if ( $( "#affcoups_vendor_description" ).val().replace( / /g, '' ).length === 0 ) {

                                if ( 'publish' == $('#post #publish').attr('name') ) {
                                    $( "#affcoups_vendor_description" ).addClass('rwmb-error');
                                    $( "#affcoups_vendor_description" ).removeClass('valid');
                                }
                            }

                            // If Vendor Title is empty
                            if ( $( "#titlewrap #title" ).val().replace( / /g, '' ).length === 0 ) {
                                affcoupsTitleRequiredMsj();
                                $( "#titlewrap #title" ).addClass('affcoups-required-msj');
                                // Hide the spinner
                                $( '#major-publishing-actions .spinner' ).hide();
                                // The buttons get "disabled" added to them on submit. Remove that class.
                                $( '#major-publishing-actions' ).find( ':button, :submit, a.submitdelete, #post-preview' ).removeClass( 'disabled' );
                                // Focus on the title field.
                                $( "#title" ).focus();
                                return false;
                            }
                        })
                        // Vendor Title listener
                        .on( "input propertychange", "#titlewrap #title", function(e) {
                            if ( $(this).val() ) {
                                $(this).removeClass('affcoups-required-msj');
                                $( "#affcoups-title-required-msj" ).hide();
                            } else {
                                affcoupsTitleRequiredMsj();
                                $(this).addClass('affcoups-required-msj');
                                $( "#affcoups-title-required-msj" ).show();
                            }
                        })
                        // Vendor Description listener
                        .on( "input propertychange", "#affcoups_vendor_description", function(e) {
                            if ( $(this).val() ) {
                                if ( $(this).hasClass('rwmb-error') ) {
                                    $(this).removeClass('rwmb-error');
                                    $(this).addClass('valid');
                                }
                            } else {
                                if ( ! $(this).hasClass('rwmb-error') ) {
                                    $(this).removeClass('valid');
                                    $(this).addClass('rwmb-error');
                                }
                            }
                        })
                        // Both Vendor Title and Vendor Description listener
                        .on( "input propertychange", "#titlewrap #title, #affcoups_vendor_description", function(e) {
                            affcoupsRequiredFieldsMsj();
                            if ( $("#titlewrap #title").val() && $("#affcoups_vendor_description").val() ) {
                                $("#rwmb-validation-message").hide();
                            } else {
                                $("#rwmb-validation-message").show();
                            }
                        });
                }
            });
        }(jQuery));
    </script>
    <?php
}
add_action( 'edit_form_advanced', 'affcoups_admin_force_vendor_post_title_and_description' );

/**
 * Admin body classes
 *
 * @param $classes
 *
 * @return string
 */
function affcoups_admin_body_classes( $classes ) {

	if ( affcoups_is_plugin_admin_area() ) {
		$classes .= 'affcoups-admin';
	}

	return $classes;
}
add_filter( 'admin_body_class', 'affcoups_admin_body_classes' );


/**
 * Maybe show admin notices
 */
function affcoups_admin_notices() {

    if ( ! affcoups_is_plugin_admin_area() )
        return;

    $notices = array();

	// Actions
	$admin_notice = ( isset( $_GET['affcoups_admin_notice'] ) ) ? $_GET['affcoups_admin_notice'] : null;

	/*
	if ( $admin_notice === 'reset_success' ) {

		$notices[] = array(
			'type' => 'success',
			'dismiss' => true,
			'message' => __('Plugin settings has been successfully reset.', 'affiliate-coupons' )
		);
	}
	*/

	// Permanent notices
	/*
	$subscription_info_dismissed = get_transient( 'affcoups_notice_subscription_dismissed' );

	if ( '1' != $subscription_info_dismissed ) {

		$subscription_message = '<p>' . __('Join our newsletter and we let you know about new releases, as well as important updates and upcoming deals.', 'affiliate-coupons' ) . '</p>';

		$subscription_message .= '<p></p>';

		$notices[] = array(
			'type' => 'info',
			'dismiss' => true,
			'force' => false,
			'message' => $subscription_message
		);
	}
	*/

	// Debug
	/*
	$notices[] = array(
		'type' => 'warning',
		'dismiss' => false,
		'force' => false,
		'message' => __('Plugin settings has been successfully reset.', 'affiliate-coupons')
	);
	*/

    // affcoups_review_request_suppressed
    $is_review_suppressed = get_option( 'affcoups_review_request_suppressed' );

    if ( empty( $is_review_suppressed ) ) {

        $is_review_temporary_suppressed = get_transient( 'affcoups_review_request_suppressed' );

        if ( empty( $is_review_temporary_suppressed ) ) {

            $review_notice = sprintf(
                wp_kses( __( 'We hope you\'re enjoying <strong>Affiliate Coupons</strong>! Could you please do us a BIG favor and give it a 5-star rating on Wordpress to help us spread the word and boost our motivation?', 'affiliate-coupons' ), 'strong' )
                . '<br>
                <ul>
                    <li><a class="affcoups-notice-btn" data-action="affcoups_remove_review_request" href="%s" target="_blank" rel="nofollow" title="' .
                __(
                            'Sure, you deserved it', 'affiliate-coupons' ) . ' "style="font-weight:bold;">' . __( 'Sure, you deserved it', 'affiliate-coupons' ) . '</a></li>
                    <li><a class="affcoups-notice-btn" data-action="affcoups_remove_review_request" href="javascript:void(0);" title="' . __( 'I already did', 'affiliate-coupons' ) . '">' . __( 'I already did', 'affiliate-coupons' ) . '</a></li>
                    <li><a class="affcoups-notice-btn" data-action="affcoups_hide_review_request" href="javascript:void(0);" title="' .
                __( 'Maybe later', 'affiliate-coupons' ) . '">' . __( 'Maybe later', 'affiliate-coupons' ) . '</a></li>
                    <li><a class="affcoups-notice-btn" data-action="affcoups_remove_review_request" href="javascript:void(0);" title="' . __( 'I don\'t want to leave a review', 'affiliate-coupons' ) . '">' . __( 'I don\'t want to leave a review', 'affiliate-coupons' ) . '</a></li>
                </ul>',
                esc_url( 'https://wordpress.org/support/plugin/affiliate-coupons/reviews/?filter=5#new-post' )
            );

            $notices[] = array(
                'id' => 'review',
                'type' => 'info',
                'dismiss' => true,
                'message' => $review_notice
            );
        }
    }

    $notices = apply_filters( 'affcoups_admin_notices', $notices );

	// Output messages
	if ( sizeof( $notices ) > 0 ) {

        foreach ( $notices as $notice_id => $notice ) {

			if ( isset( $notice['force'] ) && false === $notice['force'] )
			    continue;

			$classes = 'affcoups-notice notice';

			if ( ! empty( $notice['type'] ) ) {
				$classes .= ' notice-' . $notice['type'];
			}

			if ( isset( $notice['dismiss'] ) && true === $notice['dismiss'] ) {
				$classes .= ' is-dismissible';
			}
			?>
            <div id="affcoups-notice-<?php echo esc_attr( ! empty( $notice['id'] ) ? $notice['id'] : $notice_id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
				<?php if ( strpos( $notice['message'], '<p>' ) === false ) { ?>
                    <p><?php echo /*esc_attr(*/ $notice['message'] /*)*/; ?></p>
				<?php } else { ?>
					<?php echo /*esc_attr(*/ $notice['message'] /*)*/; ?>
				<?php } ?>
            </div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'affcoups_admin_notices' );

/**
 * Ask for a plugin review in the WP Admin footer, if we're on our plugin area pages
 *
 * @param $text
 *
 * @return string
 */
function affcoups_admin_footer_text( $text ) {

	if ( affcoups_is_plugin_admin_area() ) {
		$text = sprintf( 'If you enjoy using <strong>Affiliate Coupons</strong>, please <a href="%s" target="_blank">leave us a ★★★★★ rating</a>. A <strong style="text-decoration: underline;">huge</strong> thank you in advance, this helps a lot!', 'https://wordpress.org/support/plugin/affiliate-coupons/reviews/?filter=5#new-post' );
	};

	return $text;
}
add_filter( 'admin_footer_text', 'affcoups_admin_footer_text' );

/**
 * Maybe output the tablenav note
 */
add_action( 'manage_posts_extra_tablenav', function( $which ) {

    if ( 'top' === $which && ( affcoups_is_plugin_admin_area_coupons() || affcoups_is_plugin_admin_area_vendors() ) )
        affcoups_the_pro_features_tablenav_note();

}, 99 );

/**
 * AJAX 'affcoups_remove_review_request', 'affcoups_hide_review_request'
 *
 * @return  void
 */
function affcoups_review_request_action() {

    if ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) {
        $redirect_to = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : admin_url();
        wp_safe_redirect( $redirect_to );
        exit;
    }

    if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'remove_review_request' )
      && ! wp_verify_nonce( $_POST['_wpnonce'], 'hide_review_request' )
    ){
        wp_send_json( array( 'error' => __( "You don't have permission to do that.", 'affiliate-coupons' ) ) );
        return;
    }

    if ( empty( $_POST['action'] ) ) {
        wp_send_json( array( 'error' => __( "You don't have permission to do that.", 'affiliate-coupons' ) ) );
        return;
    }

    $action = ( ! empty( $_POST['action'] ) ) ? _sanitize_text_fields( $_POST['action'], true ) : '';

    if ( empty( $action ) ) {
        wp_send_json( array( 'error' => __( "You don't have permission to do that.", 'affiliate-coupons' ) ) );
        return;
    }

    if ( 'affcoups_remove_review_request' === $action ) {

        update_option( 'affcoups_review_request_suppressed', 1 );

    } else if( 'affcoups_hide_review_request' === $action ) {

        set_transient( 'affcoups_review_request_suppressed', 1, MONTH_IN_SECONDS );
    }

    wp_send_json_success();
}
add_action( 'wp_ajax_affcoups_remove_review_request', 'affcoups_review_request_action' );
add_action( 'wp_ajax_affcoups_hide_review_request',   'affcoups_review_request_action' );