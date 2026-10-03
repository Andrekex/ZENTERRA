<?php
/**
 * Zenterra theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ZENTERRA_VERSION', wp_get_theme()->get( 'Version' ) );

require get_template_directory() . '/inc/i18n.php';
require get_template_directory() . '/inc/contact.php';
require get_template_directory() . '/inc/prices.php';
require get_template_directory() . '/inc/hardening.php';

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	$uri = get_template_directory_uri();

	// styles.min.css is built by bin/build-assets.py and starts with a fingerprint of the
	// styles.css it was built from. It is used only while that still matches, so an edit
	// without a rebuild never serves stale styles.
	$dir = get_template_directory() . '/assets/';
	$css = 'styles.css';
	if ( is_readable( $dir . 'styles.min.css' ) ) {
		$head = (string) file_get_contents( $dir . 'styles.min.css', false, null, 0, 48 ); // phpcs:ignore WordPress.WP.AlternativeFunctions
		if ( false !== strpos( $head, 'src:' . md5_file( $dir . 'styles.css' ) ) ) {
			$css = 'styles.min.css';
		}
	}
	wp_enqueue_style( 'zenterra', $uri . '/assets/' . $css, array(), ZENTERRA_VERSION );
	wp_enqueue_script( 'zenterra', $uri . '/assets/main.js', array(), ZENTERRA_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_enqueue_script( 'zenterra-bg', $uri . '/assets/bg.js', array(), ZENTERRA_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

/**
 * Fonts are self-hosted (no requests to Google). Their small @font-face stylesheet is inlined so
 * it doesn't block rendering as an extra request, and the two fonts used above the fold are preloaded.
 */
add_action( 'wp_head', function () {
	$assets = get_template_directory_uri() . '/assets/';
	$dir    = get_template_directory() . '/assets/';
	$uk     = 'uk' === zenterra_lang();

	$preload = $uk
		? array( 'inter-cyrillic.woff2', 'manrope-cyrillic.woff2' )
		: array( 'inter-latin.woff2', 'space-grotesk-latin.woff2' );
	foreach ( $preload as $font ) {
		printf( '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n", esc_url( $assets . 'fonts/' . $font ) );
	}

	$css = (string) file_get_contents( $dir . 'fonts.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	if ( $uk ) {
		$css .= (string) file_get_contents( $dir . 'fonts-uk.css' ); // phpcs:ignore WordPress.WP.AlternativeFunctions
	}
	$css = preg_replace( '#/\*.*?\*/#s', '', $css );
	$css = str_replace( 'url(fonts/', 'url(' . esc_url( $assets ) . 'fonts/', $css );
	echo '<style id="zenterra-fonts">' . trim( preg_replace( '/\s+/', ' ', $css ) ) . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput
}, 0 );

add_action( 'wp_head', function () {
	$assets = get_template_directory_uri() . '/assets/';

	// Theme icons, unless a Site Icon is set in the Customizer.
	if ( ! has_site_icon() ) {
		printf( '<link rel="icon" href="%s" sizes="48x48">' . "\n", esc_url( $assets . 'favicon.ico' ) );
		printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( $assets . 'favicon.svg' ) );
		printf( '<link rel="icon" href="%s" type="image/png" sizes="32x32">' . "\n", esc_url( $assets . 'favicon-32x32.png' ) );
		printf( '<link rel="icon" href="%s" type="image/png" sizes="16x16">' . "\n", esc_url( $assets . 'favicon-16x16.png' ) );
		printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( $assets . 'apple-touch-icon.png' ) );
	}
	printf( '<link rel="manifest" href="%s">' . "\n", esc_url( $assets . 'site.webmanifest' ) );

	echo '<meta name="theme-color" content="#0B0B10">' . "\n";
}, 1 );

/**
 * Link to a section of the one-page layout, from any page.
 */
function zenterra_section_url( $id ) {
	return zenterra_is_home_view() ? '#' . $id : zenterra_lang_url( zenterra_lang() ) . '#' . $id;
}

/**
 * Logo: the bar mark (inline, so its bars can animate) next to the wordmark.
 * $id keeps the gradient id unique when the logo appears twice on a page.
 */
function zenterra_logo( $id = 'header' ) {
	$grad = 'zt-mark-' . $id;
	?>
	<a href="<?php echo esc_url( zenterra_is_home_view() ? '#top' : zenterra_lang_url( zenterra_lang() ) ); ?>" class="logo">
		<svg class="logo-mark" viewBox="9 11 46 42" aria-hidden="true">
			<defs><linearGradient id="<?php echo esc_attr( $grad ); ?>" x1="12" y1="10" x2="52" y2="54" gradientUnits="userSpaceOnUse"><stop stop-color="#B9B9B9"/><stop offset="1" stop-color="#5C16FF"/></linearGradient></defs>
			<g fill="url(#<?php echo esc_attr( $grad ); ?>)">
				<rect class="bar" x="10" y="25" width="6" height="14" rx="3"/><rect class="bar" x="19.5" y="18" width="6" height="28" rx="3"/><rect class="bar" x="29" y="12" width="6" height="40" rx="3"/><rect class="bar" x="38.5" y="20" width="6" height="24" rx="3"/><rect class="bar" x="48" y="26" width="6" height="12" rx="3"/>
			</g>
		</svg>
		<img class="logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.svg?ver=' . ZENTERRA_VERSION ); ?>" alt="Zenterra IT" width="120" height="28"<?php echo 'footer' === $id ? ' loading="lazy" decoding="async"' : ' fetchpriority="high"'; ?>>
	</a>
	<?php
}

// Browsers and crawlers ask for /favicon.ico at the site root; send them the theme's icon
// (only used when there is no real favicon.ico file in the WordPress folder).
add_action( 'do_faviconico', function () {
	if ( ! has_site_icon() ) {
		wp_safe_redirect( get_template_directory_uri() . '/assets/favicon.ico', 302 );
		exit;
	}
} );

// Don't advertise the WordPress version (page head and feeds).
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );
