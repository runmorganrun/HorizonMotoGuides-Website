<?php
/**
 * Regular pages (e.g. Privacy Policy, Terms) without a special template.
 */
get_header();
the_post();
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<h1 class="page-title"><?php the_title(); ?></h1>
		</div>
	</section>
	<section class="section compact" style="padding-top:0">
		<div class="shell">
			<article class="prose"><?php the_content(); ?></article>
		</div>
	</section>
</main>
<?php
get_footer();
