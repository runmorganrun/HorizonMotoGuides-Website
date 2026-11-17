<?php
/**
 * Template Name: Tours
 * The page text is the intro under the title. Tours are edited under Tours in the admin menu.
 */
get_header();
the_post();
$tours = hm_get( 'hm_tour' );
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<span class="eyebrow">Rocky Mountain Routes</span>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<p class="subhead"><?php echo esc_html( hm_page_intro() ); ?></p>
			<?php get_template_part( 'template-parts/tour-filters', null, array( 'tours' => $tours ) ); ?>
		</div>
	</section>
	<section class="section compact" style="padding-top:0">
		<div class="shell">
			<div class="grid three" id="tour-grid">
				<?php foreach ( $tours as $tour ) { get_template_part( 'template-parts/tour-card', null, array( 'tour' => $tour ) ); } ?>
			</div>
			<div class="banner-cta">
				<div><h3>Custom Route Design</h3><p>Want a specific path? We’ll help build an itinerary tailored to your riding style and skill level.</p></div>
				<div class="button-row">
					<a class="button secondary small" href="<?php echo esc_url( hm_page_url( 'suggest' ) ); ?>">Suggest a Ride</a>
					<a class="button small" href="<?php echo esc_url( hm_booking_url() ); ?>">Inquire now →</a>
				</div>
			</div>
		</div>
	</section>
	<?php $steps = hm_lines( hm_meta( 'steps' ), 3 ); ?>
	<section class="section">
		<div class="shell">
			<?php if ( $steps ) : ?>
				<div class="section-head">
					<span class="eyebrow">Expedition Briefing</span>
					<h2>How Your Mountain Ride <em class="orange">Begins</em></h2>
					<p>From selecting your route to the final mountain pass, we coordinate every detail for a safe, high-altitude ride.</p>
				</div>
				<div class="grid four">
					<?php foreach ( $steps as $s ) : ?>
						<article class="card card-body"><span class="eyebrow"><?php echo esc_html( $s[0] ); ?></span><h3><?php echo esc_html( $s[1] ); ?></h3><p><?php echo esc_html( $s[2] ); ?></p></article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="banner-cta">
				<div><h3>Ready to Plan Your Rocky Mountain Tour?</h3><p>Contact our team to discuss your route, check availability, and secure your spot.</p></div>
				<a class="button" href="<?php echo esc_url( hm_booking_url() ); ?>">Book your tour →</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
