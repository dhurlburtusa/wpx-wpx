<?php
namespace Wpx;

require_once __DIR__ . '/bootstrap.php';

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
			global $wpx;

			$mu_plugins_config = isset( $config['mu_plugins'] ) ? $config['mu_plugins'] : null;
			if ( is_array( $mu_plugins_config ) ) {
				$mu_plugins_load_time = isset( $mu_plugins_config['load_time'] ) ? $mu_plugins_config['load_time'] : true;
				$mu_plugins_mem_delta = isset( $mu_plugins_config['memory_delta'] ) ? $mu_plugins_config['memory_delta'] : true;
			}
			else {
				$mu_plugins_load_time = true;
				$mu_plugins_mem_delta = true;
			}

			$network_plugins_config = isset( $config['network_plugins'] ) ? $config['network_plugins'] : null;
			if ( is_array( $network_plugins_config ) ) {
				$network_plugins_load_time = isset( $network_plugins_config['load_time'] ) ? $network_plugins_config['load_time'] : true;
				$network_plugins_mem_delta = isset( $network_plugins_config['memory_delta'] ) ? $network_plugins_config['memory_delta'] : true;
			}
			else {
				$network_plugins_load_time = true;
				$network_plugins_mem_delta = true;
			}

			$plugins_config = isset( $config['plugins'] ) ? $config['plugins'] : null;
			if ( is_array( $plugins_config ) ) {
				$plugins_load_time = isset( $plugins_config['load_time'] ) ? $plugins_config['load_time'] : true;
				$plugins_mem_delta = isset( $plugins_config['memory_delta'] ) ? $plugins_config['memory_delta'] : true;
			}
			else {
				$plugins_load_time = true;
				$plugins_mem_delta = true;
			}

			$request_config = isset( $config['request'] ) ? $config['request'] : null;
			if ( is_array( $request_config ) ) {
				$req_exec_time = isset( $request_config['execution_time'] ) ? $request_config['execution_time'] : true;
				$req_peak_mem_use = isset( $request_config['peak_memory_use'] ) ? $request_config['peak_memory_use'] : true;
			}
			else {
				$req_exec_time = true;
				$req_peak_mem_use = true;
			}

			$theme_config = isset( $config['theme'] ) ? $config['theme'] : null;
			if ( is_array( $theme_config ) ) {
				$theme_load_time = isset( $theme_config['load_time'] ) ? $theme_config['load_time'] : true;
				$theme_mem_delta = isset( $theme_config['memory_delta'] ) ? $theme_config['memory_delta'] : true;
			}
			else {
				$theme_load_time = true;
				$theme_mem_delta = true;
			}

			error_log( '/** ' . self::$log_separator );

			// Note: The following is not done when `theme_mem_delta` is true because the `setup_theme`
			// action allows us to accurately set the pre-memory usage for the theme.
			if ( $mu_plugins_mem_delta === true || $network_plugins_mem_delta === true || $plugins_mem_delta === true ) {
				if ( ! isset( $wpx['state']['request']['_pre_mem_usage'] ) ) {
					$wpx['state']['request']['_pre_mem_usage'] = memory_get_usage();
				}
			}

			// Ensure wp-includes/plugin.php has already been loaded.
			if ( function_exists( 'add_action' ) ) {

				if ( $mu_plugins_load_time === true || $mu_plugins_mem_delta === true ) {
					add_action( 'mu_plugin_loaded', function ( $mu_plugin ) use ( $mu_plugins_load_time, $mu_plugins_mem_delta ) {
						global $wpx;

						$snapshot = array(
							'id' => str_replace( WPMU_PLUGIN_DIR . '/', '', $mu_plugin ),
						);

						if ( $mu_plugins_load_time ) {
							$snapshot['endtime'] = microtime( true );
						}

						if ( $mu_plugins_mem_delta ) {
							$snapshot['_mem_usage'] = memory_get_usage();
						}

						$wpx['state']['mu_plugins']['snapshots'][] = $snapshot;
					}, 1 );
				}

				if ( $network_plugins_load_time === true || $network_plugins_mem_delta === true ) {
					add_action( 'network_plugin_loaded', function ( $network_plugin ) use ( $network_plugins_load_time, $network_plugins_mem_delta ) {
						global $wpx;

						$snapshot = array(
							'id' => str_replace( WP_PLUGIN_DIR . '/', '', $network_plugin ),
						);

						if ( $network_plugins_load_time ) {
							$snapshot['endtime'] = microtime( true );
						}

						if ( $network_plugins_mem_delta ) {
							$snapshot['_mem_usage'] = memory_get_usage();
						}

						$wpx['state']['network_plugins']['snapshots'][] = $snapshot;
					}, 1 );
				}

				if ( $plugins_load_time === true || $plugins_mem_delta === true ) {
					add_action( 'plugin_loaded', function ( $plugin ) use ( $plugins_load_time, $plugins_mem_delta ) {
						global $wpx;

						$snapshot = array(
							'id' => str_replace( WP_PLUGIN_DIR . '/', '', $plugin ),
						);

						if ( $plugins_load_time ) {
							$snapshot['endtime'] = microtime( true );
						}

						if ( $plugins_mem_delta ) {
							$snapshot['_mem_usage'] = memory_get_usage();
						}

						$wpx['state']['plugins']['snapshots'][] = $snapshot;
					}, 1 );
				}

				if ( $theme_load_time || $theme_mem_delta ) {
					add_action( 'setup_theme', function () use ( $theme_load_time, $theme_mem_delta ) {
						global $wpx;

						if ( $theme_load_time ) {
							$wpx['state']['theme']['starttime'] = microtime( true );
						}

						if ( $theme_mem_delta ) {
							$wpx['state']['theme']['_pre_mem_usage'] = memory_get_usage();
						}
					}, 9999 );

					add_action( 'after_setup_theme', function () use ( $theme_load_time, $theme_mem_delta ) {
						global $wpx;

						if ( $theme_load_time ) {
							$wpx['state']['theme']['endtime'] = microtime( true );
						}
						if ( $theme_mem_delta ) {
							$wpx['state']['theme']['_post_mem_usage'] = memory_get_usage();
						}
					}, 9999 );
				}
			}
			else {
				trigger_error( __( '`log_request_info` MUST not be called before the core of WP is loaded. The earliest `log_request_info` may be called is in a must-use plugin, the recommended location.' ) );
			}

			if (
				$req_exec_time === true ||
				$req_peak_mem_use === true ||
				$mu_plugins_load_time === true ||
				$mu_plugins_mem_delta === true ||
				$plugins_load_time === true ||
				$plugins_mem_delta === true ||
				$theme_load_time === true ||
				$theme_mem_delta === true ||
				$network_plugins_load_time === true ||
				$network_plugins_mem_delta === true
			) {
				register_shutdown_function( function () use ( $mu_plugins_load_time, $mu_plugins_mem_delta, $network_plugins_load_time, $network_plugins_mem_delta, $plugins_load_time, $plugins_mem_delta, $req_exec_time, $req_peak_mem_use, $theme_load_time, $theme_mem_delta ) {
					// Note: `$timestart` is a global added by WP.
					global $timestart, $wpx;

					$req_starttime = $wpx['state']['request']['starttime'];
					$req_pre_mem_usage = $wpx['state']['request']['_pre_mem_usage'];
					if ( is_numeric( $timestart ) && $timestart < $req_starttime ) {
						$req_starttime = $timestart;
					}

					// There are no (or no reliable) hooks to use to get a snapshot of the time just
					// before the must-use plugins begin loading. So, we fallback to the most recent
					// the start of the request according to WPX or according to WP.
					$mu_plugins_starttime = isset( $wpx['state']['mu_plugins']['starttime'] ) ? $wpx['state']['mu_plugins']['starttime'] : $req_starttime;
					if ( is_numeric( $timestart ) && $timestart > $mu_plugins_starttime ) {
						$mu_plugins_starttime = $timestart;
					}
					$mu_plugins_pre_mem_usage = $req_pre_mem_usage;

					$mu_plugins_snapshots = $wpx['state']['mu_plugins']['snapshots'];
					$mu_plugins_snapshot_count = count( $mu_plugins_snapshots );

					if ( $mu_plugins_load_time || $mu_plugins_mem_delta ) {
						$prev_mu_plugin_endtime = $mu_plugins_starttime;
						$prev_mu_plugin_mem_usage = $mu_plugins_pre_mem_usage;
						foreach ( $mu_plugins_snapshots as $snapshot ) {
							$mu_plugin_id = $snapshot['id'];

							if ( $mu_plugins_load_time ) {
								$load_time_us = 1000000 * ( $snapshot['endtime'] - $prev_mu_plugin_endtime );

								error_log( "Loading {$mu_plugin_id} took about " . number_format( $load_time_us ) . ' μs.' );

								$prev_mu_plugin_endtime = $snapshot['endtime'];
							}

							if ( $mu_plugins_mem_delta ) {
								$memory_delta = $snapshot['_mem_usage'] - $prev_mu_plugin_mem_usage;
								error_log( "Loading {$mu_plugin_id} changed memory use by " . number_format( $memory_delta ) . ' bytes.' );

								$prev_mu_plugin_mem_usage = $snapshot['_mem_usage'];
							}
						}
					}

					if ( $mu_plugins_load_time ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $mu_plugins_snapshot_count > 1 ) {
							$endtime = $mu_plugins_snapshots[$mu_plugins_snapshot_count - 1]['endtime'];
							$duration_us = number_format( 1000000 * ($endtime - $mu_plugins_starttime) );

							error_log( "Loading {$mu_plugins_snapshot_count} must-use plugins took about {$duration_us} μs." );
						}
					}

					if ( $mu_plugins_mem_delta ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $mu_plugins_snapshot_count > 1 ) {
							$memory_delta = $mu_plugins_snapshots[$mu_plugins_snapshot_count - 1]['_mem_usage'] - $mu_plugins_pre_mem_usage;

							error_log( "Loading {$mu_plugins_snapshot_count} must-use plugins changed memory use by " . number_format( $memory_delta ) . ' bytes.' );
						}
					}

					$network_plugins_starttime = isset( $wpx['state']['network_plugins']['starttime'] ) ? $wpx['state']['network_plugins']['starttime'] : $req_starttime;
					if ( is_numeric( $timestart ) && $timestart > $network_plugins_starttime ) {
						$network_plugins_starttime = $timestart;
					}
					if ( $mu_plugins_snapshot_count > 0 ) {
						$last_mu_plugin_endtime = $wpx['state']['mu_plugins']['snapshots'][$mu_plugins_snapshot_count - 1]['endtime'];
						if ( $last_mu_plugin_endtime > $network_plugins_starttime ) {
							$network_plugins_starttime = $last_mu_plugin_endtime;
						}
					}

					$network_plugins_pre_mem_usage = $mu_plugins_pre_mem_usage;
					if ( $mu_plugins_snapshot_count > 0 ) {
						$network_plugins_pre_mem_usage = $wpx['state']['mu_plugins']['snapshots'][$mu_plugins_snapshot_count - 1]['_mem_usage'];
					}

					$network_plugins_snapshots = $wpx['state']['network_plugins']['snapshots'];
					$network_plugins_snapshot_count = count( $network_plugins_snapshots );

					if ( $network_plugins_load_time || $network_plugins_mem_delta ) {
						$prev_network_plugin_endtime = $network_plugins_starttime;
						$prev_network_plugin_mem_usage = $network_plugins_pre_mem_usage;
						foreach ( $network_plugins_snapshots as $snapshot ) {
							$network_plugin_id = $snapshot['id'];

							if ( $network_plugins_load_time ) {
								$load_time_us = 1000000 * ( $snapshot['endtime'] - $prev_network_plugin_endtime );

								error_log( "Loading {$network_plugin_id} took about " . number_format( $load_time_us ) . ' μs.' );

								$prev_network_plugin_endtime = $snapshot['endtime'];
							}

							if ( $network_plugins_mem_delta ) {
								$memory_delta = $snapshot['_mem_usage'] - $prev_network_plugin_mem_usage;
								error_log( "Loading {$network_plugin_id} changed memory use by " . number_format( $memory_delta ) . ' bytes.' );

								$prev_network_plugin_mem_usage = $snapshot['_mem_usage'];
							}
						}
					}

					if ( $network_plugins_load_time ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $network_plugins_snapshot_count > 1 ) {
							$endtime = $network_plugins_snapshots[$network_plugins_snapshot_count - 1]['endtime'];
							$duration_us = number_format( 1000000 * ($endtime - $network_plugins_starttime) );

							error_log( "Loading {$network_plugins_snapshot_count} network plugins took about {$duration_us} μs." );
						}
					}

					if ( $network_plugins_mem_delta ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $network_plugins_snapshot_count > 1 ) {
							$memory_delta = $network_plugins_snapshots[$network_plugins_snapshot_count - 1]['_mem_usage'] - $network_plugins_pre_mem_usage;

							error_log( "Loading {$network_plugins_snapshot_count} network plugins changed memory use by " . number_format( $memory_delta ) . ' bytes.' );
						}
					}

					$plugins_starttime = isset( $wpx['state']['plugins']['starttime'] ) ? $wpx['state']['plugins']['starttime'] : $req_starttime;
					if ( is_numeric( $timestart ) && $timestart > $plugins_starttime ) {
						$plugins_starttime = $timestart;
					}
					if ( $mu_plugins_snapshot_count > 0 ) {
						$last_mu_plugin_endtime = $wpx['state']['mu_plugins']['snapshots'][$mu_plugins_snapshot_count - 1]['endtime'];
						if ( $last_mu_plugin_endtime > $plugins_starttime ) {
							$plugins_starttime = $last_mu_plugin_endtime;
						}
					}
					if ( $network_plugins_snapshot_count > 0 ) {
						$last_network_plugin_endtime = $wpx['state']['network_plugins']['snapshots'][$network_plugins_snapshot_count - 1]['endtime'];
						if ( $last_network_plugin_endtime > $plugins_starttime ) {
							$plugins_starttime = $last_network_plugin_endtime;
						}
					}

					$plugins_pre_mem_usage = $network_plugins_pre_mem_usage;
					if ( $network_plugins_snapshot_count > 0 ) {
						$plugins_pre_mem_usage = $wpx['state']['network_plugins']['snapshots'][$network_plugins_snapshot_count - 1]['_mem_usage'];
					}

					$plugins_snapshots = $wpx['state']['plugins']['snapshots'];
					$plugins_snapshot_count = count( $plugins_snapshots );

					if ( $plugins_load_time || $plugins_mem_delta ) {
						$prev_plugin_endtime = $plugins_starttime;
						$prev_plugin_mem_usage = $plugins_pre_mem_usage;
						foreach ( $plugins_snapshots as $snapshot ) {
							$plugin_id = $snapshot['id'];

							if ( $plugins_load_time ) {
								$load_time_us = 1000000 * ( $snapshot['endtime'] - $prev_plugin_endtime );

								error_log( "Loading {$plugin_id} took about " . number_format( $load_time_us ) . ' μs.' );

								$prev_plugin_endtime = $snapshot['endtime'];
							}

							if ( $plugins_mem_delta ) {
								$memory_delta = $snapshot['_mem_usage'] - $prev_plugin_mem_usage;
								error_log( "Loading {$plugin_id} changed memory use by " . number_format( $memory_delta ) . ' bytes.' );

								$prev_plugin_mem_usage = $snapshot['_mem_usage'];
							}
						}
					}

					if ( $plugins_load_time ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $plugins_snapshot_count > 1 ) {
							$endtime = $plugins_snapshots[$plugins_snapshot_count - 1]['endtime'];
							$duration_us = number_format( 1000000 * ($endtime - $plugins_starttime) );

							error_log( "Loading {$plugins_snapshot_count} network plugins took about {$duration_us} μs." );
						}
					}

					if ( $plugins_mem_delta ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $plugins_snapshot_count > 1 ) {
							$memory_delta = $plugins_snapshots[$plugins_snapshot_count - 1]['_mem_usage'] - $plugins_pre_mem_usage;

							error_log( "Loading {$plugins_snapshot_count} network plugins changed memory use by " . number_format( $memory_delta ) . ' bytes.' );
						}
					}

					if ( $theme_load_time ) {
						$load_time_us = 1000000 * ( $wpx['state']['theme']['endtime'] - $wpx['state']['theme']['starttime'] );

						error_log( "Loading current theme took about " . number_format( $load_time_us ) . ' μs.' );
					}

					if ( $theme_mem_delta ) {
						$memory_delta = $wpx['state']['theme']['_post_mem_usage'] - $wpx['state']['theme']['_pre_mem_usage'];
						error_log( "Loading current theme changed memory use by " . number_format( $memory_delta ) . ' bytes.' );
					}

					if ( $req_exec_time ) {
						$endtime = $wpx['state']['request']['endtime'];
						if ( ! is_numeric( $endtime ) ) {
							$endtime = $wpx['state']['request']['endtime'] = microtime( true );
						}

						$duration_us = number_format( 1000000 * ($endtime - $req_starttime) );

						error_log( "Request execution took about {$duration_us} μs." );
					}

					if ( $req_peak_mem_use ) {
						// Note: The following requires PHP 5.2.1 or later.
						error_log( 'Request execution used ' . number_format( memory_get_peak_usage() ) . ' bytes.' );
					}

					// error_log( 'wpx: ' . print_r( $wpx, true ) );

					error_log( self::$log_separator . " */\n" );
				} );
			} // eo if
		} // eo function

	} // eo class WpDebug

} // eo if ( class_exists )
