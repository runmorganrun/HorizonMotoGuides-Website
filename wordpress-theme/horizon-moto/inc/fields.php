<?php
/**
 * Editable fields (meta boxes) for tours, routes, guides, passes, posts and theme pages.
 *
 * Field types:
 *   text     – single line
 *   textarea – paragraph
 *   lines    – one item per line, columns separated by "|"
 *   select   – fixed choices
 *   number   – whole number
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Field definitions, keyed by post type or "template:<file>" / "front". */
function hm_field_groups() {
	$image_help = 'Optional. Used only when no Featured Image is set.';
	return array(
		'hm_tour'  => array(
			'title'  => 'Tour details',
			'fields' => array(
				array( 'type', 'Tour type', 'select', 'Used for the filter buttons on the Tours and Booking pages.', hm_tour_types() ),
				array( 'price', 'Price per rider', 'text', 'Include the $ sign, e.g. $350' ),
				array( 'region', 'Region', 'text', 'Shown under the description, e.g. San Juan Mountains' ),
				array( 'summary', 'Short description', 'textarea', 'One or two sentences shown on the tour card.' ),
				array( 'info', 'Tooltip details', 'lines', 'Shown when riders hover the "i" button. One item per line: Label | Text' ),
				array( 'image_url', 'Image URL', 'text', $image_help ),
			),
		),
		'hm_route' => array(
			'title'  => 'Route page',
			'fields' => array(
				array( 'road', 'Road label', 'text', 'Shown above the title, e.g. SH 82 · Twin Lakes to Aspen' ),
				array( 'intro', 'Introduction', 'textarea', '' ),
				array( 'stats', 'Stats bar', 'lines', 'Up to 3 lines: Value | Label, e.g. About 40 mi | Twin Lakes to Aspen' ),
				array( 'highlights', 'Route highlights', 'lines', 'One per line: Title | Description' ),
				array( 'tips', 'Good to know', 'textarea', '' ),
				array( 'image_url', 'Image URL', 'text', $image_help ),
			),
		),
		'hm_guide' => array(
			'title'  => 'Guide profile',
			'fields' => array(
				array( 'role', 'Role', 'text', 'e.g. Lead Mountain Guide' ),
				array( 'focus', 'Specialty tag', 'text', 'Shown on the photo, e.g. Technical Alpine Routes' ),
				array( 'bio', 'Short bio', 'textarea', '' ),
				array( 'area', 'Area', 'text', 'e.g. Colorado Rockies, San Juan Range' ),
				array( 'languages', 'Languages', 'text', 'e.g. English, Spanish' ),
				array( 'years', 'Experience', 'text', 'e.g. 12+ Years Riding' ),
				array( 'image_url', 'Image URL', 'text', $image_help ),
			),
		),
		'hm_pass'  => array(
			'title'  => 'Pass details',
			'fields' => array(
				array( 'elevation', 'Elevation (feet)', 'number', 'Numbers only, e.g. 12095. The dashboard list is sorted by this.' ),
				array( 'road', 'Road', 'text', 'e.g. SH 82' ),
				array( 'status', 'Status', 'select', 'Shown on the private dashboard.', array( 'Open', 'Advisory', 'Closed' ) ),
			),
		),
		'post'     => array(
			'title'  => 'Article card',
			'fields' => array(
				array( 'read_time', 'Read time', 'text', 'Optional, e.g. 5 min read. Leave blank to calculate it from the article length.' ),
				array( 'image_url', 'Image URL', 'text', $image_help ),
			),
		),
		'front'    => array(
			'title'  => 'Home page sections',
			'fields' => array(
				array( 'hero_eyebrow', 'Hero label', 'text', 'Small orange label above the headline.' ),
				array( 'hero_title', 'Hero headline', 'textarea', 'Line breaks are kept. The hero background is this page\'s Featured Image.' ),
				array( 'hero_text', 'Hero text', 'textarea', '' ),
				array( 'hero_stats', 'Hero stats', 'lines', 'One per line: Value | Label, e.g. 850+ | Rides completed' ),
				array( 'tours_intro', 'Signature tours intro', 'textarea', 'The first 4 tours (by Order) are shown.' ),
				array( 'pricing', 'Pricing cards', 'lines', 'One card per line: Title | Price | Description | featured (type "featured" to highlight one card)' ),
				array( 'pricing_features', 'Pricing card checklist', 'lines', 'One item per line. Shown on every pricing card.' ),
				array( 'why', 'Why ride with us', 'lines', 'One per line: Title | Description' ),
				array( 'testimonials', 'Rider testimonials', 'lines', 'One per line: Quote | Name' ),
			),
		),
		'template:page-templates/tours.php'     => array(
			'title'  => 'Tours page sections',
			'fields' => array(
				array( 'steps', '"How your ride begins" steps', 'lines', 'One per line: Small label | Title | Description' ),
			),
		),
		'template:page-templates/booking.php'   => array(
			'title'  => 'Booking page sections',
			'fields' => array(
				array( 'essentials', 'Ride essentials cards', 'lines', 'One per line: Title | Description' ),
				array( 'faq', 'Frequently asked questions', 'lines', 'One per line: Question | Answer' ),
			),
		),
		'template:page-templates/guides.php'    => array(
			'title'  => 'Guides page sections',
			'fields' => array(
				array( 'safety', 'Safety & protocols cards', 'lines', 'One per line: Title | Description' ),
			),
		),
		'template:page-templates/suggest.php'   => array(
			'title'  => 'Suggest a Ride sections',
			'fields' => array(
				array( 'features', 'Feature list', 'lines', 'One per line: Title | Description' ),
				array( 'stats', 'Stats', 'lines', 'Up to 3 lines: Value | Label' ),
			),
		),
		'template:page-templates/dashboard.php' => array(
			'title'  => 'Dashboard sections',
			'fields' => array(
				array( 'tiles', 'Stat tiles', 'lines', 'One per line: Label | Value | Note' ),
				array( 'advisory', 'Pass advisory notice', 'textarea', 'Leave blank to hide. Pass statuses are edited under Mountain Passes.' ),
				array( 'policies', 'Policies', 'lines', 'One per line: Title | Tag | Details' ),
			),
		),
	);
}

