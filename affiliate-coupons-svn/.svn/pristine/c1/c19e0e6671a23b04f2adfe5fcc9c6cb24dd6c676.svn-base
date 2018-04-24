<?php
/**
 * Widget: Single Coupon
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Affcoups_Single_Widget' ) ) {

    /**
     * Adds UFWP_Courses widget.
     */
    class Affcoups_Single_Widget extends WP_Widget {

        protected static $did_script = false;

        /**
         * Register widget with WordPress.
         */
        function __construct() {
            parent::__construct(
                'affcoups_single_widget', // Base ID
                'Affiliate Coupons - ' . __( 'Single Coupon', 'affiliate-coupons' ), // Name
                array( 'description' => __( 'Displaying courses by their ids.', 'affiliate-coupons' ), ) // Args
            );
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {

            echo $args['before_widget'];

            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }

            if ( ! empty ( $instance['id'] ) ) {

                // IDs
                $shortcode_atts = array(
                    'id' => $instance['id'],
                );

                // Template
                $shortcode_atts['template'] = 'standard'; //$instance['template']; // TODO: Replace when separate widget template(s) were added

                // Execute Shortcode
                affcoups_widget_do_shortcode( $shortcode_atts );

            } else {
                _e( 'Please select a coupon.', 'affiliate-coupons' );
            }

            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {

            $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
            $id = ! empty( $instance['id'] ) ? $instance['id'] : '';
            $template = ! empty( $instance['template'] ) ? $instance['template'] : 'widget';

            ?>
            <!-- Title -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( esc_attr( 'Title:' ), 'affiliate-coupons' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>

            <!-- Coupon -->
            <?php
            $coupons = affcoups_get_coupon_options();
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php _e( 'Coupon:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>">
                    <?php foreach ( $coupons as $key => $label ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $id, $key ); ?>><?php echo $label; ?></option>
                    <?php } ?>
                </select>
            </p>

            <!-- Template -->
            <?php
            $templates = array(
                'widget' => __('Standard', 'affiliate-coupons')
            );
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>"><?php _e( 'Template:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>">
                    <?php foreach ( $templates as $key => $label ) { ?>
                        <option value="<?php echo $key; ?>" <?php selected( $template, $key ); ?>><?php echo $label; ?></option>
                    <?php } ?>
                </select>
                <br />
                <small>
                    <?php _e( 'The templates listed above are optimized for widgets.', 'affiliate-coupons' ); ?>
                </small>
            </p>

            <?php
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
            $instance = array();

            $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
            $instance['id'] = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
            $instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';

            return $instance;
        }
    }

}