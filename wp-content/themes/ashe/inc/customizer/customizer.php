<?php

/*
** Register Theme Customizer
*/
function ashe_customize_register( $wp_customize ) {

/*
** Sanitization Callbacks =====
*/
	// checkbox
	function ashe_sanitize_checkbox( $input ) {
		return $input ? true : false;
	}
	
	// select
	function ashe_sanitize_select( $input, $setting ) {
		
		// get all select options
		$options = $setting->manager->get_control( $setting->id )->choices;
		
		// return default if not valid
		return ( array_key_exists( $input, $options ) ? $input : $setting->default );
	}

	// number absint
	function ashe_sanitize_number_absint( $number, $setting ) {

		// ensure $number is an absolute integer
		$number = absint( $number );

		// return default if not integer
		if ( $setting->id === 'ashe_options[featured_slider_amount]' ) {
			return ( $number < 6 ? $number : $setting->default );
		} else {
			return ( $number ? $number : $setting->default );
		}

	}

	// textarea
	function ashe_sanitize_textarea( $input ) {

		$allowedtags = array(
			'a' => array(
				'href' 		=> array(),
				'title' 	=> array(),
				'_blank'	=> array()
			),
			'img' => array(
				'src' 		=> array(),
				'alt' 		=> array(),
				'width'		=> array(),
				'height'	=> array(),
				'style'		=> array(),
				'class'		=> array(),
				'id'		=> array()
			),
			'br' 	 => array(),
			'em' 	 => array(),
			'strong' => array()
		);

		// return filtered html
		return wp_kses( $input, $allowedtags );

	}

	// Custom Controls
	function ashe_sanitize_custom_control( $input ) {
		return $input;
	}


/*
** Reusable Functions =====
*/
	// checkbox
	function ashe_checkbox_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;

		if ( $section !== 'title_tagline' && $section !== 'header_image' ) {
			$section_id = 'ashe_'. $section;
		} else {
			$section_id = $section;
		}

		if ( $id === 'merge_menu' ) {
			$section_id = 'ashe_responsive';
		} 

		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_checkbox'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'		=> $name,
			'section'	=> $section_id,
			'type'		=> 'checkbox',
			'priority'	=> $priority
		) );
	}

	// text
	function ashe_text_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_text_field'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'		=> $name,
			'section'	=> 'ashe_'. $section,
			'type'		=> 'text',
			'priority'	=> $priority
		) );
	}

	// color
	function ashe_color_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'sanitize_hex_color'
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'ashe_options['. $section .'_'. $id .']', array(
			'label' 	=> $name,
			'section' 	=> 'ashe_'. $section,
			'priority'	=> $priority
		) ) );
	}

	// textarea
	function ashe_textarea_control( $section, $id, $name, $description, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_textarea'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'description'	=> wp_kses_post($description),
			'section'		=> 'ashe_'. $section,
			'type'			=> 'textarea',
			'priority'		=> $priority
		) );
	}

	// url
	function ashe_url_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'		=> $name,
			'section'	=> 'ashe_'. $section,
			'type'		=> 'text',
			'priority'	=> $priority
		) );
	}

	// number absint
	function ashe_number_absint_control( $section, $id, $name, $atts, $transport, $priority ) {
		global $wp_customize;

		if ( $section !== 'title_tagline' && $section !== 'header_image' ) {
			$section_id = 'ashe_'. $section;
		} else {
			$section_id = $section;
		}

		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_number_absint'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'section'		=> $section_id,
			'type'			=> 'number',
			'input_attrs' 	=> $atts,
			'priority'		=> $priority
		) );
	}

	// select
	function ashe_select_control( $section, $id, $name, $atts, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_select'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'section'		=> 'ashe_'. $section,
			'type'			=> 'select',
			'choices' 		=> $atts,
			'priority'		=> $priority
		) );
	}

	// radio
	function ashe_radio_control( $section, $id, $name, $atts, $transport, $priority ) {
		global $wp_customize;

		if ( $section !== 'header_image' ) {
			$section_id = 'ashe_'. $section;
		} else {
			$section_id = $section;
		}

		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default'	 => ashe_options( $section .'_'. $id),
			'type'		 => 'option',
			'transport'	 => $transport,
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'ashe_sanitize_select'
		) );
		$wp_customize->add_control( 'ashe_options['. $section .'_'. $id .']', array(
			'label'			=> $name,
			'section'		=> $section_id,
			'type'			=> 'radio',
			'choices' 		=> $atts,
			'priority'		=> $priority
		) );
	}

	// image
	function ashe_image_control( $section, $id, $name, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
		    'default' 	=> ashe_options( $section .'_'. $id),
		    'type' 		=> 'option',
		    'transport' => $transport,
		    'sanitize_callback' => 'esc_url_raw'
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, 'ashe_options['. $section .'_'. $id .']', array(
				'label'    => $name,
				'section'  => 'ashe_'. $section,
				'priority' => $priority
			)
		) );
	}

	// image crop
	function ashe_image_crop_control( $section, $id, $name, $width, $height, $transport, $priority ) {
		global $wp_customize;
		$wp_customize->add_setting( 'ashe_options['. $section .'_'. $id .']', array(
			'default' 	=> '',
			'type' 		=> 'option',
			'transport' => $transport,
			'sanitize_callback' => 'ashe_sanitize_number_absint'
		) );
		$wp_customize->add_control(
			new WP_Customize_Cropped_Image_Control( $wp_customize, 'ashe_options['. $section .'_'. $id .']', array(
				'label'    		=> $name,
				'section'  		=> 'ashe_'. $section,
				'flex_width'  	=> true,
				'flex_height' 	=> true,
				'width'       	=> $width,
				'height'      	=> $height,
				'priority' 		=> $priority
			)
		) );
	}

	// Pro Version
	class Ashe_Customize_Pro_Version extends WP_Customize_Control {
		public $type = 'pro_options';

		public function render_content() {
			echo '<span>Want more <strong>'. esc_html( $this->label ) .'</strong>?</span>';
			echo '<a href="'. esc_url($this->description) .'" target="_blank">';
				echo '<span class="dashicons dashicons-info"></span>';
				echo '<strong> '. esc_html__( 'See Ashe PRO', 'ashe' ) .'<strong></a>';
			echo '</a>';
		}
	}

	// Pro Version Links
	class Ashe_Customize_Pro_Version_Links extends WP_Customize_Control {
		public $type = 'pro_links';

		public function render_content() {
			?>
			<ul>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Upgrade', 'ashe' ); ?> <span>*</span></h3>
					<p><?php esc_html_e( 'There are lots of reasons to upgrade to Pro version. Unlimited custom Colors, rich Typography options, multiple variation of Blog Feed layout and way much more. Also Premium Support included.', 'ashe' ); ?></p>
					<a href="<?php echo esc_url('https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-customizer-about-section-buypro'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Get Ashe Pro', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Support', 'ashe' ); ?></h3>
					<p><?php esc_html_e( 'If you have any kind of theme related questions, feel free to ask.', 'ashe' ); ?></p>
					<a href="<?php echo esc_url(admin_url('themes.php?page=about-ashe&tab=ashe_tab_4')); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Contact Us', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Demo Import / Getting Started', 'ashe' ); ?></h3>
					<p><?php esc_html_e( 'All you need for startup: Demo Import, Video Tutorials and more. To see what Ashe theme can offer, please visit a ', 'ashe' ); ?><a href="<?php echo esc_url('https://wp-royal.com/themes/ashe-free/demo/?ref=ashe-free-customizer-about-section-get-started-btn/'); ?>" target="_blank"><?php esc_html_e( 'Demo Preview Page.', 'ashe' ); ?></a></p>
					<a href="<?php echo esc_url(admin_url('themes.php?page=about-ashe')); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Get Started', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Documentation', 'ashe' ); ?></h3>
					<p>
					<?php 
						$theme_data	 = wp_get_theme();
						/* translators: %s theme name */
						printf( esc_html__( 'Need more details? Please check our full documentation for detailed information on how to use %s.', 'ashe' ), esc_html( $theme_data->Name ) );
					?>
					</p>
					<a href="<?php echo esc_url('https://wp-royal.com/themes/ashe/docs/?ref=ashe-free-customizer-about-section-docs-btn/'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Documentation', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Predefined Styles', 'ashe' ); ?></h3>
					<p>
					<?php /* translators: %s link */
						printf( __( 'Ashe Pro\'s powerful setup allows you to easily create unique looking sites. Here are a few included examples that can be installed with one click in the Pro Version. More details in the <a href="%s" target="_blank" >Theme Documentation</a>', 'ashe' ), esc_url('https://wp-royal.com/themes/ashe/docs/?ref=ashe-free-backend-about-predefined-styles#predefined') );
					?>
					</p>
					<a href="<?php echo admin_url('themes.php?page=about-ashe#ashe-predefined-styles'); ?>" class="button button-primary widefat"><?php esc_html_e( 'Predefined Styles', 'ashe' ); ?></a>
				</li>
				<li class="customize-control">
					<h3><?php esc_html_e( 'Changelog', 'ashe' ); ?></h3>
					<p><?php esc_html_e( 'Want to get the gist on the latest theme changes? Just consult our changelog below to get a taste of the recent fixes and features implemented.', 'ashe' ); ?></p>
					<a href="<?php echo esc_url('https://wp-royal.com/ashe-free-changelog/?ref=ashe-free-customizer-about-section-changelog'); ?>" target="_blank" class="button button-primary widefat"><?php esc_html_e( 'Changelog', 'ashe' ); ?></a>
				</li>
			</ul>
			<?php
		}
	}

	// Control Note
	class Ashe_Customize_Control_Note extends WP_Customize_Control {
		public $type = 'control_note';

		public function render_content() {
			echo '<span><strong>'. esc_html__( 'Please Note: ', 'ashe' ) .'</strong>'. esc_html( $this->label ) .'</span>';
		}
	}

	// Control Divider
	class Ashe_Customize_Control_Divider extends WP_Customize_Control {
		public $type = 'control_divider';

		public function render_content() {
			echo '<hr>';
		}
	}



