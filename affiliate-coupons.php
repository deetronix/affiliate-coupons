<?php
/**
 * Plugin Name:     Affiliate Coupons
 * Plugin URI:      https://wordpress.org/plugins/affiliate-coupons/
 * Description:     Promote coupons and deals of products and earn money with affiliate referrals.
 * Version:         1.0.1
 * Author:          flowdee
 * Author URI:      https://flowdee.de
 * Text Domain:     affiliate-coupons
 *
 * @package         AffiliateCoupons
 * @author          flowdee
 * @copyright       Copyright (c) flowdee
 *
 * Copyright (c) 2016 - flowdee ( https://twitter.com/flowdee )
 */

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Affcoups_Plugin' ) ) {

    /**
     * Main Affiliate_Coupons class
     *
     * @since       1.0.0
     */
    class Affcoups_Plugin {

        /**
         * @var         Affcoups_Plugin $instance The one true Affcoups_Plugin
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true Affcoups_Plugin
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new Affcoups_Plugin();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {

            // Plugin name
            define( 'AFFILIATE_COUPONS_NAME', 'Affiliate Coupons' );

            // Plugin version
            define( 'AFFILIATE_COUPONS_VER', '1.0.1' );

            // Plugin path
            define( 'AFFILIATE_COUPONS_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'AFFILIATE_COUPONS_URL', plugin_dir_url( __FILE__ ) );

            // Plugin prefix
            define( 'AFFILIATE_COUPONS_PREFIX', 'affcoups_' );
        }
        
        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {

            // Basic
            require_once AFFILIATE_COUPONS_DIR . 'includes/helper.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/scripts.php';

            // Dependencies
            require_once AFFILIATE_COUPONS_DIR . 'includes/libs.php';

            // Admin only
            if ( is_admin() ) {
                require_once AFFILIATE_COUPONS_DIR . 'includes/admin/plugins.php';
                require_once AFFILIATE_COUPONS_DIR . 'includes/admin/class.settings.php';
            }

            // Coupons
            require_once AFFILIATE_COUPONS_DIR . 'includes/coupons/post-type.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/coupons/type-taxonomy.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/coupons/category-taxonomy.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/coupons/manage-coupons.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/coupons/metaboxes.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/coupon-functions.php';

            // Vendors
            require_once AFFILIATE_COUPONS_DIR . 'includes/vendors/post-type.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/vendors/manage-vendors.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/vendors/metaboxes.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/vendor-functions.php';

            // Anything else
            require_once AFFILIATE_COUPONS_DIR . 'includes/hooks.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/functions.php';
            require_once AFFILIATE_COUPONS_DIR . 'includes/shortcodes.php';
        }

        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = AFFILIATE_COUPONS_DIR . '/languages/';
            $lang_dir = apply_filters( 'affiliate_coupons_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'affiliate-coupons' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'affiliate-coupons', $locale );

            // Setup paths to current locale file
            $mofile_local   = $lang_dir . $mofile;
            $mofile_global  = WP_LANG_DIR . '/affiliate-coupons/' . $mofile;

            if( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/affiliate-coupons/ folder
                load_textdomain( 'affiliate-coupons', $mofile_global );
            } elseif( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/affiliate-coupons/languages/ folder
                load_textdomain( 'affiliate-coupons', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'affiliate-coupons', false, $lang_dir );
            }
        }
    }
} // End if class_exists check

/**
 * The main function responsible for returning the one true Affcoups_Plugin
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \Affcoups_Plugin The one true Affcoups_Plugin
 *
 */
function affcoups_load() {
    return Affcoups_Plugin::instance();
}
add_action( 'plugins_loaded', 'affcoups_load' );

/**
 * The activation hook
 */
function affcoups_activation() {
    // Create your tables here
}
register_activation_hook( __FILE__, 'affcoups_activation' );

/**
 * The deactivation hook
 */
function affcoups_deactivation() {
    // Cleanup your tables, transients etc. here
}
register_deactivation_hook(__FILE__, 'affcoups_deactivation');