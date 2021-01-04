<?php
/**
 * Admin menu
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class Affcoups_Admin_Pages
 */
class Affcoups_Admin_Pages {

    /**
     * Affcoups_Admin_Pages constructor.
     */
	public function __construct() {

	    // Hooks
        add_action( 'in_admin_header', array( $this, 'render_header' ), 100 );
	}

    /**
     * Render page header
     */
    public function render_header() {

        global $title;

        if ( ! affcoups_is_plugin_admin_area() || affcoups_is_block_editor() )
            return;

        do_action( 'affcoups_admin_header_before' );

        require_once AFFCOUPS_PLUGIN_DIR . 'includes/admin/views/pages-header.php';

        do_action( 'affcoups_admin_header_after' );
    }

}

new Affcoups_Admin_Pages();