<?php
/**
 * Home page. Sections are edited on the page set as the homepage
 * (Settings → Reading), in the "Home page sections" box.
 */
get_header();
$page_id   = (int) get_option( 'page_on_front' );
$hero_img  = $page_id && has_post_thumbnail( $page_id ) ? get_the_post_thumbnail_url( $page_id, 'full' ) : '';
$m         = function ( $key, $default = '' ) use ( $page_id ) {
	return $page_id ? hm_meta( $key, $page_id, $default ) : $default;
};
$tours     = hm_get( 'hm_tour', 4 );
$posts     = get_posts( array( 'posts_per_page' => 3 ) );
$features  = hm_lines( $m( 'pricing_features' ), 1 );
?>
<main>
	<section class="hero"<?php echo $hero_img ? ' style="--hero-image:url(\'' . esc_url( $hero_img ) . '\')"' : ''; ?>>
		<div class="shell">
			<div class="hero-content">
				<span class="eyebrow"><?php echo esc_html( $m( 'hero_eyebrow', 'Colorado Rocky Mountain Tours' ) ); ?></span>
				<h1><?php echo nl2br( esc_html( $m( 'hero_title', "Master the Rockies\non Two Wheels." ) ) ); ?></h1>
				<p><?php echo esc_html( $m( 'hero_text' ) ); ?></p>
				<div class="hero-actions">
					<a class="button" href="<?php echo esc_url( hm_booking_url() ); ?>">Book your ride&nbsp; →</a>
					<a class="button secondary" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">Explore tours</a>
				</div>
				<div class="mini-stats">
					<?php foreach ( hm_lines( $m( 'hero_stats' ), 2 ) as $stat ) : ?>
						<div><strong><?php echo esc_html( $stat[0] ); ?></strong><?php echo esc_html( $stat[1] ); ?></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>

	<?php if ( $tours ) : ?>
	<section class="section">
		<div class="shell">
			<div class="section-head left">
				<span class="eyebrow">Top Packages</span>
				<h2>Signature Guided Tours</h2>
				<p><?php echo esc_html( $m( 'tours_intro' ) ); ?></p>
			</div>
			<div class="grid two">
				<?php foreach ( $tours as $tour ) { get_template_part( 'template-parts/tour-card', null, array( 'tour' => $tour ) ); } ?>
			</div>
			<div class="banner-cta">
				<div><h3>Need a custom route?</h3><p>Journey on your terms with a bespoke itinerary tailored to your group.</p></div>
				<div class="button-row">
					<a class="button small" href="<?php echo esc_url( hm_page_url( 'suggest' ) ); ?>">Suggest a Ride</a>
					<a class="button secondary small" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">View all tours</a>
				</div>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<?php $pricing = hm_lines( $m( 'pricing' ), 4 ); ?>
	<?php if ( $pricing ) : ?>
	<section class="section compact">
		<div class="shell">
			<div class="section-head">
				<span class="eyebrow">Fair Rates &amp; Premium Service</span>
				<h2>Clear pricing for your ride</h2>
				<p>Choose between hourly custom routes or pre-packaged day tours. Transparent pricing for every mountain adventure.</p>
			</div>
			<div class="grid three">
				<?php foreach ( $pricing as $card ) : $featured = 'featured' === strtolower( $card[3] ); ?>
					<article class="card pricing-card<?php echo $featured ? ' featured' : ''; ?>">
						<span class="eyebrow"><?php echo $featured ? 'Most Popular' : 'Flexible Options'; ?></span>
						<h3><?php echo esc_html( $card[0] ); ?></h3>
						<p><?php echo esc_html( $card[2] ); ?></p>
						<div class="price"><?php echo esc_html( $card[1] ); ?> <small>/ rider</small></div>
						<?php if ( $features ) : ?>
							<ul><?php foreach ( $features as $f ) : ?><li><?php echo esc_html( $f[0] ); ?></li><?php endforeach; ?></ul>
						<?php endif; ?>
						<a href="<?php echo esc_url( hm_booking_url() ); ?>" class="button<?php echo $featured ? '' : ' secondary'; ?> small">Book today →</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="section compact">
		<div class="shell split">
			<div>
				<span class="eyebrow">Experienced Guides</span>
				<h2 class="page-title">Why Ride With Us</h2>
				<p class="subhead">We combine technical mountain expertise with seamless logistics to ensure your Rocky Mountain tour is safe, memorable, and perfectly planned.</p>
				<a class="button secondary small" href="<?php echo esc_url( hm_page_url( 'guides' ) ); ?>">Meet your guides →</a>
			</div>
			<div class="feature-panel"><?php hm_feature_rows( $m( 'why' ), '✦' ); ?></div>
		</div>
	</section>

	<?php $quotes = hm_lines( $m( 'testimonials' ), 2 ); ?>
	<?php if ( $quotes ) : ?>
	<section class="section compact">
		<div class="shell">
			<div class="section-head">
				<span class="eyebrow">Rider Feedback</span>
				<h2>Stories from the Road</h2>
				<p>Real experiences from riders who conquered the Rockies with our expert guides.</p>
			</div>
			<div class="grid three">
				<?php foreach ( $quotes as $q ) : ?>
					<article class="card quote">
						<span class="stars">★★★★★</span>
						<blockquote>“<?php echo esc_html( trim( $q[0], '“”"' ) ); ?>”</blockquote>
						<div class="meta"><span>●</span><?php echo esc_html( $q[1] ); ?> · Verified rider</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<section class="section compact">
		<div class="shell">
			<?php if ( $posts ) : ?>
				<div class="section-head left">
					<span class="eyebrow">Expedition Logs</span>
					<h2>From the Road</h2>
					<p>Essential riding tips, gear recommendations, and photo journals from our latest Rocky Mountain expeditions.</p>
				</div>
				<div class="grid three">
					<?php foreach ( $posts as $p ) { get_template_part( 'template-parts/post-card', null, array( 'post' => $p ) ); } ?>
				</div>
			<?php endif; ?>
			<div class="banner-cta">
				<div><h3>Ready to ride your Rocky Mountain adventure?</h3><p>Choose your route, meet your guide, and reserve your spot.</p></div>
				<a class="button" href="<?php echo esc_url( hm_booking_url() ); ?>">Book your tour →</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
