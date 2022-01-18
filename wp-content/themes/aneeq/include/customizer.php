<?php
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

//Customizer Controls
function aneeq_customize_register( $wp_customize ) {
	$selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';	
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

   //All our sections, settings, and controls will be added here
   wp_enqueue_style('customizr', ANEEQ_THEME_URL .'/css/customizer.css');
	//Titles
    class Aneeq_info extends WP_Customize_Control {
        public $type = 'info';
        public $label = '';
        public function render_content() { 
        ?>
            <h3 style="margin-top:30px;border:1px solid #29B6F6;padding:5px;background-color:#29B6F6;color:#fff;text-transform:uppercase;text-align:center;"><?php echo esc_html( $this->label ); ?></h3>
        <?php
        }
    } 
	
	//logo selector Settings
	require( ANEEQ_THEME_DIR . '/include/logo-selector.php');
	
	// Load customize sanitize.
	include get_template_directory() . '/include/customizer/sanitize.php';
	
	
	// Load customize sanitize.
	include get_template_directory() . '/include/customizer/active-callback.php';
	
	
	if ( class_exists( 'WP_Customize_Control' ) && ! class_exists( 'Aneeq_More_Control' ) ) :
	class Aneeq_More_Control extends WP_Customize_Control {

	/**
	* Render the content on the theme customizer page
	*/
	public function render_content() {
		?>
		<label style="overflow: hidden; zoom: 1;">
			<div class="col-md-4 col-sm-6 aneeq-btn">
				<a style="" href="https://awplife.com/wordpress-themes/aneeq-premium/" target="blank" class="btn btn-success btn"><?php esc_html_e('Upgrade to aneeq Premium','aneeq'); ?> </a>
			</div>
			<div class="col-md-3 col-sm-6">
				<h3 class="features-btn"><?php echo esc_html_e( 'Aneeq Premium - Features','aneeq'); ?></h3>
				<ul>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Responsive Design','aneeq'); ?> </li>					
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Translation Ready','aneeq'); ?> </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multi Purpose','aneeq'); ?>  </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('High Performance','aneeq'); ?>  </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Font Awesome Icons','aneeq'); ?> </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Blog Template','aneeq'); ?> </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Multi Color Option','aneeq'); ?></li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Advanced Typography','aneeq'); ?>   </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Flickr Photo Stream Widget','aneeq'); ?>   </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Woo-commerce Compatible','aneeq'); ?>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Theme Layout','aneeq'); ?>  </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Ultimate Portfolio layout with Isotope effect','aneeq'); ?> </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Home Page Active/Inactive Sections','aneeq'); ?> </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Support Access','aneeq'); ?> </li>
					<li class="background-box"> <div class="dashicons dashicons-yes"></div> <?php esc_html_e('Homepage Section Draggable','aneeq'); ?> </li>
				</ul>
			</div>
			<hr>
			<span class="customize-control-title"><?php esc_html_e( 'Found Useful Aneeq?', 'aneeq' ); ?></span>
			<p>
				<?php
					printf( esc_html_e( 'If you Like our Theme , Please do Rate us on WordPress.org  We\'d really appreciate it!', 'aneeq' ), '<a target="_new" href="https://wordpress.org/support/theme/aneeq/reviews/?filter=5">', '</a>' );
				?>
			</p>
			<div class="col-md-2 col-sm-6 aneeq-btn2">
				<a style="margin-bottom:20px;margin-left:20px;" href="https://wordpress.org/support/theme/aneeq/reviews/?filter=5" target="blank" class="btn btn-success btn"><?php esc_html_e('Rate US','aneeq'); ?> </a>
			</div>
			<hr>
			<span class="customize-control-title"><?php esc_html_e( 'Our Top Featured Recommended Plugins', 'aneeq' ); ?></span>
			<div class="col-md-2 col-sm-6 aneeq-btn2">
				<a style="margin-bottom:20px;margin-left:20px;" href="https://wordpress.org/plugins/blog-filter/" target="blank" class="btn btn-success btn"><?php esc_html_e('Blog Filter Gallery','aneeq'); ?> </a>
			</div>
			<div class="col-md-2 col-sm-6 aneeq-btn2">
				<a style="margin-bottom:20px;margin-left:20px;" href="https://wordpress.org/plugins/portfolio-filter-gallery/" target="blank" class="btn btn-success btn"><?php esc_html_e('Portfolio Filter Gallery','aneeq'); ?> </a>
			</div>
		</label>
		<?php
	}
}
endif;	
	
	//Aneeq Theme Options
	$wp_customize->add_panel('aneeq_theme_options', array(
				'title' 	=> __( 'Theme Options', 'aneeq' ),
				'priority' 	=> 2,
            )
        );
		
		//1. Upgrade To aneeq Premium ======================================
		$wp_customize->add_section( 'upgrade_aneeq_premium' , array(
			'title'      	=> __( 'Upgrade to Premium', 'aneeq' ),
			'priority'   	=> 1,
			'panel'=>'aneeq_theme_options',
		) );

			$wp_customize->add_setting( 'upgrade_aneeq_premium', array(
				'default'    		=> null,
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( new Aneeq_More_Control( $wp_customize, 'upgrade_aneeq_premium', array(
				'label'    => __( 'Aneeq Premium', 'aneeq' ),
				'section'  => 'upgrade_aneeq_premium',
				'settings' => 'upgrade_aneeq_premium',
				'priority' => 1,
			) ) ); 
		//1. Upgrade To aneeq Premium ======================================
	
		//2. General Settings Start ======================================
		$wp_customize->add_section( 'aneeq_general_settings' , array(
				'title'      	=> __( 'General Settings', 'aneeq' ),
				'priority'      => 2,
				'panel'			=> 'aneeq_theme_options',
			) 
		);
			
			
			//loading icon show hide		
			$wp_customize->add_setting( 'aneeq_loading_icon_setting', array(
					'default'      		=> 'active',
					'sanitize_callback' => 'aneeq_sanitize_radio'
				)
			);
			$wp_customize->add_control('aneeq_loading_icon_setting', array(
					'type'     		 => 'radio',
					'label'   	 	 => __('Loading Icon', 'aneeq'),
					'description'    => __('Hide/Show loading icon', 'aneeq'),
					'section'  		 => 'aneeq_general_settings',
					'priority' 		 => 1,
					'choices'  		 => array(
						'active'       => __( 'Show', 'aneeq' ),
						'inactive'     => __( 'Hide', 'aneeq' ),
					),
				)
			);
			

			//Theme Layout
			$wp_customize->add_setting( 'aneeq_theme_layout', array(
					'default'     		=> 'wide',
					'sanitize_callback' => 'aneeq_sanitize_radio',
				)
			);
				$wp_customize->add_control('aneeq_theme_layout', array(
						'type'      => 'radio',
						'label'     => __('Theme Layout', 'aneeq'),
						'section'   => 'aneeq_general_settings',
						'settings'  => 'aneeq_theme_layout',
						'priority'  => 2,
						'choices'   => array(
							'wide'       => __( 'Wide Layout', 'aneeq' ),
							'boxed'      => __( 'Box Layout', 'aneeq' ),
						),
					)
				);
				
				//Boxed Layout Background Image
				$wp_customize->add_setting( 'aneeq_boxed_layout_bgimg', array(
						'default'      		=> esc_html( 'None', 'aneeq' ),
						'sanitize_callback' => 'aneeq_sanitize_select',
					)
				);
				$wp_customize->add_control('aneeq_boxed_layout_bgimg', array(
						'type'      => 'select',
						'label'     => __('Boxed Layout Background Image', 'aneeq'),
						'section'   => 'aneeq_general_settings',
						'priority'  => 3,
						'choices'   => array(
							'None'      			=> __( 'None', 'aneeq' ),
							'crossed_stripes'       => __( 'Crossed Stripes', 'aneeq' ),
							'classy_fabric'         => __( 'Classy Fabric', 'aneeq' ),
							'low_contrast_linen'    => __( 'Low Contrast Linen', 'aneeq' ),
							'wood'    				=> __( 'Wood', 'aneeq' ),
							'diamonds'    			=> __( 'Diamonds', 'aneeq' ),
							'triangles'    			=> __( 'Triangles', 'aneeq' ),
							'black_mamba'    		=> __( 'Black Mamba', 'aneeq' ),
							'vichy'   			 	=> __( 'Vichy', 'aneeq' ),
							'back_pattern'    		=> __( 'Back Pattern', 'aneeq' ),
							'checkered_pattern'    	=> __( 'Checkered Pattern', 'aneeq' ),
							'diamond_upholstery'    => __( 'Diamond Upholstery', 'aneeq' ),
							'lyonnette'    			=> __( 'Lyonnette', 'aneeq' ),
							'graphy'    			=> __( 'Graphy', 'aneeq' ),
							'black_thread'    		=> __( 'Black Thread', 'aneeq' ),
							'subtlenet2'    		=> __( 'Subtlenet', 'aneeq' ),
						),
						'active_callback' => 'aneeq_boxed_layout_choice',
					)
				);
				
				//function aneeq_boxed_layout_choice
				function aneeq_boxed_layout_choice( $aneeq_boxed_layout_callback ) {
					if ( $aneeq_boxed_layout_callback->manager->get_setting('aneeq_theme_layout')->value() == 'boxed' ) {
						return true;
					} else {
						return false;
					}
				}
			
			//General Page Layout
			$wp_customize->add_setting( 'aneeq_general_page_layout', array(
					'default'      		=> 'fullwidth',
					'sanitize_callback' => 'aneeq_sanitize_radio'
				)
			);
			$wp_customize->add_control('aneeq_general_page_layout', array(
					'type'     		 => 'radio',
					'label'    		 => __('Single Page Layout', 'aneeq'),
					'description'    => __('Sidebar setting for single Page', 'aneeq'),
					'section'  		 => 'aneeq_general_settings',
					'priority' 		 => 5,
					'choices'  		 => array(
						'leftsidebar'       => __( 'Left Sidebar', 'aneeq' ),
						'fullwidth'         => __( 'Full width (no sidebar)', 'aneeq' ),
						'rightsidebar'    	=> __( 'Right Sidebar', 'aneeq' )
					),
				)
			);
			
			//General Blog Single Page Layout
			$wp_customize->add_setting( 'aneeq_blog_single_page_layout', array(
					'default'      		=> 'fullwidth',
					'sanitize_callback' => 'aneeq_sanitize_radio'
				)
			);
			$wp_customize->add_control('aneeq_blog_single_page_layout', array(
					'type'    		 => 'radio',
					'label'  		 => __('Single Post Layout', 'aneeq'),
					'description'    => __('Sidebar setting for single blog post', 'aneeq'),
					'section' 		 => 'aneeq_general_settings',
					'priority' 		 => 6,
					'choices'  		 => array(
						'leftsidebar'       => __( 'Left Sidebar', 'aneeq' ),
						'fullwidth'         => __( 'Full width (no sidebar)', 'aneeq' ),
						'rightsidebar'    	=> __( 'Right Sidebar', 'aneeq' )
					),
				)
			);
		
		//2. General Settings End ======================================
		
		
			//Enable Static Page = MOVED TO STATIC PAGE static_front_page	
			$wp_customize->add_setting( 'aneeq_static_page_setting', array(
					'default'      		=> 'active',
					'sanitize_callback' => 'aneeq_sanitize_radio'
				)
			);
			$wp_customize->add_control('aneeq_static_page_setting', array(
					'type'     		 => 'radio',
					'label'   	 	 => __('Static Page Content', 'aneeq'),
					'description'    => __('Show content on static Front Page', 'aneeq'),
					'section'  		 => 'static_front_page',
					'priority' 		 => 45,
					'choices'  		 => array(
						'active'       => __( 'Show', 'aneeq' ),
						'inactive'     => __( 'Hide', 'aneeq' ),
					),
				)
			);
			
			//Static Blog Layout = MOVED TO STATIC PAGE static_front_page	
			$wp_customize->add_setting( 'aneeq_page_layout_style', array(
					'default'      		=> 'rightsidebar',
					'sanitize_callback' => 'aneeq_sanitize_radio'
				)
			);
			$wp_customize->add_control('aneeq_page_layout_style', array(
					'type'      => 'radio',
					'label'     => __('Blog Posts layout', 'aneeq'),
					//'description' => __('Required: Set Static Page Content as Show', 'aneeq'),
					'section'   => 'aneeq_general_settings',
					'priority'  => 50,
					'choices'   => array(
						'leftsidebar'       => __( 'Left Sidebar', 'aneeq' ),
						'fullwidth'         => __( 'Full width (no sidebar)', 'aneeq' ),
						'rightsidebar'    	=> __( 'Right Sidebar', 'aneeq' )
					),
				)
			);
			
		
		
		// Load frontpage sections option.
		include get_template_directory() . '/include/customizer/frontpage-section.php';
		
		
		//9. Footer Settings Start ======================================
		$wp_customize->add_section( 'aneeq_footer_settings' , array(
				'title'      	=> __( 'Footer Settings', 'aneeq' ),
				'priority'      => 9,
				'panel'			=> 'aneeq_theme_options',
			) 
		);
			//Enable Footer			
			$wp_customize->add_setting( 'aneeq_widgets_section', array(
					'default'      		=> 'active',
					'sanitize_callback' => 'aneeq_sanitize_radio'
				)
			);
			$wp_customize->add_control('aneeq_widgets_section', array(
					'type'      => 'radio',
					'label'     => __('Widgets Section', 'aneeq'),
					'section'   => 'aneeq_footer_settings',
					'settings'   => 'aneeq_widgets_section',
					'priority'  => 1,
					'choices'   => array(
						'active'       => __( 'Active', 'aneeq' ),
						'inactive'     => __( 'Inactive', 'aneeq' ),
					),
				)
			);
			
			//Footer Column Layout
			$wp_customize->add_setting( 'aneeq_footer_column_layout', array(
					'default'      		=> '3',
					'sanitize_callback' => 'aneeq_sanitize_radio',
				)
			);
			$wp_customize->add_control('aneeq_footer_column_layout', array(
					'type'      => 'radio',
					'label'     => __('Footer Column Layout', 'aneeq'),
					'section'   => 'aneeq_footer_settings',
					'priority'  => 2,
					'choices'   => array(
						'1'   	 => __( 'One Column', 'aneeq' ),
						'2'      => __( 'Two Column', 'aneeq' ),
						'3'      => __( 'Three Column', 'aneeq' ),
						'4'      => __( 'Four Column', 'aneeq' ),
					),
					'active_callback' => 'aneeq_footer_choice_callback',
				)
			);
			
			
			//Footer Social Icons
			$wp_customize->add_setting( 'aneeq_footer_social_icons', array(
					'default'      		=> 'hide',
					'sanitize_callback' => 'aneeq_sanitize_radio',
				)
			);
			$wp_customize->add_control('aneeq_footer_social_icons', array(
					'type'      => 'radio',
					'label'     => __('Footer Social Icons', 'aneeq'),
					'section'   => 'aneeq_footer_settings',
					'priority'  => 12,
					'choices'   => array(
						'show'      => __( 'Show', 'aneeq' ),
						'hide'      => __( 'Hide', 'aneeq' ),
					),
					//'active_callback' => 'aneeq_footer_choice_callback',
				)
			);
			//Footer Facebook link
			$wp_customize->add_setting('aneeq_facebook_url', array( 
					'default'           => esc_html('', 'aneeq'),
					'sanitize_callback' => 'esc_url_raw'
					) 
				);
			$wp_customize->add_control('aneeq_facebook_url', array(
					'description'   => __('Enter your Facebook URL', 'aneeq'),
					'section'         => 'aneeq_footer_settings',
					'type'            => 'url',
					'priority'        => 14,
					'active_callback' => function() use ( $wp_customize ) {
							return 'show' === $wp_customize->get_setting( 'aneeq_footer_social_icons' )->value();
					},
				)
			);
			
			//Footer Twitter link
			$wp_customize->add_setting('aneeq_twitter_url', array( 
					'default'           => esc_html('', 'aneeq'),
					'sanitize_callback' => 'esc_url_raw'
					) 
				);
			$wp_customize->add_control('aneeq_twitter_url', array(
					'description'   => __('Enter your Twitter URL', 'aneeq'),
					'section'         => 'aneeq_footer_settings',
					'type'            => 'url',
					'priority'        => 16,
					'active_callback' => function() use ( $wp_customize ) {
							return 'show' === $wp_customize->get_setting( 'aneeq_footer_social_icons' )->value();
					},
				)
			);
			
			//Footer Instagram link
			$wp_customize->add_setting('aneeq_insta_url', array( 
					'default'           => esc_html('', 'aneeq'),
					'sanitize_callback' => 'esc_url_raw'
					) 
				);
			$wp_customize->add_control('aneeq_insta_url', array(
					'description'   => __('Enter your Instagram URL', 'aneeq'),
					'section'         => 'aneeq_footer_settings',
					'type'            => 'url',
					'priority'        => 18,
					'active_callback' => function() use ( $wp_customize ) {
							return 'show' === $wp_customize->get_setting( 'aneeq_footer_social_icons' )->value();
					},
				)
			);
			
			//Footer Youtube link
			$wp_customize->add_setting('aneeq_youtube_url', array( 
					'default'           => esc_html('', 'aneeq'),
					'sanitize_callback' => 'esc_url_raw'
					) 
				);
			$wp_customize->add_control('aneeq_youtube_url', array(
					'description'   => __('Enter your Youtube URL', 'aneeq'),
					'section'         => 'aneeq_footer_settings',
					'type'            => 'url',
					'priority'        => 20,
					'active_callback' => function() use ( $wp_customize ) {
							return 'show' === $wp_customize->get_setting( 'aneeq_footer_social_icons' )->value();
					},
				)
			);
			
			//Footer Pintrest link
			$wp_customize->add_setting('aneeq_pintrest_url', array( 
					'default'           => esc_html('', 'aneeq'),
					'sanitize_callback' => 'esc_url_raw'
					) 
				);
			$wp_customize->add_control('aneeq_pintrest_url', array(
					'description'   => __('Enter your Pintrest URL', 'aneeq'),
					'section'         => 'aneeq_footer_settings',
					'type'            => 'url',
					'priority'        => 22,
					'active_callback' => function() use ( $wp_customize ) {
							return 'show' === $wp_customize->get_setting( 'aneeq_footer_social_icons' )->value();
					},
				)
			);
				
			function aneeq_footer_choice_callback( $aneeq_footer_control ) {
				$aneeq_footer_radio_setting = $aneeq_footer_control->manager->get_setting('aneeq_widgets_section')->value();
				$aneeq_footer_control_id = $aneeq_footer_control->id;
				 
				//if ( $aneeq_footer_control_id == 'aneeq_footer_social_icons'  && $aneeq_footer_radio_setting == 'active' ) return true;
				if ( $aneeq_footer_control_id == 'aneeq_footer_column_layout'  && $aneeq_footer_radio_setting == 'active' ) return true;
				//if ( $aneeq_footer_control_id == 'aneeq_facebook_url'  && $aneeq_footer_radio_setting == 'active' ) return true;
				 
				return false;
			} 
		//9. Footer Settings End ======================================
			
}
add_action( 'customize_register', 'aneeq_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function aneeq_customize_preview_js() {
	wp_enqueue_script( 'aneeq_customizer_header', get_template_directory_uri() . '/include/customizer/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'aneeq_customize_preview_js' );

     
//radio box sanitization function
function aneeq_sanitize_radio( $input, $setting ){
 
	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key($input);

	//get the list of possible radio box options 
	$choices = $setting->manager->get_control( $setting->id )->choices;
					 
	//return input if valid or return default option
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
	 
}

function aneeq_sanitize_select( $input, $setting ){
 
	//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
	$input = sanitize_key($input);

	//get the list of possible select options 
	$choices = $setting->manager->get_control( $setting->id )->choices;
					 
	//return input if valid or return default option
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
	 
}


/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function aneeq_customize_partial_name() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function aneeq_customize_partial_description() {
	bloginfo( 'description' );
} 


// Load frontpage sections option.
include get_template_directory() . '/include/title-selector.php';
	
?>