<?php
/**
 * Admin body classes
 *
 * @param $classes
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

    $notices = apply_filters( 'affcoups_admin_notices', $notices );

    $is_plugin_area = affcoups_is_plugin_admin_area();

    // Output messages
    if ( sizeof( $notices ) > 0 ) {
        foreach ( $notices as $notice_id => $notice ) {

            // Maybe showing the notice on AAWP related admin pages only
            if ( isset( $notice['force'] ) && false === $notice['force'] && ! $is_plugin_area )
                continue;

            $classes = 'affcoups-notice notice';

            if ( ! empty( $notice['type'] ) )
                $classes .= ' notice-' . $notice['type'];

            if ( isset( $notice['dismiss'] ) && true === $notice['dismiss'] )
                $classes .= ' is-dismissible';

            ?>
            <div id="affcoups-notice-<?php echo ( ! empty( $notice['id'] ) ) ? $notice['id'] : $notice_id; ?>" class="<?php echo $classes; ?>">
                <?php if ( strpos( $notice['message'], '<p>') === false ) { ?>
                    <p><?php echo $notice['message']; ?></p>
                <?php } else { ?>
                    <?php echo $notice['message']; ?>
                <?php } ?>
            </div>
            <?php
        }
    }
}

add_action( 'admin_notices', 'affcoups_admin_notices' );