<?php
namespace Wpx;

require_once __DIR__ . '/__init__.php';

use function \Wpx\__404_and_die;

if ( ! class_exists( __NAMESPACE__ . '\WpConfig' ) ) {

	/*
	* Filter function used to remove the tiny mce emoji plugin.
	*
	* @param string[] $plugins
	* @return string[] The input array with `'wpemoji'` removed.
	*/
	function __remove_tiny_mce_emojis_plugin ( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}
		else {
			return array();
		}
	}

	function __set_disable_wp_cron_to_true () {
		if ( defined( 'DISABLE_WP_CRON' ) ) {
			if ( ! DISABLE_WP_CRON ) {
				trigger_error( __( '`DISABLE_WP_CRON` has already been defined and set to `false` prior to calling `configure_wp_cron`. It is not uncommon to find it set in `wp-config.php`.' ) );
			}
		}
		else {
			define( 'DISABLE_WP_CRON', true );
		}
	}

	function _wp_cron_with_exec_time () {
		global $timestart; // A WP global.

		if ( ! defined( 'DISABLE_WP_CRON' ) || ! DISABLE_WP_CRON ) {
			$starttime = is_numeric( $timestart ) ? $timestart : microtime( true );
			wp_cron();
			$endtime = microtime( true );
			$duration_us = 1000000 * ($endtime - $starttime);
			error_log("WP-Cron execution time: {$duration_us} μs");
		}
	}

	class WpConfig {

		/**
		* Configures WP behavior and functionality.
		*
		* **Example Usage**
		*
		*     use function \Wpx\configure;
		*
		*     configure([
		*     	'autop' => false,
		*     	'blog_feed' => false,
		*     	'capital_p' => false,
		*     	'emojis' => false,
		*     	'heartbeat' => [
		*     		'allow_suspension' => true,
		*     		'interval' => 60,
		*     	],
		*     	'oembed_provider_support' => false,
		*     	'plugin_and_theme_editors' => false,
		*     	'post_autosave' => [
		*     		'interval' => 30, // Save more frequently. Our data is really important.
		*     	],
		*     	'post_revisions' => [
		*     		'maximum' => 50, // We have limited database space available.
		*     	],
		*     	'rest_api' => [
		*     		'must_be_authenticated' => true,
		*     	],
		*     	'self_pinging' => false,
		*     	'texturization' => false,
		*     	'trash' => 60,
		*     	'wp_cron' => [
		*     		'disable' => true,
		*     	],
		*     	'wp_db' => [
		*     		'log_queries' => true,
		*     	],
		*     	'wp_http' => [
		*     		'access' => [
		*     			'external' => false,
		*     			'allow' => [
		*     				'api.wordpress.org',
		*     				'example.com',
		*     				// etc
		*     			],
		*     		],
		*     	],
		*     	'xmlrpc' => false,
		*     ]);
		*
		* @param array $config {
		*     The WP configuration.
		*
		*     @type array|false $autop Optional. The WP "autop"ing configuration. See
		*       `\Wpx\configure_autop` for details.
		*     @type array|false $blog_feed Optional. The WP blog feed configuration. See
		*       `\Wpx\configure_blog_feed` for details.
		*     @type array|false $capital_p Optional. The WP capital P functionality configuration.
		*       See `\Wpx\configure_capital_p` for details.
		*     @type array|false $emojis Optional. The WP emojis configuration. See
		*       `\Wpx\configure_emojis` for details.
		*     @type array|false $heartbeat Optional. The WP heartbeat configuration. See
		*       `\Wpx\configure_heartbeat` for details.
		*     @type array|false $oembed_provider_support Optional. The WP oEmbed provider support
		*       configuration. See `\Wpx\configure_oembed_provider_support` for details.
		*     @type array|false $plugin_and_theme_editors Optional. The plugin and theme editors
		*       configuration. See `\Wpx\configure_plugin_and_theme_editors` for details.
		*     @type array $post_autosave Optional. The WP post autosave configuration. See
		*       `\Wpx\configure_post_autosave` for details.
		*     @type array $post_revisions Optional. The WP post revisions configuration. See
		*       `\Wpx\configure_post_revisions` for details.
		*     @type array $rest_api Optional. The WP REST API configuration. See
		*       `\Wpx\configure_rest_api` for details.
		*     @type array|false $self_pinging Optional. The self-pinging configuration. See
		*       `\Wpx\configure_self_pinging` for details.
		*     @type array|false $texturization Optional. The WP texturization configuration. See
		*       `\Wpx\configure_texturization` for details.
		*     @type array $trash Optional. The WP trash configuration. See
		*       `\Wpx\configure_trash` for details.
		*     @type array $wp_cron Optional. The WP Cron configuration. See
		*       `\Wpx\configure_wp_cron` for details.
		*     @type array $wp_db Optional. The WP DB configuration. See
		*       `\Wpx\configure_wp_db` for details.
		*     @type array $wp_http Optional. The WP HTTP configuration. See
		*       `\Wpx\configure_wp_http` for details.
		*     @type array $xmlrpc Optional. The XML-RPC configuration. See
		*       `\Wpx\configure_xmlrpc` for details.
		* }
		*/
		public static function configure ( $config = array() ) {
			$autop_config = isset( $config['autop'] ) ? $config['autop'] : true;
			$blog_feed_config = isset( $config['blog_feed'] ) ? $config['blog_feed'] : true;
			$capital_p_config = isset( $config['capital_p'] ) ? $config['capital_p'] : true;
			$emojis_config = isset( $config['emojis'] ) ? $config['emojis'] : true;
			$heartbeat_config = isset( $config['heartbeat'] ) ? $config['heartbeat'] : true;
			$oembed_provider_support_config = isset( $config['oembed_provider_support'] ) ? $config['oembed_provider_support'] : true;
			$plugin_and_theme_editors_config = isset( $config['plugin_and_theme_editors'] ) ? $config['plugin_and_theme_editors'] : true;
			$post_autosave_config = isset( $config['post_autosave'] ) ? $config['post_autosave'] : null;
			$post_revisions_config = isset( $config['post_revisions'] ) ? $config['post_revisions'] : null;
			$rest_api_config = isset( $config['rest_api'] ) ? $config['rest_api'] : null;
			$self_pinging_config = isset( $config['self_pinging'] ) ? $config['self_pinging'] : true;
			$texturization_config = isset( $config['texturization'] ) ? $config['texturization'] : true;
			$trash_config = isset( $config['trash'] ) ? $config['trash'] : true;
			$wp_cron_config = isset( $config['wp_cron'] ) ? $config['wp_cron'] : null;
			$wp_db_config = isset( $config['wp_db'] ) ? $config['wp_db'] : null;
			$wp_http_config = isset( $config['wp_http'] ) ? $config['wp_http'] : null;
			$xmlrpc_config = isset( $config['xmlrpc'] ) ? $config['xmlrpc'] : true;

			self::configure_autop( $autop_config );

			self::configure_blog_feed( $blog_feed_config );

			self::configure_capital_p( $capital_p_config );

			self::configure_emojis( $emojis_config );

			self::configure_heartbeat( $heartbeat_config );

			self::configure_oembed_provider_support( $oembed_provider_support_config );

			self::configure_plugin_and_theme_editors( $plugin_and_theme_editors_config );

			self::configure_post_autosave( $post_autosave_config );

			self::configure_post_revisions( $post_revisions_config );

			self::configure_rest_api( $rest_api_config );

			self::configure_self_pinging( $self_pinging_config );

			self::configure_texturization( $texturization_config );

			self::configure_trash( $trash_config );

			self::configure_wp_cron( $wp_cron_config );

			self::configure_wp_db( $wp_db_config );

			self::configure_wp_http( $wp_http_config );

			self::configure_xmlrpc( $xmlrpc_config );
		}

		/**
		* Configures WP "autop"ing.
		*
		* By default, WordPress automatically inserts HTML `p` (paragraph) tags for
		* certain content.
		*
		* This can be used to prevent WordPress from "autop"ing your site's content.
		*
		* @param array|false $config {
		*     WP "autop"ing configuration.
		*
		*     @type bool $disable Flag indicating whether to disable WP "autop"ing.
		* }
		*/
		public static function configure_autop ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				foreach ( array( 'term_description', 'get_the_post_type_description' ) as $filter ) {
					remove_filter( $filter, 'wpautop' );
				}
				remove_filter( 'the_content', 'wpautop' );
				remove_filter( 'the_excerpt', 'wpautop' );
				remove_filter( 'comment_text', 'wpautop', 30 );
				remove_filter( 'widget_text_content', 'wpautop' );
				remove_filter( 'the_excerpt_embed', 'wpautop' );
			}
		}

		/**
		* Configures the WP blog feed.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @param array|false $config {
		*     WP blog feed configuration.
		*
		*     @type bool $disable Flag indicating whether to disable WP blog feed.
		* }
		*/
		public static function configure_blog_feed ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				remove_action( 'wp_head', 'feed_links_extra', 3 );
				remove_action( 'wp_head', 'feed_links', 2 );

				add_action( 'do_feed', '__404_and_die', 1 );
				add_action( 'do_feed_rdf', '__404_and_die', 1 );
				add_action( 'do_feed_rss', '__404_and_die', 1 );
				add_action( 'do_feed_rss2', '__404_and_die', 1 );
				add_action( 'do_feed_atom', '__404_and_die', 1 );
				add_action( 'do_feed_rss2_comments', '__404_and_die', 1 );
				add_action( 'do_feed_atom_comments', '__404_and_die', 1 );
			}
		}

		/**
		* Configures the WP capital P functionality.
		*
		* By default, WordPress automatically capitalizes the `p` in the word "Wordpress"
		* found in various places in the site.
		*
		* May be used to prevents WordPress from capitalizing the `p` in the word
		* "Wordpress".
		*
		* @param array|false $config {
		*     WP capital P configuration.
		*
		*     @type bool $disable Flag indicating whether to disable WP capital P functionality.
		* }
		*/
		public static function configure_capital_p ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				foreach ( array( 'the_content', 'the_title', 'wp_title' ) as $filter ) {
					remove_filter( $filter, 'capital_P_dangit', 11 );
				}
				remove_filter( 'comment_text', 'capital_P_dangit', 31 );

				remove_filter( 'widget_text_content', 'capital_P_dangit', 11 );
			}
		}

		/**
		* Configures WP emoji support.
		*
		* In WordPress 4.2, support for emojis was added into core for older browsers.
		* The "big" issue with this is that it generates an additional HTTP request on
		* your WordPress site to load the `wp-emoji-release.min.js` file.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @param array|false $config {
		*     WP emojis configuration.
		*
		*     @type bool $disable Flag indicating whether to disable WP emojis.
		* }
		*/
		public static function configure_emojis ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
				remove_action( 'admin_print_styles', 'print_emoji_styles' );

				remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
				remove_action( 'wp_print_styles', 'print_emoji_styles' );

				remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
				remove_filter( 'the_content_feed', 'wp_staticize_emoji' );

				remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

				add_filter( 'tiny_mce_plugins', '__remove_tiny_mce_emojis_plugin' );
				add_filter( 'emoji_svg_url', '__return_empty_string' );
			}
		}

		/**
		* Configures the WP heartbeat.
		*
		*     configure_heartbeat( false );
		*
		*     configure_heartbeat( [ 'disable' => true ] );
		*
		*     configure_heartbeat( [ 'interval' => 300 ] );
		*
		*     configure_heartbeat( [
		*     	'allow_suspension' => true,
		*     	'interval' => 60,
		*     ] );
		*
		* @param array|false $config {
		*     WP heartbeat configuration.
		*
		*     @type bool $disable A flag indicating whether to completely disable the WP
		*     	heartbeat. If true, then all other configs are ignored.
		*     @type int $interval The number of seconds the interval should be.
		*     @type int $minimalInterval The minimum number of seconds an interval may be.
		*     	Must be greater than or equal to 0 or less than or equal to 600.
		*     @type bool $allow_suspension A flag indicating whether the heartbeat may be
		*     	suspended.
		* }
		*/
		public static function configure_heartbeat ( $config = true ) {
			$disable = false;
			if ( $config === false ) {
				$disable = true;
			}
			elseif ( is_array( $config ) && isset( $config['disable'] ) ) {
				$disable = $config['disable'];
			}

			if ( $disable ) {
				add_action( 'init', function () {
					wp_deregister_script( 'heartbeat' );
				}, 1 );
			}
			elseif ( is_array( $config ) ) {
				add_filter( 'heartbeat_settings', function ( $settings ) use ( $config ) {
					if ( isset( $config['interval'] ) ) {
						$settings['interval'] = $config['interval'];
					}
					if ( isset( $config['minimalInterval'] ) ) {
						$settings['minimalInterval'] = $config['minimalInterval'];
					}
					if ( isset( $config['allow_suspension'] ) && $config['allow_suspension'] ) {
						$settings['suspension'] = 'disabled';
					}

					return $settings;
				} );
			}
		}

		/**
		* Configures oEmbed provider support.
		*
		* May be used to disable oEmbed provider support.
		*
		* - Prevents oEmbed discovery links from being rendered.
		* - Prevents request being made on front-end for the `wp-embed.js` JavaScript.
		* - Removes oembed/1.0/embed endpoint.
		*
		* Note: This will not disable oEmbed consumer support. That is, the ability to
		* paste URLs in posts and pages will still be possible.
		*
		* Must be called before the theme calls `wp_head`.
		*
		* Note: This will still work if called at the beginning of a WP page template
		* before `wp_head` is called.
		*
		* @see https://make.wordpress.org/core/2015/10/28/new-embeds-feature-in-wordpress-4-4/
		*
		* @param array|false $config {
		*     WP oEmbed provider support configuration.
		*
		*     @type bool $disable Flag indicating whether to disable WP oEmbed provider support.
		* }
		*/
		public static function configure_oembed_provider_support ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				// Remove the oEmbed discovery links from the front-end
				remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

				// Remove the oEmbed JavaScript from front-end
				remove_action( 'wp_head', 'wp_oembed_add_host_js' );

				// Note: No reason to dequeue the 'wp-embed' when disabling provider support.
				// It would, however, be required to disable consumer support. Plus, removing
				// it as a dependency of the 'wp-edit-post' script would be required.
				// dequeue_scripts( array( 'wp-embed' ) );

				// Remove the oembed endpoints from the REST API discovery response.
				// When disabling for provider support, we don't want to disable both endpoints.
				// We just want to disable the `embed` endpoint and keep the `proxy` endpoint.
				// remove_action( 'rest_api_init', 'wp_oembed_register_route' );

				// Note: I was unable to find a way to prevent registration of the `embed` route
				// without also preventing the registration of the `proxy` route. So, we will
				// remove the `embed` route retroactively.
				// add_action( 'rest_api_init', function () {
				// 	// Note: The following does not work because `WP_REST_Server->$endpoints` is
				// 	// protected.
				// 	unset( rest_get_server()->endpoints['/oembed/1.0/embed'] );
				// } );

				remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request' );

				// Remove the oembed/1.0/embed REST route.
				// Note: This is NOT necessary if we don't register the oembed routes in the first
				// place which is what we ~~are~~ were doing by removing the
				// `wp_oembed_register_route` callback from the `rest_api_init` action.
				// However, it was later determined that we still need the `proxy` route for the
				// WP admin functionality to continue to work. So, we explicitly filter out the
				// `embed` route. This removes it from the REST index at `/wp-json/`. Also, it
				// causes the server to return an error saying the `embed` route does not exist if
				// someone tries to access it anyway.
				add_filter( 'rest_endpoints', function ( $endpoints ) {
					unset( $endpoints['/oembed/1.0/embed'] );

					return $endpoints;
				} );

				// I am not sure if we should automatically remove 'responsive-embeds' theme support.
				// remove_theme_support( 'responsive-embeds' );

				// Note: I don't think we need to remove `get_oembed_response_data_rich` callback
				// from the `oembed_response_data` filter.
				// remove_filter( 'oembed_response_data', 'get_oembed_response_data_rich' );

				// Skip returning oembed response data during a REST request.
				// This is NOT necessary if we don't register the oembed routes in the first place
				// which is what we are doing by removing the `wp_oembed_register_route` callback
				// from the `rest_api_init` action.
				// Note: It appears the `oembed_response_data` filter only gets called during the
				// `embed` route. More accurately, it does not get called during the `proxy` route.
				// add_filter( 'oembed_response_data', function ( $data ) {
				// 	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
				// 		return false;
				// 	}

				// 	return $data;
				// } );

				// TODO: Determine if this is used when consuming oEmbeds.
				// remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result' );

				// TODO: Determine if this is used when consuming oEmbeds.
				// remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result' );

				// TODO: Determine if this is used when consuming oEmbeds.
				// remove_filter( 'oembed_dataparse', 'wp_filter_oembed_iframe_title_attribute', 20 );
			}
		}

		/**
		* Configures the plugin and theme editors in the WP admin.
		*
		* By default, WordPress gives users with sufficient privileges the ability to
		* edit plugin and theme content through the WP admin.
		*
		* Allows preventing access to the plugin and theme editors in the WP admin.
		*
		* @param array|false $config {
		*     Plugin and theme editors configuration.
		*
		*     @type bool $disable Flag indicating whether to disable the plugin and theme
		*       editors.
		* }
		*/
		public static function configure_plugin_and_theme_editors ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				if ( defined( 'DISALLOW_FILE_EDIT' ) ) {
					if ( ! DISALLOW_FILE_EDIT ) {
						add_filter( 'file_mod_allowed', function ( $file_mod_allowed, $context ) {
							if ( $context === 'capability_edit_themes' ) {
								$file_mod_allowed = true;
							}
							return $file_mod_allowed;
						} );
						// trigger_error( __( '`DISALLOW_FILE_EDIT` has already been defined and set to `false` prior to calling `configure_plugin_and_theme_editors`. It is not uncommon to find it set in `wp-config.php`.' ) )
					}
				}
				else {
					define( 'DISALLOW_FILE_EDIT', true );
				}
			}
		}

		/**
		* Configures post autosave in the WordPress admin.
		*
		* It is not recommended to disable post autosave unless database size does not
		* allow room for revisions. And even then, should only be done temporarily until
		* more database space is made available. Consider limiting the number of
		* revisions using the `configure_post_revisions` function instead. It would
		* be better to keep the latest change (aka revision than none at all).
		*
		*     configure_post_autosave( array(
		*     	'interval' => 30, // Save more frequently. Our data is really important.
		*     ) );
		*
		*     configure_post_autosave( array(
		*     	'interval' => 0, // This is just temporary.
		*     ) );
		*
		* Note: MUST be called in a plugin whether it be a must-use plugin, a network
		* plugin, or a normal/standard plugin. Otherwise, the autosave interval will
		* default to the WP default of 60 seconds.
		*
		* @see configure_post_revisions
		* @see https://www.wpbeginner.com/glossary/autosave/
		*
		* @param array $config {
		*     Post autosave configuration.
		*
		*     @type int $interval Optional. The number of seconds between autosaves. Must
		*     	be an integer greater than or equal to 0. Defaults to the WP default which is 60.
		* }
		*/
		public static function configure_post_autosave ( $config ) {
			if ( is_array( $config ) ) {
				if ( isset( $config['interval'] ) ) {
					$interval = $config['interval'];
					if ( ! is_int( $interval ) || $interval < 0 ) {
						trigger_error( __( '`$config[\'interval\']` must be an integer greater than 0.' ) );
					}
					if ( $interval === 0 ) {
						add_action( 'admin_init', function () {
							wp_deregister_script( 'autosave' );
						}, 1 );
					}
					else {
						if ( defined( 'AUTOSAVE_INTERVAL' ) ) {
							trigger_error( __( '`AUTOSAVE_INTERVAL` has already been defined prior to calling `configure_post_autosave`. This function must be called before WordPress defines `AUTOSAVE_INTERVAL` with the default value. Call this function during or before the `plugins_loaded` action. Calling in a plugin is an ideal place.' ) );
						}
						else {
							define( 'AUTOSAVE_INTERVAL', $interval );
						}
					}
				}
			}
		}

		/**
		* Configures post revisions in the WordPress admin.
		*
		* Use to limit the number of revisions saved for each post.
		*
		*     configure_post_revisions( array(
		*     	'maximum' => 50, // We have limited database space available.
		*     ) );
		*
		*     configure_post_revisions( array(
		*     	'maximum' => function ( $revisions, $post ) {
		*     		if ( $post->post_type === 'post' ) {
		*     			$revisions = 30;
		*     		}
		*     		else if ( $post->post_type === 'page' ) {
		*     			$revisions = 10;
		*     		}
		*     		return $revisions;
		*     	}
		*     ) );
		*
		* Consider using one of the following plugins:
		* - "Revision Control" by Dion Hulse
		* 	+ Allow to disable or limit by post type.
		* 	+ Allow to disable or limit per post.
		* - "WP Revisions Control" by Erick Hitter
		* 	+ Allow to disable or limit by post type.
		* 	+ Allow to disable or limit per post.
		*
		* @see https://www.wpbeginner.com/glossary/revisions/
		*
		* @param array $config {
		*     Post revisions configuration.
		*
		*     @type bool|callable|int $maximum Optional. The minimum number of revisions
		*     	to keep for a post. Must be an integer greater than or equal to 0, a boolean, or
		*     	a callable. False means don't keep any revisions. It is equivalent to 0. True
		*     	means keep all revisions which is the default. A callable will receive two
		*     	arguments -- first argument is the current revision value from previously run
		*     	filters or what the `WP_POST_REVISIONS` is set to; second argument is the post
		*     	being autosaved.
		*     @type int $wp_revisions_to_keep_priority Optional. The priority to use with the
		*     	`wp_revisions_to_keep` filter. Defaults to 100. Only applicable when
		*     	`maximum` is set.
		* }
		*/
		public static function configure_post_revisions ( $config ) {
			if ( is_array( $config ) ) {
				if ( isset( $config['maximum'] ) ) {
					$maximum = $config['maximum'];
					if ( ! is_bool( $maximum ) && ! is_int( $maximum ) && ! is_callable( $maximum ) ) {
						trigger_error( __( '`$config[\'maximum\']` must be an integer greater than or equal to 0, true, false, or a callable.' ) );
					}
					if ( is_int( $maximum ) && $maximum < 0 ) {
						trigger_error( __( '`$config[\'maximum\']` must be greater than or equal to 0.' ) );
					}
					// if ( defined( 'WP_POST_REVISIONS' ) ) {
					// 	trigger_error( __( '`WP_POST_REVISIONS` has already been defined prior to calling `configure_post_revisions`. This function must be called before WordPress defines `WP_POST_REVISIONS` with the default value. Call this function during or before the `plugins_loaded` action. Calling in a plugin is an ideal place.' ) );
					// }
					// else {
					// 	define( 'WP_POST_REVISIONS', $maximum );
					// }
					$priority = isset( $config['wp_revisions_to_keep_priority'] ) ? $config['wp_revisions_to_keep_priority'] : 100;
					if ( is_callable( $maximum ) ) {
						add_filter(
							'wp_revisions_to_keep',
							$maximum,
							$priority,
							2
						);
					}
					else {
						add_filter(
							'wp_revisions_to_keep',
							function ( $num, $post ) use ( $maximum ) {
								return $maximum;
							},
							$priority,
							2
						);
					}
				}
			}
		}

		/**
		* Configures the WP REST API.
		*
		* Allows requiring the user to be logged in to be able to use the WP REST API.
		* The URL prefix can be changed too.
		*
		* If the user is not logged in, then an error is returned to the user. The error
		* reuses the same error code (i.e., `rest_not_logged_in`) as the core WP REST API.
		*
		* Note: Since WordPress version 4.7.0, the REST API cannot be completely disabled.
		*
		* @param array $config {
		*     Post revisions configuration.
		*
		*     @type bool $must_be_authenticated Optional. When true, requires the user to be
		*     	authenticated to use the REST API. Defaults to false.
		*     @type string $url_prefix Optional. The URL prefix. Defaults to `wp-json`.
		* }
		*/
		public static function configure_rest_api ( $config ) {
			if ( is_array( $config ) ) {
				// if ( isset( $config['allow_anonymous_comments'] ) ) {
				// 	// TODO: Search for rest_allow_anonymous_comments.
				// }
				// if ( isset( $config['avatar_sizes'] ) ) {
				// 	// TODO: Search for rest_avatar_sizes.
				// }
				// if ( isset( $config['comment_trashable'] ) ) {
				// 	// TODO: Search for rest_comment_trashable.
				// }

				if ( isset( $config['must_be_authenticated'] ) ) {
					$must_be_authenticated = $config['must_be_authenticated'];
					if ( $must_be_authenticated === true ) {
						if ( version_compare( get_bloginfo( 'version' ), '4.7', '>=' ) ) {
							add_filter( 'rest_authentication_errors', function ( $error ) {
								if ( ! empty( $error ) ) {
									return $error;
								}
								if ( ! is_user_logged_in() ) {
									$error = new WP_Error(
										'rest_not_logged_in',
										__( 'You are not currently logged in.' ),
										array( 'status' => 401 )
									);
								}

								return $error;
							});
						}
						else {
							add_action( 'wp_loaded', function () {
								if ( ! is_user_logged_in() ) {
									// TODO: Find out which versions of WP has the following `json_*` filters.
									// Determine whether to keep or remove theses. Note: Not found in 5.2.4.
									// REST API 1.x
									add_filter( 'json_enabled', '__return_false' );
									add_filter( 'json_jsonp_enabled', '__return_false' );

									// REST API 2.x
									add_filter( 'rest_enabled', '__return_false' );
									add_filter( 'rest_jsonp_enabled', '__return_false' );
								}
							} );
						}
					}
				}
				// if ( isset( $config['jsonp_enabled'] ) ) {
				// 	// TODO: Search for rest_jsonp_enabled
				// }
				// if ( isset( $config['page_trashable'] ) ) {
				// 	// TODO: Search for rest_{$this->post_type}_trashable
				// }
				// if ( isset( $config['post_trashable'] ) ) {
				// 	// TODO: Search for rest_{$this->post_type}_trashable
				// }

				// if ( isset( $config['routes'] ) ) {
				// 	// TODO: Search for register_route
				// 	// args:
				// 	// - methods
				// 	// - args
				// 	// 	+ {param}
				// 	// 		* default
				// 	// 		* required
				// 	// 		* sanitize_callback
				// 	// 		* validate_callback
				// 	// - callback
				// 	// - permission_callback
				// 	// - schema
				// 	// 	+ See https://developer.wordpress.org/rest-api/extending-the-rest-api/schema/
				// }
				if ( isset( $config['url_prefix'] ) ) {
					$url_prefix = $config['url_prefix'];
					add_filter( 'rest_url_prefix', function ( $__url_prefix ) use ( $url_prefix ) {
						return $url_prefix;
					} );
				}
			}
		}

		/**
		* Configures self pinging.
		*
		* Allows disabling the ability of the site from pinging itself.
		*
		* @param array|false $config {
		*     Self pinging configuration.
		*
		*     @type bool $disable Flag indicating whether to disable self pinging.
		* }
		*/
		public static function configure_self_pinging ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				add_action( 'pre_ping', function ( &$links ) {
					$home = get_option( 'home' );

					foreach ( $links as $l => $link ) {
						if ( 0 === strpos( $link, $home ) ) {
							unset( $links[ $l ] );
						}
					}
				} );
			}
		}

		/**
		* Configures the WP texturization functionality.
		*
		* By default, WordPress "texturizes" virtually all the content on your site.
		* Calling this function early in the request will prevent WP from doing this.
		*
		* Allows preventing WordPress from "texturizing" your site's content.
		*
		* **Texturization**
		*
		* What is texturization? This is where plain quotes are replaced with fancy
		* quotes, single quotes in certain context are replaced with a prime, double
		* quotes in certain context are replaced with a double prime, double dashes are
		* replaced with an en dash, triple dashes are replaced with an em dash, exes
		* (`x`) in certain context are replaced with a multiplication symbol.
		*
		* Note: Setting `disable` to true will not prevent texturization of the HTML
		* document's title. WP did not make this configurable. Instead, set `disable` to
		* `'completely'`.
		*
		* Note: Setting `disable` to true will not prevent texturization of the archive
		* links` text. WP did not make this configurable. Instead, set `disable` to
		* `'completely'`.
		*
		* Note: Setting `disable` to true will not prevent texturization of the image
		* captions from the Gallery shortcode. The image captions come from each image
		* attachment's excerpt. Instead, set `disable` to `'completely'`.
		*
		* Note: Setting `disable` to true will not prevent texturization of a post's
		* title in the trackback RDF. Instead, set `disable` to `'completely'`.
		*
		* Note: Setting `disable` to true will not prevent texturization of the theme's
		* description as presented in the Appearance > Themes section in the WP admin.
		*  Instead, set `disable` to `'completely'`.
		*
		* Warning: Be aware of the implications of setting `disable` to `'completely'`.
		* Doing so will effectively render the `wptexturize` function as a no-op. So,
		* even if a plugin or theme calls `wptexturize`, the text will not be
		* "texturized".
		*
		* Alternative: Use the [wpuntexturize](https://wordpress.org/plugins/wpuntexturize/)
		* plugin.
		*
		* @param array|false $config {
		*     WP texturization configuration.
		*
		*     @type bool|'completely' $disable Flag indicating whether to disable the WP
		*       texturization functionality.
		* }
		*/
		public static function configure_texturization ( $config = true ) {
			$disable = false;
			if ( $config === false ) {
				$disable = true;
			}
			elseif ( is_array( $config ) && isset( $config['disable'] ) ) {
				$disable = $config['disable'];
			}

			if ( $disable === true ) {
				foreach ( array( 'comment_author', 'term_name', 'link_name', 'link_description', 'link_notes', 'bloginfo', 'wp_title', 'widget_title' ) as $filter ) {
					remove_filter( $filter, 'wptexturize' );
				}

				foreach ( array( 'single_post_title', 'single_cat_title', 'single_tag_title', 'single_month_title', 'nav_menu_attr_title', 'nav_menu_description' ) as $filter ) {
					remove_filter( $filter, 'wptexturize' );
				}

				foreach ( array( 'term_description', 'get_the_post_type_description' ) as $filter ) {
					remove_filter( $filter, 'wptexturize' );
				}

				remove_filter( 'the_title', 'wptexturize' );
				remove_filter( 'the_content', 'wptexturize' );
				remove_filter( 'the_excerpt', 'wptexturize' );
				remove_filter( 'the_post_thumbnail_caption', 'wptexturize' );
				remove_filter( 'comment_text', 'wptexturize' );
				remove_filter( 'list_cats', 'wptexturize' );
				remove_filter( 'widget_text_content', 'wptexturize' );
				remove_filter( 'the_excerpt_embed', 'wptexturize' );
			}
			elseif ( $disable === 'completely' ) {
				add_filter( 'run_wptexturize', '__return_false' );
			}
		}

		/**
		* Configures the WP trash.
		*
		* Since WordPress 2.9, posts and comments went into the trash instead of being
		* permanently deleted.
		*
		* Note: MUST be called in a plugin whether it be a must-use plugin, a network
		* plugin, or a normal/standard plugin. Otherwise, the max trash age will
		* default to the WP default of 30 days.
		*
		* @param array|false $config {
		*     WP trash configuration.
		*
		*     @type int $max_age The number of days to keep trashed posts and comments around
		*       before they are automatically deleted.
		* }
		*/
		public static function configure_trash ( $config ) {
			if ( is_array( $config ) ) {
				$max_age = isset( $config['max_age'] ) ? $config['max_age'] : null;

				if ( is_numeric( $max_age ) ) {
					if ( defined( 'EMPTY_TRASH_DAYS' ) ) {
						trigger_error( __( '`EMPTY_TRASH_DAYS` has already been defined prior to calling `configure_trash`. This function must be called before WordPress defines `EMPTY_TRASH_DAYS` with the default value. Call this function during or before the `plugins_loaded` action. Calling in a plugin is an ideal place.' ) );
					}
					else {
						define( 'EMPTY_TRASH_DAYS', $max_age );
					}
				}
			}
		}

		/**
		* Configures WP-Cron.
		*
		* By default, WordPress will automatically process all pending WP-Cron tasks
		* during virtually all requests after the theme has been set up but before any
		* theme templates are run.
		*
		* This should be called early in the request such as in a plugin or during or
		* before the `plugins_loaded` action. If called after and the `lock_timeout` is
		* set, then an error is triggered.
		*
		* If you disable the automatic running of WP-Cron, be sure to periodically make a
		* call to `/wp-cron.php?doing_wp_cron` to ensure any pending tasks get processed
		* in a timely manner.
		*
		* For example, set up a system cron job to do the following or equivalent:
		*
		*     wget -q -O - https://yourdomain.com/wp-cron.php?doing_wp_cron >/dev/null 2>&1
		*
		* Of course updating the command with your own domain.
		*
		* Note: MUST be called in a plugin whether it be a must-use plugin, a network
		* plugin, or a normal/standard plugin. Otherwise, the autosave interval will
		* default to the WP default of 60 seconds.
		*
		* Note: Both `WP_DEBUG` and `WP_DEBUG_LOG` must be defined as true when
		* `$config['log_execution']` is true in order for the log entry to show in
		* `wp-content/debug.log`.
		*
		* @param array $config {
		*     WP-Cron configuration.
		*
		*     @type bool|string $disable Allows disabling of WP-Cron. Set to true to disable
		*     	WP-Cron from working in normal requests. However, this will not disable WP-Cron
		*     	for the WP-Cron request (`wp-cron.php?doing_wp_cron`). To also disable that,
		*     	set to `'completely'`.
		*     @type bool|string $auto Controls how the automatic running of WP-Cron is handled
		*     	during the request. It can be disabled by setting this to `'disable'`. It can be
		*     	postponed until the end of the request after the theme has generated and sent its
		*     	content by setting this to `'postpone'`.
		*     @type int $lock_timeout The number of seconds for the lock timeout. Defaults to
		*     	the WordPress default of 60.
		*     @type bool $log_execution Flag indicating whether to log the execution of the
		*     	pending WP-Cron tasks.
		* }
		*/
		public static function configure_wp_cron ( $config ) {
			if ( is_array( $config ) ) {
				$was_disabled = false;
				if ( isset( $config['disable'] ) ) {
					$disable = $config['disable'];
					if ( $disable === true ) {
						__set_disable_wp_cron_to_true();
						$was_disabled = true;
					}
					else if ( $disable === 'completely' ) {
						if ( defined( 'DOING_CRON' ) ) {
							__404_and_die();
							// add_filter( 'pre_get_ready_cron_jobs', array(), 100 );
						}
						__set_disable_wp_cron_to_true();
						$was_disabled = true;
					}
				}
				if ( ! $was_disabled ) {
					if ( isset( $config['auto'] ) ) {
						$auto = $config['auto'];
						if ( $auto === 'disable' ) {
							remove_action( 'init', 'wp_cron' );
						}
						else if ( $auto === 'postpone' ) {
							remove_action( 'init', 'wp_cron' );
							if ( ! has_action( 'shutdown', 'wp_cron' ) ) {
								// PHP complains about passing an argument to `flush` when using:
								// `add_action( 'shutdown', 'flush' );`
								// TODO: Confirm that calling `flush` is necessary.
								add_action( 'shutdown', function () { flush(); } );
								// TODO: Confirm that calling `fastcgi_finish_request` is necessary. Note: It
								// should get run when `wp_cron` runs.
								// if ( function_exists( 'fastcgi_finish_request' ) ) {
								// 	// It is recommended to call `session_write_close` in addition to
								// 	// `fastcgi_finish_request` according to user feedback at
								// 	// https://www.php.net/manual/en/function.fastcgi-finish-request.php.
								// 	// `session_register_shutdown` will call `session_write_close` at shutdown.
								// 	session_register_shutdown();
								// 	add_action( 'shutdown', 'fastcgi_finish_request' );
								// }
								add_action( 'shutdown', 'wp_cron' );
							}
							if ( defined( 'DISABLE_WP_CRON' ) && DISABLE_WP_CRON ) {
								trigger_error( 'WP-Cron is disabled. It will not be postponed.' );
							}
						}
					}

					if ( isset( $config['lock_timeout'] ) ) {
						if ( defined( 'WP_CRON_LOCK_TIMEOUT' ) ) {
							trigger_error( __( '`WP_CRON_LOCK_TIMEOUT` has already been defined prior to calling `configure_wp_cron`. This function must be called before WordPress defines `WP_CRON_LOCK_TIMEOUT` with the default value. Call this function during or before the `plugins_loaded` action. Calling in a plugin is an ideal place.' ) );
						}
						else {
							define( 'WP_CRON_LOCK_TIMEOUT', $config['lock_timeout'] );
						}
					}

					// Note: This code must come after the processing of the `$config['auto']` config.
					if ( isset( $config['log_execution'] ) ) {
						if ( $config['log_execution'] === true ) {
							if ( has_action( 'init', 'wp_cron' ) ) {
								remove_action( 'init', 'wp_cron' );
								add_action( 'init', '_wp_cron_with_exec_time' );
							}
							if ( has_action( 'shutdown', 'wp_cron' ) ) {
								remove_action( 'shutdown', 'wp_cron' );
								add_action( 'shutdown', '_wp_cron_with_exec_time' );
							}
						}
					}
				}
			}
		}

		/**
		* Configures the WP-DB.
		*
		* Should be called as early in the request as possible. Ideally, this will be
		* called in a must-use plugin.
		*
		* Note: This is not used to configure the database connection. That is usually
		* done in `wp-config.php` and sometimes done in the `wp-content/db.php` drop-in.
		*
		* Note: Both `WP_DEBUG` and `WP_DEBUG_LOG` must be defined as true when
		* `$config['log_queries']` is true in order for the log entry to show in
		* `wp-content/debug.log`.
		*
		* @param array $config {
		*     WP-DB configuration.
		*
		*     @type bool $log_queries Flag indicating whether to log the database queries that
		*     	were executed during the request.
		* }
		*/
		public static function configure_wp_db ( $config ) {
			global $wpdb;

			if ( is_array( $config ) ) {
				if ( isset( $config['log_queries'] ) ) {
					if ( $config['log_queries'] === true ) {

						if ( defined( 'SAVEQUERIES' ) ) {
							if ( ! SAVEQUERIES ) {
								trigger_error( __( '`SAVEQUERIES` has already been defined as falsey prior to calling `configure_wp_db`. This function must be called before `SAVEQUERIES` is defined to something other than a truthy value. Calling in a must-use plugin is the ideal place.' ) );
							}
						}
						else {
							define( 'SAVEQUERIES', true );
						}

						add_action( 'shutdown', function () {
							global $wpdb;
							error_log( print_r( $wpdb->queries, true ) );
						} );
					}
				}
			}
		}

		/**
		* Configures the WP HTTP API.
		*
		*     configure_wp_http( [
		*     	'access' => [
		*     		'external' => false,
		*     		'allow' => [
		*     			'api.wordpress.org',
		*     			'example.com',
		*     			// etc.
		*     		],
		*     	],
		*     ] );
		*
		* @param array $config {
		*     WP HTTP configuration.
		*
		*     @type array $access {
		*         Access configuration.
		*
		*         @type bool $external Optional. Flag indicating whether to allow external access.
		*           Defaults to true.
		*         @type bool $local Optional. Flag indicating whether to allow local access.
		*           Defaults to true.
		*         @type array $allow Optional. List of hostnames to allow access. Only applicable
		*           when `$external` is false. It is recommended to include `'api.wordpress.org'`
		*           otherwise updates and downloading plugins or themes won't work.
		*     }
		* }
		*/
		public static function configure_wp_http ( $config ) {
			if ( is_array( $config ) ) {
				$access = isset( $config['access'] ) ? $config['access'] : null;
				if ( is_array( $access ) ) {
					$external = isset( $access['external'] ) ? $access['external'] : true;
					if ( $external === false ) {
						if ( defined( 'WP_HTTP_BLOCK_EXTERNAL' ) ) {
							if ( ! WP_HTTP_BLOCK_EXTERNAL ) {
								trigger_error( __( '`WP_HTTP_BLOCK_EXTERNAL` has already been defined and set to falsey prior to calling `configure_wp_http`. It is not uncommon to find it set in `wp-config.php`.' ) );
							}
						}
						else {
							define( 'WP_HTTP_BLOCK_EXTERNAL', true );
						}
					}
					$local = isset( $access['local'] ) ? $access['local'] : true;
					if ( $local === false ) {
						add_filter( 'block_local_requests', '__return_true' );
					}
					$allow = isset( $access['allow'] ) ? $access['allow'] : '';
					if ( ! empty( $allow ) ) {
						$accessible_hosts = $allow;
						if ( is_array( $accessible_hosts ) ) {
							$accessible_hosts = implode( ',', $accessible_hosts );
						}
						if ( defined( 'WP_ACCESSIBLE_HOSTS' ) ) {
							trigger_error( __( '`WP_ACCESSIBLE_HOSTS` has already been defined prior to calling `configure_wp_http`. It is not uncommon to find it set in `wp-config.php`.' ) );
						}
						else {
							define( 'WP_ACCESSIBLE_HOSTS', $accessible_hosts );
						}
					}
				}
			}
		}

		/**
		* Configures XML-RPC.
		*
		* Allows to disable the ability to publish the blog remotely.
		*
		* If you truly want to disable XML-RPC, prevent WordPress from handling its
		* requests by adding the following or its equivalent to the root WordPress
		* `.htaccess` file, the virtual host config file, NGiNX server config file, etc.
		*
		*     # Block WordPress xmlrpc.php requests
		*     <Files xmlrpc.php>
		*         order deny,allow
		*         deny from all
		*     </Files>
		*
		* Ideally, this will be called as early in the request as possible such as in a
		* must-use (MU) plugin.
		*
		* @param array|false $config {
		*     XML-RPC configuration.
		*
		*     @type bool $disable Flag indicating whether to disable XML-RPC.
		* }
		*/
		public static function configure_xmlrpc ( $config = true ) {
			if ( $config === false || ( is_array( $config ) && isset( $config['disable'] ) && $config['disable'] === true ) ) {
				if ( defined( 'XMLRPC_REQUEST' ) ) {
					add_action( 'wp_loaded', '__404_and_die' );
				}
				// add_filter( 'wp_xmlrpc_server_class', function () { return 'not_found_wp_xmlrpc_server'; } );
				// add_filter( 'xmlrpc_enabled', function () {
				// 	return false;
				// }, 100 );
			}
		}

	} // eo class WpConfig

} // eo if ( class_exists )
