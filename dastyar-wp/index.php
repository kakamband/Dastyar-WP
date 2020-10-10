<?php
/**
 * Plugin Name: Dastyar WP
 * Plugin URI: https://wordpress.com/plugins/dastyar-wp/
 * Description: پلاگین دستیار وردپرس یکی از بهترین پلاگین ها جهت بهینه سازی ، افزایش سرعت و رعایت اصول سئو می باشد.
 * Version: 1.0
 * Author: MatinBeigi.IR
 * Author URI: https://matinbeigi.ir
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'MBWP_Dastyar_WP' ) ) {

    define( 'MBWP_ESL_VERSION', '1.0' );
    define( 'MBWP_ESL_NAME', plugin_basename( __FILE__ ) );
    define( 'MBWP_ESL_DIR', plugin_dir_path( __FILE__ ) );
    define( 'MBWP_ESL_URI', plugin_dir_url( __FILE__ ) );
    define( 'MBWP_ESL_TPL', trailingslashit( MBWP_ESL_DIR . 'templates' ) );
    define( 'MBWP_ESL_class', trailingslashit( MBWP_ESL_DIR . 'class' ) );
	include MBWP_ESL_class . 'mb.php';

	

    class MBWP_Dastyar_WP {

		public function __construct() {
            // Add option page
            add_action( 'admin_menu', array( $this, 'mbwp_esl_option_page' ) );

            // Register settings
            add_action( 'admin_init', array( $this, 'mbwp_esl_register_settings' ) );

            // Add settings link
            add_filter( 'plugin_action_links_' . MBWP_ESL_NAME, array( $this, 'mbwp_esl_add_settings_link' ) );

            // Add Shortcodes
            add_shortcode( 'enamadlogo_shortcode', array( $this, 'mbwp_enamad_logo' ) );
            add_shortcode( 'shamedlogo_shortcode', array( $this, 'mbwp_shamed_logo' ) );
            add_shortcode( 'zarrinpallogo_shortcode', array( $this, 'mbwp_zarrinpal_logo' ) );
            add_shortcode( 'mbwp_esl_logos', array( $this, 'mbwp_esl_all_logos' ) );

            // Avoid Text widget rel changes
            add_filter( 'wp_targeted_link_rel', array( $this, 'mbwp_avoid_text_widget_rel' ) , 99, 2 );
        }

        function mbwp_esl_option_page() {
            add_submenu_page(
                'options-general.php',
                'دستیار وردپرس',
                'دستیار وردپرس',
                'manage_options',
                'enamad-logo-manager-options',
                array( 
                    $this,
                    'mbwp_esl_option_page_callback'
                ) 
            );
        }

        function mbwp_esl_register_settings() {
            register_setting( 'mbwp-esl-settings-group', 'mbwp_heartbeat' );
            register_setting( 'mbwp-esl-settings-group', 'mbwp_shortlink' );
            register_setting( 'mbwp-esl-settings-group', 'mbwp_pingback' );
            register_setting( 'mbwp-esl-settings-group', 'mbwp_xml_rpc' );
            register_setting( 'mbwp-esl-settings-group', 'mbwp_remove_qurey_string' );
            register_setting( 'mbwp-esl-settings-group', 'mbwp_hide_wp' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_dns_prefetch' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_contact_form' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_mbeds' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_WLManifest' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_Remove_JQuery' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_dashicons' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_remove_url_comment' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_disable_acf' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_search' );
			register_setting( 'mbwp-esl-settings-group', 'mbwp_preload_fonts' );
        }

        function mbwp_esl_option_page_callback() {
            include MBWP_ESL_TPL . 'option-page.php';
        }

        function mbwp_esl_add_settings_link( $links ) {
            $links[] = '<a href="' . admin_url( 'options-general.php?page=enamad-logo-manager-options' ) . '">تنظیمات</a>';
            $links[] = '<a href="https://matinbeigi.ir">سایت سازنده</a>';

            return $links;
        }



        function mbwp_esl_all_logos( $atts, $content = "" ) {
            return array( $this, 'mbwp_enamad_logo' ) . array( $this, 'mbwp_shamed_logo' ) . array( $this, 'mbwp_zarrinpal_logo' );
        }

        function mbwp_avoid_text_widget_rel( $rel, $link_html ) {
            if( strpos( $link_html, 'trustseal.enamad.ir' ) || strpos( $link_html, 'logo.samandehi.ir' ) ) {
                return '';
            }

            return $rel;
        }
	}

    new MBWP_Dastyar_WP();
}