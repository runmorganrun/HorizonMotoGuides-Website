<?php
/**
 * Filter buttons for the tour grid. Only shows types that have at least one tour.
 * Expects $args['tours'].
 */
$used = array();
foreach ( $args['tours'] as $tour ) {
	$used[ hm_meta( 'type', $tour->ID, 'Pre-Packaged' ) ] = true;
}
$labels = array(
	'Pre-Packaged'    => 'Pre-Packaged',
	'Custom Route'    => 'Custom Routes',
	'Multi-Day'       => 'Multi-Day',
	'Ride Submission' => 'Ride Submissions',
);
if ( count( $used ) < 2 ) {
	return;
}
?>
<div class="filters" data-filter-group="tour">
	<button class="filter active" data-filter="All">All Tours</button>
	<?php foreach ( $labels as $type => $label ) : ?>
		<?php if ( isset( $used[ $type ] ) ) : ?>
			<button class="filter" data-filter="<?php echo esc_attr( $type ); ?>"><?php echo esc_html( $label ); ?></button>
		<?php endif; ?>
	<?php endforeach; ?>
</div>
