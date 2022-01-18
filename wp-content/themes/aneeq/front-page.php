<?php
/**
 * The template for displaying home page.
 * @package aneeq
 */

get_header();

if ( 'posts' == get_option( 'show_on_front' ) ) {
	include( get_home_template() );
} else {
	
	$enabled_sections = aneeq_get_sections();
		if( is_array( $enabled_sections ) ) {
			foreach( $enabled_sections as $section ) {

				if( ( $section['id'] == 'slider' ) ){ ?>
					<?php $enable_aneeq_slider_section = aneeq_get_option( 'enable_aneeq_slider_section' );
					if( true ==$enable_aneeq_slider_section): ?>
						<section id="<?php echo esc_attr( $section['id'] ); ?>">
							<?php get_template_part( 'frontpage-sections/index', esc_attr( $section['id'] ) ); ?>
						</section>
				<?php endif; ?>

				<?php } elseif( $section['id'] == 'service' ) { ?>
					<?php $enable_aneeq_services_section = aneeq_get_option( 'enable_aneeq_services_section' );
					if( true ==$enable_aneeq_services_section): ?>
						<section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section">
							<div class="wrapper">
							   <?php get_template_part( 'frontpage-sections/index', esc_attr( $section['id'] ) ); ?>
							</div>
						</section>
				<?php endif; ?>

			<?php } elseif( $section['id'] == 'testimonial' ) { ?>
				<?php $enable_aneeq_testimonial_section = aneeq_get_option( 'enable_aneeq_testimonial_section' );
				if( true ==$enable_aneeq_testimonial_section): ?>
					<section id="<?php echo esc_attr( $section['id'] ); ?>">
						<?php get_template_part( 'frontpage-sections/index', esc_attr( $section['id'] ) ); ?>
					</section>
			<?php endif; ?>

			<?php } elseif( ( $section['id'] == 'blog' ) ){ ?>
				<?php $enable_blog_section = aneeq_get_option( 'enable_blog_section' );
				if(true ==$enable_blog_section): ?>
					<section id="<?php echo esc_attr( $section['id'] ); ?>" class="blog-posts-wrapper page-section">
						<div class="wrapper">
						   <?php get_template_part( 'frontpage-sections/index', esc_attr( $section['id'] ) ); ?>
						</div>
					</section>
				<?php endif;
			} elseif( ( $section['id'] == 'wooproduct' ) ){ ?>
				<?php $enable_woo_section = aneeq_get_option( 'enable_woo_section' );
				if(true ==$enable_woo_section): ?>
					<section id="<?php echo esc_attr( $section['id'] ); ?>" class="blog-posts-wrapper page-section">
						<div class="wrapper">
						   <?php get_template_part( 'frontpage-sections/index', esc_attr( $section['id'] ) ); ?>
						</div>
					</section>
				<?php endif;
			}
		}
	}
	
	$aneeq_static_page_setting = get_theme_mod('aneeq_static_page_setting', 'active');
	if($aneeq_static_page_setting == 'active') {
		include( get_page_template() );
	}
}
get_footer();