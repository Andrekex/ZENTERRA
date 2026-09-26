<?php
/**
 * English / Ukrainian versions of the homepage.
 *
 * English lives at /, Ukrainian at /uk/ (or /?zt_lang=uk when pretty permalinks are off).
 * Strings use the standard "zenterra" text domain; translations are in languages/uk.po.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Current language: 'uk' or 'en'. Read from the URL so it is known before WordPress
 * parses the query, which is when the translation files are chosen.
 */
function zenterra_lang() {
	static $lang = null;
	if ( null !== $lang ) {
		return $lang;
	}
	$lang = 'en';
	if ( isset( $_GET['zt_lang'] ) && 'uk' === $_GET['zt_lang'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		$lang = 'uk';
	} elseif ( isset( $_SERVER['REQUEST_URI'] ) ) {
		$path = (string) wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
		$home = rtrim( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ), '/' );
		if ( preg_match( '#^' . preg_quote( $home, '#' ) . '/uk(/|$)#', $path ) ) {
			$lang = 'uk';
		}
	}
	return $lang;
}

/**
 * Homepage URL for a language.
 */
function zenterra_lang_url( $lang ) {
	if ( 'uk' !== $lang ) {
		return home_url( '/' );
	}
	return get_option( 'permalink_structure' ) ? home_url( '/uk/' ) : add_query_arg( 'zt_lang', 'uk', home_url( '/' ) );
}

/**
 * True on either language's homepage.
 */
function zenterra_is_home_view() {
	return is_front_page() || 'uk' === get_query_var( 'zt_lang' );
}

// Front-end locale follows the URL; wp-admin keeps its own language.
add_filter( 'locale', function ( $locale ) {
	if ( is_admin() || wp_doing_ajax() ) {
		return $locale;
	}
	return 'uk' === zenterra_lang() ? 'uk' : $locale;
} );

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'zenterra', get_template_directory() . '/languages' );
} );

// /uk/ → Ukrainian homepage.
add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'zt_lang';
	return $vars;
} );

add_action( 'init', function () {
	add_rewrite_rule( '^uk/?$', 'index.php?zt_lang=uk', 'top' );

	// Register the rule once after the theme is deployed, without a manual "Save permalinks".
	$rules = get_option( 'rewrite_rules' );
	if ( get_option( 'permalink_structure' ) && is_array( $rules ) && ! isset( $rules['^uk/?$'] ) ) {
		flush_rewrite_rules( false );
	}
} );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );

add_filter( 'template_include', function ( $template ) {
	if ( 'uk' === get_query_var( 'zt_lang' ) ) {
		global $wp_query;
		$wp_query->is_404 = false;
		status_header( 200 );
		return get_template_directory() . '/front-page.php';
	}
	return $template;
} );

// Don't let WordPress "correct" /uk/ back to /.
add_filter( 'redirect_canonical', function ( $redirect ) {
	return 'uk' === get_query_var( 'zt_lang' ) ? false : $redirect;
} );

// Title, language alternates and canonical URL for the homepage in each language.
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( zenterra_is_home_view() ) {
		return 'Zenterra — ' . __( 'Experienced developers, powered by AI', 'zenterra' );
	}
	return $title;
} );

// Same signal for translation extensions that look for the "notranslate" class.
add_filter( 'body_class', function ( $classes ) {
	$classes[] = 'notranslate';
	return $classes;
} );

add_action( 'wp_head', function () {
	// The site has its own Ukrainian version, so stop browsers from machine-translating
	// the English page (Chrome in Ukrainian would otherwise show it in Ukrainian).
	echo '<meta name="google" content="notranslate">' . "\n";
	if ( ! zenterra_is_home_view() ) {
		return;
	}
	printf( '<link rel="alternate" hreflang="en" href="%s">' . "\n", esc_url( zenterra_lang_url( 'en' ) ) );
	printf( '<link rel="alternate" hreflang="uk" href="%s">' . "\n", esc_url( zenterra_lang_url( 'uk' ) ) );
	printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( zenterra_lang_url( 'en' ) ) );
	if ( ! defined( 'WPSEO_VERSION' ) && ! class_exists( 'RankMath' ) ) {
		printf( '<link rel="canonical" href="%s">' . "\n", esc_url( zenterra_lang_url( zenterra_lang() ) ) );
		printf( '<meta property="og:locale" content="%s">' . "\n", 'uk' === zenterra_lang() ? 'uk_UA' : 'en_US' );
	}
}, 2 );

// Cyrillic-capable heading font, and strings used by main.js.
add_action( 'wp_enqueue_scripts', function () {
	if ( 'uk' === zenterra_lang() ) {
		wp_enqueue_style( 'zenterra-font-uk', 'https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap', array(), null );
	}
	wp_add_inline_script( 'zenterra', 'window.ZT_I18N = ' . wp_json_encode( array(
		'invalid'   => __( 'Please fill in your name, a valid email and your goal.', 'zenterra' ),
		'sending'   => __( 'Sending…', 'zenterra' ),
		'openMenu'  => __( 'Open menu', 'zenterra' ),
		'closeMenu' => __( 'Close menu', 'zenterra' ),
	) ) . ';', 'before' );
}, 20 );

/**
 * EN | UA switch for the header.
 */
function zenterra_lang_switcher() {
	$current = zenterra_lang();
	$langs   = array(
		'en' => array( 'EN', 'English' ),
		'uk' => array( 'UA', 'Українська' ),
	);
	echo '<div class="lang-switch" role="group" aria-label="' . esc_attr__( 'Language', 'zenterra' ) . '">';
	foreach ( $langs as $code => $label ) {
		if ( $code === $current ) {
			printf( '<span class="is-current" aria-current="true" title="%s">%s</span>', esc_attr( $label[1] ), esc_html( $label[0] ) );
		} else {
			printf( '<a href="%s" hreflang="%s" lang="%s" title="%s">%s</a>', esc_url( zenterra_lang_url( $code ) ), esc_attr( $code ), esc_attr( $code ), esc_attr( $label[1] ), esc_html( $label[0] ) );
		}
	}
	echo '</div>';
}

/**
 * Hero headline split into words for the entrance animation.
 */
function zenterra_hero_title() {
	$words = preg_split( '/\s+/u', trim( __( 'Experienced developers, powered by AI.', 'zenterra' ) ) );
	foreach ( $words as $word ) {
		printf( '<span class="w"><span>%s</span></span> ', esc_html( $word ) );
	}
	printf( '<br><span class="w accent-w"><span class="accent">%s</span></span>', esc_html__( 'Every line reviewed.', 'zenterra' ) );
}
