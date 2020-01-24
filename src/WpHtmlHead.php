<?php

namespace Wpx\Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

use Wpx\Wpx\v0\WpHtml;

if ( ! \class_exists( __NAMESPACE__ . '\WpHtmlHead' ) ) {

	class WpHtmlHead {

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
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function remove_adjacent_posts_link () {
			\remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );
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
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function remove_canonical_link () {
			\remove_action( 'wp_head', 'rel_canonical' );
		}

		/**
		* Prevents WordPress from adding a generator meta tag.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function remove_generator_meta ( $priority = 100 ) {
			\remove_action( 'wp_head', 'wp_generator' );
			\remove_filter( 'the_generator', '__return_empty_string', $priority );
			\add_filter( 'the_generator', '__return_empty_string', $priority );
		}

		// /**
		// * Prevents WordPress from adding the oEmbed discovery links in the document head.
		// *
		// * Must be called before the theme calls `wp_head`.
		// *
		// * Note: This will still work if called at the beginning of a WP page template
		// * before `wp_head` is called.
		// */
		// // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		// public static function remove_oembed_discovery_links () {
		// 	\remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
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
		// // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		// public static function remove_oembed_script () {
		// 	\remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		// }

		// /**
		// * Prevents WordPress from adding the REST discovery link in the document head.
		// *
		// * Must be called before the theme calls `wp_head`.
		// *
		// * Note: This will still work if called at the beginning of a WP page template
		// * before `wp_head` is called.
		// */
		// // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		// public static function remove_rest_link () {
		// 	\remove_action( 'wp_head', 'rest_output_link_wp_head' );
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
		// // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		// public static function remove_rest_link_header () {
		// 	\remove_action( 'template_redirect', 'rest_output_link_header', 11 );
		// }

		// /**
		// * Prevents WordPress from adding a Really Simple Discovery (RSD) link in the
		// * document head.
		// *
		// * Must be called before the theme calls `wp_head`.
		// *
		// * Note: This will still work if called at the beginning of a WP page template
		// * before `wp_head` is called.
		// *
		// * Note: This is automatically done when XML-RPC is disabled.
		// */
		// // phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		// public static function remove_rsd_link () {
		// 	\remove_action( 'wp_head', 'rsd_link' );
		// }

		/**
		* Prevents WordPress from adding a shortlink link in the document head.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function remove_shortlink_link () {
			\remove_action( 'wp_head', 'wp_shortlink_wp_head' );
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
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function remove_wlwmanifest_link () {
			\remove_action( 'wp_head', 'wlwmanifest_link' );
		}

		/**
		* Convenience function for setting various content of the HTML head.
		*
		* **Example Usage**
		*
		*     WpHtmlHead::set([
		*     	'adjacent_posts_link' => false,
		*     	'canonical_link' => false,
		*     	'charset_meta' => true,
		*     	'generator_meta' => false,
		*     	'profile_link' => 'http://gmpg.org/xfn/11',
		*     //	'rest_link' => false,
		*     //	'rsd_link' => false,
		*     	'shortlink_link' => false,
		*     	'viewport_meta' => true, // Set to default.
		*     	// Or whatever you desire.
		*     	'viewport_meta' => 'width=device-width, initial-scale=0.86, maximum-scale=3.0, minimum-scale=0.86',
		*     	'wlwmanifest_link' => false,
		*     ]);
		*
		* @param array $values {
		* 	The HTML head values.
		*
		* 	@type bool $adjacent_posts_link Optional. Flag indicating whether to include
		* 		any adjacent post links when applicable.
		* 	@type bool $canonical_link Optional. Flag indicating whether to include
		* 		any a canonical link when applicable.
		* 	@type bool|string $charset_meta Optional. Set the meta charset value. Use `true`
		* 		to use the value from the WordPress settings which defaults to `'UTF-8'`. No
		* 		default value.
		* 	@type bool|string $generator_meta Optional. Flag indicating whether to include
		* 		the standard WordPress generator meta tag or to set the generator to a specific
		* 		value. Use `true` to use the default provided by WordPress.
		* 	@type bool|string $pingback_link Optional. Flag indicating whether to include
		* 		the pingback link on the appropriate pages or the pingback URL to use. Use
		* 		`true` to use the saved pingback URL.
		* 	@type string $profile_link Optional. The URL to use for a profile link. No default
		* 		value.
		* 	@type string[] $scripts Optional. Handles of pre-registered scripts to be
		* 		enqueued. No scripts are dequeued.
		* 	@type bool $shortlink_link Optional. Flag indicating whether to include a short
		* 		link in the document head.
		* 	@type string[] $styles Optional. Handles of pre-registered styles to be enqueued.
		* 		No styles are dequeued.
		* 	@type bool|string $viewport_meta Optional. Set the viewport meta value. No default
		* 		value.
		* 	@type bool $wlwmanifest_link Optional. Flag indicating whether to include a
		* 		Windows Live Writer (WLW) manifest link in the document head.
		* }
		*/
		public static function set ( $values = array() ) {
			// * 	@type bool $rest_link Optional. Flag indicating whether to include a REST API
			// * 		link in the document head.
			// $rest_link_config = isset( $values['rest_link'] ) ? $values['rest_link'] : true;
			// * 	@type false $rsd_link Optional. Flag indicating whether to include an RSD link in
			// * 		the document head. Defaults to false.
			// $rsd_link_config = isset( $values['rsd_link'] ) ? $values['rsd_link'] : false;

			if ( isset( $values['adjacent_posts_link'] ) && $values['adjacent_posts_link'] === false ) {
				self::remove_adjacent_posts_link();
			}

			if ( isset( $values['canonical_link'] ) && $values['canonical_link'] === false ) {
				self::remove_canonical_link();
			}

			if ( isset( $values['charset_meta'] ) ) {
				self::set_charset_meta( $values['charset_meta'] );
			}

			// Note: $values['content'] is reserved since it is expected in Wtf\Wp\v0\Elements\HtmlHead.

			if ( isset( $values['generator_meta'] ) ) {
				self::set_generator_meta( $values['generator_meta'] );
			}

			if ( isset( $values['pingback_link'] ) ) {
				self::set_pingback_link( $values['pingback_link'] );
			}

			if ( isset( $values['profile_link'] ) ) {
				self::set_profile_link( $values['profile_link'] );
			}

			// if ( $rest_link_config === false ) {
			// 	self::remove_rest_link();
			// }

			// if ( $rsd_link_config === false ) {
			// 	self::remove_rsd_link();
			// }

			if ( isset( $values['shortlink_link'] ) && $values['shortlink_link'] === false ) {
				self::remove_shortlink_link();
			}

			if ( ! empty( $values['styles'] ) && \is_array( $values['styles'] ) ) {
				WpHtml::enqueue_styles( $values['styles'] );
			}

			if ( ! empty( $values['scripts'] ) && \is_array( $values['scripts'] ) ) {
				WpHtml::enqueue_scripts( $values['scripts'] );
			}

			if ( isset( $values['viewport_meta'] ) ) {
				self::set_viewport_meta( $values['viewport_meta'] );
			}

			if ( isset( $values['wlwmanifest_link'] ) && $values['wlwmanifest_link'] === false ) {
				self::remove_wlwmanifest_link();
			}
		}

		/**
		* Sets the charset meta tag to the specified (or default) value.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* @param bool|string $charset Optional. The value to set the charset meta to. Defaults
		* 	to the site's `blog_charset` setting. This setting may be available in the WP
		* 	admin under Settings > Reading. This setting only shows up if it is not set to
		* 	`UTF-8`.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function set_charset_meta ( $charset = true ) {
			static $action;
			$action_name = 'wp_head';
			$priority = 0;

			if ( $action ) {
				\remove_action( $action_name, $action, $priority );
			}

			// Get the default if true.
			if ( $charset === true ) {
				$charset = \get_bloginfo( 'charset' );
			}

			$action = function () use ( $charset ) {
				echo '<meta charset="' . \esc_attr( $charset ) . '">' . "\n";
			};

			/*
			* It is recommended that the charset meta tag is one of the first two tags in the
			* HTML head. Hence the reason for a priority of 0.
			*
			* See https://htmlhead.dev/.
			*/
			\add_action( $action_name, $action, $priority );
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
		* 	Defaults to `'width=device-width, initial-scale=1'` which is the standard
		* 	for a responsive web site.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function set_generator_meta ( $generator = false ) {
			static $filter;
			$filter_name = 'the_generator';
			$priority = 100;

			if ( $filter ) {
				\remove_filter( $filter_name, $filter, $priority );
			}

			if ( $generator === false || $generator === null ) {
				$generator = '';
			}

			if ( \is_string( $generator ) ) {
				\remove_action( 'wp_head', 'wp_generator' );
				$filter = function () use ( $generator ) {
					return $generator;
				};
				\add_filter( $filter_name, $filter, $priority );
			}
			elseif ( $generator === true ) {
				\remove_action( 'wp_head', 'wp_generator' );
				\add_action( 'wp_head', 'wp_generator' );
			}
		}

		/**
		* Sets the pingback link to the specified value.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* @param bool|string $pingback_url Optional. The pingback URL. Use `true` to use the
		* 	saved pingback URL.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function set_pingback_link ( $pingback_url = true ) {
			static $action;
			$action_name = 'wp_head';
			$priority = 3;

			if ( $action ) {
				\remove_action( $action_name, $action, $priority );
			}

			if ( $pingback_url === true || ( \is_string( $pingback_url ) && ! empty( $pingback_url ) ) ) {
				$action = function () use ( $pingback_url ) {
					if ( \is_singular() && \pings_open( \get_queried_object() ) ) {
						if ( $pingback_url === true ) {
							$pingback_url = get_bloginfo( 'pingback_url' );
						}
						echo '<link rel="pingback" href="' . \esc_url( $pingback_url ) . '">' . "\n";
					}
				};

				\add_action( $action_name, $action, $priority );
			}
		}

		/**
		* Sets the profile link to the specified value.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* @param string $profile_url Optional. The profile URL.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function set_profile_link ( $profile_url = null ) {
			static $action;
			$action_name = 'wp_head';
			$priority = 3;

			if ( $action ) {
				\remove_action( $action_name, $action, $priority );
			}

			if ( \is_string( $profile_url ) && ! empty( $profile_url ) ) {
				$action = function () use ( $profile_url ) {
					echo '<link rel="profile" href="' . \esc_url( $profile_url ) . '">' . "\n";
				};

				\add_action( $action_name, $action, $priority );
			}
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
		* 	Defaults to `'width=device-width, initial-scale=1'` which is the standard
		* 	for a responsive web site.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function set_viewport_meta ( $viewport = true ) {
			static $action;
			$action_name = 'wp_head';
			/*
			* It is recommended that the viewport meta tag is one of the first two tags in the
			* HTML head. Hence the reason for a priority of 0.
			*
			* See https://htmlhead.dev/.
			*/
			$priority = 0;

			if ( $action ) {
				\remove_action( $action_name, $action, $priority );
			}

			if ( $viewport === true ) {
				$viewport = 'width=device-width, initial-scale=1';
			}

			if ( \is_string( $viewport ) && ! empty( $viewport ) ) {
				$action = function () use ( $viewport ) {
					echo '<meta name="viewport" content="' . \esc_attr( $viewport ) . '">' . "\n";
				};

				\add_action( $action_name, $action, $priority );
			}
		}

	} // eo class WpHtmlHead

} // eo if ( class_exists )
