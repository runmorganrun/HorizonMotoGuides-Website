<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="theme-color" content="#101114">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="topbar">
	<div class="shell nav">
		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">HORIZON MOTO <span>GUIDES</span></a>
		<button class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
		<nav class="navlinks">
			<?php foreach ( hm_menu_links() as $link ) : ?>
				<a class="<?php echo $link[2] ? 'active' : ''; ?>" href="<?php echo esc_url( $link[0] ); ?>"><?php echo esc_html( $link[1] ); ?></a>
			<?php endforeach; ?>
			<?php if ( current_user_can( 'edit_posts' ) ) : ?>
				<a class="admin-link<?php echo is_page_template( 'page-templates/dashboard.php' ) ? ' active' : ''; ?>" href="<?php echo esc_url( hm_page_url( 'dashboard' ) ); ?>">Admin Dashboard</a>
			<?php endif; ?>
			<a class="button small" href="<?php echo esc_url( hm_booking_url() ); ?>">Book Tour <span aria-hidden="true">→</span></a>
		</nav>
	</div>
</header>
