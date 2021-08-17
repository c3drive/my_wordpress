<?php
/**
 * Ovation Blog: Customizer
 *
 * @subpackage Ovation Blog
 * @since 1.0
 */

function ovation_blog_customize_register( $wp_customize ) {

	wp_enqueue_style('customizercustom_css', esc_url( get_template_directory_uri() ). '/assets/css/customizer.css');

	// Add custom control.
  	require get_parent_theme_file_path( 'inc/customize/customize_toggle.php' );

	// Register the custom control type.
	$wp_customize->register_control_type( 'Ovation_Blog_Toggle_Control' );

 	$wp_customize->add_section('ovation_blog_pro', array(
        'title'    => __('UPGRADE BLOG PREMIUM', 'ovation-blog'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('ovation_blog_pro', array(
        'default'           => null,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new Ovation_Blog_Pro_Control($wp_customize, 'ovation_blog_pro', array(
        'label'    => __('BLOG PREMIUM', 'ovation-blog'),
        'section'  => 'ovation_blog_pro',
        'settings' => 'ovation_blog_pro',
        'priority' => 1,
    )));

    // Theme General Settings
    $wp_customize->add_section('ovation_blog_theme_settings',array(
        'title' => __('Theme General Settings', 'ovation-blog'),
        'priority' => 1,
    ) );

    $wp_customize->add_setting( 'ovation_blog_sticky_header', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'ovation_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Ovation_Blog_Toggle_Control( $wp_customize, 'ovation_blog_sticky_header', array(
		'label'       => esc_html__( 'Show Sticky Header', 'ovation-blog' ),
		'section'     => 'ovation_blog_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'ovation_blog_sticky_header',
	) ) );

    $wp_customize->add_setting( 'ovation_blog_theme_loader', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'ovation_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Ovation_Blog_Toggle_Control( $wp_customize, 'ovation_blog_theme_loader', array(
		'label'       => esc_html__( 'Show Site Loader', 'ovation-blog' ),
		'section'     => 'ovation_blog_theme_settings',
		'type'        => 'toggle',
		'settings'    => 'ovation_blog_theme_loader',
	) ) );

    // Post Layouts
    $wp_customize->add_section('ovation_blog_layout',array(
        'title' => __('Post Layout', 'ovation-blog'),
        'description' => __( 'Change the post layout from below options', 'ovation-blog' ),
        'priority' => 2,
    ) );

	$wp_customize->add_setting( 'ovation_blog_post_sidebar', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'ovation_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Ovation_Blog_Toggle_Control( $wp_customize, 'ovation_blog_post_sidebar', array(
		'label'       => esc_html__( 'Show Fullwidth', 'ovation-blog' ),
		'section'     => 'ovation_blog_layout',
		'type'        => 'toggle',
		'settings'    => 'ovation_blog_post_sidebar',
	) ) );

	$wp_customize->add_setting( 'ovation_blog_single_post_sidebar', array(
		'default'           => false,
		'transport'         => 'refresh',
		'sanitize_callback' => 'ovation_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Ovation_Blog_Toggle_Control( $wp_customize, 'ovation_blog_single_post_sidebar', array(
		'label'       => esc_html__( 'Show Single Post Fullwidth', 'ovation-blog' ),
		'section'     => 'ovation_blog_layout',
		'type'        => 'toggle',
		'settings'    => 'ovation_blog_single_post_sidebar',
	) ) );

    $wp_customize->add_setting('ovation_blog_post_option',array(
		'default' => 'simple_post',
		'sanitize_callback' => 'ovation_blog_sanitize_select'
	));
	$wp_customize->add_control('ovation_blog_post_option',array(
		'label' => esc_html__('Select Layout','ovation-blog'),
		'section' => 'ovation_blog_layout',
		'setting' => 'ovation_blog_post_option',
		'type' => 'radio',
        'choices' => array(
            'simple_post' => __('Simple Post','ovation-blog'),
            'grid_post' => __('Grid Post','ovation-blog'),
        ),
	));

    $wp_customize->add_setting('ovation_blog_grid_column',array(
		'default' => '3_column',
		'sanitize_callback' => 'ovation_blog_sanitize_select'
	));
	$wp_customize->add_control('ovation_blog_grid_column',array(
		'label' => esc_html__('Grid Post Per Row','ovation-blog'),
		'section' => 'ovation_blog_layout',
		'setting' => 'ovation_blog_grid_column',
		'type' => 'radio',
        'choices' => array(
            '1_column' => __('1','ovation-blog'),
            '2_column' => __('2','ovation-blog'),
            '3_column' => __('3','ovation-blog'),
            '4_column' => __('4','ovation-blog'),
            '5_column' => __('6','ovation-blog'),
        ),
	));

	// Social Media
    $wp_customize->add_section('ovation_blog_urls',array(
        'title' => __('Social Media', 'ovation-blog'),
        'description' => __( 'Add social media links in the below feilds', 'ovation-blog' ),
        'priority' => 3,
    ) );
    
	$wp_customize->add_setting('ovation_blog_facebook',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	)); 
	$wp_customize->add_control('ovation_blog_facebook',array(
		'label' => esc_html__('Facebook URL','ovation-blog'),
		'section' => 'ovation_blog_urls',
		'setting' => 'ovation_blog_facebook',
		'type'    => 'url'
	));

	$wp_customize->add_setting('ovation_blog_twitter',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	)); 
	$wp_customize->add_control('ovation_blog_twitter',array(
		'label' => esc_html__('Twitter URL','ovation-blog'),
		'section' => 'ovation_blog_urls',
		'setting' => 'ovation_blog_twitter',
		'type'    => 'url'
	));

	$wp_customize->add_setting('ovation_blog_linkedin',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	)); 
	$wp_customize->add_control('ovation_blog_linkedin',array(
		'label' => esc_html__('Linkedin URL','ovation-blog'),
		'section' => 'ovation_blog_urls',
		'setting' => 'ovation_blog_linkedin',
		'type'    => 'url'
	));

	$wp_customize->add_setting('ovation_blog_youtube',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	)); 
	$wp_customize->add_control('ovation_blog_youtube',array(
		'label' => esc_html__('Youtube URL','ovation-blog'),
		'section' => 'ovation_blog_urls',
		'setting' => 'ovation_blog_youtube',
		'type'    => 'url'
	));

	$wp_customize->add_setting('ovation_blog_instagram',array(
		'default' => '',
		'sanitize_callback' => 'esc_url_raw'
	)); 
	$wp_customize->add_control('ovation_blog_instagram',array(
		'label' => esc_html__('Instagram URL','ovation-blog'),
		'section' => 'ovation_blog_urls',
		'setting' => 'ovation_blog_instagram',
		'type'    => 'url'
	));

    //Slider
	$wp_customize->add_section( 'ovation_blog_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'ovation-blog' ),
    	'description' => __( 'Image Dimension ( 700 x 795 ) px', 'ovation-blog' ),
		'priority'   => 4,
	) );

	$wp_customize->add_setting('ovation_blog_slider_arrows',array(
       'default' => true,
       'sanitize_callback'	=> 'sanitize_text_field'
    ));
    $wp_customize->add_control('ovation_blog_slider_arrows',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide slider','ovation-blog'),
       'section' => 'ovation_blog_slider_section',
    ));

	// $post_list = get_posts();
	$args = array('numberposts' => -1); 
	$post_list = get_posts($args);
	$i = 0;	
	$pst_sls[]= __('Select','ovation-blog');
	foreach ($post_list as $key => $p_post) {
		$pst_sls[$p_post->ID]=$p_post->post_title;
	}
	for ( $s = 1; $s <= 4; $s++ ) {
		$wp_customize->add_setting('ovation_blog_post_setting'.$s,array(
			'sanitize_callback' => 'ovation_blog_sanitize_choices',
		));
		$wp_customize->add_control('ovation_blog_post_setting'.$s,array(
			'type'    => 'select',
			'choices' => $pst_sls,
			'label' => __('Select post','ovation-blog'),
			'section' => 'ovation_blog_slider_section',
		));
	}
	wp_reset_postdata();

	// Popular Post
	$wp_customize->add_section('ovation_blog_post',array(
		'title' => esc_html__('Popular Post','ovation-blog'),
		'description' => __( 'Image Dimension ( 270 x 295 ) px', 'ovation-blog' ),
		'priority' => 5,
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= __('Select','ovation-blog');
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('ovation_blog_post_category_setting',array(
		'default' => 0,
		'sanitize_callback' => 'ovation_blog_sanitize_select',
	));
	$wp_customize->add_control('ovation_blog_post_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => esc_html__('Select Category to display Post','ovation-blog'),
		'section' => 'ovation_blog_post',
	));

	// Top Categories
	$wp_customize->add_section('ovation_blog_top_category',array(
		'title' => esc_html__('Top Categories','ovation-blog'),
		'description' => __( 'Image Dimension ( 410 x 260 ) px', 'ovation-blog' ),
		'priority' => 6,
	));

	$wp_customize->add_setting('ovation_blog_top_category_text',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	)); 
	$wp_customize->add_control('ovation_blog_top_category_text',array(
		'label' => esc_html__('Heading Text','ovation-blog'),
		'section' => 'ovation_blog_top_category',
		'setting' => 'ovation_blog_top_category_text',
		'type'    => 'text'
	));

	$wp_customize->add_setting('ovation_blog_top_category_heading',array(
		'default' => '',
		'sanitize_callback' => 'sanitize_text_field'
	)); 
	$wp_customize->add_control('ovation_blog_top_category_heading',array(
		'label' => esc_html__('Heading','ovation-blog'),
		'section' => 'ovation_blog_top_category',
		'setting' => 'ovation_blog_top_category_heading',
		'type'    => 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_post[]= __('Select','ovation-blog');
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_post[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('ovation_blog_top_category_setting',array(
		'default' => 0,
		'sanitize_callback' => 'ovation_blog_sanitize_select',
	));
	$wp_customize->add_control('ovation_blog_top_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_post,
		'label' => esc_html__('Select Category to display Post','ovation-blog'),
		'section' => 'ovation_blog_top_category',
	));
    
	//Footer
    $wp_customize->add_section( 'ovation_blog_footer_copyright', array(
    	'title'      => esc_html__( 'Footer Text', 'ovation-blog' ),
    	'priority' => 8,
	) );

    $wp_customize->add_setting('ovation_blog_footer_text',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('ovation_blog_footer_text',array(
		'label'	=> esc_html__('Copyright Text','ovation-blog'),
		'section'	=> 'ovation_blog_footer_copyright',
		'type'		=> 'text'
	));

	//Logo
	$wp_customize->add_setting('ovation_blog_logo_max_height',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('ovation_blog_logo_max_height',array(
		'label'	=> esc_html__('Logo Width','ovation-blog'),
		'section'	=> 'title_tagline',
		'type'		=> 'number'
	));
    $wp_customize->add_setting( 'ovation_blog_logo_title', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'ovation_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Ovation_Blog_Toggle_Control( $wp_customize, 'ovation_blog_logo_title', array(
		'label'       => esc_html__( 'Show Site Title', 'ovation-blog' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'ovation_blog_logo_title',
	) ) );

    $wp_customize->add_setting( 'ovation_blog_logo_text', array(
		'default'           => true,
		'transport'         => 'refresh',
		'sanitize_callback' => 'ovation_blog_sanitize_checkbox',
	) );
	$wp_customize->add_control( new Ovation_Blog_Toggle_Control( $wp_customize, 'ovation_blog_logo_text', array(
		'label'       => esc_html__( 'Show Site Tagline', 'ovation-blog' ),
		'section'     => 'title_tagline',
		'type'        => 'toggle',
		'settings'    => 'ovation_blog_logo_text',
	) ) );

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'ovation_blog_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'ovation_blog_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'ovation_blog_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'ovation_blog_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'ovation-blog' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'ovation-blog' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'ovation_blog_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'ovation_blog_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'ovation_blog_customize_register' );

function ovation_blog_customize_partial_blogname() {
	bloginfo( 'name' );
}

function ovation_blog_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function ovation_blog_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function ovation_blog_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

define('OVATION_BLOG_PRO_LINK',__('https://www.ovationthemes.com/wordpress/blog-wordpress-theme/','ovation-blog'));

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('Ovation_Blog_Pro_Control')):
    class Ovation_Blog_Pro_Control extends WP_Customize_Control{

    public function render_content(){?>
        <label style="overflow: hidden; zoom: 1;">
	        <div class="col-md-2 col-sm-6 upsell-btn">
                <a href="<?php echo esc_url( OVATION_BLOG_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE BLOG PREMIUM','ovation-blog');?> </a>
	        </div>
            <div class="col-md-4 col-sm-6">
                <img class="ovation_blog_img_responsive " src="<?php echo esc_url(get_template_directory_uri()); ?>/screenshot.png">

            </div>
	        <div class="col-md-3 col-sm-6">
	            <h3 style="margin-top:10px; margin-left: 20px; text-decoration:underline; color:#333;"><?php esc_html_e('BLOG PREMIUM - Features', 'ovation-blog'); ?></h3>
                <ul style="padding-top:10px">
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Boxed or fullwidth layout', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Shortcode Support', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Demo Importer', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Section Reordering', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Contact Page Template', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multiple Blog Layouts', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Unlimited Color Options', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Designed with HTML5 and CSS3', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Customizable Design & Code', 'ovation-blog');?> </li>                    
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Cross Browser Support', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Detailed Documentation Included', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Stylish Custom Widgets', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Patterns Background', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('WPML Compatible (Translation Ready)', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Full Support', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('10+ Sections', 'ovation-blog');?> </li>
                    <li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Live Customizer', 'ovation-blog');?> </li>
                   	<li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('AMP Ready', 'ovation-blog');?> </li>
                   	<li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Clean Code', 'ovation-blog');?> </li>
                   	<li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('SEO Friendly', 'ovation-blog');?> </li>
                   	<li class="upsell-ovation_blog"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Supper Fast', 'ovation-blog');?> </li>                    
                </ul>
        	</div>
		    <div class="col-md-2 col-sm-6 upsell-btn upsell-btn-bottom">
	            <a href="<?php echo esc_url( OVATION_BLOG_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE BLOG PREMIUM','ovation-blog');?> </a>
		    </div>
			<p><?php printf(__('Please review us if you love our product on %1$sWordPress.org%2$s. </br></br>  Thank You', 'ovation-blog'), '<a target="blank" href="https://wordpress.org/support/theme/ovation-blog/reviews/">', '</a>');
            ?></p>
        </label>
    <?php } }
endif;