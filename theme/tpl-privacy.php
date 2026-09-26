<?php
/**
 * Privacy policy, English or Ukrainian (routed from inc/i18n.php).
 * The text lives in inc/privacy/en.html and inc/privacy/uk.html.
 */

get_header();
$zenterra_policy = get_template_directory() . '/inc/privacy/' . ( 'uk' === zenterra_lang() ? 'uk' : 'en' ) . '.html';
?>

<main id="main" class="section legal">
	<div class="container narrow">
		<article class="legal-content entry-content">
			<?php echo wp_kses_post( (string) file_get_contents( $zenterra_policy ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions ?>
		</article>
	</div>
</main>

<?php
get_footer();
