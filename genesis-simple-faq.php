<?php
/**
 * Plugin Name: FAQ by WPCraft
 * Plugin URI: https://github.com/wpcraft-ru/faq-wpc
 *
 * Description: A plugin for the Genesis Framework to manage FAQ components via shortcodes.
 *
 * Author: WPCraft
 * Author URI: https://www.wpcraft.ru/
 *
 *
 * Text Domain: genesis-simple-faq
 * Domain Path: /languages
 *
 * License: GPL-2.0-or-later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Version: 0.9.2
 */

define( 'GENESIS_SIMPLE_PLUGIN_VERSION', '0.9.2' );
define( 'GENESIS_SIMPLE_FAQ_DIR', plugin_dir_path( __FILE__ ) );
define( 'GENESIS_SIMPLE_FAQ_URL', plugins_url( '', __FILE__ ) );


add_filter('faq_wpc_config', function($config = []){

	$config['plugin_version'] = GENESIS_SIMPLE_PLUGIN_VERSION;
	$config['plugin_dir_path'] = GENESIS_SIMPLE_FAQ_DIR;
	$config['plugins_url'] = GENESIS_SIMPLE_FAQ_URL;
	return $config;
});


// Initialize the object on	`plugins_loaded`.
add_action( 'plugins_loaded', function(){
	if( ! current_user_can('administrator')){
		return;
	}

	$GLOBALS['faq_wpc'] = [];
	require_once GENESIS_SIMPLE_FAQ_DIR . '/includes/class-genesis-simple-faq.php';

			/**
		 * Instance of the plugin assets (loaded in the class).
		 */
		// require_once GENESIS_SIMPLE_FAQ_DIR . 'includes/class-genesis-simple-faq-assets.php';
		// $GLOBALS['faq_wpc']['ass'] = new Genesis_Simple_FAQ_Assets();

		/**
		 * Instance of the Genesis Simple FAQ custom post type.
		 */
		require_once GENESIS_SIMPLE_FAQ_DIR . 'includes/class-genesis-simple-faq-cpt.php';

		/**
		 * Instance of the Genesis Simple FAQ taxonomy.
		 */
		require_once GENESIS_SIMPLE_FAQ_DIR . 'includes/class-genesis-simple-faq-taxonomy.php';

		/**
		 * Instance of the Genesis Simple FAQ shortcode.
		 */
		require_once GENESIS_SIMPLE_FAQ_DIR . 'includes/class-genesis-simple-faq-shortcode.php';

} );
