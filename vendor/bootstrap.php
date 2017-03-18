<?php
/**
 * Bootstrap
 *
 * @package     AffiliateCoupons\Vendor
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
    require AFFCOUPS_DIR . 'vendor/meta-box/meta-box.php';
}
