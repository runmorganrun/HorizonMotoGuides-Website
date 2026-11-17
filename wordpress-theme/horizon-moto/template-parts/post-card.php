<?php
/**
 * Blog article card. Expects $args['post'] (WP_Post).
 */
$item     = $args['post'];
$cats     = get_the_category( $item->ID );
$category = $cats ? $cats[0]->name : '';
$excerpt  = has_excerpt( $item ) ? get_the_excerpt( $item ) : wp_trim_words( wp_strip_all_tags( $item->post_content ), 28 );
?>
<article class="card blog-card" data-category="<?php echo esc_attr( $category ); ?>">
	<a class="card-image" href="<?php echo esc_url( get_permalink( $item ) ); ?>">
		<img src="<?php echo esc_url( hm_image_url( $item->ID, 'large' ) ); ?>" alt="<?php echo esc_attr( get_the_title( $item ) ); ?>" loading="lazy">
		<?php if ( $category ) : ?><span class="tag"><?php echo esc_html( $category ); ?></span><?php endif; ?>
	</a>
	<div class="card-body">
		<div class="meta"><span>◷ <?php echo esc_html( hm_read_time( $item->ID ) ); ?></span></div>
		<h3><a href="<?php echo esc_url( get_permalink( $item ) ); ?>"><?php echo esc_html( get_the_title( $item ) ); ?></a></h3>
		<p><?php echo esc_html( $excerpt ); ?></p>
		<div class="card-bottom"><a class="orange" href="<?php echo esc_url( get_permalink( $item ) ); ?>">Read more &nbsp; →</a></div>
	</div>
</article>
