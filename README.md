# Numeric Shortlinks for WordPress

**A plugin which enables shortlinks for posts and pages based on their ID (i.e. http://example.com/123).**

This plugin doesn't have any configuration options. It automatically hooks into the `wp_get_shortlink()` function and adds the new URL both in HTML `<head>` and any plugin that relies on shortlink functionality.

## Available Filters

### numeric_shortlinks_to_url

Create your own mapping to post ID. Used when creating a shortlink.

	add_filter( 'numeric_shortlinks_to_url', 'my_shortlink_to_url' );

	function my_shortlink_to_url( $post_id ) {
		// Do something to $post_id
		// The resulting URL will be http://example.com/$post_id
		return $post_id;
	}

### numeric_shortlinks_to_id

Map the trailing part of URL to post ID. Used when resolving a shortlink.

	add_filter( 'numeric_shortlinks_to_id', 'my_shortlink_to_id' );

	function my_shortlink_to_id( $slug ) {
		// Convert $slug to a numeric $post_id
		return $slug;
	}

## Author

Created by **Kaspars Dambis**:  
[konstruktors.com](http://konstruktors.com)  
[@konstruktors](http://twitter.com/konstruktors)
