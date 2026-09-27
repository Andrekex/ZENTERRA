<?php
/**
 * English / Ukrainian versions of the homepage and the privacy policy.
 *
 * English lives at / and /privacy-policy/, Ukrainian at /uk/ and /uk/privacy-policy/
 * (or ?zt_lang=uk / ?zt_page=privacy when pretty permalinks are off).
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
 * URL of a theme page ('' = homepage, 'privacy' = privacy policy) in a language.
 */
function zenterra_url( $lang, $page = '' ) {
	$uk = 'uk' === $lang;
	if ( get_option( 'permalink_structure' ) ) {
		$path = ( $uk ? '/uk' : '' ) . ( 'privacy' === $page ? '/privacy-policy' : '' ) . '/';
		return home_url( $path );
	}
	$args = array();
	if ( $uk ) {
		$args['zt_lang'] = 'uk';
	}
	if ( 'privacy' === $page ) {
		$args['zt_page'] = 'privacy';
	}
	return add_query_arg( $args, home_url( '/' ) );
}

/**
 * Homepage URL for a language.
 */
function zenterra_lang_url( $lang ) {
	return zenterra_url( $lang );
}

/**
 * Privacy policy URL in the current language.
 */
function zenterra_privacy_url() {
	return zenterra_url( zenterra_lang(), 'privacy' );
}

/**
 * The theme page being shown: 'privacy' or '' (homepage / regular WordPress content).
 */
function zenterra_page() {
	return 'privacy' === get_query_var( 'zt_page' ) ? 'privacy' : '';
}

/**
 * True on either language's homepage.
 */
function zenterra_is_home_view() {
	return '' === zenterra_page() && ( is_front_page() || 'uk' === get_query_var( 'zt_lang' ) );
}

// Front-end locale follows the URL only, never the site's language setting: / is always
// English and /uk/ always Ukrainian, even when Settings → General is set to Українська
// (as on Hostiq). wp-admin keeps its own language.
add_filter( 'locale', function ( $locale ) {
	if ( is_admin() || wp_doing_ajax() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return $locale;
	}
	return 'uk' === zenterra_lang() ? 'uk' : 'en_US';
} );

add_action( 'after_setup_theme', function () {
	// WordPress loads its own strings (html lang, dates…) in the site language before the
	// theme runs; reload them in the page's language so / is fully English.
	if ( ! is_admin() && ! wp_doing_ajax() && ! ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		unload_textdomain( 'default', true );
		load_default_textdomain( 'uk' === zenterra_lang() ? 'uk' : 'en_US' );
		$GLOBALS['wp_locale'] = new WP_Locale();
	}
	load_theme_textdomain( 'zenterra', get_template_directory() . '/languages' );
}, 0 );

// /uk/ → Ukrainian homepage; /privacy-policy/ and /uk/privacy-policy/ → privacy policy.
add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'zt_lang';
	$vars[] = 'zt_page';
	return $vars;
} );

add_action( 'init', function () {
	add_rewrite_rule( '^uk/?$', 'index.php?zt_lang=uk', 'top' );
	add_rewrite_rule( '^privacy-policy/?$', 'index.php?zt_page=privacy', 'top' );
	add_rewrite_rule( '^uk/privacy-policy/?$', 'index.php?zt_page=privacy&zt_lang=uk', 'top' );

	// Register the rules once after the theme is deployed, without a manual "Save permalinks".
	$rules = get_option( 'rewrite_rules' );
	if ( get_option( 'permalink_structure' ) && is_array( $rules ) && ! isset( $rules['^uk/privacy-policy/?$'] ) ) {
		flush_rewrite_rules( false );
	}
} );

add_action( 'after_switch_theme', 'flush_rewrite_rules' );

add_filter( 'template_include', function ( $template ) {
	if ( 'privacy' === zenterra_page() ) {
		global $wp_query;
		$wp_query->is_404 = false;
		status_header( 200 );
		return get_template_directory() . '/tpl-privacy.php';
	}
	if ( 'uk' === get_query_var( 'zt_lang' ) ) {
		global $wp_query;
		$wp_query->is_404 = false;
		status_header( 200 );
		return get_template_directory() . '/front-page.php';
	}
	return $template;
} );

// Don't let WordPress "correct" /uk/ or /privacy-policy/ back to /.
add_filter( 'redirect_canonical', function ( $redirect ) {
	return ( get_query_var( 'zt_lang' ) || get_query_var( 'zt_page' ) ) ? false : $redirect;
} );

add_filter( 'body_class', function ( $classes ) {
	if ( 'privacy' === zenterra_page() ) {
		$classes[] = 'zt-privacy';
	}
	return $classes;
} );

