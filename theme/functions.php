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

add_action( 'after_setup_theme', function () {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
} );

add_action( 'wp_enqueue_scripts', function () {
	$uri = get_template_directory_uri();

	wp_enqueue_style(
		'zenterra-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@500;600;700&display=swap',
		array(),
		null
	);
	wp_enqueue_style( 'zenterra', $uri . '/assets/styles.css', array( 'zenterra-fonts' ), ZENTERRA_VERSION );
	wp_enqueue_script( 'zenterra', $uri . '/assets/main.js', array(), ZENTERRA_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_enqueue_script( 'zenterra-bg', $uri . '/assets/bg.js', array(), ZENTERRA_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

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

	// Leave meta tags to an SEO plugin when one is active.
	if ( zenterra_is_home_view() && ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) ) {
		$description = __( 'Zenterra is a team of experienced developers who use AI to work faster. We build websites, apps and AI solutions that solve real business problems, at a fixed price, with every line of code reviewed.', 'zenterra' );
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr__( 'Zenterra — Experienced developers, powered by AI', 'zenterra' ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr__( 'Websites, apps and AI solutions for real business problems. Fixed price, every line reviewed.', 'zenterra' ) );
		echo '<meta property="og:type" content="website">' . "\n";
		printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $assets . 'zenterra-mark-1024.png' ) );
		echo '<meta property="og:image:width" content="1024"><meta property="og:image:height" content="1024">' . "\n";
		echo '<meta name="twitter:card" content="summary">' . "\n";
	}
	echo '<meta name="theme-color" content="#0B0B10">' . "\n";
}, 1 );

/**
 * Link to a section of the one-page layout, from any page.
 */
function zenterra_section_url( $id ) {
	return zenterra_is_home_view() ? '#' . $id : home_url( '/#' . $id );
}

/**
 * Logo: the bar mark (inline, so its bars can animate) next to the wordmark.
 * $id keeps the gradient id unique when the logo appears twice on a page.
 */
function zenterra_logo( $id = 'header' ) {
	$grad = 'zt-mark-' . $id;
	?>
	<a href="<?php echo esc_url( zenterra_is_home_view() ? '#top' : zenterra_lang_url( zenterra_lang() ) ); ?>" class="logo" aria-label="Zenterra">
		<svg class="logo-mark" viewBox="9 11 46 42" aria-hidden="true">
			<defs><linearGradient id="<?php echo esc_attr( $grad ); ?>" x1="12" y1="10" x2="52" y2="54" gradientUnits="userSpaceOnUse"><stop stop-color="#B9B9B9"/><stop offset="1" stop-color="#5C16FF"/></linearGradient></defs>
			<g fill="url(#<?php echo esc_attr( $grad ); ?>)">
				<rect class="bar" x="10" y="25" width="6" height="14" rx="3"/><rect class="bar" x="19.5" y="18" width="6" height="28" rx="3"/><rect class="bar" x="29" y="12" width="6" height="40" rx="3"/><rect class="bar" x="38.5" y="20" width="6" height="24" rx="3"/><rect class="bar" x="48" y="26" width="6" height="12" rx="3"/>
			</g>
		</svg>
		<img class="logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.svg' ); ?>" alt="" width="120" height="28">
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
