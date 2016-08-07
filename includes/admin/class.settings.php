<?php
/**
 * Settings
 *
 * Source: https://codex.wordpress.org/Settings_API
 *
 * @package     AffiliateCoupons\Settings
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;


if ( ! class_exists('Affcoups_Settings') ) {

    class Affcoups_Settings
    {
        public $options;

        public function __construct()
        {
            // Options
            $this->options = affcoups_get_options();

            // Initialize
            add_action('admin_menu', array( &$this, 'add_admin_menu') );
            add_action('admin_init', array( &$this, 'init_settings') );
        }

        function add_admin_menu()
        {
            /*
             * Source: https://codex.wordpress.org/Function_Reference/add_options_page
             */
            add_submenu_page(
                'edit.php?post_type=affcoups_coupon',
                __( 'Affiliate Coupons - Settings', 'affiliate-coupons' ), // Page title
                __( 'Settings', 'affiliate-coupons' ), // Menu title
                'manage_options', // Capabilities
                'affcoups_settings', // Menu slug
                array( &$this, 'options_page' ) // Callback
            );

        }

        function init_settings()
        {
            register_setting(
                'affcoups_settings',
                'affcoups_settings',
                array( &$this, 'validate_input_callback' )
            );

            // SECTION: Quickstart
            add_settings_section(
                'affcoups_settings_section_quickstart',
                __('Quickstart Guide', 'affiliate-coupons'),
                array( &$this, 'section_quickstart_render' ),
                'affcoups_settings'
            );

            /*
            // SECTION ONE
            add_settings_section(
                'affcoups_settings_section_general',
                __('General', 'affiliate-coupons'),
               false,
                'affcoups_settings'
            );

            add_settings_field(
                'affcoups_settings_text_field_01',
                __('Text Field', 'affiliate-coupons'),
                array(&$this, 'text_field_01_render'),
                'affcoups_settings',
                'affcoups_settings_section_general',
                array('label_for' => 'affcoups_settings_text_field_01')
            );

            add_settings_field(
                'affcoups_settings_select_field_01',
                __('Select Field', 'affiliate-coupons'),
                array(&$this, 'select_field_01_render'),
                'affcoups_settings',
                'affcoups_settings_section_general',
                array('label_for' => 'affcoups_settings_select_field_01')
            );

            add_settings_field(
                'affcoups_settings_checkbox_field_01',
                __('Checkbox Field', 'affiliate-coupons'),
                array(&$this, 'checkbox_field_01_render'),
                'affcoups_settings',
                'affcoups_settings_section_general',
                array('label_for' => 'affcoups_settings_checkbox_field_01')
            );
            */

            // SECTION TWO
            add_settings_section(
                'affcoups_settings_section_coupons',
                __('Coupons', 'affiliate-coupons'),
                array( &$this, 'section_two_render' ), // Optional you can output a description for each section
                'affcoups_settings'
            );

            add_settings_field(
                'affcoups_settings_coupon_lifetime',
                __('Expiration', 'affiliate-coupons'),
                array(&$this, 'coupon_lifetime_render'),
                'affcoups_settings',
                'affcoups_settings_section_coupons'
            );

        }

        function validate_input_callback( $input ) {

            /*
             * Here you can validate (and manipulate) the user input before saving to the database
             */

            return $input;
        }

        function section_quickstart_render() {
            ?>

            <div class="postbox">
                <h3 class='hndle'><?php _e('Quickstart Guide', 'affiliate-coupons'); ?></h3>
                <div class="inside">
                    <p>
                        <strong><?php _e( 'First Steps', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <ol>
                        <li><?php _e( 'Create vendors', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Create coupons', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Link coupons to vendors', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Assign categories and/or types to coupons if needed', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Display coupons inside your posts/pages by using shortcodes', 'affiliate-coupons' ); ?></li>
                    </ol>

                    <p>
                        <strong><?php _e( 'Displaying all coupons', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <p>
                        <code>[affcoups_coupons]</code>
                    </p>

                    <p>
                        <strong><?php _e( 'Filtering coupons by category and/or type', 'affiliate-coupons' ); ?></strong><br />
                        <?php _e( 'By passing the category/type id or slug you can filter the results individually.', 'affiliate-coupons' ); ?>
                    </p>
                    <p>
                        <code>[affcoups_coupons category="12" type="8"]</code> <?php _e( 'or', 'affiliate-coupons' ); ?> <code>[affcoups_coupons category="group-xyz" type="8"]</code> <?php _e( 'etc.', 'affiliate-coupons' ); ?>
                    </p>

                    <p>
                        <strong><?php _e( 'Show/hide expired coupons', 'affiliate-coupons' ); ?></strong><br />
                        <?php _e( 'Contrary to the settings below you can show/hide expired for each shortcode individually.', 'affiliate-coupons' ); ?>
                    </p>
                    <p>
                        <code>[affcoups_coupons hide_expired="true"]</code> <?php _e( 'vs.', 'affiliate-coupons' ); ?> <code>[affcoups_coupons hide_expired="false"]</code>
                    </p>

                    <?php do_action( 'affcoups_settings_quickstart_render' ); ?>
                </div>
            </div>

            <?php
        }

        function section_two_render() {

            return;
            ?>

            <p>Section two description...</p>

            <?php
        }

        function coupon_lifetime_render() {

            $hide_expired_coupons = ( isset ( $this->options['hide_expired_coupons'] ) && $this->options['hide_expired_coupons'] == '1' ) ? 1 : 0;
            ?>

            <input type="checkbox" id="affcoups_settings_hide_expired_coupons" name="affcoups_settings[hide_expired_coupons]" value="1" <?php echo($hide_expired_coupons == 1 ? 'checked' : ''); ?> />
            <label for="affcoups_settings_hide_expired_coupons"><?php _e('Hide coupons after they expired', 'affiliate-coupons'); ?></label>
            <?php
        }



        // TODO: Dummies


        function text_field_01_render() {

            $text = ( ! empty($this->options['text_01'] ) ) ? esc_attr( trim($this->options['text_01'] ) ) : ''

            ?>
            <input type="text" name="affcoups_settings[text_01]" id="affcoups_settings_text_field_01" value="<?php echo esc_attr( trim( $text ) ); ?>" />
            <?php
        }

        function select_field_01_render() {

            $select_options = array(
                '0' => __('Please select...', 'affiliate-coupons'),
                '1' => __('Option One', 'affiliate-coupons'),
                '2' => __('Option Two', 'affiliate-coupons'),
                '3' => __('Option Three', 'affiliate-coupons')
            );

            $selected = ( isset ( $this->options['select_01'] ) ) ? $this->options['select_01'] : '0';

            ?>
            <select id="affcoups_settings_select_field_01" name="affcoups_settings[select_01]">
                <?php foreach ( $select_options as $key => $label ) { ?>
                    <option value="<?php echo $key; ?>" <?php selected( $selected, $key ); ?>><?php echo $label; ?></option>
                <?php } ?>
            </select>
            <?php
        }

        function checkbox_field_01_render() {

            $checked = ( isset ( $this->options['checkbox_01'] ) && $this->options['checkbox_01'] == '1' ) ? 1 : 0;
            ?>

                <input type="checkbox" id="affcoups_settings_checkbox_field_01" name="affcoups_settings[checkbox_01]" value="1" <?php echo($checked == 1 ? 'checked' : ''); ?> />
                <label for="affcoups_settings_checkbox_field_01"><?php _e('Activate in order to do some cool stuff.', 'affiliate-coupons'); ?></label>
            <?php
        }

        function text_field_02_render() {

            $text = ( ! empty($this->options['text_02'] ) ) ? esc_attr( trim($this->options['text_02'] ) ) : ''

            ?>
            <input type="text" name="affcoups_settings[text_02]" id="affcoups_settings_text_field_02" value="<?php echo esc_attr( trim( $text ) ); ?>" />
            <?php
        }

        function options_page() {
            ?>

            <div class="wrap">
                <?php screen_icon(); ?>
                <h2><?php _e('Affiliate Coupons', 'affiliate-coupons'); ?></h2>

                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        <div id="post-body-content">
                            <div class="meta-box-sortables ui-sortable">
                                <form action="options.php" method="post">
                                    <?php
                                    settings_fields('affcoups_settings');
                                    affcoups_do_settings_sections('affcoups_settings');
                                    ?>

                                    <p><?php submit_button('Save Changes', 'button-primary', 'submit', false); ?></p>
                                </form>
                            </div>

                        </div>
                        <!-- /#post-body-content -->
                        <div id="postbox-container-1" class="postbox-container">
                            <div class="meta-box-sortables">
                                <?php
                                /*
                                 * require_once WP_UDEMY_DIR . 'includes/libs/flowdee_infobox.php';
                                $flowdee_infobox = new Flowdee_Infobox();
                                $flowdee_infobox->set_plugin_slug('udemy');
                                $flowdee_infobox->display();
                                */
                                ?>
                            </div>
                            <!-- /.meta-box-sortables -->
                        </div>
                        <!-- /.postbox-container -->
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

new Affcoups_Settings();

/*
 * Custom settings section output
 *
 * Replacing: do_settings_sections('affcoups_settings');
 */
function affcoups_do_settings_sections( $page ) {

    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections[$page]))
        return;

    foreach ((array)$wp_settings_sections[$page] as $section) {

        $title = '';

        if ($section['title'])
            $title = "<h3 class='hndle'>{$section['title']}</h3>\n";

        if ($section['callback'])
            call_user_func($section['callback'], $section);

        if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]))
            continue;

        echo '<div class="postbox">';
        echo $title;
        echo '<div class="inside">';
        echo '<table class="form-table">';
        do_settings_fields($page, $section['id']);
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }
}