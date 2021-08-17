<?php
/**
 * Displays footer site info
 *
 * @subpackage Responsive Blogger
 * @since 1.0
 * @version 1.4
 */

?>
<div class="site-info">
	<?php
		echo esc_html( get_theme_mod( 'ovation_blog_footer_text' ) );
		printf(
			/* translators: %s: Blogger WordPress Theme. */
			'<a href="' . esc_attr__( 'https://www.ovationthemes.com/wordpress/free-blogger-wordpress-theme/', 'responsive-blogger' ) . '"> %s</a>',
            esc_html__( 'Blogger WordPress Theme', 'responsive-blogger' )
		);
	?>
</div>