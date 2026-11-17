<?php
/**
 * Tour card. Expects $args['tour'] (WP_Post).
 */
$tour  = $args['tour'];
$id    = $tour->ID;
$title = get_the_title( $tour );
$type  = hm_meta( 'type', $id, 'Pre-Packaged' );
$info  = hm_lines( hm_meta( 'info', $id ), 2 );
$tip   = 'tour-tip-' . $id;
?>
<article class="card tour-card" data-type="<?php echo esc_attr( $type ); ?>">
	<div class="card-image">
		<img src="<?php echo esc_url( hm_image_url( $id, 'large' ) ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy">
		<span class="tag"><?php echo esc_html( $type ); ?></span>
	</div>
	<div class="card-body">
		<div class="label-row tour-title">
			<h3><?php echo esc_html( $title ); ?></h3>
			<?php if ( $info ) : ?>
				<button type="button" class="tip" aria-label="<?php echo esc_attr( 'More about ' . $title ); ?>" aria-describedby="<?php echo esc_attr( $tip ); ?>">i</button>
				<div class="tip-box tip-wide" role="tooltip" id="<?php echo esc_attr( $tip ); ?>">
					<?php foreach ( $info as $row ) : ?>
						<p><?php if ( $row[1] ) : ?><strong><?php echo esc_html( $row[0] ); ?>:</strong> <?php echo esc_html( $row[1] ); ?><?php else : ?><?php echo esc_html( $row[0] ); ?><?php endif; ?></p>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
		<p><?php echo esc_html( hm_meta( 'summary', $id ) ); ?></p>
		<?php if ( hm_meta( 'region', $id ) ) : ?>
			<div class="feature-row"><div class="iconbox">⌖</div><div><strong><?php echo esc_html( hm_meta( 'region', $id ) ); ?></strong></div></div>
		<?php endif; ?>
		<div class="card-bottom">
			<span class="price"><?php echo esc_html( hm_meta( 'price', $id ) ); ?> <small>/ rider</small></span>
			<a class="button small" href="<?php echo esc_url( hm_booking_url( $tour->post_name ) ); ?>">Reserve your spot →</a>
		</div>
	</div>
</article>
