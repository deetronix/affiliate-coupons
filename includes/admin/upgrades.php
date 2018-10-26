<?php
/**
 * Plugin Upgrades
 *
 * @since       1.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handling plugin upgrades
 */
function affcoups_plugin_upgrades() {

    $version_installed = get_option( 'affcoups_version', '' );

    // Plugin already up2date
    if ( $version_installed === AFFCOUPS_VERSION )
        return;

    /*
     * Loop updates
     ---------------------------------------------------------- */

    // v2 (Removed MB plugin installation requirement)
    if ( empty ( $version_installed ) && is_plugin_active( 'meta-box/meta-box.php' ) )
        affcoups_plugin_upgrade_pre_v2();

    if ( ! empty( $version_installed ) ) {

        // Version X
        //if ( version_compare( $version_installed, '2.0.0', '<' ) )
           //function_to^_call();
    }
    /* ---------------------------------------------------------- */

    // Update installed version
    update_option( 'affcoups_version', AFFCOUPS_VERSION );
}
add_action( 'admin_init', 'affcoups_plugin_upgrades' );

/**
 * Pre 2.0: Removed meta box plugin installation requirement
 */
function affcoups_plugin_upgrade_pre_v2() {

    // Add admin notice
    add_action( 'admin_notices', function() {
        ?>
        <div class="notice-warning notice affcoups-notice is-dismissible">
            <p>
                <strong>Affiliate Coupons</strong><br />
                <?php printf( wp_kses( __( 'With the latest update we removed the "meta box" dependency again. This means, you can now <a href="%s">deactivate the meta box plugin</a>. Thanks!', 'affiliate-coupons' ), array(  'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'plugins.php' ) ) ); ?>
            </p>
        </div>
        <?php
    });
}