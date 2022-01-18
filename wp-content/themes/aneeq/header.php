<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="<?php bloginfo('charset'); ?>"> 
	<?php wp_head(); ?>
	<?php 
	get_template_part('custom-color-css');
	$aneeq_theme_layout = get_theme_mod('aneeq_theme_layout', 'wide');
	$aneeq_boxed_layout_bgimg = get_theme_mod('aneeq_boxed_layout_bgimg', 'None');
	?>
</head>

<body bgcolor="red" <?php body_class($aneeq_theme_layout); if($aneeq_theme_layout=='boxed' & ($aneeq_boxed_layout_bgimg != "None") ){ ?> style="background: rgba(0, 0, 0, 0) url(<?php echo esc_url(get_template_directory_uri() . '/css/icons/icons/'); ?><?php echo esc_attr($aneeq_boxed_layout_bgimg); ?>.jpg) repeat scroll 0 0;"<?php } ?>>
	<?php $aneeq_loading_icon_setting = get_theme_mod('aneeq_loading_icon_setting','active'); 
	if($aneeq_loading_icon_setting != 'inactive' ){
	?>
		<?php wp_body_open(); ?>
		<div class="loader-wrapper">
			<div id="loader">
				<div class="position-center-center">
					<div class="ldr"></div>
				</div>
			</div>   
		</div>   
		<?php 
	}
	//WordPress header customizer 
	$aneeq_header_one_name = get_theme_mod('aneeq_header_one_name','');
	$aneeq_header_one_text = get_theme_mod('aneeq_header_one_text','');
	if ( get_header_image() != '') { ?>
		<header class="custom-header">
			<div class="wp-custom-header">
				<img src="<?php header_image(); ?>">
			</div>
			<div class="container header-content">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="">
							<?php if($aneeq_header_one_name != '') { ?>
							<h1><?php echo esc_html($aneeq_header_one_name ,'aneeq'); ?></h1>
							<?php }  if($aneeq_header_one_text != '') { ?>
							<h3><?php echo esc_html($aneeq_header_one_text ,'aneeq'); ?></h3>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</header>
	<?php } ?>
   <section class="wrapper">
		<header id="header">
				<div class="container">
					<div class="row">
						<div class="header-spacer">
							<div class="col-lg-3 col-sm-3 col-xs-12">
								<div class="site-logo">
									<!-- image logo -->
									<?php if(has_custom_logo()):?>
									<div class="logo-image">
										<?php the_custom_logo();?>
									</div>
									<?php endif;?>
									
									<!-- text logo -->
									<?php if (display_header_text() == true ) { ?>
									<?php $aneeq_site_description = get_bloginfo( 'description', 'display' ); ?>
									<div class="logo-text">
										<h2 class="site-title <?php if(!has_custom_logo()) echo 'text-logo'; ?>">
											<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name', 'display' ); ?></a>
										</h2>
										<?php 
											if ( $aneeq_site_description || is_customize_preview() ) : ?>
												<p class="site-description"><?php echo esc_html($aneeq_site_description);?></p>
										<?php endif; ?>
									</div>
									<?php } ?>
								</div>
							</div>

							<!-- Navigation -->
							<div class="col-lg-9 col-sm-9 col-xs-12">
								<div class="navbar navbar-default navbar-static-top" role="navigation">
									<div class="navbar-header">
										<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
											<span class="sr-only"> <?php esc_html_e('Toggle Navigation','aneeq') ?></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
											<span class="icon-bar"></span>
										</button>
									</div>
									<div class="navbar-collapse collapse">
										<?php
										$args = array(
											'theme_location'  	 => 'primary-menu',
											//'container'		 => false,
											'depth'              => 5,
											'menu_class'	 	 => 'nav navbar-nav navbar-right',
											'walker'		 	 => new Aneeq_Walker_Nav_Primary()
										);

										if (has_nav_menu('primary-menu')) {
											wp_nav_menu( $args ); 
										} 
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</header>