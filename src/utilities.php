<?php
namespace Wpx;

if ( ! defined( 'ABSPATH' ) ) { status_header(404); die(); }

/**
* Configures the WP heartbeat.
*
*     configure_heartbeat( [ 'disable' => TRUE ] );
*
*     configure_heartbeat( [ 'interval' => 300 ] );
*
*     configure_heartbeat( [
*     	'allow_suspension' => TRUE,
*     	'interval' => 60,
*     ] );
*
* @since WPX 0.0.0-alpha
*
* @param array $config {
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
function configure_heartbeat ( $config ) {
	if ( $config['disable'] === TRUE ) {
		add_action( 'init', function () {
			wp_deregister_script( 'heartbeat' );
		}, 1 );
	}
	else {
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
