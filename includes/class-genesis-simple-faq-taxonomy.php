<?php
namespace WPCraft;

/**
 * Class to handle taxonomy registering.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Taxonomy {

	public static $tax_name = 'faq_tags_wpc';
	public static $cpt_name;
	public static $config;
	/**
	 * Constructor.
	 */
	public static function init() {

		add_filter('faq_wpc_config', function ($config) {
			$config['tax_name'] = self::$tax_name;
			return $config;
		});

		self::$config = apply_filters('faq_wpc_config', []);
		self::$cpt_name = self::$config['cpt_name'];

		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
		add_action( 'init', array( __CLASS__, 'add_faq_shortcode_column' ) );
	}

	/**
	 * Registering the taxonomy.
	 */
	public static function register_taxonomy() {

		// dd(self::$cpt_name);
		
		register_taxonomy(
			self::$tax_name,
			self::$cpt_name,
			array(
				'label'        => __( 'Categories', 'genesis-simple-faq' ),
				'public'       => false,
				'rewrite'      => false,
				'show_ui'      => true,
				'show_in_rest' => true,
				'hierarchical' => false,
			)
		);
		register_taxonomy_for_object_type( self::$tax_name, self::$cpt_name );
	}

	/**
	 * Function to modify the FAQ's Category table columns and add a shortcode snippet.
	 *
	 * @since 0.9.1
	 */
	public static function add_faq_shortcode_column() {

		add_filter( 'manage_edit-' . self::$tax_name . '_columns', function($columns){

			$columns['gs_faq'] = __( 'Shortcode', 'genesis-simple-faq' );
			return $columns;

		} );

		add_action( 'manage_' . self::$tax_name . '_custom_column', function($content, $column_name, $term_id){
			if ( 'gs_faq' === $column_name ) {
				$content = '[gs_faq cat="' . $term_id . '"]';
			}
	
			return $content;
		}, 10, 3 );

	}



}
Genesis_Simple_FAQ_Taxonomy::init();