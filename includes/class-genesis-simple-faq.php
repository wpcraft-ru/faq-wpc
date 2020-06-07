<?php

namespace WPCraft;
/**
 * Genesis Simple FAQ main class.
 *
 * @package genesis-simple-faq
 */

/**
 * The main class.
 *
 * @since 0.9.0
 */
final class FAQCore {

	/**
	 * Plugin version
	 *
	 * @var string
	 */
	public static $plugin_version = GENESIS_SIMPLE_PLUGIN_VERSION;

	/**
	 * Minimum WordPress version
	 *
	 * @var string
	 */
	public static $min_wp_version = '4.8';

	/**
	 * Minimum Genesis version
	 *
	 * @var string
	 */
	public static $min_genesis_version = '2.5';

	/**
	 * The plugin textdomain, for translations.
	 *
	 * @var string
	 */
	public static $plugin_textdomain = 'genesis-simple-faq';

	/**
	 * The url to the plugin directory.
	 *
	 * @var string
	 */
	public static $plugin_dir_url;

	/**
	 * The path to the plugin directory.
	 *
	 * @var string
	 */
	public static $plugin_dir_path;

	/**
	 * Post type object.
	 *
	 * @var WP_Post
	 */
	public static $post_type;

	/**
	 * Post type taxonomy.
	 *
	 * @var Object
	 */
	public static $post_type_tax;

	/**
	 * Shortcode object.
	 *
	 * @var string
	 */
	public static $shortcode;

	/**
	 * Widget object.
	 *
	 * @var WP_Widget
	 */
	public static $widget;

	/**
	 * Assets object.
	 *
	 * @var Genesis_Simple_FAQ_Assets
	 */
	public static $assets;

	/**
	 * Constructor.
	 *
	 * @since 0.9.0
	 */
	public function __construct() {


	}

	/**
	 * Initialize.
	 *
	 * @since 0.9.0
	 */
	public static function init() {

		self::$plugin_dir_url  = GENESIS_SIMPLE_FAQ_URL;
		self::$plugin_dir_path = GENESIS_SIMPLE_FAQ_DIR;

		self::load_plugin_textdomain();

		// register_activation_hook( __FILE__, 'flush_rewrite_rules' );


		add_action( 'plugins_loaded', array( __CLASS__, 'instantiate' ) );

	}

	/**
	 * Load the plugin textdomain, for translation.
	 *
	 * @since 0.9.0
	 */
	public static function load_plugin_textdomain() {
		load_plugin_textdomain( self::$plugin_textdomain, false, self::$plugin_dir_path . 'languages/' );
	}

	/**
	 * Include the class file, instantiate the classes, create objects.
	 *
	 * @since 0.9.0
	 */
	public static function instantiate() {




		/**
		 * Instance of the Genesis Simple FAQ Widget.
		 */
		// require_once self::$plugin_dir_path . 'includes/class-genesis-simple-faq-widget.php';
		// self::$widget = new Genesis_Simple_FAQ_Widget();
		// add_action( 'widgets_init', array( $this, 'register_widgets' ) );

	}

	/**
	 * Register Widget(s).
	 *
	 * @since 0.9.0
	 */
	public static function register_widgets() {

		// register_widget( 'Genesis_Simple_FAQ_Widget' );

	}

}

FAQCore::init();