/*
** Pro Version =====
*/

	// add Colors section
	$wp_customize->add_section( 'ashe_pro' , array(
		'title'		 => esc_html__( 'About Ashe', 'ashe' ),
		'priority'	 => 1,
		'capability' => 'edit_theme_options'
	) );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version_Links ( $wp_customize,
			'pro_version_', array(
				'section'	=> 'ashe_pro',
				'type'		=> 'pro_links',
				'label' 	=> '',
				'priority'	=> 1
			)
		)
	);


/*
** Skins =====
*/

	// add Skins section
	$wp_customize->add_section( 'ashe_skins' , array(
		'title'		 => esc_html__( 'Skins', 'ashe' ),
		'priority'	 => 2,
		'capability' => 'edit_theme_options'
	) );

	$skin_select = array(
		'default' => esc_html__( 'Default', 'ashe' ),
		'dark' => esc_html__( 'Dark', 'ashe' ),
		'box' => esc_html__( 'Box', 'ashe' ),
	);

	// Skin Select
	ashe_select_control( 'skins', 'select', esc_html__( 'Select Theme Skin', 'ashe' ), $skin_select, 'refresh', 1 );

	// Pro Version
	$wp_customize->add_setting( 'select_skins_note', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Control_Note ( $wp_customize,
			'select_skins_note', array(
				'section'	=> 'ashe_skins',
				'type'		=> 'control_note',
				'label' 	=> esc_html__( 'After activating non-default skin, you will NOT be able to take control over skin colors. These options are only available in the Ashe PRO.', 'ashe' ),
				'priority'	=> 2
			)
		)
	);

	// Dark Mode Divider
	$wp_customize->add_setting( 'dark_mode_divider', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Control_Divider ( $wp_customize,
			'dark_mode_divider', array(
				'section'	=> 'ashe_skins',
				'type'		=> 'control_divider',
				'priority'	=> 3
			)
		)
	);

	// Dark Mode
	ashe_checkbox_control( 'skins', 'dark_mode', esc_html__( 'Show Dark Mode Switcher', 'ashe' ), 'refresh', 4 );

	// Dark Mode Note
	$wp_customize->add_setting( 'dark_mode_note', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Control_Note ( $wp_customize,
			'dark_mode_note', array(
				'section'	=> 'ashe_skins',
				'type'		=> 'control_note',
				'label' 	=> esc_html__( 'Switcher icon will be added to the right of the Navigation Menu. When the Dark Mode is enabled color controls will NOT work except Accent Color control. Dark Mode design reduces the light emitted by device screens while maintaining the minimum color contrast ratios required for readability.', 'ashe' ),
				'priority'	=> 5
			)
		)
	);

	// Pro Version
	$wp_customize->add_setting( 'pro_version_skins', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_skins', array(
				'section'	  => 'ashe_skins',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Skins', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-skin-customizer#!/ashe-pro-page-colors' ),
				'priority'	  => 100
			)
		)
	);

