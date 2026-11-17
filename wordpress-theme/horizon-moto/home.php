<?php
/**
 * Blog index (the page chosen as "Posts page" in Settings → Reading) and category archives.
 * The intro text comes from the Posts page's own text.
 */
get_header();
$blog_id = (int) get_option( 'page_for_posts' );
$title   = is_category() ? single_cat_title( '', false ) : ( $blog_id ? get_the_title( $blog_id ) : 'Mountain Ride Dispatches' );
$intro   = is_category() ? wp_strip_all_tags( category_description() ) : ( $blog_id ? hm_page_intro( $blog_id ) : '' );
$cats    = get_categories( array( 'hide_empty' => true ) );
?>
<main>
	<section class="section">
		<div class="shell">
			<div class="section-head left" style="max-width:none;display:flex;align-items:end;justify-content:space-between;gap:25px;flex-wrap:wrap">
				<div>
					<span class="eyebrow">Ride Intel</span>
					<h1 class="page-title"><?php echo esc_html( $title ); ?></h1>
					<?php if ( $intro ) : ?><p class="subhead"><?php echo esc_html( $intro ); ?></p><?php endif; ?>
				</div>
				<?php if ( is_category() ) : ?>
					<a class="button secondary" href="<?php echo esc_url( hm_blog_url() ); ?>">▣ &nbsp; View all posts</a>
				<?php endif; ?>
			</div>
			<hr style="border:0;border-top:1px solid var(--line);margin:38px 0 30px">
			<?php if ( ! is_category() && count( $cats ) > 1 ) : ?>
				<div class="filters" data-filter-group="article">
					<button class="filter active" data-filter="All">All</button>
					<?php foreach ( $cats as $cat ) : ?>
						<button class="filter" data-filter="<?php echo esc_attr( $cat->name ); ?>"><?php echo esc_html( $cat->name ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if ( have_posts() ) : ?>
				<div class="grid three" id="blog-grid">
					<?php
					while ( have_posts() ) {
						the_post();
						get_template_part( 'template-parts/post-card', null, array( 'post' => get_post() ) );
					}
					?>
				</div>
				<div class="pagination"><?php echo wp_kses_post( paginate_links() ); ?></div>
			<?php else : ?>
				<p class="empty-state">No articles yet. Check back soon.</p>
			<?php endif; ?>
			<div class="banner-cta">
				<div><h3>Have a ride to suggest?</h3><p>Share your favorite Colorado routes with our community of riders.</p></div>
				<div class="button-row">
					<a class="button" href="<?php echo esc_url( hm_page_url( 'suggest' ) ); ?>">Submit a ride</a>
					<a class="button secondary" href="<?php echo esc_url( hm_page_url( 'tours' ) ); ?>">Browse tours</a>
				</div>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
