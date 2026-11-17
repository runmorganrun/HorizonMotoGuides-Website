<?php
/**
 * Single blog article.
 */
get_header();
the_post();
$cats = get_the_category();
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<span class="eyebrow"><?php echo esc_html( $cats ? $cats[0]->name : 'Ride Intel' ); ?> · <?php echo esc_html( hm_read_time( get_the_ID() ) ); ?></span>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<p class="subhead"><?php echo esc_html( get_the_date() ); ?></p>
		</div>
	</section>
	<section class="section compact" style="padding-top:0">
		<div class="shell">
			<img class="post-hero-image" src="<?php echo esc_url( hm_image_url( get_the_ID(), 'full' ) ); ?>" alt="<?php the_title_attribute(); ?>">
			<article class="prose"><?php the_content(); ?></article>
			<div class="banner-cta" style="max-width:760px;margin-inline:auto">
				<div><h3>Ready to ride?</h3><p>Choose your route, meet your guide, and reserve your spot.</p></div>
				<div class="button-row">
					<a class="button" href="<?php echo esc_url( hm_booking_url() ); ?>">Book your tour →</a>
					<a class="button secondary" href="<?php echo esc_url( hm_blog_url() ); ?>">More articles</a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
