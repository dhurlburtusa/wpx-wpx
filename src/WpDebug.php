<?php
namespace Wpx;

require_once __DIR__ . '/bootstrap.php';

use function \Wpx\__404_and_die;

if ( ! class_exists( __NAMESPACE__ . '\WpDebug' ) ) {

	/**
	 * The WP debug class.
	 *
	 * Use to help with debugging/troubleshooting.
	 */
	class WpDebug {
		private static $log_separator = '================================================================================';

		/**
		* Logs information about the request.
		*
		* This should be called as early in the request as possible. The earliest possible
		* would be in a must-use plugin since it depends on most of WordPress core being
		* loaded first.
		*
		* In order for logging to take place, be sure `WP_DEBUG` has been defined as true.
		* This is usually done in `wp-config.php`.
		*
		* @param array $config {
		*     The configuration.
		*
		*     @type bool $execution_time Optional. Flag indicating whether to log the
		*       approximate request execution time. Note: It will only include the time
		*       from when this function is called to the end of the request. So, call this
		*       function as soon as possible. Defaults to true.
		*     @type bool $blog_feed Optional. The WP blog feed configuration. See
		*       `\Wpx\configure_blog_feed` for details.
		* }
		*/
		public static function log_request_info ( $config = array() ) {
			$execution_time = isset( $config['execution_time'] ) ? $config['execution_time'] : true;
			$peak_memory_use = isset( $config['peak_memory_use'] ) ? $config['peak_memory_use'] : true;

			error_log( '/** ' . self::$log_separator );

			if ( $execution_time === true || $peak_memory_use === true ) {

				register_shutdown_function( function () use ( $execution_time, $peak_memory_use ) {
					global $timestart, $wpx;

					if ( $execution_time ) {
						$starttime = $wpx['state']['request']['start'];
						if ( is_numeric( $timestart ) && $timestart < $starttime ) {
							$starttime = $timestart;
						}
						$endtime = $wpx['state']['request']['end'];

						if ( ! is_numeric( $endtime ) ) {
							$endtime = $wpx['state']['request']['end'] = microtime( true );
						}

						$duration_us = number_format( 1000000 * ($endtime - $starttime) );

						error_log( "Approx. request execution time: {$duration_us} μs." );
					}

					if ( $peak_memory_use ) {
						// Note: The following requires PHP 5.2.1 or later.
						error_log( 'Approx. peak memory Use: ' . number_format( memory_get_peak_usage() ) . ' bytes.' );
						// error_log( 'Approx. memory Use: ' . number_format( memory_get_usage() ) . ' bytes.' );
					}

					error_log( self::$log_separator . " */\n" );
				} );
			} // eo if
		} // eo function

	} // eo class WpDebug

} // eo if ( class_exists )
