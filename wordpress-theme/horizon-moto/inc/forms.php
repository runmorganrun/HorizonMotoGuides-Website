<?php
/**
 * Booking request and ride suggestion forms. Submissions are emailed to the
 * address set in Customize → Horizon Moto Settings → Form emails.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hm_form_recipient() {
	$email = hm_setting( 'form_email' );
	return is_email( $email ) ? $email : get_option( 'admin_email' );
}

/** Redirect back to the form page with a status flag. */
function hm_form_redirect( $status, $anchor ) {
	$back = wp_get_referer();
	$back = $back ? remove_query_arg( array( 'sent', 'tour' ), $back ) : home_url( '/' );
	$back = strtok( $back, '#' );
	wp_safe_redirect( add_query_arg( 'sent', $status, $back ) . '#' . $anchor );
	exit;
}

/** Shared checks: nonce and honeypot. Returns false for spam/invalid requests. */
function hm_form_valid( $action ) {
	if ( ! isset( $_POST['hm_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hm_nonce'] ) ), $action ) ) {
		return false;
	}
	// Hidden field that people never see; bots tend to fill it in.
	return empty( $_POST['hm_website'] );
}

function hm_post_field( $key, $type = 'text' ) {
	$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
	if ( 'email' === $type ) {
		return sanitize_email( $raw );
	}
	if ( 'textarea' === $type ) {
		return sanitize_textarea_field( $raw );
	}
	return sanitize_text_field( $raw );
}

/* ----- Booking request ----- */

add_action( 'admin_post_nopriv_hm_booking', 'hm_handle_booking' );
add_action( 'admin_post_hm_booking', 'hm_handle_booking' );

function hm_handle_booking() {
	if ( ! hm_form_valid( 'hm_booking' ) ) {
		hm_form_redirect( 'error', 'reserve' );
	}
	$data = array(
		'Tour'           => hm_post_field( 'tour' ),
		'Preferred date' => hm_post_field( 'preferred_date' ),
		'Name (as on ID)' => hm_post_field( 'name' ),
		'Email'          => hm_post_field( 'email', 'email' ),
		'Riders'         => hm_post_field( 'riders' ),
		'Skill level'    => hm_post_field( 'skill' ),
		'Notes'          => hm_post_field( 'notes', 'textarea' ),
	);
	if ( ! $data['Tour'] || ! $data['Name (as on ID)'] || ! is_email( $data['Email'] ) ) {
		hm_form_redirect( 'error', 'reserve' );
	}
	$body = "New tour booking request from the website:\n\n";
	foreach ( $data as $label => $value ) {
		$body .= $label . ': ' . ( '' !== $value ? $value : '—' ) . "\n";
	}
	$body .= "\nReply to this email to contact the rider.";
	$sent = wp_mail(
		hm_form_recipient(),
		'Booking request: ' . $data['Tour'] . ' (' . $data['Name (as on ID)'] . ')',
		$body,
		array( 'Reply-To: ' . $data['Name (as on ID)'] . ' <' . $data['Email'] . '>' )
	);
	hm_form_redirect( $sent ? 'booking' : 'error', 'reserve' );
}

/* ----- Ride suggestion (with optional GPX upload) ----- */

add_action( 'admin_post_nopriv_hm_suggest', 'hm_handle_suggest' );
add_action( 'admin_post_hm_suggest', 'hm_handle_suggest' );

function hm_handle_suggest() {
	if ( ! hm_form_valid( 'hm_suggest' ) ) {
		hm_form_redirect( 'error', 'suggest' );
	}
	$data = array(
		'Route name'  => hm_post_field( 'route_name' ),
		'Name'        => hm_post_field( 'name' ),
		'Email'       => hm_post_field( 'email', 'email' ),
		'Difficulty'  => hm_post_field( 'difficulty' ),
		'Description' => hm_post_field( 'description', 'textarea' ),
	);
	if ( ! $data['Route name'] || ! $data['Name'] || ! is_email( $data['Email'] ) ) {
		hm_form_redirect( 'error', 'suggest' );
	}

	$attachments = array();
	$tmp_dir     = '';
	if ( ! empty( $_FILES['gpx']['tmp_name'] ) && UPLOAD_ERR_OK === $_FILES['gpx']['error'] ) {
		$original = sanitize_file_name( wp_unslash( $_FILES['gpx']['name'] ) );
		$is_gpx   = '.gpx' === strtolower( substr( $original, -4 ) );
		if ( $is_gpx && $_FILES['gpx']['size'] <= 5 * MB_IN_BYTES && is_uploaded_file( $_FILES['gpx']['tmp_name'] ) ) {
			$tmp_dir = trailingslashit( get_temp_dir() ) . 'hm-' . wp_generate_password( 12, false );
			if ( wp_mkdir_p( $tmp_dir ) ) {
				$path = $tmp_dir . '/' . $original;
				if ( move_uploaded_file( $_FILES['gpx']['tmp_name'], $path ) ) {
					$attachments[] = $path;
				}
			}
		}
	}

	$body = "New ride suggestion from the website:\n\n";
	foreach ( $data as $label => $value ) {
		$body .= $label . ': ' . ( '' !== $value ? $value : '—' ) . "\n";
	}
	$body .= 'GPX file: ' . ( $attachments ? 'attached' : 'none' ) . "\n";
	$sent = wp_mail(
		hm_form_recipient(),
		'Ride suggestion: ' . $data['Route name'],
		$body,
		array( 'Reply-To: ' . $data['Name'] . ' <' . $data['Email'] . '>' ),
		$attachments
	);

	foreach ( $attachments as $file ) {
		wp_delete_file( $file );
	}
	if ( $tmp_dir ) {
		@rmdir( $tmp_dir ); // phpcs:ignore WordPress.PHP.NoSilencedErrors
	}
	hm_form_redirect( $sent ? 'suggest' : 'error', 'suggest' );
}

/** Message shown above a form after it is submitted. */
function hm_form_notice( $success_flag, $success_text ) {
	if ( ! isset( $_GET['sent'] ) ) {
		return;
	}
	$flag = sanitize_key( wp_unslash( $_GET['sent'] ) );
	if ( $flag === $success_flag ) {
		echo '<p class="form-alert success" role="status">' . esc_html( $success_text ) . '</p>';
	} elseif ( 'error' === $flag ) {
		echo '<p class="form-alert error" role="alert">Sorry, your message could not be sent. Please check the required fields and try again, or email us directly.</p>';
	}
}
