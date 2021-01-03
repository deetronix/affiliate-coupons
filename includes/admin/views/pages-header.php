<?php
/**
 * Admin Header View
 */

$title = ( isset( $title ) ) ? $title : '';
$is_pro = affcoups_is_pro_version();
?>
<div id="affcoups-admin-header">

    <div id="affcoups-admin-header-logo">
        <img src="<?php echo AFFCOUPS_PLUGIN_URL . 'assets/img/site-logo-reversed.png'; ?>" alt="AffCoups Logo" />
        <span><?php echo $title; ?></span>
    </div>

    <div id="affcoups-admin-header-links">

        <a
            href="<?php echo ( $is_pro ) ? 'https://affcoups.com/account/' : 'https://affcoups.com/features/'; ?>"
            target="_blank"
        ><i class='dashicons dashicons-text-page'></i><?php echo ( $is_pro ) ? __( 'Your AffCoups Account', 'affiliate-coupons' ) : __( 'Upgrade to the Pro Version', 'affiliate-coupons' ); ?></a>

        <a href="https://affcoups.com/docs/" target="_blank"><i class='dashicons dashicons-text-page'></i><?php _e( 'Documentation', 'affiliate-coupons' ); ?></a>
    </div>

</div>