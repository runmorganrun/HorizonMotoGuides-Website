<?php
$links  = hm_menu_links();
$routes = hm_get( 'hm_route' );
$ig     = hm_setting( 'instagram' );
$fb     = hm_setting( 'facebook' );
?>
<footer class="footer">
	<div class="shell">
		<div class="footer-grid">
			<div>
				<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">HORIZON MOTO <span>GUIDES</span></a>
				<p><?php echo esc_html( hm_setting( 'footer_text' ) ); ?></p>
				<a class="button small" href="<?php echo esc_url( hm_booking_url() ); ?>">◎ &nbsp; Book a Tour</a>
				<?php if ( $ig || $fb ) : ?>
					<p><strong>FOLLOW OUR RIDES</strong><br>
						<?php if ( $ig ) : ?><a href="<?php echo esc_url( $ig ); ?>" target="_blank" rel="noopener">◎ Instagram</a> &nbsp; <?php endif; ?>
						<?php if ( $fb ) : ?><a href="<?php echo esc_url( $fb ); ?>" target="_blank" rel="noopener">f Facebook</a><?php endif; ?>
					</p>
				<?php endif; ?>
			</div>
			<div>
				<h4>Explore</h4>
				<div class="footer-links">
					<?php foreach ( array_slice( $links, 0, 5 ) as $link ) : ?>
						<a href="<?php echo esc_url( $link[0] ); ?>"><?php echo esc_html( $link[1] ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php if ( $routes ) : ?>
				<div>
					<h4>Top Routes</h4>
					<div class="footer-links">
						<?php foreach ( $routes as $route ) : ?>
							<a href="<?php echo esc_url( get_permalink( $route ) ); ?>"><?php echo esc_html( get_the_title( $route ) ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			<div>
				<h4>Contact Us</h4>
				<p>⌖ &nbsp; <?php echo nl2br( esc_html( hm_setting( 'address' ) ) ); ?></p>
				<p>☎ &nbsp; <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', hm_setting( 'phone' ) ) ); ?>"><?php echo esc_html( hm_setting( 'phone' ) ); ?></a></p>
				<p>✉ &nbsp; <a href="mailto:<?php echo esc_attr( antispambot( hm_setting( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( hm_setting( 'email' ) ) ); ?></a></p>
				<p>◷ &nbsp; <?php echo esc_html( hm_setting( 'hours' ) ); ?></p>
			</div>
		</div>
		<div class="copyright">
			<span>© <?php echo esc_html( gmdate( 'Y' ) ); ?> Horizon Moto Guides. All rights reserved.</span>
			<span><a href="<?php echo esc_url( hm_blog_url() ); ?>">Riding Tips</a> &nbsp;&nbsp; <a href="<?php echo esc_url( hm_page_url( 'suggest' ) ); ?>">Suggest a Ride</a></span>
		</div>
	</div>
</footer>
<div id="toast" class="toast" role="status" aria-live="polite"></div>
<?php wp_footer(); ?>
</body>
</html>
