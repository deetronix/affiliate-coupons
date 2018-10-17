<?php
/**
 * Widget: Single Coupon
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
};

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
				__( 'Coupon', 'affiliate-coupons' ), // Name
				array( 'description' => __( 'Displays a single coupon.', 'affiliate-coupons' ), ) // Args
			);
		}

		/**
		 * Front-end display of widget.
		 *
		 * @see WP_Widget::widget()
		 *
		 * @param array $args Widget arguments.
		 * @param array $instance Saved values from database.
		 */
		public function widget( $args, $instance ) {

			echo wp_kses_post( $args['before_widget'] );

			if ( ! empty( $instance['title'] ) ) {
				echo wp_kses_post( $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'] );
			}

			if ( ! empty ( $instance['id'] ) ) {

				// IDs
				$shortcode_atts = array(
					'id' => $instance['id'],
				);

				// Template
				$shortcode_atts['template'] = ( ! empty( $instance['template'] ) ) ? $instance['template'] : 'widget';

                // Style
                $shortcode_atts['style'] = ( ! empty( $instance['style'] ) ) ? $instance['style'] : 'standard';

				// Execute Shortcode
				affcoups_widget_do_shortcode( $shortcode_atts );

			} else {
				echo esc_attr( 'Please select a coupon.', 'affiliate-coupons' );
			}

			echo wp_kses_post( $args['after_widget'] );
		}

		/**
		 * Back-end widget form.
		 *
		 * @see WP_Widget::form()
		 *
		 * @param array $instance Previously saved values from database.
		 */
		public function form( $instance ) {

			$title    = ! empty( $instance['title'] ) ? $instance['title'] : '';
			$id       = ! empty( $instance['id'] ) ? $instance['id'] : '';
			$template = ! empty( $instance['template'] ) ? $instance['template'] : 'widget';
            $style = ! empty( $instance['style'] ) ? $instance['style'] : 'standard';
			?>
            <!-- Title -->
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( esc_attr( 'Title:' ), 'affiliate-coupons' ); ?></label>
                <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
            </p>

            <!-- Coupon -->
			<?php
			$coupons = affcoups_get_coupon_options();
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>"><?php esc_attr_e( 'Coupon:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'id' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'id' ) ); ?>">
					<?php foreach ( $coupons as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $id, $key ); ?>><?php echo esc_attr( $label ); ?></option>
					<?php } ?>
                </select>
            </p>

            <!-- Templates -->
			<?php
            $templates = affcoups_get_widget_template_options();
			?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>"><?php esc_attr_e( 'Template:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'template' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'template' ) ); ?>">
					<?php foreach ( $templates as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $template, $key ); ?>><?php echo esc_attr( $label ); ?></option>
					<?php } ?>
                </select>
                <br/>
                <small>
					<?php esc_attr_e( 'The templates listed above are optimized for widgets.', 'affiliate-coupons' ); ?>
                </small>
            </p>

            <!-- Styles -->
            <?php
            $styles = affcoups_get_style_options();
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>"><?php esc_attr_e( 'Style:', 'affiliate-coupons' ); ?></label>
                <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'style' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'style' ) ); ?>">
                    <?php foreach ( $styles as $key => $label ) { ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $style, $key ); ?>><?php echo esc_attr( $label ); ?></option>
                    <?php } ?>
                </select>
            </p>
            <?php affcoups_the_pro_feature_note( __( 'More templates & styles', 'affiliate-coupons' ), false ); ?>
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

			$instance['title']    = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			$instance['id']       = ( ! empty( $new_instance['id'] ) ) ? strip_tags( $new_instance['id'] ) : '';
			$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';
            $instance['style'] = ( ! empty( $new_instance['style'] ) ) ? strip_tags( $new_instance['style'] ) : '';

			return $instance;
		}
	}

}