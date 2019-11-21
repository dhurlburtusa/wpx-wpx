<?php
namespace Wpx\v0;

if ( ! class_exists( __NAMESPACE__ . '\WpHtml' ) ) {

	class WpHtml {

		/**
		* Convenience function for configuring an HTML response.
		*
		* **Example Usage**
		*
		*     WpHtml::configure([
		*     	'adjacent_posts_link' => false,
		*     	'canonical_link' => false,
		*     	'generator_meta' => false,
		*     	'meta_charset' => true,
		*     	'meta_viewport' => true, // Set to default.
		*     	// Or whatever you desire.
		*     	'meta_viewport' => 'width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86',
		*     //	'rest_link' => false,
		*     //	'rsd_link' => false,
		*     	'shortlink_link' => false,
		*     	'wlwmanifest_link' => false,
		*     ]);
		*
		* @param array $config {
		*     The WP HTML response configuration.
		*
		*     @type false $adjacent_posts_link Optional. Flag indicating whether to include
		*     	any adjacent post links when applicable.
		*     @type false $canonical_link Optional. Flag indicating whether to include
		*     	any a canonical link when applicable.
		*     @type false|string $generator_meta Optional. Flag indicating whether to include
		*     	the standard WordPress generator meta tag or to set the generator to a specific
		*     	value. Defaults to false.
		*     @type true|string $meta_charset Optional. Set the meta charset value. Defaults
		*     	to true which means use the value from the WordPress settings which defaults
		*     	to UTF-8.
		*     @type true|string $meta_viewport Optional. Set the meta viewport value. Defaults
		*     	to true which means use the default viewport settings. See
		*     	`WpHtml::set_meta_viewport` for more information.
		*     @type false $rest_link Optional. Flag indicating whether to include a REST API
		*     	link in the document head. Defaults to true.
		*     @type false $rsd_link Optional. Flag indicating whether to include an RSD link in
		*     	the document head. Defaults to false.
		*     @type string[] $scripts Optional. Handles of pre-registered scripts. Defaults to
		*     	null.
		*     @type string[] $styles Optional. Handles of pre-registered styles. Defaults to
		*     	null.
		*     @type false $shortlink_link Optional. Flag indicating whether to include a short
		*     	link in the document head. Defaults to false.
		*     @type false $wlwmanifest_link Optional. Flag indicating whether to include a
		*     	Windows Live Writer (WLW) manifest link in the document head. Defaults to false.
		* }
		*/
		public static function configure ( $config = array() ) {
			$adjacent_posts_link_config = isset( $config['adjacent_posts_link'] ) ? $config['adjacent_posts_link'] : true;
			$canonical_link_config = isset( $config['canonical_link'] ) ? $config['canonical_link'] : true;
			$generator_meta_config = isset( $config['generator_meta'] ) ? $config['generator_meta'] : false;
			$meta_charset_config = isset( $config['meta_charset'] ) ? $config['meta_charset'] : true;
			$meta_viewport_config = isset( $config['meta_viewport'] ) ? $config['meta_viewport'] : true;
			// $rest_link_config = isset( $config['rest_link'] ) ? $config['rest_link'] : true;
			// $rsd_link_config = isset( $config['rsd_link'] ) ? $config['rsd_link'] : false;
			$shortlink_link_config = isset( $config['shortlink_link'] ) ? $config['shortlink_link'] : false;
			$scripts_config = isset( $config['scripts'] ) ? $config['scripts'] : null;
			$styles_config = isset( $config['styles'] ) ? $config['styles'] : null;
			$wlwmanifest_link_config = isset( $config['wlwmanifest_link'] ) ? $config['wlwmanifest_link'] : false;

			if ( $adjacent_posts_link_config === false ) {
				self::remove_adjacent_posts_link();
			}

			if ( $canonical_link_config === false ) {
				self::remove_canonical_link();
			}

			if ( $generator_meta_config === false ) {
				self::remove_generator_meta();
			}
			else if ( is_string( $generator_meta_config ) ) {
				remove_action( 'wp_head', 'wp_generator' );
				add_filter( 'the_generator', function () {
					return $generator_meta_config;
				}, 100 );
			}

			self::set_meta_charset( $meta_charset_config );

			if ( $meta_viewport_config === true ) {
				self::set_meta_viewport();
			}
			else if ( is_string( $meta_viewport_config ) ) {
				self::set_meta_viewport( $meta_viewport_config );
			}

			// if ( $rest_link_config === false ) {
			// 	self::remove_rest_link();
			// }

			// if ( $rsd_link_config === false ) {
			// 	self::remove_rsd_link();
			// }

			if ( $shortlink_link_config === false ) {
				self::remove_shortlink_link();
			}

			if ( is_array( $styles_config ) ) {
				self::enqueue_styles( $styles_config );
			}

			if ( is_array( $scripts_config ) ) {
				self::enqueue_scripts( $scripts_config );
			}

			if ( $wlwmanifest_link_config === false ) {
				self::remove_wlwmanifest_link();
			}
		}

		/**
		* Convenience function for dequeuing styles.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @param string[] $handles The handles of the styles to dequeue.
		*/
		public static function dequeue_styles ( $handles ) {
			add_action( 'wp_enqueue_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					wp_dequeue_style( $handle );
				}
			}, 100 );
		}

		/**
		* Enables shortcodes in the text widget.
		*
		* By default, the WP text widget does not recognize shortcodes.
		*/
		public static function enable_text_widget_shortcodes () {
			add_filter( 'widget_text', 'do_shortcode' );
		}

		/**
		* Convenience function for enqueuing pre-registered scripts.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @param string[] $handles The handles of the pre-registered scripts to enqueue.
		* @param int $priority Optional. The priority at which to enqueue the styles. The
		*   priority affects where in the markup the style is inserted which affects the
		*   CSS cascade. Defaults to 110.
		*/
		public static function enqueue_scripts ( $handles, $priority = 110 ) {
			add_action( 'wp_enqueue_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					wp_enqueue_script( $handle );
				}
			}, $priority );
		}

		/**
		* Convenience function for enqueuing pre-registered styles.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @param string[] $handles The handles of the pre-registered styles to enqueue.
		* @param int $priority Optional. The priority at which to enqueue the styles. The
		*   priority affects where in the markup the style is inserted which affects the
		*   CSS cascade. Defaults to 100.
		*/
		public static function enqueue_styles ( $handles, $priority = 100 ) {
			add_action( 'wp_enqueue_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					wp_enqueue_style( $handle );
				}
			}, $priority );
		}

		/**
		* Prevents WordPress from adding relational links for adjacent posts in the
		* document head.
		*
		* On single post pages, WordPress by default adds relational links for
		* adjacent posts to the document head. Calling this function will cause those
		* links to be left out.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		public static function remove_adjacent_posts_link () {
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
		}

		/**
		* Prevents WordPress from adding the canonical link in the document head.
		*
		* For singular post types, for example blog post or a page, WordPress by default
		* includes a canonical link in the document head. Calling this function will
		* cause that link to be left out.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		public static function remove_canonical_link () {
			remove_action( 'wp_head', 'rel_canonical' );
		}

		/**
		* Prevents WordPress from adding a generator meta tag.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		public static function remove_generator_meta ( $priority = 100 ) {
			remove_action( 'wp_head', 'wp_generator' );
			add_filter( 'the_generator', '__return_empty_string', $priority );
		}

		// /**
		// * Prevents WordPress from adding the oEmbed discovery links in the document head.
		// *
		// * Must be called before the theme calls `wp_head`.
		// *
		// * Note: This will still work if called at the beginning of a WP page template
		// * before `wp_head` is called.
		// */
		// public static function remove_oembed_discovery_links () {
		// 	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		// }

		// /**
		// * Prevents WordPress from adding the `script` tag to include the oEmbed script
		// * from the front-end.
		// *
		// * Must be called before the theme calls `wp_head`.
		// *
		// * Note: This will still work if called at the beginning of a WP page template
		// * before `wp_head` is called.
		// *
		// * Note: This does not affect the oEmbed script used in the WP admin.
		// */
		// public static function remove_oembed_script () {
		// 	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		// }

		// /**
		// * Prevents WordPress from adding the REST discovery link in the document head.
		// *
		// * Must be called before the theme calls `wp_head`.
		// *
		// * Note: This will still work if called at the beginning of a WP page template
		// * before `wp_head` is called.
		// */
		// public static function remove_rest_link () {
		// 	remove_action( 'wp_head', 'rest_output_link_wp_head' );
		// }

		// /**
		// * Prevents WordPress from adding the REST discovery link response header.
		// *
		// * Must be called before the theme calls `template_redirect`. Callbacks of any of
		// * the following actions would be a good place to call this function:
		// *
		// * - `plugins_loaded`
		// * - `setup_theme`
		// * - `after_setup_theme`
		// * - `init`
		// * - `wp_loaded`
		// * - `send_headers`
		// * - `wp`
		// *
		// * Although, `wp_loaded` is arguably the ideal action.
		// */
		// public static function remove_rest_link_header () {
		// 	remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		// }

		/**
		* Prevents WordPress from adding a Really Simple Discovery (RSD) link in the
		* document head.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* Note: This is automatically done when XML-RPC is disabled.
		*/
		public static function remove_rsd_link () {
			remove_action( 'wp_head', 'rsd_link' );
		}

		/**
		* Prevents WordPress from adding a shortlink link in the document head.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		public static function remove_shortlink_link () {
			remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		}

		/**
		* Prevents WordPress from adding a Windows Live Writer (WLW) manifest link in the
		* document head.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		public static function remove_wlwmanifest_link () {
			remove_action( 'wp_head', 'wlwmanifest_link' );
		}

		/**
		* Sets the charset meta tag to the specified (or default) value.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* @param string $charset Optional. The value to set the charset meta to. Defaults
		* 	to the site's `blog_charset` setting. This setting may be available in the WP
		* 	admin under Settings > Reading. This setting only shows up if it is not set to
		* 	`UTF-8`.
		*/
		public static function set_meta_charset ( $charset = true ) {
			// Get the default if NULL.
			if ( $charset === true ) {
				$charset = get_bloginfo( 'charset' );
			}
			/*
			* It is recommended that the charset meta tag is one of the first two tags in the
			* HTML head. Hence the reason for a priority of 0.
			*
			* See https://htmlhead.dev/.
			*/
			add_action( 'wp_head', function () use ( $charset ) {
				echo '<meta charset="' . esc_attr( $charset ) . '">' . "\n";
			}, 0 );
		}

		/**
		* Sets the viewport meta tag to the specified (or default) value.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* @param string $viewport Optional. The value to set the viewport meta to.
		* 	Defaults to `'width=device-width, initial-scale=1'` which is that standard
		* 	for a responsive web site.
		*/
		public static function set_meta_viewport ( $viewport = 'width=device-width, initial-scale=1' ) {
			/*
			* It is recommended that the viewport meta tag is one of the first two tags in the
			* HTML head. Hence the reason for a priority of 0.
			*
			* See https://htmlhead.dev/.
			*/
			add_action( 'wp_head', function () use ( $viewport ) {
				echo '<meta name="viewport" content="' . esc_attr( $viewport ) . '">' . "\n";
			}, 0 );
		}

	} // eo class WpHtml

} // eo if ( class_exists )
