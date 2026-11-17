<?php
/**
 * Template Name: Suggest a Ride
 * The page text is the intro paragraph. Suggestions are emailed (see Customize → Horizon Moto Settings → Form emails).
 */
get_header();
the_post();
$stats = hm_lines( hm_meta( 'stats' ), 2 );
?>
<main>
	<section class="shell suggest-layout" id="suggest">
		<div class="suggest-intro">
			<span class="eyebrow">Community Rides · Colorado</span>
			<h1>Share your favorite <em>mountain switchbacks</em></h1>
			<p><?php echo esc_html( hm_page_intro() ); ?></p>
			<div class="feature-panel" style="margin-top:30px"><?php hm_feature_rows( hm_meta( 'features' ) ); ?></div>
			<?php if ( $stats ) : ?>
				<div class="stats-box">
					<?php foreach ( $stats as $s ) : ?><div><strong><?php echo esc_html( $s[0] ); ?></strong><span><?php echo esc_html( $s[1] ); ?></span></div><?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="suggest-form">
			<div class="form-heading"><h2><?php the_title(); ?></h2><p>Share your route details with our guide team.</p></div>
			<form method="post" enctype="multipart/form-data" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="hm_suggest">
				<?php wp_nonce_field( 'hm_suggest', 'hm_nonce' ); ?>
				<div class="hm-trap" aria-hidden="true"><label>Website <input type="text" name="hm_website" tabindex="-1" autocomplete="off"></label></div>
				<?php hm_form_notice( 'suggest', 'Thanks for sharing your route! Our guide team will review your suggestion.' ); ?>
				<div class="field-grid">
					<div class="field full"><label for="route-name">Route name *</label><input id="route-name" name="route_name" required placeholder="e.g., Million Dollar Hwy"></div>
					<div class="field full"><label for="your-name">Your name *</label><input id="your-name" name="name" required placeholder="Alex Rider" autocomplete="name"></div>
					<div class="field"><label for="your-email">Email address *</label><input id="your-email" name="email" type="email" required placeholder="rider@email.com" autocomplete="email"></div>
					<div class="field"><label for="difficulty">Difficulty *</label><select id="difficulty" name="difficulty" required><option value="">Select level</option><option>Beginner</option><option>Intermediate</option><option>Advanced</option><option>Expert</option></select></div>
					<div class="field full"><label for="description">Route description</label><textarea id="description" name="description" placeholder="Describe the scenery and road..."></textarea></div>
					<div class="field full"><label for="gpx-file">Upload GPX file</label><label class="upload"><input id="gpx-file" name="gpx" type="file" accept=".gpx,application/gpx+xml"><span>⇧<br>Click to browse GPX file<br><small>GPX format only, max 5MB</small></span></label></div>
					<div class="field full"><button class="button" type="submit">⊙ &nbsp; Submit Ride Suggestion</button><span class="form-note" style="text-align:center">⌑ &nbsp; Secure route data submission</span></div>
				</div>
			</form>
		</div>
	</section>
</main>
<?php
get_footer();
