<?php if ( ashe_options( 'main_nav_label' ) === true ) : ?>

<div id="main-nav" class="clear-fix">

	<div <?php echo esc_attr(ashe_options( 'general_header_width' )) === 'contained' ? 'class="boxed-wrapper"': ''; ?>>	
		
		<!-- Alt Sidebar Icon -->
		<?php if ( ashe_options( 'main_nav_show_sidebar' ) === true ) : ?>
		<div class="main-nav-sidebar">
			<div>
				<span></span>
				<span></span>
				<span></span>
			</div>
		</div>
		<?php endif; ?>

		<!-- Mini Logo -->
		<?php
		$mini_logo = ashe_get_image_src_by_url( ashe_options( 'main_nav_mini_logo' ), 'full' );

		if ( isset($mini_logo[0]) ) : ?>
		<div class="mini-logo">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( bloginfo('name') ); ?>" >
				<img src="<?php echo esc_url( $mini_logo[0] ); ?>" width="<?php echo esc_attr( $mini_logo[1] ); ?>" height="<?php echo esc_attr( $mini_logo[2] ); ?>" alt="<?php esc_attr( bloginfo('name') ); ?>">
			</a>
		</div>
		<?php endif; ?>

		<!-- Icons -->
		<div class="main-nav-icons">
			<?php if ( ashe_options( 'skins_dark_mode' ) === true && 'dark' !== ashe_options( 'skins_select' ) ) : ?>
				<div class="dark-mode-switcher">
					<i class="fa fa-moon-o" aria-hidden="true"></i>

					<?php if ( current_user_can('manage_options') ) : ?>
					<div class="dark-mode-admin-notice"><?php esc_html_e( 'To disable this option, navigate to Appearance > Customize > Skins section and uncheck "Dark Mode Switcher" option. Only logged-in admin level users can see this notice!', 'ashe' ); ?></div>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( ashe_options( 'main_nav_show_search' ) === true ) : ?>
			<div class="main-nav-search">
				<i class="fa fa-search"></i>
				<i class="fa fa-times"></i>
				<?php get_search_form(); ?>
			</div>
			<?php endif; ?>
		</div>

		<?php // Navigation Menus

		wp_nav_menu( array(
			'theme_location' 	=> 'main',
			'menu_id'        	=> 'main-menu',
			'menu_class' 		=> '',
			'container' 	 	=> 'nav',
			'container_class'	=> 'main-menu-container',
			'fallback_cb' 		=> 'ashe_main_menu_fallback'
		) );

		?>

		<!-- Mobile Menu Button -->
		<span class="mobile-menu-btn">
			<?php

			if ( 'chevron-down' === ashe_options('responsive_menu_icon') ) {
				echo '<i class="fa fa-chevron-down"></i>';
			} else {
				echo '<a>'. esc_html( ashe_options('responsive_mobile_icon_text') ) .'</a>';
			}

			?>
		</span>

		<?php
		
		$mobile_menu_location = 'main';
		$mobile_menu_items = '';

		if ( ashe_options( 'main_nav_merge_menu' ) === true ) {
			$mobile_menu_items = wp_nav_menu( array(
				'theme_location' => 'top',
				'container'		 => '',
				'items_wrap' 	 => '%3$s',
				'echo'			 => false,
				'fallback_cb'	 => false,
			) );

			if ( ! has_nav_menu('main') ) {
				$mobile_menu_location = 'top';
				$mobile_menu_items = '';
			}
		}
		

		wp_nav_menu( array(
			'theme_location' 	=> $mobile_menu_location,
			'menu_id'        	=> 'mobile-menu',
			'menu_class' 		=> '',
			'container' 	 	=> 'nav',
			'container_class'	=> 'mobile-menu-container',
			'items_wrap' 		=> '<ul id="%1$s" class="%2$s">%3$s '. $mobile_menu_items .'</ul>',
			'fallback_cb'	    => false,
		) );

		?>

	</div>

</div><!-- #main-nav -->
<?php endif; ?>