/*
** Colors =====
*/

	// add Colors section
	$wp_customize->add_section( 'ashe_colors' , array(
		'title'		 => esc_html__( 'Colors', 'ashe' ),
		'priority'	 => 3,
		'capability' => 'edit_theme_options'
	) );

	// Content Accent
	ashe_color_control( 'colors', 'content_accent', esc_html__( 'Accent', 'ashe' ), 'postMessage', 3 );

	$wp_customize->get_control( 'header_textcolor' )->section = 'ashe_colors';
	$wp_customize->get_control( 'header_textcolor' )->priority = 6;
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	// Header Background
	ashe_color_control( 'colors', 'header_bg', esc_html__( 'Header Background', 'ashe' ), 'postMessage', 9 );
	
	// Body Background
	$wp_customize->get_control( 'background_color' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_color' )->priority = 12;
	$wp_customize->get_control( 'background_color' )->label = 'Body Background';

	$wp_customize->get_control( 'background_image' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_image' )->priority = 15;
	$wp_customize->get_control( 'background_preset' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_preset' )->priority = 18;
	$wp_customize->get_control( 'background_position' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_position' )->priority = 21;
	$wp_customize->get_control( 'background_size' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_size' )->priority = 23;
	$wp_customize->get_control( 'background_repeat' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_repeat' )->priority = 25;
	$wp_customize->get_control( 'background_attachment' )->section = 'ashe_colors';
	$wp_customize->get_control( 'background_attachment' )->priority = 27;

	// Pro Version
	$wp_customize->add_setting( 'pro_version_colors', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_colors', array(
				'section'	  => 'ashe_colors',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Colors', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-colors-customizer#!/ashe-pro-page-colors' ),
				'priority'	  => 100
			)
		)
	);


/*
** General Layouts =====
*/

	// add General Layouts section
	$wp_customize->add_section( 'ashe_general' , array(
		'title'		 => esc_html__( 'General Layouts', 'ashe' ),
		'priority'	 => 3,
		'capability' => 'edit_theme_options'
	) );

	// Sidebar Width
	ashe_number_absint_control( 'general', 'sidebar_width', esc_html__( 'Sidebar Width', 'ashe' ), array( 'step' => '1' ), 'refresh', 3 );

	// Sticky Sidebar
	ashe_checkbox_control( 'general', 'sidebar_sticky', esc_html__( 'Enable Sticky Sidebar', 'ashe' ), 'refresh', 5 );

	// Page Layout Combinations
	$page_layouts = array(
		'col1-rsidebar' => esc_html__( '1 Column', 'ashe' ),
		'list-rsidebar' => esc_html__( 'List Style', 'ashe' ),
	);

	// Blog Page Layout
	ashe_select_control( 'general', 'home_layout', esc_html__( 'Blog Page', 'ashe' ), $page_layouts, 'refresh', 13 );

	$boxed_width = array(
		'full' 		=> esc_html__( 'Full', 'ashe' ),
		'contained' => esc_html__( 'Contained', 'ashe' ),
		'boxed' 	=> esc_html__( 'Boxed', 'ashe' ),
	);

	// Header Width
	ashe_select_control( 'general', 'header_width', esc_html__( 'Header Width', 'ashe' ), $boxed_width, 'refresh', 25 );

	$boxed_width_slider = array(
		'full' => esc_html__( 'Full', 'ashe' ),
		'boxed' => esc_html__( 'Boxed', 'ashe' ),
	);

	// Slider Width
	ashe_select_control( 'general', 'slider_width', esc_html__( 'Featured Slider Width', 'ashe' ), $boxed_width_slider, 'refresh', 27 );
	
	// Featured Links Width
	ashe_select_control( 'general', 'links_width', esc_html__( 'Featured Links Width', 'ashe' ), $boxed_width_slider, 'refresh', 28 );

	// Content Width
	ashe_select_control( 'general', 'content_width', esc_html__( 'Content Width', 'ashe' ), $boxed_width_slider, 'refresh', 29 );

	// Single Content Width
	ashe_select_control( 'general', 'single_width', esc_html__( 'Single Content Width', 'ashe' ), $boxed_width_slider, 'refresh', 31 );

	// Footer Width
	ashe_select_control( 'general', 'footer_width', esc_html__( 'Footer Width', 'ashe' ), $boxed_width, 'refresh', 33 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_general_layouts', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_general_layouts', array(
				'section'	  => 'ashe_general',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Layout Options', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-general-layouts-customizer#!/ashe-pro-page-layouts' ),
				'priority'	  => 100
			)
		)
	);


/*
** Top Bar =====
*/

	// add Top Bar section
	$wp_customize->add_section( 'ashe_top_bar' , array(
		'title'		 => esc_html__( 'Top Bar', 'ashe' ),
		'priority'	 => 5,
		'capability' => 'edit_theme_options'
	) );

	// Top Bar label
	ashe_checkbox_control( 'top_bar', 'label', esc_html__( 'Top Bar', 'ashe' ), 'refresh', 1 );


/*
** Header Image =====
*/

	$wp_customize->get_section( 'header_image' )->priority = 10;

	// Page Header label
	ashe_checkbox_control( 'header_image', 'label', esc_html__( 'Page Header', 'ashe' ), 'refresh', 1 );

	$bg_image_size = array(
		'cover'   => esc_html__( 'Cover', 'ashe' ),
		'initial' => esc_html__( 'Pattern', 'ashe' )
	);

	// Background Image Size
	ashe_radio_control( 'header_image', 'bg_image_size', esc_html__( 'Background Image Size', 'ashe' ), $bg_image_size, 'refresh', 10 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_header', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_header', array(
				'section'	  => 'header_image',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Header Options', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/ashe/customizer/free/header-image2.html?ref=ashe-free-header-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** Site Identity =====
*/


	// Logo Width
	ashe_number_absint_control( 'title_tagline', 'logo_width', esc_html__( 'Width', 'ashe' ), array( 'step' => '10' ), 'postMessage', 8 );

	// SEO Title
	ashe_checkbox_control( 'title_tagline', 'seo_title', esc_html__( 'Enable Hidden Title (h1 missing SEO issue)', 'ashe' ), 'refresh', 17 );

	$wp_customize->get_control( 'custom_logo' )->transport = 'selective_refresh';

	// Pro Version
	$wp_customize->add_setting( 'pro_version_logo', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_logo', array(
				'section'	  => 'title_tagline',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Logo Options', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/ashe/customizer/free/typography-logo.html?ref=ashe-free-site-identity-customizer' ),
				'priority'	  => 50
			)
		)
	);


