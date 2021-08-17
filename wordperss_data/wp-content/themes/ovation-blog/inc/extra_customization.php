<?php 

	$ovation_blog_sticky_header = get_theme_mod('ovation_blog_sticky_header');

	$ovation_blog_custom_style= "";

	if($ovation_blog_sticky_header != true){

		$ovation_blog_custom_style .='.wrap_figure.fixed{';

			$ovation_blog_custom_style .='position: static;';
			
		$ovation_blog_custom_style .='}';
	}

	$ovation_blog_logo_max_height = get_theme_mod('ovation_blog_logo_max_height');

	if($ovation_blog_logo_max_height != false){

		$ovation_blog_custom_style .='.custom-logo-link img{';

			$ovation_blog_custom_style .='max-height: '.esc_html($ovation_blog_logo_max_height).'px;';
			
		$ovation_blog_custom_style .='}';
	}