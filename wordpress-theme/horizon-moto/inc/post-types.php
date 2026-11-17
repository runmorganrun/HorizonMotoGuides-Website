<?php
/**
 * Content types: Tours, Routes, Guides, Mountain Passes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function () {
	$common = array(
		'show_ui'      => true,
		'show_in_rest' => false, // Classic edit screen keeps the custom fields on one form.
		'supports'     => array( 'title', 'thumbnail', 'page-attributes' ),
	);

	register_post_type( 'hm_tour', $common + array(
		'labels'             => hm_labels( 'Tour', 'Tours' ),
		'public'             => false,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-location-alt',
		'menu_position'      => 5,
	) );

	register_post_type( 'hm_route', $common + array(
		'labels'        => hm_labels( 'Route', 'Top Routes' ),
		'public'        => true,
		'has_archive'   => false,
		'rewrite'       => array( 'slug' => 'route' ),
		'menu_icon'     => 'dashicons-admin-site-alt3',
		'menu_position' => 6,
	) );

	register_post_type( 'hm_guide', $common + array(
		'labels'             => hm_labels( 'Guide', 'Guides' ),
		'public'             => false,
		'publicly_queryable' => false,
		'menu_icon'          => 'dashicons-groups',
		'menu_position'      => 7,
	) );

	register_post_type( 'hm_pass', array(
		'labels'             => hm_labels( 'Mountain Pass', 'Mountain Passes' ),
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'supports'           => array( 'title' ),
		'menu_icon'          => 'dashicons-flag',
		'menu_position'      => 8,
	) );
} );

function hm_labels( $singular, $plural ) {
	return array(
		'name'          => $plural,
		'singular_name' => $singular,
		'add_new'       => 'Add ' . $singular,
		'add_new_item'  => 'Add ' . $singular,
		'edit_item'     => 'Edit ' . $singular,
		'new_item'      => 'New ' . $singular,
		'view_item'     => 'View ' . $singular,
		'search_items'  => 'Search ' . $plural,
		'not_found'     => 'No ' . strtolower( $plural ) . ' found',
		'all_items'     => 'All ' . $plural,
		'menu_name'     => $plural,
	);
}

/* ----- Admin list columns so key details are visible at a glance ----- */

add_filter( 'manage_hm_pass_posts_columns', function ( $cols ) {
	return array(
		'cb'           => $cols['cb'],
		'title'        => 'Pass',
		'hm_elevation' => 'Elevation (ft)',
		'hm_road'      => 'Road',
		'hm_status'    => 'Status',
	);
} );
add_action( 'manage_hm_pass_posts_custom_column', function ( $col, $id ) {
	if ( 'hm_elevation' === $col ) {
		$e = hm_meta( 'elevation', $id );
		echo $e ? esc_html( number_format_i18n( (int) $e ) ) : '—';
	} elseif ( 'hm_road' === $col ) {
		echo esc_html( hm_meta( 'road', $id, '—' ) );
	} elseif ( 'hm_status' === $col ) {
		echo esc_html( hm_meta( 'status', $id, 'Open' ) );
	}
}, 10, 2 );
add_filter( 'manage_edit-hm_pass_sortable_columns', function ( $cols ) {
	$cols['hm_elevation'] = 'hm_elevation';
	return $cols;
} );

add_filter( 'manage_hm_tour_posts_columns', function ( $cols ) {
	return array(
		'cb'       => $cols['cb'],
		'title'    => 'Tour',
		'hm_type'  => 'Type',
		'hm_price' => 'Price',
		'hm_order' => 'Order',
	);
} );
add_action( 'manage_hm_tour_posts_custom_column', function ( $col, $id ) {
	if ( 'hm_type' === $col ) {
		echo esc_html( hm_meta( 'type', $id ) );
	} elseif ( 'hm_price' === $col ) {
		echo esc_html( hm_meta( 'price', $id ) );
	} elseif ( 'hm_order' === $col ) {
		echo (int) get_post_field( 'menu_order', $id );
	}
}, 10, 2 );

/* Default admin sorting: passes by elevation, tours/routes/guides by Order. */
add_action( 'pre_get_posts', function ( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}
	$type = $query->get( 'post_type' );
	if ( 'hm_pass' === $type && ( ! $query->get( 'orderby' ) || 'hm_elevation' === $query->get( 'orderby' ) ) ) {
		$query->set( 'meta_key', '_hm_elevation' );
		$query->set( 'orderby', 'meta_value_num' );
		if ( ! isset( $_GET['order'] ) ) {
			$query->set( 'order', 'DESC' );
		}
	} elseif ( in_array( $type, array( 'hm_tour', 'hm_route', 'hm_guide' ), true ) && ! $query->get( 'orderby' ) ) {
		$query->set( 'orderby', array( 'menu_order' => 'ASC', 'date' => 'ASC' ) );
	}
} );