/** Which field group applies to a post, if any. */
function hm_group_key_for( $post ) {
	$groups = hm_field_groups();
	if ( 'page' === $post->post_type ) {
		if ( (int) get_option( 'page_on_front' ) === (int) $post->ID ) {
			return 'front';
		}
		$key = 'template:' . get_page_template_slug( $post->ID );
		return isset( $groups[ $key ] ) ? $key : null;
	}
	return isset( $groups[ $post->post_type ] ) ? $post->post_type : null;
}

add_action( 'add_meta_boxes', function ( $post_type, $post ) {
	if ( ! $post instanceof WP_Post ) {
		return;
	}
	$key = hm_group_key_for( $post );
	if ( ! $key ) {
		return;
	}
	$group = hm_field_groups()[ $key ];
	add_meta_box( 'hm_fields', $group['title'], 'hm_render_meta_box', $post_type, 'normal', 'high', array( 'key' => $key ) );
}, 10, 2 );

function hm_render_meta_box( $post, $box ) {
	$group = hm_field_groups()[ $box['args']['key'] ];
	wp_nonce_field( 'hm_save_fields', 'hm_fields_nonce' );
	echo '<style>.hm-field{margin:0 0 18px}.hm-field label{display:block;font-weight:600;margin-bottom:5px}.hm-field input[type=text],.hm-field input[type=number],.hm-field textarea,.hm-field select{width:100%}.hm-field textarea{min-height:90px}.hm-field .description{margin-top:4px}</style>';
	foreach ( $group['fields'] as $field ) {
		list( $name, $label, $type ) = $field;
		$help    = isset( $field[3] ) ? $field[3] : '';
		$id      = 'hm_' . $name;
		$value   = get_post_meta( $post->ID, '_hm_' . $name, true );
		echo '<div class="hm-field"><label for="' . esc_attr( $id ) . '">' . esc_html( $label ) . '</label>';
		if ( 'select' === $type ) {
			echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '">';
			foreach ( $field[4] as $option ) {
				echo '<option' . selected( $value, $option, false ) . '>' . esc_html( $option ) . '</option>';
			}
			echo '</select>';
		} elseif ( 'textarea' === $type || 'lines' === $type ) {
			$rows = 'lines' === $type ? 6 : 4;
			echo '<textarea id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" rows="' . (int) $rows . '">' . esc_textarea( $value ) . '</textarea>';
		} else {
			$input_type = 'number' === $type ? 'number' : 'text';
			echo '<input type="' . esc_attr( $input_type ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '">';
		}
		if ( $help ) {
			echo '<p class="description">' . esc_html( $help ) . '</p>';
		}
		echo '</div>';
	}
}

add_action( 'save_post', function ( $post_id, $post ) {
	if ( ! isset( $_POST['hm_fields_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hm_fields_nonce'] ) ), 'hm_save_fields' ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$key = hm_group_key_for( $post );
	if ( ! $key ) {
		return;
	}
	foreach ( hm_field_groups()[ $key ]['fields'] as $field ) {
		list( $name, , $type ) = $field;
		if ( ! isset( $_POST[ 'hm_' . $name ] ) ) {
			continue;
		}
		$raw = wp_unslash( $_POST[ 'hm_' . $name ] );
		if ( 'textarea' === $type || 'lines' === $type ) {
			$value = sanitize_textarea_field( $raw );
		} elseif ( 'number' === $type ) {
			$value = '' === trim( $raw ) ? '' : (string) absint( $raw );
		} elseif ( 'select' === $type ) {
			$value = in_array( $raw, $field[4], true ) ? $raw : $field[4][0];
		} elseif ( 'image_url' === $name ) {
			$value = esc_url_raw( $raw );
		} else {
			$value = sanitize_text_field( $raw );
		}
		update_post_meta( $post_id, '_hm_' . $name, $value );
	}
}, 10, 2 );
