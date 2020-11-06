<?php
/**
 * @package 	WordPress
 * @subpackage 	Whiskers
 * @version		1.0.0
 * 
 * Post Masonry Template
 * Created by CMSMasters
 * 
 */


$cmsmasters_post_metadata = !is_home() ? explode(',', $cmsmasters_metadata) : array();


$date = (in_array('date', $cmsmasters_post_metadata) || is_home()) ? true : false;
$categories = (get_the_category() && (in_array('categories', $cmsmasters_post_metadata) || is_home())) ? true : false;
$author = (in_array('author', $cmsmasters_post_metadata) || is_home()) ? true : false;
$comments = (comments_open() && (in_array('comments', $cmsmasters_post_metadata) || is_home())) ? true : false;
$likes = (in_array('likes', $cmsmasters_post_metadata) || is_home()) ? true : false;
$more = (in_array('more', $cmsmasters_post_metadata) || is_home()) ? true : false;


$post_sort_categs = get_the_terms(0, 'category');

if ($post_sort_categs != '') {
	$post_categs = '';
	
	foreach ($post_sort_categs as $post_sort_categ) {
		$post_categs .= ' ' . $post_sort_categ->slug;
	}
	
	$post_categs = ltrim($post_categs, ' ');
}


$cmsmasters_post_format = get_post_format();

?>
<!-- Start Post Masonry Article -->
<article id="post-<?php the_ID(); ?>" <?php post_class('cmsmasters_post_masonry'); ?> data-category="<?php echo esc_attr($post_categs); ?>">
	<div class="cmsmasters_post_cont">
		<?php
		if ($cmsmasters_post_format == 'image') {
			$cmsmasters_post_image_link = get_post_meta(get_the_ID(), 'cmsmasters_post_image_link', true);
			
			whiskers_post_type_image(get_the_ID(), $cmsmasters_post_image_link);
		} elseif ($cmsmasters_post_format == 'gallery') {
			$cmsmasters_post_images = explode(',', str_replace(' ', '', str_replace('img_', '', get_post_meta(get_the_ID(), 'cmsmasters_post_images', true))));
			
			$slider_data = ' data-auto-height="false"';
			
			whiskers_post_type_slider(get_the_ID(), $cmsmasters_post_images, 'cmsmasters-blog-masonry-thumb', $slider_data);
		} elseif ($cmsmasters_post_format == '' && !post_password_required() && has_post_thumbnail()) {
			whiskers_thumb(get_the_ID(), 'cmsmasters-blog-masonry-thumb', true, false, true, false, true, true, false);
		} elseif ($cmsmasters_post_format == 'video') {
			$cmsmasters_post_video_type = get_post_meta(get_the_ID(), 'cmsmasters_post_video_type', true);
			$cmsmasters_post_video_link = get_post_meta(get_the_ID(), 'cmsmasters_post_video_link', true);
			$cmsmasters_post_video_links = get_post_meta(get_the_ID(), 'cmsmasters_post_video_links', true);
			
			whiskers_post_type_video(get_the_ID(), $cmsmasters_post_video_type, $cmsmasters_post_video_link, $cmsmasters_post_video_links, 'cmsmasters-blog-masonry-thumb');
		}
		?>
		<div class="cmsmasters_post_cont_inner">
			<?php
			if ($categories || $author) {
				echo '<div class="cmsmasters_post_cont_info entry-meta">';
				
					$categories ? whiskers_get_post_category(get_the_ID(), 'category', 'page') : '';
					
					$author ? whiskers_get_post_author('page') : '';
					
				echo '</div>';
			}
			
			
			whiskers_post_heading(get_the_ID(), 'h3');
			
			
			if ($cmsmasters_post_format == 'audio') {
				$cmsmasters_post_audio_links = get_post_meta(get_the_ID(), 'cmsmasters_post_audio_links', true);
				
				whiskers_post_type_audio($cmsmasters_post_audio_links);
			}
			
			
			whiskers_post_exc_cont();
			
			
			$more ? whiskers_post_more(get_the_ID()) : '';
			
			
			if ($date || $likes || $comments) {
				echo '<footer class="cmsmasters_post_footer entry-meta">';
					
					$date  ? whiskers_get_post_date('page', 'masonry') : '';
					
					
					if ($date || $likes || $comments) {
						echo '<div class="cmsmasters_post_meta_info">';
					
							$likes ? whiskers_get_post_likes('page') : '';
							
							$comments ? whiskers_get_post_comments('page') : '';
							
						echo '</div>';
						
					}
					
				echo '</footer>';
			}
			?>
		</div>
	</div>
</article>
<!-- Finish Post Masonry Article -->