/*
** Main Navigation =====
*/

	// add Main Navigation section
	$wp_customize->add_section( 'ashe_main_nav' , array(
		'title'		 => esc_html__( 'Main Navigation', 'ashe' ),
		'priority'	 => 23,
		'capability' => 'edit_theme_options'
	) );

	// Main Navigation
	ashe_checkbox_control( 'main_nav', 'label', esc_html__( 'Main Navigation', 'ashe' ), 'refresh', 1 );

	$main_nav_align = array(
		'left' => esc_html__( 'Left', 'ashe' ),
		'center' => esc_html__( 'Center', 'ashe' ),
		'right' => esc_html__( 'Right', 'ashe' ),
	);

	// Align
	ashe_select_control( 'main_nav', 'align', esc_html__( 'Align', 'ashe' ), $main_nav_align, 'refresh', 7 );

	// Show Search Icon
	ashe_checkbox_control( 'main_nav', 'show_search', esc_html__( 'Show Search Icon', 'ashe' ), 'refresh', 13 );

	// Show Sidebar Icon
	ashe_checkbox_control( 'main_nav', 'show_sidebar', esc_html__( 'Show Sidebar Icon', 'ashe' ), 'refresh', 15 );

	// Simple Header
	ashe_checkbox_control( 'main_nav', 'simple_header', esc_html__( 'Show Simple Header', 'ashe' ), 'refresh', 16 );

	// Mini Logo
	ashe_image_control( 'main_nav', 'mini_logo', esc_html__( 'Logo Upload', 'ashe' ), 'refresh', 17 );

	// Mini Logo Width
	ashe_number_absint_control( 'main_nav', 'mini_logo_width', esc_html__( 'Logo Width', 'ashe' ), array( 'step' => '1' ), 'postMessage', 19 );


