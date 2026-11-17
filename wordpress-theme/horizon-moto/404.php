<?php
get_header();
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<span class="eyebrow">Off route</span>
			<h1 class="page-title">This road doesn’t go anywhere.</h1>
			<p class="subhead">The page you were looking for has moved or no longer exists.</p>
			<div class="hero-actions" style="justify-content:center">
				<a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>">Back to home</a>
				<a class="button secondary" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">Browse tours</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
