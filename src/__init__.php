<?php
namespace Wpx;

if ( ! defined( 'ABSPATH' ) ) { status_header(404); die(); }

if ( ! defined( 'WPX__VERSION' ) ) {
	define( 'WPX__VERSION', '0.0.0-alpha10' );

	function __404_and_die () {
		status_header( 404 );
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
