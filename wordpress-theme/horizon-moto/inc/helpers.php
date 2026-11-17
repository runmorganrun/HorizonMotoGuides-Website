<?php
/**
 * Small helpers used across templates.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Read a theme meta field (stored with an _hm_ prefix). */
function hm_meta( $key, $post_id = null, $default = '' ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	$value   = get_post_meta( $post_id, '_hm_' . $key, true );
	return ( '' === $value || null === $value ) ? $default : $value;
}

/**
 * Parse a "one item per line" field. Each line is split on "|" into $parts trimmed columns.
 * Blank lines are skipped. Missing columns come back as empty strings.
 */
function hm_lines( $text, $parts = 2 ) {
	$items = array();
	foreach ( preg_split( '/\r\n|\r|\n/', (string) $text ) as $line ) {
		$line = trim( $line );
		if ( '' === $line ) {
			continue;
		}
		$cols = array_map( 'trim', explode( '|', $line, $parts ) );
		$items[] = array_pad( $cols, $parts, '' );
	}
	return $items;
}

/** Featured image URL, falling back to the "Image URL" field, then a stock photo. */
function hm_image_url( $post_id, $size = 'large' ) {
	if ( has_post_thumbnail( $post_id ) ) {
		return get_the_post_thumbnail_url( $post_id, $size );
	}
	$url = hm_meta( 'image_url', $post_id );
	return $url ? $url : hm_stock_photo( 'mountains' );
}

/** Stock photos used by the original design (Unsplash). */
function hm_stock_photo( $name, $width = 900 ) {
	$photos = array(
		'pass'      => 'photo-1519681393784-d120267933ba',
		'road'      => 'photo-1500530855697-b586d89ba3ee',
		'mountains' => 'photo-1464822759023-fed622ff2c3b',
		'forest'    => 'photo-1448375240586-882707db888b',
		'sunset'    => 'photo-1500534623283-312aade485b7',
		'ride'      => 'photo-1558981806-ec527fa84c39',
		'peak'      => 'photo-1464278533981-50106e6176b1',
		'map'       => 'photo-1500534623283-312aade485b7',
	);
	$id = isset( $photos[ $name ] ) ? $photos[ $name ] : $photos['mountains'];
	return 'https://images.unsplash.com/' . $id . '?auto=format&fit=crop&w=' . (int) $width . '&q=82';
}

/** Customizer setting with default. */
function hm_opt( $key, $default = '' ) {
	return get_theme_mod( 'hm_' . $key, $default );
}

/** URL of the first published page using a given page template, or the home URL. */
function hm_page_url( $template ) {
	static $cache = array();
	if ( isset( $cache[ $template ] ) ) {
		return $cache[ $template ];
	}
	$pages = get_posts( array(
		'post_type'      => 'page',
		'post_status'    => array( 'publish', 'private' ),
		'meta_key'       => '_wp_page_template',
		'meta_value'     => 'page-templates/' . $template . '.php',
		'posts_per_page' => 1,
		'fields'         => 'ids',
	) );
	$cache[ $template ] = $pages ? get_permalink( $pages[0] ) : home_url( '/' );
	return $cache[ $template ];
}

function hm_blog_url() {
	$id = (int) get_option( 'page_for_posts' );
	return $id ? get_permalink( $id ) : home_url( '/' );
}

function hm_tour_types() {
	return array( 'Pre-Packaged', 'Custom Route', 'Multi-Day', 'Ride Submission' );
}

/** Published posts of a theme content type, in the order set by the "Order" field. */
function hm_get( $post_type, $limit = -1 ) {
	return get_posts( array(
		'post_type'      => $post_type,
		'posts_per_page' => $limit,
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'ASC' ),
	) );
}

/**
 * Links for the main menu. Uses the "Main menu" set in Appearance → Menus,
 * or falls back to the theme's standard pages.
 * Returns arrays of [ url, label, is_current ].
 */
function hm_menu_links() {
	$current_id = get_queried_object_id();
	$links      = array();
	$locations  = get_nav_menu_locations();
	if ( ! empty( $locations['primary'] ) ) {
		$items = wp_get_nav_menu_items( $locations['primary'] );
		foreach ( (array) $items as $item ) {
			if ( (int) $item->menu_item_parent ) {
				continue;
			}
			$is_current = (int) $item->object_id === $current_id && 'custom' !== $item->type;
			if ( (int) $item->object_id === (int) get_option( 'page_for_posts' ) && ( is_singular( 'post' ) || is_category() ) ) {
				$is_current = true;
			}
			$links[] = array( $item->url, $item->title, $is_current );
		}
		return $links;
	}
	$fallback = array(
		array( hm_page_url( 'tours' ), 'Tours' ),
		array( hm_page_url( 'booking' ), 'Booking' ),
		array( hm_blog_url(), 'Blog' ),
		array( hm_page_url( 'guides' ), 'Guides' ),
		array( hm_page_url( 'suggest' ), 'Suggest a Ride' ),
	);
	foreach ( $fallback as $link ) {
		$links[] = array( $link[0], $link[1], false );
	}
	return $links;
}

/** Booking page URL, optionally preselecting a tour. */
function hm_booking_url( $tour_slug = '' ) {
	$url = hm_page_url( 'booking' );
	return $tour_slug ? add_query_arg( 'tour', $tour_slug, $url ) . '#reserve' : $url;
}

/** Estimated read time for a post: the "Read time" field, or calculated from word count. */
function hm_read_time( $post_id ) {
	$manual = hm_meta( 'read_time', $post_id );
	if ( $manual ) {
		return $manual;
	}
	$words = str_word_count( wp_strip_all_tags( get_post_field( 'post_content', $post_id ) ) );
	return max( 1, (int) ceil( $words / 220 ) ) . ' min read';
}

/** Output a section of "Title | Text" feature rows. */
function hm_feature_rows( $text, $icon = '⌖' ) {
	foreach ( hm_lines( $text, 2 ) as $row ) {
		printf(
			'<div class="feature-row"><div class="iconbox">%s</div><div><strong>%s</strong><p>%s</p></div></div>',
			esc_html( $icon ),
			esc_html( $row[0] ),
			esc_html( $row[1] )
		);
	}
}

/** Plain-text intro for page heroes, taken from the page's own text in the editor. */
function hm_page_intro( $post_id = null ) {
	$post_id = $post_id ? $post_id : get_the_ID();
	return trim( wp_strip_all_tags( strip_shortcodes( get_post_field( 'post_content', $post_id ) ) ) );
}
