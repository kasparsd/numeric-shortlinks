# Numeric Shortlinks for WordPress

**A plugin which enables shortlinks for posts and pages based on their ID (i.e. http://example.com/123).**

This plugin doesn't have any configuration options. It automatically hooks into the `wp_get_shortlink()` function and adds the new URL both in HTML `<head>` and any plugin that relies on shortlink functionality.

## Prefer even shorter apha-numeric shortlinks?

This plugin allows you to choose between numeric shortlinks that are an exact match of the post ID, or use the alpha-numeric version for even shorter links.

Simply set the `numeric_shortlinks_bijection` filter to `true`, like so:

	add_filter( 'enable_numeric_shortlinks_bijection', '__return_true' );


## Available Filters

### numeric_shortlinks_encode

Create your own mapping to post ID. Used when creating a shortlink.

	add_filter( 'numeric_shortlinks_encode', 'my_shortlink_encode' );

	function my_shortlink_encode( $post_id ) {
		// Do something to $post_id
		// The resulting URL will be http://example.com/$post_id
		return $post_id;
	}

### numeric_shortlinks_decode

Map the trailing part of URL to post ID. Used when resolving a shortlink.

	add_filter( 'numeric_shortlinks_decode', 'my_shortlink_decode' );

	function my_shortlink_decode( $slug ) {
		// Convert $slug to a numeric $post_id
		return $slug;
	}

## Author

Created by **Kaspars Dambis**:  
[konstruktors.com](http://konstruktors.com)  
[@konstruktors](http://twitter.com/konstruktors)
