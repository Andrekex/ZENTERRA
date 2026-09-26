<footer class="site-footer">
	<div class="container footer-inner">
		<div>
			<?php zenterra_logo(); ?>
			<p class="muted small">Experienced developers, powered by AI.<br>Working with clients in the US and EU.</p>
		</div>
		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'zenterra' ); ?>">
			<a href="<?php echo esc_url( zenterra_section_url( 'services' ) ); ?>">Services</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'pricing' ) ); ?>">Pricing</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'process' ) ); ?>">Process</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'agencies' ) ); ?>">For agencies</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'contact' ) ); ?>">Contact</a>
		</nav>
		<p class="muted small copyright">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Zenterra</p>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
