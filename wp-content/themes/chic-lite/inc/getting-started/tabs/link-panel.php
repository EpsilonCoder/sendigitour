<?php
/**
 * Right Buttons Panel.
 *
 * @package Chic_Lite
 */
?>
<div class="panel-right">
	<div class="panel-aside">
		<h4><?php esc_html_e( 'Upgrade To Pro', 'chic-lite' ); ?></h4>
		<p><?php esc_html_e( 'The Pro version of the theme allows you to change the look and feel of the website with just a few clicks. You can easily change the color, background image and pattern, as well as fonts of the website with the Pro theme. The Pro version comes with multiple layouts to help you create an attractive and engaging website. Furthermore, the premium themes are WPML and Polylang compatible to allow you to create a multilingual website with ease.', 'chic-lite' ); ?></p>
		<p><?php esc_html_e( 'Also, the premium theme gets regular updates and has a dedicated support team to solve your queries.', 'chic-lite' ); ?></p>
		<a class="button button-primary" href="<?php echo esc_url( 'https://rarathemes.com/wordpress-themes/chic-pro/' ); ?>" title="<?php esc_attr_e( 'View Premium Version', 'chic-lite' ); ?>" target="_blank">
            <?php esc_html_e( 'Read more about the features here', 'chic-lite' ); ?>
        </a>
	</div><!-- .panel-aside Theme Support -->
	<!-- Knowledge base -->
	<div class="panel-aside">
		<h4><?php esc_html_e( 'Visit the Knowledge Base', 'chic-lite' ); ?></h4>
		<p><?php esc_html_e( 'Need help with WordPress and our theme as quickly as possible? Visit our well-organized documentation.', 'chic-lite' ); ?></p>
		<p><?php esc_html_e( 'Our documentation comes with a step-by-step guide from installing WordPress to customizing our theme to creating an attractive and engaging website.', 'chic-lite' ); ?></p>

		<a class="button button-primary" href="<?php echo esc_url( 'https://docs.rarathemes.com/docs/' . CHIC_LITE_THEME_TEXTDOMAIN . '/' ); ?>" title="<?php esc_attr_e( 'Visit the knowledge base', 'chic-lite' ); ?>" target="_blank"><?php esc_html_e( 'Visit the Knowledge Base', 'chic-lite' ); ?></a>
	</div><!-- .panel-aside knowledge base -->
</div><!-- .panel-right -->