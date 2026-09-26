<?php
/**
 * Prices per language. English in USD, Ukrainian in UAH ("від" = from).
 * Edit here; the pricing cards read these through zenterra_price().
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function zenterra_prices() {
	return array(
		// key            English (USD)      Ukrainian (UAH)
		'landing'    => array( '$800–1,500',   'від 12 000 грн' ),
		'company'    => array( '$1,500–2,500', 'від 25 000 грн' ),
		'advanced'   => array( '$3,500–6,000', 'від 45 000 грн' ),
		'redesign'   => array( '$1,500–3,000', 'від 15 000 грн' ),
		'support'    => array( '$100–300',     'від 2 500 грн' ),
		'audit'      => array( '$800–1,500',   'від 10 000 грн' ),
		'chatbot'    => array( '$1,500–5,000', 'від 20 000 грн' ),
		'automation' => array( '$2,000–8,000', 'від 25 000 грн' ),
	);
}

function zenterra_price( $key ) {
	$prices = zenterra_prices();
	return $prices[ $key ][ 'uk' === zenterra_lang() ? 1 : 0 ];
}
