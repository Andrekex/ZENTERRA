<?php
/**
 * Fallback template for posts, pages, archives and 404s.
 * The homepage itself is front-page.php.
 */

get_header();
?>

<main id="main" class="section">
	<div class="container narrow">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?>>
					<?php if ( is_singular() ) : ?>
						<h1><?php the_title(); ?></h1>
					<?php else : ?>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<?php endif; ?>

					<?php if ( 'post' === get_post_type() ) : ?>
						<p class="muted small"><?php echo esc_html( get_the_date() ); ?></p>
					<?php endif; ?>

					<div class="entry-content">
						<?php is_singular() ? the_content() : the_excerpt(); ?>
					</div>
				</article>
			<?php endwhile; ?>

			<?php the_posts_pagination(); ?>
		<?php else : ?>
			<p class="eyebrow">404</p>
			<h1><?php esc_html_e( 'Page not found', 'zenterra' ); ?></h1>
			<p class="section-lead"><?php esc_html_e( 'The page you are looking for does not exist.', 'zenterra' ); ?></p>
			<a class="btn btn-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to homepage', 'zenterra' ); ?></a>
		<?php endif; ?>
	</div>
</main>

<?php
get_footer();
