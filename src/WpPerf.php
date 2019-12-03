<?php
namespace Wpx\Wpx\v0;

if ( ! class_exists( __NAMESPACE__ . '\WpPerf' ) ) {

	class WpPerf {

		// TODO: Test that the extra memory overhead of these functions is worth the
		// performance gain.

		/**
		* Retrieve stylesheet directory path for current theme.
		*
		* A high-performance (i.e., memoized) version of WordPress's
		* `get_stylesheet_directory`. The internal functions and filters will only be
		* called once per request instead of each time this function is called. The style
		* sheet directory shouldn't be changing during the request.
		*
		* @see https://developer.wordpress.org/reference/functions/get_stylesheet_directory/
		*/
		public static function get_stylesheet_directory () {
			static $dir;

			if ( ! $dir ) {
				$dir = get_stylesheet_directory();
			}

			return $dir;
		}

		/**
		* Retrieve stylesheet directory URI.
		*
		* A high-performance (i.e., memoized) version of WordPress's
		* `get_stylesheet_directory_uri`. The internal functions and filters will only be
		* called once per request instead of each time this function is called. The style
		* sheet directory URI shouldn't be changing during the request.
		*
		* @see https://developer.wordpress.org/reference/functions/get_stylesheet_directory_uri/
		*/
		public static function get_stylesheet_directory_uri () {
			static $uri;

			if ( ! $uri ) {
				$uri = get_stylesheet_directory_uri();
			}

			return $uri;
		}

		/**
		* Retrieves the URI of current theme stylesheet.
		*
		* A high-performance (i.e., memoized) version of WordPress's `get_stylesheet_uri`.
		* The internal functions and filters will only be called once per request instead
		* of each time this function is called. The style sheet URI shouldn't be changing
		* during the request.
		*
		* @see https://developer.wordpress.org/reference/functions/get_stylesheet_uri/
		*/
		public static function get_stylesheet_uri () {
			static $uri;

			if ( ! $uri ) {
				$uri = get_stylesheet_uri();
			}

			return $uri;
		}

		/**
		* Retrieve current theme directory.
		*
		* A high-performance (i.e., memoized) version of WordPress's
		* `get_template_directory`. The internal functions and filters will only be called
		* once per request instead of each time this function is called. The template
		* directory shouldn't be changing during the request.
		*
		* @see https://developer.wordpress.org/reference/functions/get_template_directory/
		*/
		public static function get_template_directory () {
			static $dir;

			if ( ! $dir ) {
				$dir = get_template_directory();
			}

			return $dir;
		}

		/**
		* Retrieve theme directory URI.
		*
		* A high-performance (i.e., memoized) version of WordPress's
		* `get_template_directory_uri`. The internal functions and filters will only be
		* called once per request instead of each time this function is called. The
		* template directory URI shouldn't be changing during the request.
		*
		* @see https://developer.wordpress.org/reference/functions/get_template_directory_uri/
		*/
		public static function get_template_directory_uri () {
			static $uri;

			if ( ! $uri ) {
				$uri = get_template_directory_uri();
			}

			return $uri;
		}

	} // eo class WpPerf

} // eo if ( class_exists )
