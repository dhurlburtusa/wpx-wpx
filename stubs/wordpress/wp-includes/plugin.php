<?php

function add_action( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
}

function add_filter( $tag, $function_to_add, $priority = 10, $accepted_args = 1 ) {
}

function apply_filters( $tag, $value ) {
	return $value;
}

function do_action( $tag, $arg = '' ) {
}

function has_action( $tag, $function_to_check = false ) {
}

function remove_action( $tag, $function_to_remove, $priority = 10 ) {
}

function remove_filter( $tag, $function_to_remove, $priority = 10 ) {
}
