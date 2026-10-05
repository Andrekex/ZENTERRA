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
		'landing'    => array( '$700–1,300',  'від 10 000 грн' ),
		'company'    => array( '$1,300–2,100', 'від 21 000 грн' ),
		'advanced'   => array( '$3,000–5,000', 'від 38 000 грн' ),
		'redesign'   => array( '$1,300–2,500', 'від 12 000 грн' ),
		'support'    => array( '$90–250',     'від 2 000 грн' ),
		'audit'      => array( '$700–1,300',  'від 8 500 грн' ),
		'chatbot'    => array( '$1,300–4,200', 'від 17 000 грн' ),
		'automation' => array( '$1,700–6,800', 'від 21 000 грн' ),
	);
}

function zenterra_price( $key ) {
	$prices = zenterra_prices();
	return $prices[ $key ][ 'uk' === zenterra_lang() ? 1 : 0 ];
}
