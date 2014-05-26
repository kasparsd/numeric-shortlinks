<?php
/*
Plugin Name: Numeric Shortlinks
Description: Adds support for numeric (i.e. <code>http://example.com/123</code>) and alpha-numeric (i.e. <code>http://example.com/d3E</code>) shortlinks.
Version: 1.6.1
Author: Kaspars Dambis	
*/


add_filter( 'pre_get_shortlink', 'numeric_shortlink_head', 10, 4 );

function numeric_shortlink_head( $return, $id, $context, $slugs ) {

	if ( is_singular() ) 
		$id = get_queried_object_id();

	$id = apply_filters( 'numeric_shortlinks_encode', $id );

	if ( ! empty( $id ) )
		return home_url( $id );

	return $return;

}


add_action( 'template_redirect', 'maybe_numeric_shortlink_redirect' );

function maybe_numeric_shortlink_redirect() {

	global $wp;

	// Make sure this is a 404 request
	if ( ! is_404() )
		return;

	// Get the trailing part of the request URL
	$request = basename( $wp->request );

	// Get the trailing part of the URI
	$maybe_post_id = (int) apply_filters( 'numeric_shortlinks_decode', $request );

	// Check if it is a valid post ID
	if ( empty( $maybe_post_id ) || ! is_numeric( $maybe_post_id ) )
		return;

	// Redirect if post found
	if ( $post_url = get_permalink( $maybe_post_id ) ) {
		wp_redirect( $post_url, 301 );
		exit;
	}

}


add_action( 'init', 'maybe_enable_bijection_shortlinks' );

function maybe_enable_bijection_shortlinks() {

	// Disabled by default
	if ( apply_filters( 'numeric_shortlinks_bijection', false ) )
		new numeric_bijection_shortlinks();

}


class numeric_bijection_shortlinks {

	var $dictionary = 'abcdefghijklmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
	var $base = 57; // strlen( $dictionary )


	function numeric_bijection_shortlinks() {

		add_filter( 'numeric_shortlinks_encode', array( $this, 'encode' ) );
		add_filter( 'numeric_shortlinks_decode', array( $this, 'decode' ) );

	}

	function encode( $id ) {

		$slug = array();

		while ( $id > 0 ) {
			$slug[] = $this->dictionary[ $id % $this->base ];
			$id = floor( $id / $this->base );
		}

		return implode( '', array_reverse( $slug ) );

	}

	function decode( $slug ) {

		$id = 0;

		foreach ( str_split( $slug ) as $char ) {
			$pos = strpos( $this->dictionary, $char );

			if ( $pos === false )
				return $slug;

			$id = $id * $this->base + $pos;
		}

		if ( $id )
			return $id;

		return $slug;

	}

}
