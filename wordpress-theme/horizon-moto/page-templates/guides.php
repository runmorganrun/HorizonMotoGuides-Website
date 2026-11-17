<?php
/**
 * Template Name: Guides
 * The page text is the intro under the title. Guides are edited under Guides in the admin menu.
 */
get_header();
the_post();
$guides = hm_get( 'hm_guide' );
$safety = hm_lines( hm_meta( 'safety' ), 2 );
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<span class="eyebrow">Expert Ride Leaders</span>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<p class="subhead"><?php echo esc_html( hm_page_intro() ); ?></p>
		</div>
	</section>
	<section class="section compact" style="padding-top:15px">
		<div class="shell">
			<div class="grid three">
				<?php foreach ( $guides as $g ) : ?>
					<article class="card guide-card">
						<div class="card-image">
							<img src="<?php echo esc_url( hm_image_url( $g->ID, 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $g ) ); ?>" loading="lazy">
							<?php if ( hm_meta( 'focus', $g->ID ) ) : ?><span class="tag"><?php echo esc_html( hm_meta( 'focus', $g->ID ) ); ?></span><?php endif; ?>
						</div>
						<div class="card-body">
							<span class="guide-role">◉ <?php echo esc_html( hm_meta( 'role', $g->ID ) ); ?></span>
							<h3><?php echo esc_html( get_the_title( $g ) ); ?></h3>
							<p><?php echo esc_html( hm_meta( 'bio', $g->ID ) ); ?></p>
							<p style="margin-top:14px">
								<?php if ( hm_meta( 'area', $g->ID ) ) : ?><span class="orange">⌖</span> &nbsp; Area: <?php echo esc_html( hm_meta( 'area', $g->ID ) ); ?><br><?php endif; ?>
								<?php if ( hm_meta( 'languages', $g->ID ) ) : ?><span class="orange">⚑</span> &nbsp; Speaks: <?php echo esc_html( hm_meta( 'languages', $g->ID ) ); ?><?php endif; ?>
							</p>
							<div class="card-bottom">
								<span class="meta"><?php echo esc_html( hm_meta( 'years', $g->ID ) ); ?></span>
								<a class="button secondary small" href="<?php echo esc_url( hm_booking_url() ); ?>">Ride with <?php echo esc_html( strtok( get_the_title( $g ), ' ' ) ); ?> →</a>
							</div>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<div class="banner-cta">
				<div><h3>Ready to book your Rocky Mountain ride?</h3><p>Choose your preferred guide or let us match you with the perfect leader for your route.</p></div>
				<div class="button-row">
					<a class="button" href="<?php echo esc_url( hm_booking_url() ); ?>">Book a tour</a>
					<a class="button secondary" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">See routes</a>
				</div>
			</div>
		</div>
	</section>
	<?php if ( $safety ) : ?>
	<section class="section">
		<div class="shell split">
			<div>
				<span class="eyebrow">Safety &amp; Protocols</span>
				<h2 class="page-title">Mountain Precision.<br>Certified Safety.<br>Unmatched Adventure.</h2>
				<p class="subhead">Based in the Colorado Rockies, we provide expert-led, fully-vetted motorcycle expeditions for every skill level.</p>
			</div>
			<div class="grid two">
				<?php foreach ( $safety as $s ) : ?>
					<article class="card card-body"><span class="eyebrow">Active status</span><h3><?php echo esc_html( $s[0] ); ?></h3><p><?php echo esc_html( $s[1] ); ?></p></article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
</main>
<?php
get_footer();
