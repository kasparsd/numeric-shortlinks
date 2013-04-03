<?php
/*
Plugin Name: Numeric Shortlinks
Description: Adds support for numeric shortlinks like <code>http://example.com/123</code>
Version: 2.5
Author: Kaspars Dambis	
*/


add_filter( 'pre_get_shortlink', 'numeric_shortlink_head', 10, 4 );

function numeric_shortlink_head( $return, $id, $context, $slugs ) {
	global $wp_query, $post;
	
	if ( $wp_query->is_singular() && ! $wp_query->is_front_page() || is_admin() ) {
		if ( is_admin() )
			$post_id = $post->ID;
		else
			$post_id = $wp_query->get_queried_object_id();

		return get_bloginfo('home') . '/' . $post_id;
	}
	
	return $return;
}


add_action( 'pre_get_posts', 'numeric_shortlink_redirect' );

function numeric_shortlink_redirect( $query ) {
	if ( ! $query->is_main_query() )
		return;

	$uri_int = trim( $_SERVER['REQUEST_URI'], '/' );

	if ( ! is_numeric( $uri_int ) )
		return;
	
	if ( $post_url = get_permalink( $uri_int ) ) {
		wp_redirect( $post_url, 301 );
		exit;	
	}
}

