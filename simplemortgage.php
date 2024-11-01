<?php

/* Designed and developed by Gilbert Karogo K., a product of umatidocs.com */
/*
Plugin Name: Simplelender
Plugin URI: https://www.wplendev.com/
Description: A complete digital marketing tool for lenders on wordpress.
Author: WPlendev
Version: 1.3.23
Author URI: https://www.wplendev.com/
*/

if ( !defined( 'WP_SIMPLELENDER__PLUGIN_DIR' ) ) {
    $dir_name = basename( dirname( __FILE__ ) );
    define( 'WP_SIMPLELENDER__PLUGIN_DIR', $dir_name );
    define( 'WP_SIMPLELENDER__PLUGIN_URL', plugins_url( plugin_basename( WP_SIMPLELENDER__PLUGIN_DIR ) ) );


	if ( !defined( 'ABSPATH' ) ) {
		exit;
	}
	function simplemortgage_avoid_double_uninstall(){
		if( !simplelender_fs()->is_plan('growth') ){
			wp_die( 'Please deactivate premium simplelender before activating simplelender.' );
		}
	}
	register_deactivation_hook( __FILE__, 'simplemortgage_avoid_double_uninstall' );

	if ( !function_exists( 'simplelender_fs' ) ) {
		// Create a helper function for easy SDK access.
		function simplelender_fs()
		{
			global  $simplelender_fs ;
			
			if ( !isset( $simplelender_fs ) ) {
				// Include Freemius SDK.
				require_once dirname( __FILE__ ) . '/freemius/start.php';
				$simplelender_fs = fs_dynamic_init( array(
					'id'               => '2939',
					'slug'             => 'simplemortgage',
					'type'             => 'theme',
					'public_key'       => 'pk_7e31bf3f6589499648c453f9ed078',
					'is_premium'       => false,
					'is_premium_only'  => false,
					'has_addons'       => false,
					'has_paid_plans'   => true,
					'is_org_compliant' => false,
					'trial'            => array(
					'days'               => 14,
					'is_require_payment' => true,
				),
					'has_affiliation'  => 'all',
					'menu'             => array(
					'slug'    => 'mvc_simplelender_clientloannotes',
					'support' => false,
				),
					'is_live'          => true,
				) );
			}
			
			return $simplelender_fs;
		}
		
		// Init Freemius.
		simplelender_fs();
		// Signal that SDK was initiated.
		do_action( 'simplelender_fs_loaded' );
	}
	error_reporting(0);

	require_once dirname( __FILE__ ) . '/app/functions/functions.php';

	if ( !function_exists( 'simplemortgage_activate' ) ) {
		function simplemortgage_activate(){
			ob_start();
			global  $wp_rewrite ;
			require_once dirname( __FILE__ ) . '/simplemortgage_loader.php';
			$loader = new simplemortgageLoader();
			$loader->activate();
			$wp_rewrite->flush_rules( true );
			ob_get_clean();
			///GFForms::activation_hook();
		}
	}

	if ( !function_exists( 'simplemortgage_deactivate' ) ){
		function simplemortgage_deactivate()
		{
			global  $wp_rewrite ;
			require_once dirname( __FILE__ ) . '/simplemortgage_loader.php';
			$loader = new simplemortgageLoader();
			$loader->deactivate();
			$wp_rewrite->flush_rules( true );
		}
	}

	if ( !function_exists( 'simplemortgage_loadmanager' ) ){
		function simplemortgage_loadmanager(){
			simplelender_class( 'simplelender_init' )->init();
		}
	}

	register_activation_hook( __FILE__, 'simplemortgage_activate' );
	register_deactivation_hook( __FILE__, 'simplemortgage_deactivate' );

	add_action(
		'init',
		'simplemortgage_loadmanager',
		8888,
		1
	);
}
else{
	//echo there are tow installations of simplemortgage.		
	if ( !function_exists( 'simplemortgage_plugin_active' ) ) {
		function simplemortgage_plugin_active( $plugin )
		{
			return in_array( $plugin, (array) get_option( 'active_plugins', array() ) );
		}

	}
	if ( !function_exists( 'simplemortgage_avoid_double_install' ) ) {
		function simplemortgage_avoid_double_install()
		{
			if ( simplemortgage_plugin_active( "simplelender-by-umatidocs-com/simplelender-by-umatidocs-com.php" ) ) {
				wp_die( 'Please deactivate simplelender before activating simplelender.' );
			}
			if ( simplemortgage_plugin_active( "simplelender-by-umatidocs-com-premium/simplelender-by-umatidocs-com.php" ) ) {
				wp_die( 'Please deactivate simplelender premium before activating simplelender.' );
			}
			if ( simplemortgage_plugin_active( "simplemortgage/simplemortgage.php" ) ) {
				wp_die( 'Please deactivate simplelender before activating simplelender.' );
			}
			if ( simplemortgage_plugin_active( "simplemortgage-premium/simplemortgage.php" ) ) {
				wp_die( 'Please deactivate simplelender premium before activating simplelender.' );
			}
		}
		
	}

	register_activation_hook( __FILE__, 'simplemortgage_avoid_double_install' );
	
}