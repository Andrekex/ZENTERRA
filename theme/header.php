<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script>
		try { const t = localStorage.getItem('zt-theme'); if (t) document.documentElement.dataset.theme = t; } catch (e) {}
	</script>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'zenterra' ); ?></a>

<header class="site-header">
	<div class="container header-inner">
		<?php zenterra_logo(); ?>
		<nav class="nav" id="nav" aria-label="<?php esc_attr_e( 'Main', 'zenterra' ); ?>">
			<a href="<?php echo esc_url( zenterra_section_url( 'services' ) ); ?>">Services</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'pricing' ) ); ?>">Pricing</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'process' ) ); ?>">Process</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'agencies' ) ); ?>">For agencies</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'faq' ) ); ?>">FAQ</a>
			<a href="<?php echo esc_url( zenterra_section_url( 'contact' ) ); ?>" class="btn btn-sm btn-primary nav-cta">Start a project</a>
		</nav>
		<div class="header-actions">
			<button class="icon-btn" id="theme-toggle" type="button" aria-label="<?php esc_attr_e( 'Toggle dark mode', 'zenterra' ); ?>">
				<svg class="i-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
				<svg class="i-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.8A9 9 0 1 1 11.2 3a7 7 0 0 0 9.8 9.8z"/></svg>
			</button>
			<button class="icon-btn menu-btn" id="menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Open menu', 'zenterra' ); ?>" aria-expanded="false" aria-controls="nav">
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
			</button>
		</div>
	</div>
</header>
