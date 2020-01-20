<?php

function get_body_class( $class = '' ) {
	if ( ! \is_array( $class ) ) {
		$class = array( $class );
	}
	return $class;
}

function get_page_template_slug( $post = null ) {
	return '';
}
