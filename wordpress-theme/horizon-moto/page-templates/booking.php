<?php
/**
 * Template Name: Booking
 * The page text is the intro under the title. Requests are emailed (see Customize → Horizon Moto Settings → Form emails).
 */
get_header();
the_post();
$tours    = hm_get( 'hm_tour' );
$selected = isset( $_GET['tour'] ) ? sanitize_title( wp_unslash( $_GET['tour'] ) ) : '';
?>
<main>
	<section class="page-hero">
		<div class="shell">
			<span class="eyebrow">Available Tours</span>
			<h1 class="page-title"><?php the_title(); ?></h1>
			<p class="subhead"><?php echo esc_html( hm_page_intro() ); ?></p>
		</div>
	</section>
	<section class="section compact" style="padding-top:0">
		<div class="shell">
			<?php get_template_part( 'template-parts/tour-filters', null, array( 'tours' => $tours ) ); ?>
			<div class="grid three" id="tour-grid">
				<?php foreach ( $tours as $tour ) { get_template_part( 'template-parts/tour-card', null, array( 'tour' => $tour ) ); } ?>
			</div>
			<div class="banner-cta">
				<div><h3>Need a custom route or private tour?</h3><p>Our guides can build bespoke itineraries for groups and specialized trips.</p></div>
				<a href="<?php echo esc_url( hm_page_url( 'suggest' ) ); ?>" class="button secondary small">Inquire About Custom Tours</a>
			</div>
		</div>
	</section>

	<section class="section" id="reserve">
		<div class="shell">
			<div class="section-head left">
				<span class="eyebrow">Tour Reservation</span>
				<h2>Request Your Horizon Moto Tour</h2>
				<p>Select your route, provide your details, and our team will confirm your spot on the next Colorado expedition.</p>
			</div>
			<form class="booking-layout" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="hm_booking">
				<input type="hidden" name="preferred_date" id="preferred-date" value="">
				<?php wp_nonce_field( 'hm_booking', 'hm_nonce' ); ?>
				<div class="hm-trap" aria-hidden="true"><label>Website <input type="text" name="hm_website" tabindex="-1" autocomplete="off"></label></div>
				<div class="panel">
					<?php hm_form_notice( 'booking', 'Thanks! Your tour request has been sent. Our guide team will be in touch to confirm your reservation.' ); ?>
					<h3>Tour details</h3>
					<p>Tell us what kind of ride you have in mind.</p>
					<div class="field-grid">
						<div class="field full">
							<label for="tour-choice">Route package</label>
							<select required id="tour-choice" name="tour">
								<option value="">Choose a tour</option>
								<?php foreach ( $tours as $tour ) : ?>
									<option<?php selected( $selected, $tour->post_name ); ?>><?php echo esc_html( get_the_title( $tour ) ); ?></option>
								<?php endforeach; ?>
								<option>Custom route request</option>
							</select>
						</div>
						<div class="field">
							<div class="label-row">
								<label for="rider-name">Your name</label>
								<button type="button" class="tip" aria-label="How should I enter my name?" aria-describedby="name-tip">i</button>
								<div class="tip-box align-left" role="tooltip" id="name-tip"><p>Enter your name exactly as it appears on your legal form of ID.</p></div>
							</div>
							<input id="rider-name" name="name" required placeholder="Alex Rider" aria-describedby="name-tip" autocomplete="name">
						</div>
						<div class="field">
							<label for="rider-email">Email address</label>
							<input id="rider-email" name="email" type="email" required placeholder="rider@email.com" autocomplete="email">
						</div>
						<div class="field">
							<label for="rider-count">Number of riders</label>
							<select id="rider-count" name="riders"><option>1 rider</option><option>2 riders</option><option>3 riders</option><option>4+ riders</option></select>
						</div>
						<div class="field">
							<div class="label-row">
								<label for="skill-level">Skill level</label>
								<button type="button" class="tip" aria-label="What do the skill levels mean?" aria-describedby="skill-tip">i</button>
								<div class="tip-box" role="tooltip" id="skill-tip">
									<p><strong>Beginner:</strong> Still learning the basics of starting, stopping, shifting, turning, and balancing at low speeds. Still building confidence in traffic. Not experienced with mountain riding.</p>
									<p><strong>Intermediate:</strong> Handles routine riding comfortably and is building consistency in tighter turns, hard braking, and changing weather and road conditions. Some experience with mountain riding.</p>
									<p><strong>Advanced:</strong> Rides with precise, smooth control in varied conditions, anticipates hazards early, and adjusts speed and positioning before problems develop.</p>
								</div>
							</div>
							<select id="skill-level" name="skill" aria-describedby="skill-tip"><option>Beginner</option><option>Intermediate</option><option>Advanced</option></select>
						</div>
						<div class="field full">
							<label for="booking-notes">Anything else we should know?</label>
							<textarea id="booking-notes" name="notes" placeholder="Tell us about your riding preferences..."></textarea>
						</div>
						<div class="field full">
							<button class="button" type="submit">Send booking request →</button>
							<span class="form-note">No payment is taken online. Our team will confirm your booking and share payment options.</span>
						</div>
					</div>
				</div>
				<aside class="panel">
					<h3>Select dates</h3>
					<p>Choose a preferred tour date.</p>
					<div class="calendar-head">
						<button class="button secondary small" type="button" data-calendar="-1" aria-label="Previous month">‹</button>
						<strong class="calendar-month"></strong>
						<button class="button secondary small" type="button" data-calendar="1" aria-label="Next month">›</button>
					</div>
					<div class="calendar" id="calendar"></div>
					<p class="form-note" id="selected-date">Select a date to continue.</p>
					<div class="feature-row"><div class="iconbox">✓</div><div><strong>Personal confirmation</strong><p>Flexible payment options and a personal guide contact.</p></div></div>
					<a class="button" href="<?php echo esc_url( hm_page_url( 'suggest' ) ); ?>" style="width:100%;margin-top:16px">Ask a question</a>
				</aside>
			</form>
		</div>
	</section>

	<section class="section compact">
		<div class="shell">
			<?php $essentials = hm_lines( hm_meta( 'essentials' ), 2 ); ?>
			<?php if ( $essentials ) : ?>
				<div class="section-head">
					<span class="eyebrow">Tour Operations &amp; Risk Standards</span>
					<h2>Plan Your <em class="orange">Adventure</em></h2>
					<p>Everything you need to know about booking, safety requirements, and tour logistics.</p>
				</div>
				<div class="grid four">
					<?php foreach ( $essentials as $e ) : ?>
						<article class="card card-body"><span class="eyebrow">Ride essentials</span><h3><?php echo esc_html( $e[0] ); ?></h3><p><?php echo esc_html( $e[1] ); ?></p></article>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="grid two" style="margin-top:35px">
				<div class="panel faq">
					<h3>Frequently Asked Questions</h3>
					<?php foreach ( hm_lines( hm_meta( 'faq' ), 2 ) as $f ) : ?>
						<details><summary><?php echo esc_html( $f[0] ); ?></summary><p><?php echo esc_html( $f[1] ); ?></p></details>
					<?php endforeach; ?>
				</div>
				<div class="panel">
					<h3>Tour Support</h3>
					<p>Need help choosing a tour or coordinating a group ride?</p>
					<p>Support line: <strong><?php echo esc_html( hm_setting( 'support_line' ) ); ?></strong><br><?php echo esc_html( hm_setting( 'hours' ) ); ?></p>
					<a class="button" href="mailto:<?php echo esc_attr( antispambot( hm_setting( 'email' ) ) ); ?>">Contact the team</a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
