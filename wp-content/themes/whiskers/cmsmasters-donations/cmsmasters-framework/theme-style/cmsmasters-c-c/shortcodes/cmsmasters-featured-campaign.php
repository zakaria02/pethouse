<?php
/**
 * @package 	WordPress
 * @subpackage 	Whiskers
 * @version 	1.0.2
 * 
 * Content Composer Featured Campaign Shortcode
 * Created by CMSMasters
 * 
 */


extract(shortcode_atts($new_atts, $atts));


$unique_id = $shortcode_id;


$this->campaign_atts = array(
	'cmsmasters_campaign_metadata' => 	$campaign_metadata
);

$this->campaign_atts['campaign_color'] = $campaign_color;


$args = array( 
	'p' => 						$campaign, 
	'post_type' => 				'campaign', 
	'ignore_sticky_posts' => 	true 
);


$query = new WP_Query($args);


$out = '';

if ($query->have_posts()) :
	$out .= '<div id="featured_campaign_' . $unique_id . '" class="cmsmasters_featured_campaign' . 
		(($classes != '') ? ' ' . esc_attr($classes) : '') . 
		'"' . 
		(($animation != '') ? ' data-animation="' . esc_attr($animation) . '"' : '') . 
		(($animation != '' && $animation_delay != '') ? ' data-delay="' . esc_attr($animation_delay) . '"' : '') . 
	'>' . "\n";
		
		while ($query->have_posts()) : $query->the_post();
			
			$out .= cmsmasters_composer_ob_load_template('cmsmasters-donations/cmsmasters-framework/theme-style' . CMSMASTERS_THEME_STYLE . '/post-type/campaign-vertical.php', $this->campaign_atts);
			
		endwhile;
		
	$out .= '</div>' . "\n";
endif;


wp_reset_postdata();


echo whiskers_return_content($out);
