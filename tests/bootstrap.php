<?php
// Disable XDebug backtrace:
if ( function_exists( 'xdebug_disable' ) ) {
	xdebug_disable();
}

// Report all PHP errors:
error_reporting( -1 );

require_once __DIR__ . '/../vendor/autoload.php';
