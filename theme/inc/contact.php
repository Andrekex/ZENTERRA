<?php
/**
 * Contact form: options, recipient setting and the submission handler.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function zenterra_contact_topics() {
	return array(
		'Landing page',
		'Company website',
		'Advanced website / online store',
		'Redesign / migration',
		'AI chatbot / assistant',
		'AI automation',
		'AI audit',
		'Web or mobile app / MVP',
		'White-label partnership',
		'Something else',
	);
}

function zenterra_contact_budgets() {
	return array( 'Under $1,500', '$1,500–3,000', '$3,000–6,000', '$6,000+', 'Not sure yet' );
}

define( 'ZENTERRA_DEFAULT_EMAIL', 'administration@zenterrait.com' );

/**
 * Where requests are sent, also shown on the page.
 * Can be overridden under Appearance → Customize → Contact form.
 */
function zenterra_contact_email() {
	$email = get_theme_mod( 'zenterra_contact_email', '' );
	return is_email( $email ) ? $email : ZENTERRA_DEFAULT_EMAIL;
}

add_action( 'customize_register', function ( $wp_customize ) {
	$wp_customize->add_section( 'zenterra_contact', array(
		'title'    => __( 'Contact form', 'zenterra' ),
		'priority' => 160,
	) );
	$wp_customize->add_setting( 'zenterra_contact_email', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_email',
	) );
	$wp_customize->add_control( 'zenterra_contact_email', array(
		'label'       => __( 'Send requests to', 'zenterra' ),
		'description' => __( 'Also shown on the page. Leave empty to use administration@zenterrait.com.', 'zenterra' ),
		'section'     => 'zenterra_contact',
		'type'        => 'email',
	) );
} );

// The form is public and usually served from page cache, so it uses a honeypot and
// a per-IP limit instead of a nonce (a cached nonce would expire and block real visitors).
add_action( 'admin_post_nopriv_zenterra_contact', 'zenterra_handle_contact' );
add_action( 'admin_post_zenterra_contact', 'zenterra_handle_contact' );

function zenterra_handle_contact() {
	$back = remove_query_arg( 'contact', wp_get_referer() ?: home_url( '/' ) );
	$done = function ( $status ) use ( $back ) {
		wp_safe_redirect( add_query_arg( 'contact', $status, $back ) . '#contact' );
		exit;
	};

	$field = function ( $key ) {
		return isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : ''; // phpcs:ignore WordPress.Security
	};

	// Bots fill in the hidden field; pretend it worked.
	if ( '' !== $field( 'website' ) ) {
		$done( 'sent' );
	}

	$ip       = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$rate_key = 'zenterra_contact_' . md5( $ip );
	$count    = (int) get_transient( $rate_key );
	if ( $count >= 5 ) {
		$done( 'limit' );
	}

	$name     = sanitize_text_field( $field( 'name' ) );
	$email    = sanitize_email( $field( 'email' ) );
	$goal     = sanitize_textarea_field( $field( 'goal' ) );
	$examples = sanitize_text_field( $field( 'examples' ) );
	$deadline = sanitize_text_field( $field( 'deadline' ) );
	$topic    = in_array( $field( 'topic' ), zenterra_contact_topics(), true ) ? $field( 'topic' ) : 'Something else';
	$budget   = in_array( $field( 'budget' ), zenterra_contact_budgets(), true ) ? $field( 'budget' ) : 'Not sure yet';

	if ( '' === $name || ! is_email( $email ) || '' === $goal ) {
		$done( 'invalid' );
	}

	$body = implode( "\n", array(
		"Name: $name",
		"Email: $email",
		"Service: $topic",
		"Budget: $budget",
		'Deadline: ' . ( $deadline ?: '—' ),
		'',
		'Business and goal:',
		$goal,
		'',
		'Sites they like: ' . ( $examples ?: '—' ),
	) );

	$sent = wp_mail(
		zenterra_contact_email(),
		"Project request: $topic — $name",
		$body,
		array( 'Reply-To: ' . str_replace( array( "\r", "\n", '<', '>' ), '', $name ) . " <$email>" )
	);

	set_transient( $rate_key, $count + 1, HOUR_IN_SECONDS );
	$done( $sent ? 'sent' : 'error' );
}