/*
** Featured Slider =====
*/

	// add featured slider section
	$wp_customize->add_section( 'ashe_featured_slider' , array(
		'title'		 => esc_html__( 'Featured Slider', 'ashe' ),
		'priority'	 => 25,
		'capability' => 'edit_theme_options'
	) );

	// Featured Slider
	ashe_checkbox_control( 'featured_slider', 'label', esc_html__( 'Featured Slider', 'ashe' ), 'refresh', 1 );

	$slider_display = array(
		'front' => esc_html__( 'Front Page', 'ashe' ),
		'blog' => esc_html__( 'Posts Page', 'ashe' ),
		'both' => esc_html__( 'Front and Posts Pages', 'ashe' ),
	);
	 
	// Slider Location
	ashe_select_control( 'featured_slider', 'location', esc_html__( 'Display Slider on', 'ashe' ), $slider_display, 'refresh', 2 );

	$slider_source = array(
		'custom' => esc_html__( 'Custom', 'ashe' ),
		'posts' => esc_html__( 'Posts', 'ashe' ),
	);
	 
	// Source
	ashe_select_control( 'featured_slider', 'source', esc_html__( 'Source', 'ashe' ), $slider_source, 'refresh', 3 );

	// Repeater
	$wp_customize->add_setting( 'featured_slider_repeater', array(
		'sanitize_callback' => 'customizer_repeater_sanitize',
         'default' => json_encode( array(
	         	array(
	         		'image_url' => '',
	         		'title' => 'Slide 1 Title',
	         		'text' => 'Slide 1 Description. Some lorem ipsum dolor sit amet text',
	         		'link' => '',
	         		'btn_text' => 'Button 1',
	         		'checkbox' => '0',
	         		'id' => 'customizer_repeater_56d7ea7f40af1'
	         	),
	         	array(
	         		'image_url' => '',
	         		'title' => 'Slide 2 Title',
	         		'text' => 'Slide 2 Description. Some lorem ipsum dolor sit amet text',
	         		'link' => '',
	         		'btn_text' => 'Button 2',
	         		'checkbox' => '0',
	         		'id' => 'customizer_repeater_56d7ea7f40af2'
	         	),
	         	array(
	         		'image_url' => '',
	         		'title' => 'Slide 3 Title',
	         		'text' => 'Slide 3 Description. Some lorem ipsum dolor sit amet text',
	         		'link' => '',
	         		'btn_text' => 'Button 3',
	         		'checkbox' => '0',
	         		'id' => 'customizer_repeater_56d7ea7f40af3'
	         	),
            ) )
	));

	$wp_customize->add_control( new Customizer_Repeater( $wp_customize, 'featured_slider_repeater', array(
		'label'   => esc_html__( 'Slider Item','ashe') ,
		'section' => 'ashe_featured_slider',
		'customizer_repeater_image_control' => true,
		'customizer_repeater_title_control' => true,
		'customizer_repeater_text_control' => true,
		'customizer_repeater_btn_text_control' => true,
		'customizer_repeater_link_control' => true,
		'customizer_repeater_checkbox_control' => true,
		'priority' => 4,
	) ) );

	$slider_display = array(
		'all' 		=> 'All Posts',
		'category' 	=> 'by Post Category'
	);
	 
	// Display
	ashe_select_control( 'featured_slider', 'display', esc_html__( 'Display Posts', 'ashe' ), $slider_display, 'refresh', 5 );

	$slider_cats = array();

	foreach ( get_categories() as $categories => $category ) {
	    $slider_cats[$category->term_id] = $category->name;
	}
	 
	// Category
	ashe_select_control( 'featured_slider', 'category', esc_html__( 'Select Category', 'ashe' ), $slider_cats, 'refresh', 6 );

	// Amount
	ashe_number_absint_control( 'featured_slider', 'amount', esc_html__( 'Number of Slides', 'ashe' ), array( 'step' => '1', 'max' => '5' ), 'refresh', 10 );

	// Exclude Images
	ashe_checkbox_control( 'featured_slider', 'exc_images', esc_html__( 'Exclude Slides without Images', 'ashe' ), 'refresh', 20 );

	// Navigation
	ashe_checkbox_control( 'featured_slider', 'navigation', esc_html__( 'Show Navigation Arrows', 'ashe' ), 'refresh', 25 );

	// Pagination
	ashe_checkbox_control( 'featured_slider', 'pagination', esc_html__( 'Show Pagination Dots', 'ashe' ), 'refresh', 30 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_featured_slider', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_featured_slider', array(
				'section'	  => 'ashe_featured_slider',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Slider Options ', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-general-layouts-customizer#!/ashe-pro-page-sliders' ),
				'priority'	  => 100
			)
		)
	);


/*
** Featured Links =====
*/

	// add featured links section
	$wp_customize->add_section( 'ashe_featured_links' , array(
		'title'		 => esc_html__( 'Featured Links', 'ashe' ),
		'priority'	 => 27,
		'capability' => 'edit_theme_options'
	) );

	// Featured Links
	ashe_checkbox_control( 'featured_links', 'label', esc_html__( 'Featured Links', 'ashe' ), 'refresh', 1 );

	$featured_links_display = array(
		'front' => esc_html__( 'Front Page', 'ashe' ),
		'blog' => esc_html__( 'Posts Page', 'ashe' ),
		'both' => esc_html__( 'Front and Posts Pages', 'ashe' ),
	);
	 
	// Slider Location
	ashe_select_control( 'featured_links', 'location', esc_html__( 'Display Featured Links on', 'ashe' ), $featured_links_display, 'refresh', 2 );

	// Link #1 Title
	ashe_text_control( 'featured_links', 'title_1', esc_html__( 'Title', 'ashe' ), 'refresh', 9 );

	// Link #1 URL
	ashe_url_control( 'featured_links', 'url_1', esc_html__( 'URL', 'ashe' ), 'refresh', 11 );

	// Link #1 Image
	ashe_image_crop_control( 'featured_links', 'image_1', esc_html__( 'Image', 'ashe' ), 600, 340, 'refresh', 13 );

	// Link #2 Title
	ashe_text_control( 'featured_links', 'title_2', esc_html__( 'Title', 'ashe' ), 'refresh', 15 );

	// Link #2 URL
	ashe_url_control( 'featured_links', 'url_2', esc_html__( 'URL', 'ashe' ), 'refresh', 17 );

	// Link #2 Image
	ashe_image_crop_control( 'featured_links', 'image_2', esc_html__( 'Image', 'ashe' ), 600, 340, 'refresh', 19 );

	// Link #3 Title
	ashe_text_control( 'featured_links', 'title_3', esc_html__( 'Title', 'ashe' ), 'refresh', 21 );

	// Link #3 URL
	ashe_url_control( 'featured_links', 'url_3', esc_html__( 'URL', 'ashe' ), 'refresh', 23 );

	// Link #3 Image
	ashe_image_crop_control( 'featured_links', 'image_3', esc_html__( 'Image', 'ashe' ), 600, 340, 'refresh', 25 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_featured_links', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_featured_links', array(
				'section'	  => 'ashe_featured_links',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Feat. Links Options ', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/ashe/customizer/free/featured-links.html?ref=ashe-free-featured-links' ),
				'priority'	  => 100
			)
		)
	);

