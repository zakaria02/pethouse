<?php 
/**
 * @package 	WordPress
 * @subpackage 	Whiskers
 * @version		1.0.0
 * 
 * Archive Template
 * Created by CMSMasters
 * 
 */


$current_tax = '';

$current_tax .= (has_term('', 'category') ? 'category' : '');
$current_tax .= (has_term('', 'pj-categs') ? 'pj-categs' : '');
$current_tax .= (has_term('', 'product_cat') ? 'product_cat' : '');
$current_tax .= (has_term('', 'tribe_events_cat') ? 'tribe_events_cat' : '');
$current_tax .= (has_term('', 'cp-categs') ? 'cp-categs' : '');
$current_tax .= (has_term('', 'events_category') ? 'events_category' : '');

?>
<article id="post-<?php the_ID(); ?>" <?php post_class('cmsmasters_archive_type'); ?>>
	<?php 
	if (!post_password_required() && has_post_thumbnail()) {
		echo '<div class="cmsmasters_archive_item_img_wrap">';
			if(get_post_type() == "profile") {
				whiskers_thumb(get_the_ID(), 'cmsmasters-project-masonry-thumb', true, false, false, false, false, true, false, false, false, 'cmsmasters_theme_icon_image', false);
			} else {
				whiskers_thumb(get_the_ID(), 'cmsmasters-square-thumb');
			}
		echo '</div>';
	}
	?>
	<div class="cmsmasters_archive_item_cont_wrap">
		<div class="cmsmasters_archive_item_type">
			<?php 
			echo '<span class="cmsmasters_archive_item_user_name">' . 
				'<a href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" rel="author" title="' . esc_attr__('Posts by', 'whiskers') . ' ' . get_the_author_meta('display_name') . '">' . get_the_author_meta('display_name') . '</a>' . 
			'</span>';
			
			$post_type_obj = get_post_type_object(get_post_type());
			
			echo '<span>' . $post_type_obj->labels->singular_name . '</span>';
			?>
		</div>
		<?php
		
		if (cmsmasters_title(get_the_ID(), false) != get_the_ID()) {
			?>
			<header class="cmsmasters_archive_item_header entry-header">
				<h3 class="cmsmasters_archive_item_title entry-title">
					<a href="<?php the_permalink(); ?>">
						<?php cmsmasters_title(get_the_ID(), true); ?>
					</a>
				</h3>
			</header>
			<?php 
		}
		
		
		if (whiskers_excerpt(55, false) != '') {
			echo cmsmasters_divpdel('<div class="cmsmasters_archive_item_content entry-content">' . "\n" . 
				wpautop(whiskers_excerpt(55, false)) . 
			'</div>' . "\n");
		}
		
		
		if (get_post_type() == 'post' || $current_tax != '') {
			echo '<footer class="cmsmasters_archive_item_info entry-meta">';
				
				if (get_post_type() == 'post') {
					echo '<span class="cmsmasters_archive_item_date_wrap">' . 
						'<abbr class="published cmsmasters_archive_item_date" title="' . esc_attr(get_the_date()) . '">';
							
							
							if (cmsmasters_title(get_the_ID(), false) == get_the_ID()) {
								echo '<a href="' . esc_url(get_permalink()) . '">' . 
									get_the_date() . 
								'</a>';
							} else {
								echo get_the_date();
							}
							
							
						echo '</abbr>' . 
						'<abbr class="dn date updated" title="' . esc_attr(get_the_modified_date()) . '">' . 
							get_the_modified_date() . 
						'</abbr>' . 
					'</span>';
				}
				
				
				if ($current_tax != '') {
					echo '<span class="cmsmasters_archive_item_category">' . 
						esc_html__('In', 'whiskers') . ' ' . 
						whiskers_get_the_category_list(get_the_ID(), $current_tax, ', ') . 
					'</span>';
				}
				
			echo '</footer>';
		}
		?>
	</div>
</article>