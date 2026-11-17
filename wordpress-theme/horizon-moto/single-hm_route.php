<?php
/**
 * Top Route detail page (linked from the footer). Edited under Top Routes in the admin menu.
 */
get_header();
the_post();
$id         = get_the_ID();
$stats      = hm_lines( hm_meta( 'stats' ), 2 );
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<?php if ( hm_meta( 'road' ) ) : ?><span class="eyebrow"><?php echo esc_html( hm_meta( 'road' ) ); ?></span><?php endif; ?>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<p class="subhead"><?php echo esc_html( hm_meta( 'intro' ) ); ?></p>
			<?php if ( $stats ) : ?>
				<div class="stats-box route-stats">
					<?php foreach ( $stats as $s ) : ?><div><strong><?php echo esc_html( $s[0] ); ?></strong><span><?php echo esc_html( $s[1] ); ?></span></div><?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
	<section class="section compact">
		<div class="shell split route-split">
			<img class="route-image" src="<?php echo esc_url( hm_image_url( $id, 'large' ) ); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy">
			<div class="feature-panel">
				<h3>Route highlights</h3>
				<?php hm_feature_rows( hm_meta( 'highlights' ) ); ?>
			</div>
		</div>
	</section>
	<section class="section compact">
		<div class="shell">
			<div class="panel route-tips">
				<?php if ( hm_meta( 'tips' ) ) : ?>
					<h3>Good to know</h3>
					<p><?php echo esc_html( hm_meta( 'tips' ) ); ?></p>
				<?php endif; ?>
				<a class="button" href="<?php echo esc_url( hm_booking_url() ); ?>">Ride it with a guide →</a>
				<a class="button secondary" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">Browse all tours</a>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
