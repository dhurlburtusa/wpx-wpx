<?php

namespace Wpx\Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

use function Wpx\Wpx\v0\__ends_with;

if ( ! \class_exists( __NAMESPACE__ . '\Is' ) ) {

	class Is {

		/**
		* Determines whether the current request is running in a local environment.
		*
		* It is common for a virtual host to be set up locally using a domain
		* (aka hostname) that ends with `.local`. That is, `.local` is used as the
		* top-level domain. Based on this fact, a local environment is determined as
		* follows:
		*
		* - If the server IP address (`$_SERVER['SERVER_ADDR']`) is `127.0.0.1`, then we are
		* 	local.
		*
		* - If the host name (`$_SERVER['HTTP_HOST']`) or the server name
		* 	(`$_SERVER['SERVER_NAME']`) ends with `.local`, then we are local.
		*
		* @return bool true if determined to be local, false otherwise.
		*/
		public static function local () {
			// When running WP-CLI, the `$_SERVER variable` exists but many values are not set.
			// Therefore, we need to check whether the value is set before reading it. Otherwise
			// an error occurs.
			$is_local = (
				( isset( $_SERVER['SERVER_ADDR'] ) && $_SERVER['SERVER_ADDR'] === '127.0.0.1' ) ||
				( isset( $_SERVER['HTTP_HOST'] ) && __ends_with( $_SERVER['HTTP_HOST'], '.local' ) ) ||
				( isset( $_SERVER['SERVER_NAME'] ) && __ends_with( $_SERVER['SERVER_NAME'], '.local' ) )
			);
			return $is_local;
		}

		/**
		* Determines whether the request is for one of the authentication pages.
		*
		* @return bool true if the request if for one of the authentication pages, false
		*   otherwise.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function wp_authentication () {
			return $GLOBALS['pagenow'] === 'wp-login.php';
		}

		/**
		* Determines whether the current request is an autosave request.
		*
		* @return bool
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function wp_autosave () {
			// Note: Confirmed there is not an equivalent function in WP core as of version
			// 5.2.4.
			$is_autosave = \defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE;
			return $is_autosave;
		}

		/**
		* Determines whether the current request is a REST request.
		*
		* @return bool
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function wp_rest () {
			// Note: Confirmed there is not an equivalent function in WP core as of version
			// 5.2.4.
			$is_rest = \defined( 'REST_REQUEST' ) && REST_REQUEST;
			return $is_rest;
		}

		/**
		* Determines whether the request is for XML-RPC.
		*
		* Plugins and themes are loaded and run even during an XML-RPC request. This can
		* be used to minimize work done in plugins or themes.
		*
		* @return bool true if is an XML-RPC request, false otherwise.
		*/
		// phpcs:ignore PSR1.Methods.CamelCapsMethodName.NotCamelCaps
		public static function wp_xmlrpc () {
			$is_xmlrpc = \defined( 'XMLRPC_REQUEST' );
			return $is_xmlrpc;
		}

	}
}