// Page titles for Google and the browser tab.
add_filter( 'pre_get_document_title', function ( $title ) {
	if ( 'privacy' === zenterra_page() ) {
		return __( 'Privacy Policy', 'zenterra' ) . ' — Zenterra IT';
	}
	if ( zenterra_is_home_view() ) {
		return __( 'Zenterra IT — AI-Powered Web Development, Fixed Price', 'zenterra' );
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
	$page = zenterra_page();
	if ( 'privacy' !== $page && ! zenterra_is_home_view() ) {
		return;
	}
	printf( '<link rel="alternate" hreflang="en" href="%s">' . "\n", esc_url( zenterra_url( 'en', $page ) ) );
	printf( '<link rel="alternate" hreflang="uk" href="%s">' . "\n", esc_url( zenterra_url( 'uk', $page ) ) );
	printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( zenterra_url( 'en', $page ) ) );

	// Description and social previews. The theme owns these on its own pages (SEO plugins are
	// told to skip them below), so they're always present and never duplicated.
	$uk  = 'uk' === zenterra_lang();
	$url = zenterra_url( zenterra_lang(), $page );
	if ( 'privacy' === $page ) {
		$desc  = __( 'How Zenterra IT collects, uses and protects your personal data.', 'zenterra' );
		$title = __( 'Privacy Policy', 'zenterra' ) . ' — Zenterra IT';
		$og    = $desc;
	} else {
		$desc  = __( 'Experienced developers + AI: company websites in 1–2 weeks, AI chatbots and automations. Fixed price upfront, every line of code reviewed by a human.', 'zenterra' );
		$title = __( 'Zenterra IT — Experienced developers, powered by AI', 'zenterra' );
		$og    = __( 'Websites, AI solutions and MVPs for small businesses, startups and agencies. Fixed price, every line reviewed.', 'zenterra' );
	}
	$image = get_template_directory_uri() . '/assets/og-image-' . ( $uk ? 'uk' : 'en' ) . '.png';
	printf( '<link rel="canonical" href="%s">' . "\n", esc_url( $url ) );
	printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
	echo '<meta property="og:type" content="website">' . "\n";
	echo '<meta property="og:site_name" content="Zenterra IT">' . "\n";
	printf( '<meta property="og:locale" content="%s">' . "\n", $uk ? 'uk_UA' : 'en_US' );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( $title ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $og ) );
	printf( '<meta property="og:url" content="%s">' . "\n", esc_url( $url ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) );
	echo '<meta property="og:image:width" content="1200"><meta property="og:image:height" content="630">' . "\n";
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";

	if ( '' === $page ) {
		$org = array(
			'@context'  => 'https://schema.org',
			'@type'     => 'Organization',
			'name'      => 'Zenterra IT',
			'legalName' => 'LLC ZENTERRA',
			'url'       => home_url( '/' ),
			'logo'      => get_template_directory_uri() . '/assets/zenterra-mark-1024.png',
			'email'     => zenterra_contact_email(),
			'sameAs'    => array( ZENTERRA_LINKEDIN, 'https://t.me/' . ZENTERRA_TELEGRAM ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $org, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
}, 2 );

// On the theme's pages, stop SEO plugins (Rank Math, Yoast) adding a second — or, when
// unconfigured, an empty — set of tags. They still handle regular posts and pages.
add_action( 'wp_head', function () {
	if ( 'privacy' === zenterra_page() || zenterra_is_home_view() ) {
		remove_all_actions( 'rank_math/head' );
	}
}, 0 );
add_filter( 'wpseo_frontend_presenters', function ( $presenters ) {
	return ( 'privacy' === zenterra_page() || zenterra_is_home_view() ) ? array() : $presenters;
} );

// Sitemap: the theme's pages (both homepages, both privacy pages) for Google Search Console.
add_action( 'wp_sitemaps_init', function ( $sitemaps ) {
	$sitemaps->registry->add_provider( 'zenterra', new class() extends WP_Sitemaps_Provider {
		public function __construct() {
			$this->name        = 'zenterra';
			$this->object_type = 'zenterra';
		}
		public function get_url_list( $page_num, $object_subtype = '' ) {
			$urls = array();
			foreach ( array( '', 'privacy' ) as $page ) {
				foreach ( array( 'en', 'uk' ) as $lang ) {
					$urls[] = array( 'loc' => zenterra_url( $lang, $page ) );
				}
			}
			return $urls;
		}
		public function get_max_num_pages( $object_subtype = '' ) {
			return 1;
		}
	} );
} );

// Cyrillic-capable heading font, and strings used by main.js.
add_action( 'wp_enqueue_scripts', function () {
	if ( 'uk' === zenterra_lang() ) {
		wp_enqueue_style( 'zenterra-font-uk', get_template_directory_uri() . '/assets/fonts-uk.css', array(), ZENTERRA_VERSION );
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
			// Same page in the other language (the policy links to the policy, everything else to the homepage)
			printf( '<a href="%s" hreflang="%s" lang="%s" title="%s">%s</a>', esc_url( zenterra_url( $code, zenterra_page() ) ), esc_attr( $code ), esc_attr( $code ), esc_attr( $label[1] ), esc_html( $label[0] ) );
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
