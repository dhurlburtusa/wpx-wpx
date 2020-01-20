<?php

function wp_dequeue_script( $handle ) {
}

function wp_deregister_script( $handle ) {
}

function wp_enqueue_script( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {
}

function wp_register_script( $handle, $src, $deps = array(), $ver = false, $in_footer = false ) {
	return true;
}

function wp_script_add_data( $handle, $key, $value ) {
	return true;
}
