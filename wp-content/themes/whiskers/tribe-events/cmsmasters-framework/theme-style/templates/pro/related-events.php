<?php
/**
 * @cmsmasters_package 	Whiskers
 * @cmsmasters_version 	1.0.0
 */


$posts = tribe_get_related_posts();

if ( is_array( $posts ) && ! empty( $posts ) ) : ?>

<h2 class="tribe-events-related-events-title"><?php printf( esc_html__( 'Related %s', 'whiskers' ), tribe_get_event_label_plural() ); ?></h2>

<ul class="tribe-related-events tribe-clearfix hfeed vcalendar clearfix">
	<?php foreach ( $posts as $post ) : ?>
	<li>
		<div class="tribe-related-events-thumbnail">
			<a href="<?php echo esc_url( tribe_get_event_link( $post ) ); ?>" class="url" rel="bookmark">
				<?php echo (has_post_thumbnail($post->ID)) ? get_the_post_thumbnail($post->ID, 'cmsmasters-blog-masonry-thumb') : '<span class="cmsmasters_events_img_placeholder cmsmasters_theme_icon_image"></span>'; ?>
			</a>
		</div>
		<div class="tribe-related-event-info">
			<abbr class="published"><?php echo tribe_get_start_date(); ?></abbr>
			<h5 class="tribe-related-events-title summary"><a href="<?php echo esc_url(tribe_get_event_link( $post )); ?>" class="url" rel="bookmark"><?php echo esc_html(get_the_title( $post->ID )); ?></a></h5>
		</div>
	</li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>