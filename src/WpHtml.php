<?php

namespace Wpx\Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

use Wpx\Wpx\v0\Html;

if ( ! \class_exists( __NAMESPACE__ . '\WpHtml' ) ) {

	class WpHtml {

		/**
		* Gets the `body` tag's attributes.
		*
		* Note: `get_body_class` is called to get the body class attribute from WP based
		* on the current request.
		* Note: Use the standard `body_class` filter to filter the `class` attribute.
		*
		* @param array $attrs {
		* 	The `body` tag attributes.
		*
		* 	@type string|string[] $class Optional. CSS class(es) to add to the `body` tag.
		* 		Defaults to `''`.
		* }
		*
		* @return string
		*
		* @see Wpx\Wpx\v0\Html::attrs
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function body_attrs ( $attrs = array() ) {
			if ( ! isset( $attrs['class'] ) ) {
				$attrs['class'] = '';
			}
			$attrs['class'] = join( ' ', \get_body_class( $attrs['class'] ) );

			if ( $attrs['class'] === '' ) {
				$attrs['class'] = null;
			}

			$html = Html::attrs( $attrs );
			$html = \apply_filters( 'wpx_wpx_0__the_body_attrs', $html );
			return $html;
		}

		/**
		* Convenience function for dequeuing scripts.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @param string[] $handles The handles of the scripts to dequeue.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function dequeue_scripts ( $handles ) {
			\add_action( 'wp_print_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					\wp_dequeue_script( $handle );
				}
			}, 100 );
			\add_action( 'wp_print_footer_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					\wp_dequeue_script( $handle );
				}
			}, 100 );
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
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function dequeue_styles ( $handles ) {
			\add_action( 'wp_enqueue_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					\wp_dequeue_style( $handle );
				}
			}, 100 );
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
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function enqueue_scripts ( $handles, $priority = 110 ) {
			\add_action( 'wp_enqueue_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					\wp_enqueue_script( $handle );
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
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function enqueue_styles ( $handles, $priority = 100 ) {
			\add_action( 'wp_enqueue_scripts', function () use ( $handles ) {
				foreach ( $handles as $handle ) {
					\wp_enqueue_style( $handle );
				}
			}, $priority );
		}

		/**
		* Gets the `html` tag's attributes.
		*
		* @param array $attrs {
		* 	The `html` tag attributes.
		*
		* 	@type string|string[] $class Optional. CSS class(es) to add to the `html` tag.
		* 		Defaults to `''`.
		* }
		*
		* @return string
		*
		* @see Wpx\Wpx\v0\Html::attrs
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function html_attrs ( $attrs = array() ) {
			$def_dir = null;
			$def_lang = null;

			$has_dir = ! empty( $attrs['dir'] );
			$has_lang = ! empty( $attrs['lang'] );

			// If the `dir` or `lang` is not set, then get the default values.
			if ( ! $has_dir || ! $has_lang ) {
				$dir_lang_attrs = \get_language_attributes();

				if ( ! $has_dir ) {
					preg_match( '/dir=["\']([^"\']+)["\']/', $dir_lang_attrs, $matches );
					if ( count( $matches ) === 2 ) {
						$def_dir = $matches[1];
					}
					$attrs['dir'] = $def_dir;
				}

				if ( ! $has_lang ) {
					preg_match( '/lang=["\']([^"\']+)["\']/', $dir_lang_attrs, $matches );
					if ( count( $matches ) === 2 ) {
						$def_lang = $matches[1];
					}
					$attrs['lang'] = $def_lang;
				}
			}

			$html = Html::attrs( $attrs );
			$html = \apply_filters( 'wpx_wpx_0__the_html_attrs', $html );
			return $html;
		}

		/**
		* Registers the specified script.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* Note: Using `in_footer` is only effective if `wp_footer` is called. Almost all
		* themes will call this function.
		*
		* @param array $script {
		* 	The script configuration.
		*
		* 	@type string $handle A unique name to be assigned to the script. This handle is
		* 		used when enqueuing or dequeuing the script. It is also used to reference
		* 		dependencies.
		* 	@type string $src The URL to the script.
		* 	@type string $conditional Optional. IE conditional comment condition(s). For
		* 		example, `'lte IE 9'` will cause this script to be included if the browser is
		* 		Internet Explorer version 9 or earlier.
		* 	@type string[] $deps Optional. A set of registered script handles this script
		* 		depends on. Defaults to an empty array.
		* 	@type bool $in_footer Optional. Flag indicating whether to enqueue this script
		* 		before `</body>` instead of in the `<head>`. Defaults to `true`.
		* 	@type bool|string $ver Optional. A string specifying script version number, if it
		* 		has one, which is added to the URL as a query string for cache busting purposes.
		* 		If version is set to `false`, a version number is automatically added equal to
		* 		current installed WordPress version. If `null`, no version is added. Defaults to
		* 		`null`.
		* }
		*
		* @see https://en.wikipedia.org/wiki/Conditional_comment
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function register_script ( $script ) {
			$handle = $script['handle'];
			$src = $script['src'];
			$deps = \is_array( $script['deps'] ) ? $script['deps'] : array();
			$in_footer = isset( $script['in_footer'] ) ? $script['in_footer'] : true;
			$ver = isset( $script['ver'] ) ? $script['ver'] : null;
			\wp_register_script( $handle, $src, $deps, $ver, $in_footer );

			if ( \is_string( $script['conditional'] ) ) {
				\wp_script_add_data( $handle, 'conditional', $script['conditional'] );
			}
		}

		/**
		* Registers the specified style sheet.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: Only effective if `wp_head` is called. Almost all themes will call this
		* function.
		*
		* @param array $style {
		* 	The style sheet configuration.
		*
		* 	@type string $handle A unique name to be assigned to the style sheet. This handle
		* 		is used when enqueuing or dequeuing the script. It is also used to reference
		* 		dependencies.
		* 	@type string $src The URL to the style sheet.
		* 	@type string[] $deps Optional. A set of registered style handles this style sheet
		* 		depends on. Defaults to an empty array.
		* 	@type string $media The media query string determining when the styles in the
		* 		style sheet should be applied. Defaults to `'all'`.
		* 	@type bool|string $ver Optional. A string specifying style sheet version number,
		* 		if it has one, which is added to the URL as a query string for cache busting
		* 		purposes. If version is set to `false`, a version number is automatically added
		* 		equal to current installed WordPress version. If `null`, no version is added.
		* 		Defaults to `null`.
		* }
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function register_style ( $style ) {
			$handle = $style['handle'];
			$src = $style['src'];
			$deps = \is_array( $style['deps'] ) ? $style['deps'] : array();
			$ver = isset( $style['ver'] ) ? $style['ver'] : null;
			$media = isset( $style['media'] ) ? $style['media'] : 'all';
			\wp_register_style( $handle, $src, $deps, $ver, $media );
		}

		/**
		* Outputs the `body` tag's attributes.
		*
		* Note: `get_body_class` is called to get the body class attribute from WP based
		* on the current request.
		* Note: Use the standard `body_class` filter to filter the `class` attribute.
		*
		* @param array $attrs {
		* 	The `body` tag attributes.
		*
		* 	@type string|string[] $class Optional. CSS class(es) to add to the `body` tag.
		* 		Defaults to `''`.
		* }
		*
		* @see Wpx\Wpx\v0\WpHtml::body_attrs
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function the_body_attrs ( $attrs = array() ) {
			$html = self::body_attrs( $attrs );
			echo $html;
		}

		/**
		* Outputs the `html` tag's attributes.
		*
		* @param array $attrs {
		* 	The `html` tag attributes.
		*
		* 	@type string|string[] $class Optional. CSS class(es) to add to the `html` tag.
		* 		Defaults to `''`.
		* }
		*
		* @see Wpx\Wpx\v0\Html::attrs
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function the_html_attrs ( $attrs = array() ) {
			$html = self::html_attrs( $attrs );
			echo $html;
		}

	} // eo class WpHtml

} // eo if ( class_exists )
