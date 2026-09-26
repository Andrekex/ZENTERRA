<footer class="site-footer">
	<div class="container footer-inner">
		<div>
			<?php zenterra_logo(); ?>
			<p class="muted small"><?php esc_html_e( 'Experienced developers, powered by AI.', 'zenterra' ); ?><br><?php esc_html_e( 'Working with clients in the US and EU.', 'zenterra' ); ?></p>
			<p class="footer-contacts small">
				<a href="mailto:<?php echo esc_attr( antispambot( zenterra_contact_email() ) ); ?>"><?php echo esc_html( antispambot( zenterra_contact_email() ) ); ?></a>
				<a href="<?php echo esc_url( 'https://t.me/' . ZENTERRA_TELEGRAM ); ?>" target="_blank" rel="noopener">Telegram @<?php echo esc_html( ZENTERRA_TELEGRAM ); ?></a>
			</p>
		</div>
		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'zenterra' ); ?>">
			<a href="<?php echo esc_url( zenterra_section_url( 'services' ) ); ?>"><?php esc_html_e( 'Services', 'zenterra' ); ?></a>
			<a href="<?php echo esc_url( zenterra_section_url( 'pricing' ) ); ?>"><?php esc_html_e( 'Pricing', 'zenterra' ); ?></a>
			<a href="<?php echo esc_url( zenterra_section_url( 'process' ) ); ?>"><?php esc_html_e( 'Process', 'zenterra' ); ?></a>
			<a href="<?php echo esc_url( zenterra_section_url( 'agencies' ) ); ?>"><?php esc_html_e( 'For agencies', 'zenterra' ); ?></a>
			<a href="<?php echo esc_url( zenterra_section_url( 'contact' ) ); ?>"><?php esc_html_e( 'Contact', 'zenterra' ); ?></a>
		</nav>
		<p class="muted small copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php esc_html_e( 'LLC ZENTERRA', 'zenterra' ); ?><br><?php esc_html_e( 'All rights reserved.', 'zenterra' ); ?></p>
	</div>
</footer>

<a href="#top" class="to-top" id="to-top" aria-label="<?php esc_attr_e( 'Back to top', 'zenterra' ); ?>">
	<svg class="to-top-ring" viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="22" pathLength="100"/></svg>
	<svg class="to-top-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
