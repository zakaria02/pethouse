<?php
/**
 * @package 	WordPress
 * @subpackage 	Whiskers
 * @version		1.0.0
 * 
 * CMSMasters Donations Campaign Horizontal Format
 * Created by CMSMasters
 * 
 */


$cmsmasters_metadata = explode(',', $cmsmasters_campaigns_metadata);

$title = (in_array('title', $cmsmasters_metadata) || is_home() || is_archive() || is_search()) ? true : false;
$excerpt = (in_array('excerpt', $cmsmasters_metadata) || is_home() || is_archive() || is_search()) ? true : false;
$donated_percent = (in_array('donated_percent', $cmsmasters_metadata) || is_home() || is_archive() || is_search()) ? true : false;

global $post;

$camp = $post;


if (is_home() || is_archive() || is_search()) {
	$cmsmasters_thumb_size = 'post-thumbnail';
} else {
	$cmsmasters_thumb_size = 'cmsmasters-square-thumb';
}
?>
<!-- Start Horizontal Campaign -->
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php 
	whiskers_thumb($camp->ID, $cmsmasters_thumb_size, true, false, true, false, true, true, false, false, 'cmsmasters_theme_icon_money');
	
	
	if ($title) {
		whiskers_donations_campaign_heading($camp->ID, 'h3', true);
	}
	
	
	if ($excerpt) {
		if ($camp->post_excerpt != '') {
			$cmsmasters_content = $camp->post_excerpt;
		} else {
			$cmsmasters_content = $camp->post_content;
		}
		
		
		whiskers_donations_campaign_exc_cont($cmsmasters_content);
	}
	
	
	if ($donated_percent) {
		whiskers_donations_campaign_donated($camp->ID, 'page', 'horizontal');
	}
	?>
</article>
<!-- Finish Horizontal Campaign -->