/*
** Blog Page =====
*/

	// add Blog Page section
	$wp_customize->add_section( 'ashe_blog_page' , array(
		'title'		 => esc_html__( 'Blog Page', 'ashe' ),
		'priority'	 => 29,
		'capability' => 'edit_theme_options'
	) );

	$post_description = array(
		'none' 		=> esc_html__( 'None', 'ashe' ),
		'excerpt' 	=> esc_html__( 'Post Excerpt', 'ashe' ),
		'content' 	=> esc_html__( 'Post Content', 'ashe' ),
	);

	// Post Description
	ashe_select_control( 'blog_page', 'post_description', esc_html__( 'Post Description', 'ashe' ), $post_description, 'refresh', 3 );

	$post_pagination = array(
		'default' 	=> esc_html__( 'Default', 'ashe' ),
		'numeric' 	=> esc_html__( 'Numeric', 'ashe' ),
	);

	// Post Pagination
	ashe_select_control( 'blog_page', 'post_pagination', esc_html__( 'Post Pagination', 'ashe' ), $post_pagination, 'refresh', 5 );

	// Show Drop Caps
	ashe_checkbox_control( 'blog_page', 'show_dropcaps', esc_html__( 'Show Drop Caps (First Big Letter)', 'ashe' ), 'refresh', 6 );

	// Show Categories
	ashe_checkbox_control( 'blog_page', 'show_categories', esc_html__( 'Show Categories', 'ashe' ), 'refresh', 7 );

	// Show Date
	ashe_checkbox_control( 'blog_page', 'show_date', esc_html__( 'Show Date', 'ashe' ), 'refresh', 8 );

	// Show Comments
	ashe_checkbox_control( 'blog_page', 'show_comments', esc_html__( 'Show Comments', 'ashe' ), 'refresh', 9 );

	// Show Author
	ashe_checkbox_control( 'blog_page', 'show_author', esc_html__( 'Show Author', 'ashe' ), 'refresh', 13 );

	// Show Facebook
	ashe_checkbox_control( 'blog_page', 'show_facebook', esc_html__( 'Show Facebook', 'ashe' ), 'refresh', 17 );

	// Show Twitter
	ashe_checkbox_control( 'blog_page', 'show_twitter', esc_html__( 'Show Twitter', 'ashe' ), 'refresh', 19 );

	// Show Pinterest
	ashe_checkbox_control( 'blog_page', 'show_pinterest', esc_html__( 'Show Pinterest', 'ashe' ), 'refresh', 21 );

	// Show Google Plus
	ashe_checkbox_control( 'blog_page', 'show_google', esc_html__( 'Show Google Plus', 'ashe' ), 'refresh', 23 );

	// Show Linkedin
	ashe_checkbox_control( 'blog_page', 'show_linkedin', esc_html__( 'Show Linkedin', 'ashe' ), 'refresh', 25 );

	// Show reddit
	ashe_checkbox_control( 'blog_page', 'show_reddit', esc_html__( 'Show Reddit', 'ashe' ), 'refresh', 27 );

	// Show Tumblr
	ashe_checkbox_control( 'blog_page', 'show_tumblr', esc_html__( 'Show Tumblr', 'ashe' ), 'refresh', 29 );

	$related_posts = array(
		'none' 		=> esc_html__( 'None', 'ashe' ),
		'related' 	=> esc_html__( 'Related', 'ashe' )
	);

	// Related Posts Orderby
	ashe_select_control( 'blog_page', 'related_orderby', esc_html__( 'Related Posts - Display', 'ashe' ), $related_posts, 'refresh', 33 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_blog_page', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_blog_page', array(
				'section'	  => 'ashe_blog_page',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Blog Options ', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/item-ashe-pro/?ref=ashe-free-general-layouts-customizer#!/ashe-pro-page-layouts' ),
				'priority'	  => 100
			)
		)
	);



/*
** Single Post =====
*/

	// add single post section
	$wp_customize->add_section( 'ashe_single_page' , array(
		'title'		 => esc_html__( 'Single Post', 'ashe' ),
		'priority'	 => 31,
		'capability' => 'edit_theme_options'
	) );

	// Show Featured Image
	ashe_checkbox_control( 'single_page', 'show_featured_image', esc_html__( 'Show Featured Image', 'ashe' ), 'refresh', 5 );

	// Show Categories
	ashe_checkbox_control( 'single_page', 'show_categories', esc_html__( 'Show Categories', 'ashe' ), 'refresh', 5 );

	// Show Date
	ashe_checkbox_control( 'single_page', 'show_date', esc_html__( 'Show Date', 'ashe' ), 'refresh', 7 );

	// Show Comments
	ashe_checkbox_control( 'single_page', 'show_comments', esc_html__( 'Show Comments', 'ashe' ), 'refresh', 13 );

	// Show Author
	ashe_checkbox_control( 'single_page', 'show_author', esc_html__( 'Show Author', 'ashe' ), 'refresh', 15 );

	// Show Author Description
	ashe_checkbox_control( 'single_page', 'show_author_desc', esc_html__( 'Show Author Description', 'ashe' ), 'refresh', 18 );

	// Related Posts Orderby
	ashe_select_control( 'single_page', 'related_orderby', esc_html__( 'Related Posts - Display', 'ashe' ), $related_posts, 'refresh', 23 );


