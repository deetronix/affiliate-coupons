<?php
/**
 * Libs
 *
 * @package     AffiliateCoupons\Libs
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Meta Box
 */
if ( ! class_exists( 'RW_Meta_Box' ) ) {
    require AFFILIATE_COUPONS_DIR . '/includes/libs/meta-box/meta-box.php';
}
