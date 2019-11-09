<?php
namespace Wpx;

if ( ! defined( 'WPX__VERSION' ) ) {
	define( 'WPX__VERSION', '0.0.0-alpha10' );

	function __404_and_die () {
		$protocol = $_SERVER['SERVER_PROTOCOL'];
		if ( ! in_array( $protocol, array( 'HTTP/1.1', 'HTTP/2', 'HTTP/2.0' ) ) ) {
			$protocol = 'HTTP/1.0';
		}
		@header( "$protocol 404 Not Found", /* replace */ true, 404 );
		die();
	}

	global $wpx;

	$wpx = array(
		// IDEA: 'cache' = array(
		// 	'locale'?
		// ),
		'state' => array(
			'locale' => NULL,
			'request' => array(
				'start' => microtime( TRUE ),
				'end' => NULL,
			),
		),
	);
}
