<?php
namespace WPCraft;

/**
 * Genesis Simple FAQ shortcode class.
 *
 * @package genesis-simple-faq
 */

/**
 * Class to handle shortcode creation, rendering, and asset loading.
 *
 * @since 0.9.0
 */
class Genesis_Simple_FAQ_Shortcode {

	public static $tax_name;
	public static $shortcode_name = 'faq_wpc';
	public static $cpt_name;
	public static $config;

	/**
	 * Constructor function initiates the shortcode.
	 *
	 * @return void
	 *
	 * @since 0.9.0
	 */
	public static function init() {

		add_filter('faq_wpc_config', function ($config) {
			$config['shortcode_name'] = self::$shortcode_name;
			return $config;
		});

		self::$config = apply_filters('faq_wpc_config', []);
		self::$cpt_name = self::$config['cpt_name'];
		self::$tax_name = self::$config['tax_name'];


		// Register shortcode.
		add_shortcode( self::$shortcode_name, array( __CLASS__, 'shortcode' ) );

	}

	/**
	 * Shortcode builder function.
	 *
	 * @param  array $atts    Array of passed in attributes.
	 *
	 * @return string  $faq     String of HTML to output.
	 *
	 * @since 0.9.0
	 */
	public static function shortcode( $atts ) {

		$a = shortcode_atts(
			array(
				'id'    => '',
				'cat'   => '',
				'limit' => -1,
				'order' => 'DESC',
			),
			$atts
		);

		// If IDs are set, use them. Otherwise retrieve all.
		$ids = '' !== $a['id'] ? explode( ',', $a['id'] ) : array();

		// If category IDs are set, use them. Otherwise retrieve all.
		$cats = '' !== $a['cat'] ? explode( ',', $a['cat'] ) : array();

		$args = array(
			'orderby'        => 'post__in',
			'order'          => $a['order'],
			'post_type'      => self::$cpt_name,
			'post__in'       => $ids,
			'posts_per_page' => $a['limit'],
		);

		if ( $cats ) {
			$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'terms'    => $cats,
					'taxonomy' => self::$tax_name,
				),
			);
		}

		$faqs = new \WP_Query( $args );

		$output = '';

		if ( $faqs->have_posts() ) {

			$output .= '<div class="faq-wpc-wrapper" role="tablist" itemscope="" itemtype="https://schema.org/FAQPage">';

			while ( $faqs->have_posts() ) {
				$faqs->the_post();

				$question = get_the_title();
				$answer   = wpautop( get_the_content() );
				$template = sprintf(
					'
					<div class="gs-faq__answer no-animation" itemprop="mainEntity" itemscope="" itemtype="https://schema.org/Question">
						<div class="gs-faq__answer__heading" itemprop="name">
							<strong>%1$s</strong>
						</div>
						<div itemscope="" itemtype="https://schema.org/Answer" itemprop="acceptedAnswer">
							<div itemprop="text">
								%2$s
							</div>
						</div>
					</div>
					',
					esc_html( $question ),
					do_shortcode( $answer )
				);

				// Allow filtering of the template markup.
				$output .= apply_filters( 'faq_template_wpc', $template, $question, $answer );
			}

			$output .= '</div>';

		}

		wp_reset_postdata();

		return $output;

	}

}

Genesis_Simple_FAQ_Shortcode::init();