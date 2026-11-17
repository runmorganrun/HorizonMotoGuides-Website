<?php
/**
 * Template Name: Admin Dashboard (private)
 * Only logged-in editors and administrators can see this page. Keep the page's
 * Visibility set to Private as a second safeguard.
 */
if ( ! is_user_logged_in() ) {
	auth_redirect();
}
if ( ! current_user_can( 'edit_posts' ) ) {
	wp_die( 'This page is only available to site staff.', 'Staff only', array( 'response' => 403 ) );
}
get_header();
the_post();
$passes = get_posts( array(
	'post_type'      => 'hm_pass',
	'posts_per_page' => -1,
	'meta_key'       => '_hm_elevation',
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
) );
$tours    = hm_get( 'hm_tour', 3 );
$tiles    = hm_lines( hm_meta( 'tiles' ), 3 );
$advisory = hm_meta( 'advisory' );
$policies = hm_lines( hm_meta( 'policies' ), 3 );
$actions  = array(
	array( 'Mountain pass statuses', 'Open, close or flag passes on the status list.', admin_url( 'edit.php?post_type=hm_pass' ) ),
	array( 'Tours & prices', 'Edit tour details, prices and tooltip information.', admin_url( 'edit.php?post_type=hm_tour' ) ),
	array( 'Dashboard notices', 'Update these stat tiles, the advisory notice and policies.', get_edit_post_link( get_the_ID(), 'raw' ) ),
);
?>
<main class="dashboard">
	<section class="dashboard-live">
		<div class="shell dashboard-grid">
			<div>
				<span class="eyebrow">Live Operations · Private to staff</span>
				<h1><?php the_title(); ?></h1>
				<p class="muted"><?php echo esc_html( hm_page_intro() ); ?></p>
				<?php if ( $tiles ) : ?>
					<div class="stat-grid">
						<?php foreach ( $tiles as $t ) : ?>
							<div class="stat-tile"><span><?php echo esc_html( $t[0] ); ?></span><strong><?php echo esc_html( $t[1] ); ?></strong><span class="orange"><?php echo esc_html( $t[2] ); ?></span></div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
				<div class="panel">
					<h3>△ &nbsp; Active High-Pass Route Status</h3>
					<p class="muted"><?php echo esc_html( count( $passes ) ); ?> paved passes above 10,000 ft · edit under Mountain Passes</p>
					<div class="status-list">
						<?php foreach ( $passes as $p ) : $status = hm_meta( 'status', $p->ID, 'Open' ); ?>
							<div class="status-row">
								<span><strong>⌖ &nbsp; <?php echo esc_html( get_the_title( $p ) ); ?></strong><br><small class="muted"><?php echo esc_html( hm_meta( 'road', $p->ID ) ); ?> &nbsp; · &nbsp; <?php echo esc_html( number_format_i18n( (int) hm_meta( 'elevation', $p->ID, 0 ) ) ); ?> ft</small></span>
								<span class="status<?php echo 'Advisory' === $status ? ' warn' : ( 'Closed' === $status ? ' closed' : '' ); ?>"><?php echo esc_html( $status ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<aside>
				<div class="panel">
					<span class="eyebrow">Direct Command Deck</span>
					<h3>Mission Control Actions</h3>
					<p class="muted">Jump straight to the parts of the site you update most.</p>
					<?php foreach ( $actions as $a ) : ?>
						<div class="panel dashboard-action" style="padding:13px">
							<strong><?php echo esc_html( $a[0] ); ?></strong>
							<p class="muted"><?php echo esc_html( $a[1] ); ?></p>
							<a class="button small" href="<?php echo esc_url( $a[2] ); ?>">Open editor</a>
						</div>
					<?php endforeach; ?>
					<p class="muted">Navigation relays</p>
					<a class="button secondary small" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">Tour inventory</a>
					<a class="button secondary small" href="<?php echo esc_url( hm_booking_url() ); ?>">Bookings desk</a>
				</div>
				<?php if ( $advisory ) : ?>
					<div class="panel" style="margin-top:14px"><strong>⚑ Pass Advisory Notice</strong><p class="muted"><?php echo esc_html( $advisory ); ?></p></div>
				<?php endif; ?>
			</aside>
		</div>
	</section>
	<?php if ( $tours ) : ?>
	<section class="section">
		<div class="shell">
			<div class="section-head left">
				<span class="eyebrow">Rate Architecture</span>
				<h2>Package Architecture &amp; Rate Engine</h2>
				<p>Current rates for the first three tours. Edit prices under Tours.</p>
			</div>
			<div class="package-list">
				<h3>Active Expeditions Catalog</h3>
				<?php foreach ( $tours as $t ) : ?>
					<article class="package-item">
						<img src="<?php echo esc_url( hm_image_url( $t->ID, 'thumbnail' ) ); ?>" alt="" loading="lazy">
						<div class="package-copy"><span class="orange" style="font-size:9px"><?php echo esc_html( hm_meta( 'type', $t->ID ) ); ?></span><h3><?php echo esc_html( get_the_title( $t ) ); ?></h3><p>⌖ &nbsp; <?php echo esc_html( hm_meta( 'region', $t->ID ) ); ?></p></div>
						<div><span class="muted">CURRENT RATE</span><br><strong class="price"><?php echo esc_html( hm_meta( 'price', $t->ID ) ); ?></strong></div>
						<a class="button small" href="<?php echo esc_url( get_edit_post_link( $t->ID, 'raw' ) ); ?>">Edit tour →</a>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
	<?php if ( $policies ) : ?>
	<section class="section compact">
		<div class="shell">
			<div class="section-head">
				<span class="eyebrow">Tour Operations &amp; Risk Standards</span>
				<h2>Booking Protocols &amp; Cancellation Governance</h2>
			</div>
			<div class="panel faq" style="max-width:760px;margin:auto">
				<?php foreach ( $policies as $p ) : ?>
					<details><summary><?php echo esc_html( $p[0] ); ?><?php if ( $p[1] ) : ?> <span class="orange"> · <?php echo esc_html( $p[1] ); ?></span><?php endif; ?></summary><p><?php echo esc_html( $p[2] ); ?></p></details>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php endif; ?>
</main>
<?php
get_footer();
