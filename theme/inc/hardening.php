<?php
/**
 * Keep the site owner anonymous and the login name private.
 *
 * WordPress normally publishes the admin's display name and username through the REST API,
 * author archives (/?author=1 → /author/<login>/), the users sitemap, oEmbed data and feeds.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// REST API: no public user list (the block editor still works for logged-in users).
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );

// Author archives and ?author=N lookups go to the homepage instead of revealing the login name.
add_action( 'template_redirect', function () {
	if ( is_author() || ( isset( $_GET['author'] ) && ! is_admin() ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}, 1 );

// Sitemap: no users sitemap.
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );

// oEmbed previews and feeds show the studio, not a person.
add_filter( 'oembed_response_data', function ( $data ) {
	unset( $data['author_url'] );
	$data['author_name'] = 'Zenterra IT';
	return $data;
} );
add_filter( 'the_author', function ( $name ) {
	return is_feed() ? 'Zenterra IT' : $name;
} );