/*
** Social Media =====
*/

	// add social media section
	$wp_customize->add_section( 'ashe_social_media' , array(
		'title'		 => esc_html__( 'Social Media', 'ashe' ),
		'priority'	 => 33,
		'capability' => 'edit_theme_options'
	) );
	
	// Social Window
	ashe_checkbox_control( 'social_media', 'window', esc_html__( 'Open Social Links in New Window', 'ashe' ), 'refresh', 1 );

	// Social Icons Array
	$social_icons = array(
		'facebook' 				=> 'Facebook 1',
		'facebook-official'		=> 'Facebook 2',
		'facebook-square' 		=> 'Facebook 3',
		'twitter' 				=> 'Twitter 1',
		'twitter-square' 		=> 'Twitter 2',
		'google' 				=> 'Google',
		'google-plus' 			=> 'Google Plus 1',
		'google-plus-official'	=> 'Google Plus 2',
		'google-plus-square'	=> 'Google Plus 3',
		'linkedin'				=> 'Linkedin 1',
		'linkedin-square' 		=> 'Linkedin 2',
		'pinterest' 			=> 'Pinterest 1',
		'pinterest-p' 			=> 'Pinterest 2',
		'pinterest-square'		=> 'Pinterest 3',
		'behance' 				=> 'Behance 1',
		'behance-square'		=> 'Behance 2',
		'tumblr' 				=> 'Tumblr 1',
		'tumblr-square' 		=> 'Tumblr 2',
		'reddit' 				=> 'Reddit 1',
		'reddit-alien' 			=> 'Reddit 2',
		'reddit-square' 		=> 'Reddit 3',
		'dribbble' 				=> 'Dribbble',
		'vk' 					=> 'vKontakte',
		'odnoklassniki' 		=> 'Odnoklassniki',
		'skype' 				=> 'Skype',
		'film' 					=> 'Film',
		'youtube-play' 			=> 'Youtube 1',
		'youtube' 				=> 'Youtube 2',
		'youtube-square' 		=> 'Youtube 3',
		'vimeo-square' 			=> 'Vimeo',
		'twitch' 				=> 'Twitch',
		'soundcloud' 			=> 'Soundcloud',
		'instagram' 			=> 'Instagram',
		'info' 					=> 'Info 1',
		'info-circle' 			=> 'Info 2',
		'flickr' 				=> 'Flickr',
		'rss' 					=> 'RSS 1',
		'rss-square' 			=> 'RSS 2',
		'heart' 				=> 'Heart 1',
		'heart-o' 				=> 'Heart 2',
		'github' 				=> 'Github 1',
		'github-alt' 			=> 'Github 2',
		'github-square' 		=> 'Github 3',
		'stack-overflow' 		=> 'Stack Overflow',
		'qq' 					=> 'QQ',
		'weibo' 				=> 'Weibo',
		'weixin' 				=> 'Weixin',
		'xing' 					=> 'Xing 1',
		'xing-square' 			=> 'Xing 2',
		'gamepad' 				=> 'Gamepad',
		'medium' 				=> 'Medium',
		'map-marker' 			=> 'Map Marker',
		'envelope' 				=> 'Envelope 1',
		'envelope-o' 			=> 'Envelope 2',
		'envelope-square ' 		=> 'Envelope 3',
		'etsy' 					=> 'Etsy',
		'snapchat' 				=> 'Snapchat 1',
		'snapchat-ghost' 		=> 'Snapchat 2',
		'snapchat-square'		=> 'Snapchat 3',
		'spotify'				=> 'Spotify',
		'deviantart'			=> 'DeviantArt',
		'shopping-cart'			=> 'Cart',
		'meetup' 				=> 'Meetup',
		'cc-paypal' 			=> 'PayPal',
		'credit-card' 			=> 'Credit Card',
	);

	// Social #1 Icon
	ashe_select_control( 'social_media', 'icon_1', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 3 );

	// Social #1 Icon
	ashe_url_control( 'social_media', 'url_1', esc_html__( 'URL', 'ashe' ), 'refresh', 5 );

	// Social #2 Icon
	ashe_select_control( 'social_media', 'icon_2', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 7 );

	// Social #2 Icon
	ashe_url_control( 'social_media', 'url_2', esc_html__( 'URL', 'ashe' ), 'refresh', 9 );

	// Social #3 Icon
	ashe_select_control( 'social_media', 'icon_3', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 11 );

	// Social #3 Icon
	ashe_url_control( 'social_media', 'url_3', esc_html__( 'URL', 'ashe' ), 'refresh', 13 );

	// Social #4 Icon
	ashe_select_control( 'social_media', 'icon_4', esc_html__( 'Select Icon', 'ashe' ), $social_icons, 'refresh', 15 );

	// Social #4 Icon
	ashe_url_control( 'social_media', 'url_4', esc_html__( 'URL', 'ashe' ), 'refresh', 17 );


