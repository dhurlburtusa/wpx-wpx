<?php

function get_option( $option, $default = false ) {
}

function wp_load_alloptions() {
	return apply_filters( 'alloptions', array() );
}
