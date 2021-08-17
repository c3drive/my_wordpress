<?php
/**
 * Displays footer site info
 *
 * @subpackage Ovation Blog
 * @since 1.0
 * @version 1.4
 */

?>
<div class="site-info">
	<?php
		echo esc_html( get_theme_mod( 'ovation_blog_footer_text' ) );
		printf(
			/* translators: %s: Blog WordPress Theme. */
			esc_html__( ' %s ', 'ovation-blog' ),
			'<a href="' . esc_attr__( 'https://www.ovationthemes.com/wordpress/free-blog-wordpress-theme/', 'ovation-blog' ) . '"> Blog WordPress Theme</a>'
		);
	?>
</div>