/*
** Typography =====
*/
	// add Typography section
	$wp_customize->add_section( 'ashe_typography' , array(
		'title'		 => esc_html__( 'Typography', 'ashe' ),
		'priority'	 => 34,
		'capability' => 'edit_theme_options'
	) );

	$font_family = array(
		'Open+Sans' => esc_html__( 'Open Sans', 'ashe' ),
		'Rokkitt' 	=> esc_html__( 'Rokkitt', 'ashe' ),
		'Kalam' 	=> esc_html__( 'Kalam', 'ashe' )
	);

	// Logo Font Family
	ashe_select_control( 'typography', 'logo_family', esc_html__( 'Font Family', 'ashe' ), $font_family, 'refresh', 1 );

	// Navigation Font Family
	ashe_select_control( 'typography', 'nav_family', esc_html__( 'Font Family', 'ashe' ), $font_family, 'refresh', 5 );

	// Italic
	ashe_checkbox_control( 'typography', 'nav_italic', esc_html__( 'Italic', 'ashe' ), 'postMessage', 7 );

	// Uppercase
	ashe_checkbox_control( 'typography', 'nav_uppercase', esc_html__( 'Uppercase', 'ashe' ), 'postMessage', 8 );


	// Pro Version
	$wp_customize->add_setting( 'pro_version_typography', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_typography', array(
				'section'	  => 'ashe_typography',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Typography Options', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/ashe/customizer/free/typography-logo.html?ref=ashe-free-typography-customizer' ),
				'priority'	  => 10
			)
		)
	);



/*
** Page Footer =====
*/

	// add page footer section
	$wp_customize->add_section( 'ashe_page_footer' , array(
		'title'		 => esc_html__( 'Page Footer', 'ashe' ),
		'priority'	 => 35,
		'capability' => 'edit_theme_options'
	) );

	$copyright_description = 'Enter <strong>$year</strong> to update the year automatically and <strong>$copy</strong> for the copyright symbol.<br><br>Example: $year Ashe Theme $copy.';

	// Copyright
	ashe_textarea_control( 'page_footer', 'copyright', esc_html__( 'Your Copyright Text', 'ashe' ), $copyright_description, 'refresh', 3 );

	// Show Scroll-Top Button
	ashe_checkbox_control( 'page_footer', 'show_scrolltop', esc_html__( 'Show Scroll-Top Button', 'ashe' ), 'refresh', 5 );

	// Pro Version
	$wp_customize->add_setting( 'pro_version_page_footer', array(
		'sanitize_callback' => 'ashe_sanitize_custom_control'
	) );
	$wp_customize->add_control( new Ashe_Customize_Pro_Version ( $wp_customize,
			'pro_version_page_footer', array(
				'section'	  => 'ashe_page_footer',
				'type'		  => 'pro_options',
				'label' 	  => esc_html__( 'Footer Options', 'ashe' ),
				'description' => esc_html( 'https://wp-royal.com/themes/ashe/customizer/free/page-footer.html?ref=ashe-free-page-footer-customizer' ),
				'priority'	  => 100
			)
		)
	);


/*
** Preloader =====
*/

	// add Preloader section
	$wp_customize->add_section( 'ashe_preloader' , array(
		'title'		 => esc_html__( 'Preloader', 'ashe' ),
		'priority'	 => 45,
		'capability' => 'edit_theme_options'
	) );

	// Preloading Animation
	ashe_checkbox_control( 'preloader', 'label', esc_html__( 'Preloading Animation', 'ashe' ), 'refresh', 1 );


/*
** Responsive =====
*/

	// add Responsive section
	$wp_customize->add_section( 'ashe_responsive' , array(
		'title'		  => esc_html__( 'Responsive', 'ashe' ),
		'description' => esc_html__( 'These options will only apply to Mobile devices.', 'ashe' ),
		'priority'	  => 50,
		'capability'  => 'edit_theme_options'
	) );


	// Merge to Responsive Menu
	ashe_checkbox_control( 'main_nav', 'merge_menu', esc_html__( 'Merge Top and Main Menus', 'ashe' ), 'refresh', 1 );
	
	// Featured Slider
	ashe_checkbox_control( 'responsive', 'featured_slider', esc_html__( 'Show Featured Slider', 'ashe' ), 'refresh', 3 );

	// Featured Links
	ashe_checkbox_control( 'responsive', 'featured_links', esc_html__( 'Show Featured Links', 'ashe' ), 'refresh', 5 );

	// Related Posts
	ashe_checkbox_control( 'responsive', 'related_posts', esc_html__( 'Show Related Posts', 'ashe' ), 'refresh', 7 );

	// Mobile Menu Icons Array
	$mobile_menu_icons = array(
		'chevron-down' 			 => 'Arrow',
		'text' 					 => 'Text',
	);

	// Select Mobile Menu Icon
	ashe_select_control( 'responsive', 'menu_icon', esc_html__( 'Select Mobile Menu Icon', 'ashe' ), $mobile_menu_icons, 'refresh', 9 );

	// Mobile Menu Text
	ashe_text_control( 'responsive', 'mobile_icon_text', esc_html__( 'Menu Button Text', 'ashe' ), 'refresh', 11 );


}
add_action( 'customize_register', 'ashe_customize_register' );


/*
** Bind JS handlers to instantly live-preview changes
*/
function ashe_customize_preview_js() {
	wp_enqueue_script( 'ashe-customize-preview', get_theme_file_uri( '/inc/customizer/js/customize-preview.js' ), array( 'customize-preview' ), '1.1', true );
}
add_action( 'customize_preview_init', 'ashe_customize_preview_js' );

/*
** Load dynamic logic for the customizer controls area.
*/
function ashe_panels_js() {
	wp_enqueue_style( 'fontawesome', get_theme_file_uri( '/assets/css/font-awesome.css' ) );
	wp_enqueue_style( 'ashe-customizer-ui-css', get_theme_file_uri( '/inc/customizer/css/customizer-ui.css' ) );
	wp_enqueue_script( 'ashe-customize-controls', get_theme_file_uri( '/inc/customizer/js/customize-controls.js' ), array(), '1.2', true );
}
add_action( 'customize_controls_enqueue_scripts', 'ashe_panels_js' );
