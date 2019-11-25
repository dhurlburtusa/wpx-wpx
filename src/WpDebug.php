<?php
namespace Wpx\v0;

require_once __DIR__ . '/bootstrap.php';

if ( ! class_exists( __NAMESPACE__ . '\WpDebug' ) ) {

	/**
	 * The WP debug class.
	 *
	 * Use to help with debugging/troubleshooting.
	 */
	class WpDebug {
		private static $log_separator = '================================================================================';

		private static $state;

		private static function &__get_state () {
			if ( ! is_array( self::$state ) ) {
				self::$state = array(
					'log_request_info_called' => false,
					'mu_plugins' => array(
						'snapshots' => array(
							// Each item will be like the following.
							// array( 'id' => string, 'endtime' => float, '_mem_usage' => int )
						),
					),
					'network_plugins' => array(
						'snapshots' => array(
							// Each item will be like the following.
							// array( 'id' => string, 'endtime' => float, '_mem_usage' => int )
						),
					),
					'plugins' => array(
						// '_pre_mem_usage' => int,
						'_skip_' => false,
						'snapshots' => array(
							// Each item will be like the following.
							// array( 'id' => string, 'endtime' => float, '_mem_usage' => int )
						),
						// 'starttime' => float,
					),
					'theme' => array(
						// 'starttime' => float,
						// 'endtime' => float,
						// '_pre_mem_usage' => int,
						// '_post_mem_usage' => int,
					),
					'request' => array(
						// '_pre_mem_usage' => int,
						'starttime' => microtime( true ),
						'endtime' => null,
					),
				);
			}

			return self::$state;
		}

		/**
		 * Echos the current WP Cache stats.
		 *
		 * By default, WordPress uses its own object caching mechanism. If this default
		 * has not been changed, then the current WP Cache stats will be echoed.
		 *
		 * This can be used as a WordPress shutdown action.
		 *
		 *     register_shutdown_function( function () {
		 *     	WpDebug::echo_wp_object_cache_stats();
		 *     } );
		 */
		public static function echo_wp_object_cache_stats_html () {
			global $wp_object_cache;

			if ( is_object( $wp_object_cache ) ) {
				$wp_object_cache->stats();
			}
		}

		/**
		 * Generates the current WP Cache stats as HTML.
		 *
		 * By default, WordPress uses its own object caching mechanism. If this default
		 * has not been changed, then the current WP Cache stats will be formatted with
		 * HTML and returned.
		 *
		 * @return {string}
		 */
		public static function get_wp_object_cache_stats_html () {
			global $wp_object_cache;

			$wp_object_cache_stats_html = '';
			if ( is_object( $wp_object_cache ) ) {
				ob_start();
				$wp_object_cache->stats();
				$wp_object_cache_stats_html = ob_get_contents();
				ob_end_clean();
			}
			return $wp_object_cache_stats_html;
		}

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
		*     Optional. The configuration.
		*
		*     @type array $mu_plugins {
		*       Optional. The must-use plugin configuration.
		*
		*       @type bool $load_time Optional. Flag indicating whether to track and log the time
		*         each must-use plugin takes to load.
		*       @type bool $memory_delta Optional. Flag indicating whether to track and log the
		*         change in memory usage for each loaded must-use plugin.
		*     }
		*     @type array $network_plugins {
		*       Optional. The network plugin configuration. (Only applies in a multi-site setup.)
		*
		*       @type bool $load_time Optional. Flag indicating whether to track and log the time
		*         each network plugin takes to load.
		*       @type bool $memory_delta Optional. Flag indicating whether to track and log the
		*         change in memory usage for each loaded network plugin.
		*     }
		*     @type array $plugins {
		*       Optional. The regular plugin configuration.
		*
		*       @type bool $load_time Optional. Flag indicating whether to track and log the time
		*         each regular plugin takes to load.
		*       @type bool $memory_delta Optional. Flag indicating whether to track and log the
		*         change in memory usage for each loaded regular plugin.
		*     }
		*     @type array $request {
		*       Optional. The request configuration.
		*
		*       @type bool $execution_time Optional. Flag indicating whether to track and log the
		*         execution time of the request.
		*       @type bool $peak_memory_use Optional. Flag indicating whether to track and log the
		*         peak memory usage of the request.
		*     }
		*     @type array $theme {
		*       Optional. The theme configuration.
		*
		*       @type bool $load_time Optional. Flag indicating whether to track and log the time
		*         the theme (both child and parent if applicable) takes to load.
		*       @type bool $memory_delta Optional. Flag indicating whether to track and log the
		*         change in memory usage for loading the theme (both child and parent if
		*         applicable).
		*     }
		* }
		*/
		public static function log_request_info ( $config = array() ) {
			$state = self::__get_state();

			if ( $state['log_request_info_called'] ) {
				error_log('`WpDebug::log_request_info` needlessly called multiple times.');
				return;
			}

			self::$state['log_request_info_called'] = true;

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
			if ( $mu_plugins_mem_delta || $network_plugins_mem_delta || $plugins_mem_delta ) {
				if ( ! isset( $state['request']['_pre_mem_usage'] ) ) {
					$state['request']['_pre_mem_usage'] = memory_get_usage();
				}
			}

			// Ensure wp-includes/plugin.php has already been loaded.
			if ( function_exists( 'add_action' ) ) {

				if ( $mu_plugins_load_time || $mu_plugins_mem_delta ) {
					add_action( 'mu_plugin_loaded', function ( $mu_plugin ) use ( &$state, $mu_plugins_load_time, $mu_plugins_mem_delta ) {
						$snapshot = array(
							'id' => str_replace( WPMU_PLUGIN_DIR . '/', '', $mu_plugin ),
						);

						if ( $mu_plugins_load_time ) {
							$snapshot['endtime'] = microtime( true );
						}

						if ( $mu_plugins_mem_delta ) {
							$snapshot['_mem_usage'] = memory_get_usage();
						}

						$state['mu_plugins']['snapshots'][] = $snapshot;
					}, 1 );
				}

				if ( $network_plugins_load_time || $network_plugins_mem_delta ) {
					add_action( 'network_plugin_loaded', function ( $network_plugin ) use ( &$state, $network_plugins_load_time, $network_plugins_mem_delta ) {
						$snapshot = array(
							'id' => str_replace( WP_PLUGIN_DIR . '/', '', $network_plugin ),
						);

						if ( $network_plugins_load_time ) {
							$snapshot['endtime'] = microtime( true );
						}

						if ( $network_plugins_mem_delta ) {
							$snapshot['_mem_usage'] = memory_get_usage();
						}

						$state['network_plugins']['snapshots'][] = $snapshot;
					}, 1 );
				}

				if ( $plugins_load_time || $plugins_mem_delta ) {
					add_action( 'muplugins_loaded', function () use ( &$state, $plugins_load_time, $plugins_mem_delta ) {
						// HACK: The `active_plugins` option is retrieved just before WP iterates over the
						// active plugins. We are taking advantage of that fact to get the most accurate
						// `_pre_mem_usage` and `starttime`.
						add_filter( 'pre_option_active_plugins', function ( $pre ) use ( &$state, $plugins_load_time, $plugins_mem_delta ) {
							if ( ! $state['plugins']['_skip_'] ) {
								if ( $plugins_mem_delta ) {
									$state['plugins']['_pre_mem_usage'] = memory_get_usage();
								}

								if ( $plugins_load_time ) {
									$state['plugins']['starttime'] = microtime( true );
								}
							}
							// `$pre` not being `false` is an indication that another
							// `pre_option_active_plugins` filter was run that returned a value that represents
							// the active plugins. Setting `_skip_` to true ensures that the
							// `option_active_plugins` filter does not change the `_pre_mem_usage` or
							// `starttime` values. This is probably completely unnecessary. If `$pre` is not
							// false, then the `option_active_plugins` should not be triggered. This is left in
							// for robustness.
							if ( $pre !== false ) {
								$state['plugins']['_skip_'] = true;
							}
							return $pre;
						}, 9999 );
						add_filter( 'option_active_plugins', function ( $value ) use ( &$state, $plugins_load_time, $plugins_mem_delta ) {
							if ( ! $state['plugins']['_skip_'] ) {
								if ( $plugins_mem_delta ) {
									$state['plugins']['_pre_mem_usage'] = memory_get_usage();
								}

								if ( $plugins_load_time ) {
									$state['plugins']['starttime'] = microtime( true );
								}
								$state['plugins']['_skip_'] = true;
							}
							return $value;
						}, 9999 );

						if ( $plugins_mem_delta ) {
							$state['plugins']['_pre_mem_usage'] = memory_get_usage();
						}

						if ( $plugins_load_time ) {
							$state['plugins']['starttime'] = microtime( true );
						}
					}, 9999 );

					add_action( 'plugin_loaded', function ( $plugin ) use ( &$state, $plugins_load_time, $plugins_mem_delta ) {
						$state['plugins']['_skip_'] = true; // Left in for robustness, but is probably unnecessary.
						$snapshot = array(
							'id' => str_replace( WP_PLUGIN_DIR . '/', '', $plugin ),
						);

						if ( $plugins_load_time ) {
							$snapshot['endtime'] = microtime( true );
						}

						if ( $plugins_mem_delta ) {
							$snapshot['_mem_usage'] = memory_get_usage();
						}

						$state['plugins']['snapshots'][] = $snapshot;
					}, 1 );
				}

				if ( $theme_load_time || $theme_mem_delta ) {
					add_action( 'setup_theme', function () use ( &$state, $theme_load_time, $theme_mem_delta ) {
						if ( $theme_load_time ) {
							$state['theme']['starttime'] = microtime( true );
						}

						if ( $theme_mem_delta ) {
							$state['theme']['_pre_mem_usage'] = memory_get_usage();
						}
					}, 9999 );

					add_action( 'after_setup_theme', function () use ( &$state, $theme_load_time, $theme_mem_delta ) {
						if ( $theme_load_time ) {
							$state['theme']['endtime'] = microtime( true );
						}
						if ( $theme_mem_delta ) {
							$state['theme']['_post_mem_usage'] = memory_get_usage();
						}
					}, 9999 );
				}
			}
			else {
				trigger_error( __( '`log_request_info` MUST not be called before the core of WP is loaded. The earliest `log_request_info` may be called is in a must-use plugin, the recommended location.' ) );
			}

			if (
				$req_exec_time ||
				$req_peak_mem_use ||
				$mu_plugins_load_time ||
				$mu_plugins_mem_delta ||
				$plugins_load_time ||
				$plugins_mem_delta ||
				$theme_load_time ||
				$theme_mem_delta ||
				$network_plugins_load_time ||
				$network_plugins_mem_delta
			) {
				register_shutdown_function( function () use ( &$state, $mu_plugins_load_time, $mu_plugins_mem_delta, $network_plugins_load_time, $network_plugins_mem_delta, $plugins_load_time, $plugins_mem_delta, $req_exec_time, $req_peak_mem_use, $theme_load_time, $theme_mem_delta ) {
					// Note: `$timestart` is a global added by WP.
					global $timestart;

					$req_starttime = $state['request']['starttime'];
					$req_pre_mem_usage = isset( $state['request']['_pre_mem_usage'] ) ? $state['request']['_pre_mem_usage'] : 0;
					if ( is_numeric( $timestart ) && $timestart < $req_starttime ) {
						$req_starttime = $timestart;
					}

					// There are no (or no reliable) hooks to use to get a snapshot of the time just
					// before the must-use plugins begin loading. So, we fallback to the most recent
					// the start of the request according to WPX or according to WP.
					$mu_plugins_starttime = isset( $state['mu_plugins']['starttime'] ) ? $state['mu_plugins']['starttime'] : $req_starttime;
					if ( is_numeric( $timestart ) && $timestart > $mu_plugins_starttime ) {
						$mu_plugins_starttime = $timestart;
					}
					$mu_plugins_pre_mem_usage = $req_pre_mem_usage;

					$mu_plugins_snapshots = $state['mu_plugins']['snapshots'];
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

					$network_plugins_starttime = isset( $state['network_plugins']['starttime'] ) ? $state['network_plugins']['starttime'] : $req_starttime;
					if ( is_numeric( $timestart ) && $timestart > $network_plugins_starttime ) {
						$network_plugins_starttime = $timestart;
					}
					if ( $mu_plugins_snapshot_count > 0 ) {
						$last_mu_plugin_endtime = $state['mu_plugins']['snapshots'][$mu_plugins_snapshot_count - 1]['endtime'];
						if ( $last_mu_plugin_endtime > $network_plugins_starttime ) {
							$network_plugins_starttime = $last_mu_plugin_endtime;
						}
					}

					$network_plugins_pre_mem_usage = $mu_plugins_pre_mem_usage;
					if ( $mu_plugins_snapshot_count > 0 ) {
						$network_plugins_pre_mem_usage = $state['mu_plugins']['snapshots'][$mu_plugins_snapshot_count - 1]['_mem_usage'];
					}

					$network_plugins_snapshots = $state['network_plugins']['snapshots'];
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

					$plugins_snapshots = $state['plugins']['snapshots'];
					$plugins_snapshot_count = count( $plugins_snapshots );

					if ( $plugins_load_time || $plugins_mem_delta ) {
						if ( $plugins_load_time ) {
							$prev_plugin_endtime = $state['plugins']['starttime'];
						}
						if ( $plugins_mem_delta ) {
							$prev_plugin_mem_usage = $state['plugins']['_pre_mem_usage'];
						}
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
							$duration_us = number_format( 1000000 * ($endtime - $state['plugins']['starttime']) );

							error_log( "Loading {$plugins_snapshot_count} regular plugins took about {$duration_us} μs." );
						}
					}

					if ( $plugins_mem_delta ) {
						// If there is one or fewer, then don't both logging duplicate information.
						if ( $plugins_snapshot_count > 1 ) {
							$memory_delta = $plugins_snapshots[$plugins_snapshot_count - 1]['_mem_usage'] - $state['plugins']['_pre_mem_usage'];

							error_log( "Loading {$plugins_snapshot_count} regular plugins changed memory use by " . number_format( $memory_delta ) . ' bytes.' );
						}
					}

					if ( $theme_load_time ) {
						$load_time_us = 1000000 * ( $state['theme']['endtime'] - $state['theme']['starttime'] );

						error_log( "Loading current theme took about " . number_format( $load_time_us ) . ' μs.' );
					}

					if ( $theme_mem_delta ) {
						$memory_delta = $state['theme']['_post_mem_usage'] - $state['theme']['_pre_mem_usage'];
						error_log( "Loading current theme changed memory use by " . number_format( $memory_delta ) . ' bytes.' );
					}

					if ( $req_exec_time ) {
						$endtime = $state['request']['endtime'];
						if ( ! is_numeric( $endtime ) ) {
							$endtime = $state['request']['endtime'] = microtime( true );
						}

						$duration_us = number_format( 1000000 * ($endtime - $req_starttime) );

						error_log( "Request execution took about {$duration_us} μs." );
					}

					if ( $req_peak_mem_use ) {
						// Note: The following requires PHP 5.2.1 or later.
						error_log( 'Request execution used ' . number_format( memory_get_peak_usage() ) . ' bytes.' );
					}

					// error_log( '$state: ' . print_r( $state, true ) );

					error_log( self::$log_separator . " */\n" );
				} );
			} // eo if
			else {
				register_shutdown_function( function () {
					error_log( self::$log_separator . " */\n" );
				} );
			}
		} // eo function

	} // eo class WpDebug

} // eo if ( class_exists )
