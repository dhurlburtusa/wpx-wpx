<?php
namespace Wpx\v0;

if ( ! defined( 'WPX_WPX_0__VERSION' ) ) {
	define( 'WPX_WPX_0__VERSION', '0.0.0-alpha.14' );

	function __404_and_die () {
		// Implementation Note: Not using WP's `status_header` function here so that this
		// file may be included in `wp-config.php`. That is, `status_header` won't exist
		// when `wp-config.php` is included.
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
			$protocol = 'HTTP/1.0';
		}
		@header( "$protocol 404 Not Found", /* replace */ true, 404 );
		die();
	}

	/*
	 * Determines whether the specified string ends with a specified string.
	 *
	 * Unfortunately, PHP doesn't come with an equivalent function.
	 *
	 * @param string $haystack The string to be examined.
	 * @param string $needle The string to look for at the end of the haystack.
	 *
	 * @return bool true if the haystack ends with the needle, false otherwise.
	 */
	function __ends_with ( $haystack, $needle ) {
		return substr_compare( $haystack, $needle, -strlen( $needle )) === 0;
	}

}
