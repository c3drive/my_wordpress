<?php
/**
 * Theme functions and definitions
 *
 * @package responsive_blogger
 */ 


if ( ! function_exists( 'responsive_blogger_enqueue_styles' ) ) :
	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 */
	function responsive_blogger_enqueue_styles() {
		wp_enqueue_style( 'ovation-blog-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'responsive-blogger-style', get_stylesheet_directory_uri() . '/style.css', array( 'ovation-blog-style-parent' ), '1.0.0' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'responsive_blogger_enqueue_styles', 99 );

function responsive_blogger_customize_register() {
    global $wp_customize;
    $wp_customize->remove_section( 'ovation_blog_pro' );
}
add_action( 'customize_register', 'responsive_blogger_customize_register', 11 );

function responsive_blogger_customize( $wp_customize ) {

    wp_enqueue_style('customizercustom_css', esc_url( get_stylesheet_directory_uri() ). '/assets/css/customizer.css');

    $wp_customize->add_section('responsive_blogger_pro', array(
        'title'    => __('UPGRADE BLOGGER PREMIUM', 'responsive-blogger'),
        'priority' => 1,
    ));

    $wp_customize->add_setting('responsive_blogger_pro', array(
        'default'           => null,
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control(new Responsive_Blogger_Pro_Control($wp_customize, 'responsive_blogger_pro', array(
        'label'    => __('BLOGGER PREMIUM', 'responsive-blogger'),
        'section'  => 'responsive_blogger_pro',
        'settings' => 'responsive_blogger_pro',
        'priority' => 1,
    )));  

    // Horizontal Post Slider
    $wp_customize->add_section('responsive_blogger_horizontal_slider',array(
        'title' => esc_html__('Single Post Slider','responsive-blogger'),
        'description' => __( 'Image Dimension ( 600 x 300 ) px', 'responsive-blogger' ),
        'priority' => 7,
    ));

    $wp_customize->add_setting('responsive_blogger_horizontal_post_slider_arrows',array(
       'default' => true,
       'sanitize_callback'  => 'ovation_blog_sanitize_checkbox'
    ));
    $wp_customize->add_control('responsive_blogger_horizontal_post_slider_arrows',array(
       'type' => 'checkbox',
       'label' => __('Show / Hide Horizontal Post Slider','responsive-blogger'),
       'section' => 'responsive_blogger_horizontal_slider',
    ));

    $args = array('numberposts' => -1);
    $post_list = get_posts($args);
    $i = 0; 
    $pst_sls[]= __('Select','responsive-blogger');
    foreach ($post_list as $key => $p_post) {
        $pst_sls[$p_post->ID]=$p_post->post_title;
    }
    for ( $s = 1; $s <= 4; $s++ ) {
        $wp_customize->add_setting('responsive_blogger_horizontal_post_setting'.$s,array(
            'sanitize_callback' => 'ovation_blog_sanitize_choices',
        ));
        $wp_customize->add_control('responsive_blogger_horizontal_post_setting'.$s,array(
            'type'    => 'select',
            'choices' => $pst_sls,
            'label' => __('Select post','responsive-blogger'),
            'section' => 'responsive_blogger_horizontal_slider',
        ));
    }
    wp_reset_postdata();
}
add_action( 'customize_register', 'responsive_blogger_customize' );

function responsive_blogger_header_style() {
    if ( get_header_image() ) :
    $custom_css = "
        .wrap_figure{
            background-image:url('".esc_url(get_header_image())."');
            background-position: center top;
        }";
        wp_add_inline_style( 'ovation-blog-style', $custom_css );
    endif;
}
add_action( 'wp_enqueue_scripts', 'responsive_blogger_header_style' );

function responsive_blogger_setup() {    
    add_theme_support( "align-wide" );
    add_theme_support( "wp-block-styles" );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'woocommerce' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support('custom-background',array(
        'default-color' => 'ffffff',
    ));
    add_image_size( 'responsive-blogger-featured-image', 2000, 1200, true );
    add_image_size( 'responsive-blogger-thumbnail-avatar', 100, 100, true );

    $GLOBALS['content_width'] = 525;

    add_theme_support( 'html5', array(
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );

    // Add theme support for Custom Logo.
    add_theme_support( 'custom-logo', array(
        'width'       => 250,
        'height'      => 250,
        'flex-width'  => true,
    ) );

    /*
     * This theme styles the visual editor to resemble the theme style,
     * specifically font, colors, and column width.
     */
    add_editor_style( array( 'assets/css/editor-style.css') );

}
add_action( 'after_setup_theme', 'responsive_blogger_setup' );

function responsive_blogger_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'responsive-blogger' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'responsive-blogger' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
        'after_title'   => '</h3></div>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Page Sidebar', 'responsive-blogger' ),
        'id'            => 'sidebar-2',
        'description'   => __( 'Add widgets here to appear in your pages and posts', 'responsive-blogger' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<div class="widget_container"><h3 class="widget-title">',
        'after_title'   => '</h3></div>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'responsive-blogger' ),
        'id'            => 'footer-1',
        'description'   => __( 'Add widgets here to appear in your footer.', 'responsive-blogger' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'responsive-blogger' ),
        'id'            => 'footer-2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'responsive-blogger' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 3', 'responsive-blogger' ),
        'id'            => 'footer-3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'responsive-blogger' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 4', 'responsive-blogger' ),
        'id'            => 'footer-4',
        'description'   => __( 'Add widgets here to appear in your footer.', 'responsive-blogger' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'responsive_blogger_widgets_init' );

function responsive_blogger_enqueue_comments_reply() {
    if( get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'comment_form_before', 'responsive_blogger_enqueue_comments_reply' );

define('RESPONSIVE_BLOGGER_PRO_LINK',__('https://www.ovationthemes.com/wordpress/blog-wordpress-theme/','responsive-blogger'));

/* Pro control */
if (class_exists('WP_Customize_Control') && !class_exists('Responsive_Blogger_Pro_Control')):
    class Responsive_Blogger_Pro_Control extends WP_Customize_Control{

    public function render_content(){?>
        <label style="overflow: hidden; zoom: 1;">
            <div class="col-md-2 col-sm-6 upsell-btn">
                <a href="<?php echo esc_url( RESPONSIVE_BLOGGER_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE BLOGGER PREMIUM','responsive-blogger');?> </a>
            </div>
            <div class="col-md-4 col-sm-6">
                <img class="responsive_blogger_img_responsive " src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/screenshot.png">
            </div>
            <div class="col-md-3 col-sm-6">
                <h3 style="margin-top:10px; margin-left: 20px; text-decoration:underline; color:#333;"><?php esc_html_e('BLOGGER PREMIUM - Features', 'responsive-blogger'); ?></h3>
                <ul style="padding-top:10px">
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Boxed or fullwidth layout', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Shortcode Support', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Demo Importer', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Section Reordering', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Contact Page Template', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multiple Blog Layouts', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Unlimited Color Options', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Designed with HTML5 and CSS3', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Customizable Design & Code', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Cross Browser Support', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Detailed Documentation Included', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Stylish Custom Widgets', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Patterns Background', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('WPML Compatible (Translation Ready)', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Full Support', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('10+ Sections', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Live Customizer', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('AMP Ready', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Clean Code', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('SEO Friendly', 'responsive-blogger');?> </li>
                    <li class="upsell-responsive_blogger"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Supper Fast', 'responsive-blogger');?> </li>                    
                </ul>
            </div>
            <div class="col-md-2 col-sm-6 upsell-btn upsell-btn-bottom">
                <a href="<?php echo esc_url( RESPONSIVE_BLOGGER_PRO_LINK ); ?>" target="blank" class="btn btn-success btn"><?php esc_html_e('UPGRADE BLOGGER PREMIUM','responsive-blogger');?> </a>
            </div>
            <p><?php printf(__('Please review us if you love our product on %1$sWordPress.org%2$s. </br></br>  Thank You', 'responsive-blogger'), '<a target="blank" href="https://wordpress.org/support/theme/responsive-blogger/reviews/">', '</a>');
            ?></p>
        </label>
    <?php } }
endif;