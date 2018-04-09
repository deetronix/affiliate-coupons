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
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Affcoups_Settings' ) ) {

    class Affcoups_Settings {
        public $options;

        public function __construct() {
            // Options
            $this->options = affcoups_get_options();

            add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );
            add_action( 'admin_init', array( &$this, 'init_settings' ) );
        }

        function add_admin_menu() {
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

        function init_settings() {
            register_setting(
                'affcoups_settings',
                'affcoups_settings',
                array( &$this, 'validate_input_callback' )
            );

            /*
             * Section: Quickstart
             */
            add_settings_section(
                'affcoups_settings_section_quickstart',
                __('Quickstart Guide', 'affiliate-coupons'),
                array( &$this, 'section_quickstart_render' ),
                'affcoups_settings'
            );

            /*
             * Section: General
             */
            add_settings_section(
                'affcoups_settings_section_general',
                __('General', 'affiliate-coupons'),
                false,
                'affcoups_settings'
            );

            add_settings_field(
                'affcoups_settings_coupon_expiration',
                __('Expiration', 'affiliate-coupons'),
                array(&$this, 'coupon_expiration_render'),
                'affcoups_settings',
                'affcoups_settings_section_general',
                array('label_for' => 'affcoups_hide_expired_coupons')
            );

            add_settings_field(
                'affcoups_settings_order',
                __('Sorting', 'affiliate-coupons'),
                array(&$this, 'order_render'),
                'affcoups_settings',
                'affcoups_settings_section_general',
                array('label_for' => 'affcoups_order')
            );

            /*
             * Section: Output
             */
            add_settings_section(
                'affcoups_settings_section_output',
                __('Output', 'affiliate-coupons'),
                false,
                'affcoups_settings'
            );

            add_settings_field(
                'affcoups_settings_templates',
                __('Templates', 'affiliate-coupons'),
                array(&$this, 'templates_render'),
                'affcoups_settings',
                'affcoups_settings_section_output',
                array('label_for' => 'affcoups_template')
            );

            add_settings_field(
                'affcoups_settings_contents',
                __('Contents', 'affiliate-coupons'),
                array(&$this, 'contents_render'),
                'affcoups_settings',
                'affcoups_settings_section_output',
                false
            );

            add_settings_field(
                'affcoups_settings_discount',
                __('Discount', 'affiliate-coupons'),
                array(&$this, 'discount_render'),
                'affcoups_settings',
                'affcoups_settings_section_output',
                false
            );

            add_settings_field(
                'affcoups_settings_button',
                __('Button', 'affiliate-coupons'),
                array(&$this, 'button_render'),
                'affcoups_settings',
                'affcoups_settings_section_output',
                array('label_for' => 'affcoups_button_text')
            );

            add_settings_field(
                'affcoups_settings_custom_css',
                __('Custom CSS', 'affiliate-coupons'),
                array(&$this, 'custom_css_render'),
                'affcoups_settings',
                'affcoups_settings_section_output',
                array('label_for' => 'affcoups_custom_css')
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
                <h3 class='hndle'><?php esc_html_e('Quickstart Guide', 'affiliate-coupons'); ?></h3>
                <div class="inside">
                    <p>
                        <strong><?php esc_html_e( 'First Steps', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <ol>
                        <li><?php esc_html_e( 'Create vendors', 'affiliate-coupons' ); ?></li>
                        <li><?php esc_html_e( 'Create coupons', 'affiliate-coupons' ); ?></li>
                        <li><?php esc_html_e( 'Link coupons to vendors', 'affiliate-coupons' ); ?></li>
                        <li><?php esc_html_e( 'Assign categories and/or types to coupons if needed', 'affiliate-coupons' ); ?></li>
                        <li><?php esc_html_e( 'Display coupons inside your posts/pages by using shortcodes', 'affiliate-coupons' ); ?></li>
                    </ol>

                    <p>
                        <strong><?php esc_html_e( 'Show all coupons', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <p>
                        <code>[affcoups]</code>
                    </p>

                    <p>
                        <strong><?php esc_html_e( 'Show single coupons', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <p>
                        <code>[affcoups id="123"]</code> <?php esc_html_e( 'or', 'affiliate-coupons' ); ?> <code>[affcoups id="123,456,789"]</code>
                    </p>

                    <p>
                        <strong><?php esc_html_e( 'Filter coupons', 'affiliate-coupons' ); ?></strong><br />
                        <?php esc_html_e( 'By passing the id or slug (only if specified) you can filter the results individually.', 'affiliate-coupons' ); ?>
                    </p>
                    <ul>
                        <li>
                            <?php esc_html_e( 'Filter by vendor:', 'affiliate-coupons' ); ?>
                            <code>[affcoups vendor="123"]</code>
                        </li>
                        <li>
                            <?php esc_html_e( 'Filter by category:', 'affiliate-coupons' ); ?>
                            <code>[affcoups category="123"]</code> <?php esc_html_e( 'or', 'affiliate-coupons' ); ?> <code>[affcoups category="group-xyz"]</code>
                        </li>
                        <li>
                            <?php esc_html_e( 'Filter by type:', 'affiliate-coupons' ); ?>
                            <code>[affcoups type="123"]</code> <?php esc_html_e( 'or', 'affiliate-coupons' ); ?> <code>[affcoups type="type-xyz"]</code>
                        </li>
                    </ul>
                    <p>
                        <strong><?php esc_html_e( 'Show/hide expired coupons', 'affiliate-coupons' ); ?></strong><br />
                        <?php esc_html_e( 'Contrary to the settings below you can show/hide expired for each shortcode individually.', 'affiliate-coupons' ); ?>
                    </p>
                    <p>
                        <code>[affcoups hideesc_html_expired="true"]</code> <?php esc_html_e( 'vs.', 'affiliate-coupons' ); ?> <code>[affcoups hide_expired="false"]</code>
                    </p>

                    <p>
                        <small><?php esc_html_e( 'All filter options above can be combined inside the same shortcode.', 'affiliate-coupons' ); ?></small>
                    </p>

                    <p>
                        <strong><?php esc_html_e( 'Sorting coupons', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <ul>
                        <li>
                            <?php esc_html_e( 'Order:', 'affiliate-coupons' ); ?>
                            <code>[affcoups order="asc"]</code> (asc, desc)
                        </li>
                        <li>
                            <?php esc_html_e( 'Order by:', 'affiliate-coupons' ); ?>
                            <code>[affcoups orderby="title"]</code> (name, date, random, title, description, discount, valid_from, valid_to)
                        </li>
                    </ul>
                    </p>

                    <p>
                        <strong><?php esc_html_e( 'Templates', 'affiliate-coupons' ); ?></strong><br />
                        <?php esc_html_e( 'You can easily select a template on a shortcode basis as follows:', 'affiliate-coupons' ); ?>
                    </p>
                    <p>
                        <code>[affcoups template="standard"]</code>
                    </p>
                    <p>
                        <?php esc_html_e( 'The following templates are available right now:', 'affiliate-coupons' ); ?> <code>standard</code>, <code>grid</code>, <code>list</code> & <code>widget</code>
                    </p>
                    <p>
                        <?php esc_html_e( 'In order to display multiple coupons side by side, make use of the grid functionality:', 'affiliate-coupons' ); ?>
                    </p>
                    <p>
                        <code>[affcoups grid="2"]</code>, <code>[affcoups grid="3"]</code> etc.
                    </p>
                    <p>
                        <?php esc_html_e( 'When passing the grid size parameter, the plugin will automatically choose the grid template.', 'affiliate-coupons' ); ?>
                    </p>

                    <?php do_action( 'affcoups_settings_quickstart_render' ); ?>
                </div>
            </div>

            <?php
        }

        function coupon_expiration_render() {

            $hide_expired_coupons = ( isset ( $this->options['hide_expired_coupons'] ) && $this->options['hide_expired_coupons'] == '1' ) ? 1 : 0;
            ?>

            <input type="checkbox" id="affcoups_hide_expired_coupons" name="affcoups_settings[hide_expired_coupons]" value="1" <?php echo( $hide_expired_coupons == 1 ? 'checked' : '' ); ?> />
            <label for="affcoups_hide_expired_coupons"><?php esc_html_e('Hide coupons after they expired', 'affiliate-coupons'); ?></label>
            <?php
        }

        function order_render() {

            $order_options = array(
                'asc' => __( 'Ascending ', 'affiliate-coupons' ),
                'desc' => __('Descending', 'affiliate-coupons')
            );

            $order = ( isset ( $this->options['order'] ) ) ? $this->options['order'] : 'desc';

            $orderby_options = array(
                'name' => __('Name (Post)', 'affiliate-coupons' ),
                'date' => __('Date published (Post)', 'affiliate-coupons'),
                'random' => __('Random', 'affiliate-coupons'),
                'title' => __('Title (Coupon)', 'affiliate-coupons'),
                'description' => __('Description (Coupon)', 'affiliate-coupons'),
                'discount' => __('Discount (Coupon)', 'affiliate-coupons'),
                'valid_from' => __('Valid from date (Coupon)', 'affiliate-coupons'),
                'valid_to' => __('Valid to date (Coupon)', 'affiliate-coupons')
            );

            $orderby = ( isset ( $this->options['orderby'] ) ) ? $this->options['orderby'] : 'date';

            ?>
            <h4><?php esc_html_e('Order', 'affiliate-coupons' ); ?></h4>
            <p>
                <select id="affcoups_order" name="affcoups_settings[order]">
                    <?php foreach ( $order_options as $key => $label ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $order, $key ); ?>><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </p>

            <h4><?php esc_html_e('Order by', 'affiliate-coupons' ); ?></h4>
            <p>
                <select id="affcoups_orderby" name="affcoups_settings[orderby]">
                    <?php foreach ( $orderby_options as $key => $label ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $orderby, $key ); ?>><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </p>

            <?php
        }

        function section_two_render() {

            return;
            ?>

            <p>Section two description...</p>

            <?php
        }

        function templates_render() {

            $template_options = array(
                'standard' => __( 'Standard', 'affiliate-coupons' ),
                'grid' => __('Grid', 'affiliate-coupons')
            );

            $template = ( isset ( $this->options['template'] ) ) ? $this->options['template'] : 'grid';

            $grid_size = ( ! empty( $this->options['grid_size'] ) && is_numeric( $this->options['grid_size'] ) ) ? intval( $this->options['grid_size'] ) : 3;

            ?>
            <h4><?php esc_html_e('Template', 'affiliate-coupons' ); ?></h4>
            <p>
                <select id="affcoups_template" name="affcoups_settings[template]">
                    <?php foreach ( $template_options as $key => $label ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $template, $key ); ?>><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </p>

            <h4><?php esc_html_e('Grid size', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="number" name="affcoups_settings[grid_size]" id="affcoups_grid_size" value="<?php echo esc_attr( trim( $grid_size ) ); ?>" />
            </p>
            <?php
        }

        function contents_render() {

            $excerpt_length = ( ! empty( $this->options['excerpt_length'] ) && is_numeric( $this->options['excerpt_length'] ) ) ? intval( $this->options['excerpt_length'] ) : 90;

            ?>
            <h4><?php esc_html_e('Excerpt Length', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="number" name="affcoups_settings[excerpt_length]" id="affcoups_excerpt_length" value="<?php echo esc_attr( trim( $excerpt_length ) ); ?>" />
            </p>
            <p class="desc">
                <?php esc_html_e('Some templates are displaying an excerpt instead of the whole coupon description.', 'affiliate-coupons' ); ?>
            </p>
            <?php
        }

        function discount_render() {

            $discount_bg_color = ( isset ( $this->options['discount_bg_color'] ) ) ? $this->options['discount_bg_color'] : '';
            $discount_color = ( isset ( $this->options['discount_color'] ) ) ? $this->options['discount_color'] : '';

            ?>
            <h4><?php esc_html_e('Background Color', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="text" class="affcoups-input-colorpicker" name="affcoups_settings[discount_bg_color]" value="<?php echo $discount_bg_color; ?>" />
            </p>
            <h4><?php esc_html_e('Text Color', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="text" class="affcoups-input-colorpicker" name="affcoups_settings[discount_color]" value="<?php echo $discount_color; ?>" />
            </p>
            <?php $this->the_color_picker_note(); ?>
            <?php
        }

        function button_render() {

            $button_text = ( ! empty( $this->options['button_text'] ) ) ? esc_attr( trim( $this->options['button_text'] ) ) : __( 'Go to the deal', 'affiliate-coupons' );

            $button_icon_options = array(
                '' => __( 'None', 'affiliate-coupons' ),
                'hand-right' => __('Hand right', 'affiliate-coupons'),
                'gavel' => __('Gavel', 'affiliate-coupons'),
                'cart' => __('Shopping cart', 'affiliate-coupons')
            );

            $button_icon = ( isset ( $this->options['button_icon'] ) ) ? $this->options['button_icon'] : '';
            $button_bg_color = ( isset ( $this->options['button_bg_color'] ) ) ? $this->options['button_bg_color'] : '';
            $button_color = ( isset ( $this->options['button_color'] ) ) ? $this->options['button_color'] : '';
            ?>
            <h4><?php esc_html_e('Text', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="text" name="affcoups_settings[button_text]" id="affcoups_button_text" value="<?php echo esc_attr( trim( $button_text ) ); ?>" />
            </p>

            <h4><?php esc_html_e('Icon', 'affiliate-coupons' ); ?></h4>
            <p>
                <select id="affcoups_button_icon" name="affcoups_settings[button_icon]">
                    <?php foreach ( $button_icon_options as $key => $label ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $button_icon, $key ); ?>><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </p>

            <h4><?php esc_html_e('Background Color', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="text" class="affcoups-input-colorpicker" name="affcoups_settings[button_bg_color]" value="<?php echo $button_bg_color; ?>" />
            </p>
            <h4><?php esc_html_e('Text Color', 'affiliate-coupons' ); ?></h4>
            <p>
                <input type="text" class="affcoups-input-colorpicker" name="affcoups_settings[button_color]" value="<?php echo $button_color; ?>" />
            </p>
            <?php $this->the_color_picker_note(); ?>
            <?php
        }

        function custom_css_render() {

            $custom_css_activated = ( isset ( $this->options['custom_css_activated'] ) && $this->options['custom_css_activated'] == '1' ) ? 1 : 0;
            $custom_css = ( !empty ( $this->options['custom_css'] ) ) ? $this->options['custom_css'] : '';
            ?>

            <p>
                <input type="checkbox" id="affcoups_custom_css_activated" name="affcoups_settings[custom_css_activated]" value="1" <?php echo( $custom_css_activated == 1 ? 'checked' : '' ); ?>>
                <label for="affcoups_custom_css_activated"><?php esc_html_e('Output custom CSS styles', 'affiliate-coupons'); ?></label>
            </p>
            <br />
            <textarea id="affcoups_custom_css" name="affcoups_settings[custom_css]" rows="10" cols="80" style="width: 100%;"><?php echo stripslashes( $custom_css ); ?></textarea>
            <p>
                <small><?php esc_html_e("Please don't use the <code>style</code> tag. Simply paste you CSS classes/definitions e.g. <code>.affcoups .affcoups-coupon { background-color: #333; }</code>", 'affiliate-coupons' ) ?></small>
            </p>

            <?php
        }

        function the_color_picker_note() {
            ?>
            <p class="desc">
                <?php esc_html_e('In case you want to change the colors, you must pick a new color for all fields above.', 'affiliate-coupons' ); ?>
            </p>
            <?php
        }

        function options_page() {
            ?>

            <div class="affcoups affcoups-settings">
                <div class="wrap">
                    <h2 class="affcoups-settings-headline"><?php esc_html_e('Affiliate Coupons', 'affiliate-coupons'); ?></h2>

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
                                    <!-- Resources & Support -->
                                    <div class="postbox">
                                        <h3><span>Resources &amp; Support</span></h3>
                                        <div class="inside">
                                            <p><?php esc_html_e('Here you can find a brief overview of the most important resources in order use our plugin.', 'affiliate-coupons' ); ?></p>
                                            <ul>
                                                <li><a href="<?php echo affcoups_get_website_url(); ?>" target="_blank">Website</a></li>
                                                <li><a href="<?php echo affcoups_get_website_url( 'support' ); ?>" target="_blank">Support</a></li>
                                                <li><a href="https://wordpress.org/plugins/affiliate-coupons/#developers" target="_blank">Changelog</a></li>
                                                <li><a href="https://twitter.com/affcoups" target="_blank">Follow us on Twitter</a></li>
                                            </ul>
                                            <p>Created & Maintained by <a href="https://twitter.com/flowdee">flowdee</a></p>
                                        </div>
                                    </div>

                                    <!-- Newsletter -->
                                    <?php
                                    global $current_user;

                                    $user_email = ( isset( $current_user->user_email ) ) ? $current_user->user_email : '';
                                    $form_group_name = apply_filters( 'affcoups_sidebar_subscribe_form_group_name', 'group[12785][2]' );
                                    ?>
                                    <div class="postbox">
                                        <h3><span><?php esc_html_e('Latest News & Updates', 'affiliate-coupons' ); ?></span></h3>
                                        <div class="inside">
                                            <p><?php esc_html_e('Join our newsletter and we let you know about new releases, as well as important updates and upcoming deals.', 'affiliate-coupons' ); ?></p>
                                            <!-- Begin MailChimp Signup Form -->
                                            <div id="mc_embed_signup">
                                                <form action="https://flowdee.us10.list-manage.com/subscribe/post?u=cc9fc194eb9ba7a4d8616c2cb&amp;id=a4798350bf" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                                    <div id="mc_embed_signup_scroll">

                                                        <div class="mc-field-group">
                                                            <label for="mce-EMAIL"><?php esc_html_e('Email Address', 'affiliate-coupons' ); ?></label>
                                                            <input type="email" value="<?php echo $user_email; ?>" name="EMAIL" class="required email" id="mce-EMAIL">
                                                        </div>
                                                        <div id="mce-responses" class="clear">
                                                            <div class="response" id="mce-error-response" style="display:none"></div>
                                                            <div class="response" id="mce-success-response" style="display:none"></div>
                                                        </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                                        <div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_cc9fc194eb9ba7a4d8616c2cb_a4798350bf" tabindex="-1" value=""></div>
                                                        <input type="checkbox" id="group_cr" name="<?php echo $form_group_name; ?>" value="1" checked="checked" style="display:none">
                                                        <div class="clear">
                                                            <p>
                                                                <input type="submit" value="<?php esc_html_e('Subscribe', 'affiliate-coupons' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
                                                            </p>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <!--End mc_embed_signup-->
                                        </div>
                                    </div>
                                </div>
                                <!-- /.meta-box-sortables -->
                            </div>
                            <!-- /.postbox-container -->
                        </div>
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