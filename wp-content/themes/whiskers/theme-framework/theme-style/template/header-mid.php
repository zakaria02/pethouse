<?php 
/**
 * @package 	WordPress
 * @subpackage 	Whiskers
 * @version		1.0.0
 * 
 * Header Middle Template
 * Created by CMSMasters
 * 
 */


$cmsmasters_option = whiskers_get_global_options();


echo '<div class="header_mid" data-height="' . esc_attr($cmsmasters_option['whiskers' . '_header_mid_height']) . '">' . 
	'<div class="header_mid_outer">' . 
		'<div class="header_mid_inner">';
			do_action('cmsmasters_before_header_mid', $cmsmasters_option);
			
			do_action('cmsmasters_before_logo', $cmsmasters_option);
			echo '<div class="logo_wrap">';
				
				whiskers_logo();
				
			echo '</div>';
			do_action('cmsmasters_after_logo', $cmsmasters_option);
			
			
			if (
				$cmsmasters_option['whiskers' . '_header_styles'] != 'c_nav'
			) { 
				if (
					$cmsmasters_option['whiskers' . '_header_add_cont'] == 'cust_html' && 
					$cmsmasters_option['whiskers' . '_header_add_cont_cust_html'] !== ''
				) {
					echo '<div class="slogan_wrap">' . 
						'<div class="slogan_wrap_inner">' . 
							'<div class="slogan_wrap_text">' . 
								stripslashes($cmsmasters_option['whiskers' . '_header_add_cont_cust_html']) . 
							'</div>' . 
						'</div>' . 
					'</div>';
				} elseif (
					$cmsmasters_option['whiskers' . '_header_add_cont'] == 'social' && 
					isset($cmsmasters_option['whiskers' . '_social_icons'])
				) {
					whiskers_social_icons();
				}
			}
			
			
			if ($cmsmasters_option['whiskers' . '_header_styles'] == 'default') {
				echo '<div class="resp_mid_nav_wrap">' . 
					'<div class="resp_mid_nav_outer">' . 
						'<a class="responsive_nav resp_mid_nav" href="' . esc_js("javascript:void(0)") . '">' . 
							'<span></span>' . 
						'</a>' . 
					'</div>' . 
				'</div>';
			}
			
			
			if (CMSMASTERS_WOOCOMMERCE) {
				whiskers_woocommerce_header_cart_link($cmsmasters_option); 
			}
			
			if (
				$cmsmasters_option['whiskers' . '_header_styles'] == 'default' && 
				$cmsmasters_option['whiskers' . '_header_mid_button'] == 1 && 
				$cmsmasters_option['whiskers' . '_header_mid_button_text'] != '' && 
				$cmsmasters_option['whiskers' . '_header_mid_button_link'] != '' 
			) {
				echo '<div class="header_mid_button_wrap">' . 
					'<a href="' . esc_url($cmsmasters_option['whiskers' . '_header_mid_button_link']) . '" class="cmsmasters_button header_mid_button">' . esc_html($cmsmasters_option['whiskers' . '_header_mid_button_text']) . '</a>' . 
				'</div>';
			}

			if (
				$cmsmasters_option['whiskers' . '_header_search'] && 
				$cmsmasters_option['whiskers' . '_header_styles'] != 'c_nav'
			) {
				echo '<div class="mid_search_but_wrap">' . 
					'<a href="' . esc_js("javascript:void(0)") . '" class="mid_search_but cmsmasters_header_search_but cmsmasters-icon-search-1"></a>' . 
				'</div>';
			}			
			
			
			if ($cmsmasters_option['whiskers' . '_header_styles'] == 'default') {
				echo '<!-- Start Navigation -->' . 
				'<div class="mid_nav_wrap">' . 
					'<nav>';
						
						$nav_args = array( 
							'theme_location' => 	'primary', 
							'menu_id' => 			'navigation', 
							'menu_class' => 		'mid_nav navigation', 
							'link_before' => 		'<span class="nav_item_wrap">', 
							'link_after' => 		'</span>', 
							'fallback_cb' => 		false
						);
						
						
						if (class_exists('Walker_Cmsmasters_Nav_Mega_Menu')) {
							$nav_args['walker'] = new Walker_Cmsmasters_Nav_Mega_Menu();
						}
						
						
						wp_nav_menu($nav_args);
						
					echo '</nav>' . 
				'</div>' . 
				'<!-- Finish Navigation -->';
			}
			
			
			do_action('cmsmasters_after_header_mid', $cmsmasters_option);
		echo '</div>' . 
	'</div>' . 
'</div>';

