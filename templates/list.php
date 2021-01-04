<?php
/**
 * List template
 *
 * @package AffiliateCoupons\Templates
 *
 * @var Affcoups_Coupon $coupon
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Check if coupons were found
if ( ! isset( $coupons ) )
    return;

?>
<?php affcoups_tpl_the_wrapper_start(); ?>

    <div class="affcoups-coupons-list">

        <?php foreach( $coupons as $coupon ) { ?>

            <div class="<?php $coupon->the_classes('affcoups-coupon' ); ?>"<?php $coupon->the_container(); ?>>

                <?php if ( $coupon->get_discount() ) { ?>
                    <span class="affcoups-coupon__discount"><?php echo esc_attr( $coupon->get_discount() ); ?></span>
                <?php } ?>

                <div class="affcoups-coupon__header">

                    <?php $coupon->the_image(); ?>

                    <?php if ( $coupon->get_types() ) { ?>
                        <div class="affcoups-coupon__types">
                            <?php $coupon->the_types(); ?>
                        </div>
                    <?php } ?>

                </div>

                <div class="affcoups-coupon__content">

                    <span class="affcoups-coupon__title"><?php echo esc_attr( $coupon->get_title() ); ?></span>

                    <div class="affcoups-coupon__description">

                        <div class="affcoups-coupon__description-excerpt">
                            <?php $coupon->the_excerpt(); ?>
                        </div>
                        <div class="affcoups-coupon__description-full">
                            <?php echo wp_kses_post( $coupon->get_description() ); ?>
                            <a href="#" class="affcoups-toggle-desc" data-blub="true" data-affcoups-toggle-desc="true"><?php _e('Show Less', 'affiliate-coupons' ); ?></a>
                        </div>
                    </div>

                </div>

                <div class="affcoups-coupon__footer">

                    <?php if ( $coupon->show_code() ) { ?>
                        <div class="affcoups-coupon__code">
                            <?php $coupon->the_code(); ?>
                        </div>
                    <?php } ?>

                    <?php $coupon->the_button(); ?>

                    <?php if ( $coupon->show_valid_dates() ) { ?>
                        <div class="affcoups-coupon__valid-dates">
                            <?php $coupon->the_valid_dates(); ?>
                        </div>
                    <?php } ?>

                </div>

            </div>
        <?php } ?>

    </div>

<?php affcoups_tpl_the_wrapper_end(); ?>
