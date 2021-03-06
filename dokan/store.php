<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$store_user   = get_userdata( get_query_var( 'author' ) );
$store_info   = dokan_get_store_info( $store_user->ID );
$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

get_header( 'shop' );

$sidebar_data = theshopier_pages_sidebar_act('shop');

extract( $sidebar_data );

$check_mobile = theshopier_check_device('xs');

$datas = array(
    'show_bcrumb'	=> 1,
    'is_shop'		=> 1
);
do_action( 'theshopier_breadcrumb', $datas );
?>

    <div class="container">
        <div class="row">


        <?php do_action( 'woocommerce_before_main_content' ); ?>

        <?php if ( dokan_get_option( 'enable_theme_store_sidebar', 'dokan_general', 'off' ) == 'off' ) { ?>
            <div id="dokan-secondary" class="dokan-clearfix col-sm-6 dokan-store-sidebar" role="complementary">
                <div class="dokan-widget-area widget-collapse nth-sidebar">
                    <?php do_action( 'dokan_sidebar_store_before', $store_user, $store_info ); ?>
                    <?php
                    if ( ! dynamic_sidebar( 'dokan-store-sidebar' ) ) {

                        $args = array(
                            'before_widget' => '<aside class="widget">',
                            'after_widget'  => '</aside>',
                            'before_title'  => '<h3 class="widget-title">',
                            'after_title'   => '</h3>',
                        );

                        if ( class_exists( 'Dokan_Store_Location' ) ) {
                            the_widget( 'Dokan_Store_Category_Menu', array( 'title' => __( 'Store Category', 'dokan' ) ), $args );

                            if ( dokan_get_option( 'store_map', 'dokan_general', 'on' ) == 'on' ) {
                                the_widget( 'Dokan_Store_Location', array( 'title' => __( 'Store Location', 'dokan' ) ), $args );
                            }

                            if ( dokan_get_option( 'contact_seller', 'dokan_general', 'on' ) == 'on' ) {
                                the_widget( 'Dokan_Store_Contact_Form', array( 'title' => __( 'Contact Seller', 'dokan' ) ), $args );
                            }
                        }

                    }
                    ?>

                    <?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
                </div>
            </div><!-- #secondary .widget-area -->
            <?php
        } else {
            get_sidebar( 'store' );
        }
        ?>

        <div id="dokan-primary" class="dokan-single-store col-sm-18">
            <div id="dokan-content" class="store-page-wrap woocommerce" role="main">

                <?php dokan_get_template_part( 'store-header' ); ?>

                <?php do_action( 'dokan_store_profile_frame_after', $store_user, $store_info ); ?>

                <?php if ( have_posts() ) { ?>

                    <div class="seller-items row">

                        <?php woocommerce_product_loop_start(); ?>

                        <?php while ( have_posts() ) : the_post(); ?>

                            <?php wc_get_template_part( 'content', 'product' ); ?>

                        <?php endwhile; // end of the loop. ?>

                        <?php woocommerce_product_loop_end(); ?>

                    </div>

                    <?php dokan_content_nav( 'nav-below' ); ?>

                <?php } else { ?>

                    <p class="dokan-info"><?php _e( 'No products were found of this seller!', 'dokan' ); ?></p>

                <?php } ?>
            </div>

        </div><!-- .dokan-single-store -->

        <?php do_action( 'woocommerce_after_main_content' ); ?>


        </div>
    </div>

<?php get_footer( 'shop' ); ?>