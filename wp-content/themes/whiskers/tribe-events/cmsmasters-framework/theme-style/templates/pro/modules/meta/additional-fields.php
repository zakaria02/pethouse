<?php
/**
 * @cmsmasters_package 	Whiskers
 * @cmsmasters_version 	1.0.0
 */


if ( ! isset( $fields ) || empty( $fields ) || ! is_array( $fields ) ) {
	return;
}

?>

<div class="tribe-events-meta-group tribe-events-meta-group-other">
	<h5 class="tribe-events-single-section-title"><?php esc_html_e( 'Other', 'whiskers' ) ?></h5>
	<div class="cmsmasters_event_meta_info">
		<?php foreach ( $fields as $name => $value ): ?>
			<div class="cmsmasters_event_meta_info_item">
				<span class="cmsmasters_event_meta_info_item_title"><?php echo esc_html( $name );  ?></span>
				<span class="cmsmasters_event_meta_info_item_descr tribe-meta-value"><?php echo wp_kses_post($value); ?></span>
			</div>
		<?php endforeach ?>
	</div>
</div>