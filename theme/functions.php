<?php
/**
 * Zenterra theme setup.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'ZENTERRA_VERSION', wp_get_theme()->get( 'Version' ) );

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
} );

add_filter( 'wp_resource_hints', function ( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = array( 'href' => 'https://fonts.gstatic.com', 'crossorigin' );
	}
	return $urls;
}, 10, 2 );

add_action( 'wp_head', function () {
	// Theme favicons, unless a Site Icon is set in the Customizer.
	if ( ! has_site_icon() ) {
		$assets = get_template_directory_uri() . '/assets/';
		printf( '<link rel="icon" href="%s" type="image/svg+xml">' . "\n", esc_url( $assets . 'favicon.svg' ) );
		printf( '<link rel="icon" href="%s" type="image/png" sizes="32x32">' . "\n", esc_url( $assets . 'favicon-32.png' ) );
		printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( $assets . 'apple-touch-icon.png' ) );
	}

	// Leave meta tags to an SEO plugin when one is active.
	if ( is_front_page() && ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) ) {
		$description = 'Zenterra is a team of experienced developers who use AI to work faster. We build websites, apps and AI solutions that solve real business problems, at a fixed price, with every line of code reviewed.';
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( 'Zenterra — Experienced developers, powered by AI' ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( 'Websites, apps and AI solutions for real business problems. Fixed price, every line reviewed.' ) );
		echo '<meta property="og:type" content="website">' . "\n";
	}
	echo '<meta name="theme-color" content="#5c16ff">' . "\n";
}, 1 );

/**
 * Link to a section of the one-page layout, from any page.
 */
function zenterra_section_url( $id ) {
	return is_front_page() ? '#' . $id : home_url( '/#' . $id );
}

/**
 * Logo mark used in the header and footer.
 */
function zenterra_logo() {
	?>
	<a href="<?php echo esc_url( is_front_page() ? '#top' : home_url( '/' ) ); ?>" class="logo">
		<img class="logo-img" src="<?php echo esc_url( get_template_directory_uri() . '/assets/logo.svg' ); ?>" alt="Zenterra" width="120" height="28">
	</a>
	<?php
}
