<?php

function get_queried_object() {
	return null;
}

function get_queried_object_id() {
	return 0;
}

function get_query_var( $var, $default = '' ) {
	return null;
}

function is_404() {
	return false;
}

function is_archive() {
	return false;
}

function is_attachment( $attachment = '' ) {
	return false;
}

function is_author( $author = '' ) {
	return false;
}

function is_category( $category = '' ) {
	return false;
}

function is_date() {
	return false;
}

function is_embed() {
	return false;
}

function is_front_page() {
	return true;
}

function is_home() {
	return false;
}

function is_page( $page = '' ) {
	return false;
}

function is_post_type_archive( $post_types = '' ) {
	return false;
}

function is_privacy_policy() {
	return false;
}

function is_search() {
	return false;
}

function is_single( $post = '' ) {
	return false;
}

function is_singular( $post_types = '' ) {
	return false;
}

function is_tag( $tag = '' ) {
	return false;
}

function is_tax( $taxonomy = '', $term = '' ) {
	return false;
}
