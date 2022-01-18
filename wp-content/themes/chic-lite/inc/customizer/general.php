<?php
/**
 * General Settings
 *
 * @package Chic_Lite
 */

function chic_lite_customize_register_general( $wp_customize ){
    
    /** General Settings */
    $wp_customize->add_panel( 
        'general_settings',
         array(
            'priority'    => 60,
            'capability'  => 'edit_theme_options',
            'title'       => __( 'General Settings', 'chic-lite' ),
            'description' => __( 'Customize Banner, Featured, Social, Sharing, SEO, Post/Page, Newsletter & Instagram, Shop, Performance and Miscellaneous settings.', 'chic-lite' ),
        ) 
    );
      
    /** Slider Settings */
    $wp_customize->get_section( 'header_image' )->panel                    = 'general_settings';
    $wp_customize->get_section( 'header_image' )->title                    = __( 'Banner Section', 'chic-lite' );
    $wp_customize->get_section( 'header_image' )->priority                 = 10;
    $wp_customize->get_control( 'header_image' )->active_callback          = 'chic_lite_banner_ac';
    $wp_customize->get_control( 'header_video' )->active_callback          = 'chic_lite_banner_ac';
    $wp_customize->get_control( 'external_header_video' )->active_callback = 'chic_lite_banner_ac';
    $wp_customize->get_section( 'header_image' )->description              = '';                                               
    $wp_customize->get_setting( 'header_image' )->transport                = 'refresh';
    $wp_customize->get_setting( 'header_video' )->transport                = 'refresh';
    $wp_customize->get_setting( 'external_header_video' )->transport       = 'refresh';
    
    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'           => 'slider_banner',
            'sanitize_callback' => 'chic_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Chic_Lite_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'       => __( 'Banner Options', 'chic-lite' ),
                'description' => __( 'Choose banner as static image/video or as a slider.', 'chic-lite' ),
                'section'     => 'header_image',
                'choices'     => array(
                    'no_banner'         => __( 'Disable Banner Section', 'chic-lite' ),
                    'slider_banner'     => __( 'Banner as Slider', 'chic-lite' ),
                    'static_banner'     => __( 'Static/Video Banner', 'chic-lite' ),
                ),
                'priority' => 5 
            )            
        )
    );
    
    /** Slider Content Style */
    $wp_customize->add_setting(
        'slider_type',
        array(
            'default'           => 'latest_posts',
            'sanitize_callback' => 'chic_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Chic_Lite_Select_Control(
            $wp_customize,
            'slider_type',
            array(
                'label'   => __( 'Slider Content Style', 'chic-lite' ),
                'section' => 'header_image',
                'choices' => chic_lite_slider_options(),
                'active_callback' => 'chic_lite_banner_ac'  
            )
        )
    );
    
    /** Slider Category */
    $wp_customize->add_setting(
        'slider_cat',
        array(
            'default'           => '',
            'sanitize_callback' => 'chic_lite_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Chic_Lite_Select_Control(
            $wp_customize,
            'slider_cat',
            array(
                'label'           => __( 'Slider Category', 'chic-lite' ),
                'section'         => 'header_image',
                'choices'         => chic_lite_get_categories(),
                'active_callback' => 'chic_lite_banner_ac'  
            )
        )
    );
    
    
    /** No. of slides */
    $wp_customize->add_setting(
        'no_of_slides',
        array(
            'default'           => 3,
            'sanitize_callback' => 'chic_lite_sanitize_number_absint'
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Slider_Control( 
            $wp_customize,
            'no_of_slides',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Number of Slides', 'chic-lite' ),
                'description' => __( 'Choose the number of slides you want to display', 'chic-lite' ),
                'choices'     => array(
                    'min'   => 1,
                    'max'   => 20,
                    'step'  => 1,
                ),
                'active_callback' => 'chic_lite_banner_ac'                 
            )
        )
    );

    /** Repetitive Posts */
    $wp_customize->add_setting(
        'include_repetitive_posts',
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'include_repetitive_posts',
            array(
                'section'       => 'header_image',
                'label'         => __( 'Include Repetitive Posts', 'chic-lite' ),
                'description'   => __( 'Enable to add posts included in slider in blog page too.', 'chic-lite' ),
                'active_callback' => 'chic_lite_banner_ac'
            )
        )
    );
    
    /** HR */
    $wp_customize->add_setting(
        'banner_hr',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Note_Control( 
            $wp_customize,
            'banner_hr',
            array(
                'section'     => 'header_image',
                'description' => '<hr/>',
                'active_callback' => 'chic_lite_banner_ac'
            )
        )
    );
    
    /** Slider Auto */
    $wp_customize->add_setting(
        'slider_auto',
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'slider_auto',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Auto', 'chic-lite' ),
                'description' => __( 'Enable slider auto transition.', 'chic-lite' ),
                'active_callback' => 'chic_lite_banner_ac'
            )
        )
    );
    
    /** Slider Loop */
    $wp_customize->add_setting(
        'slider_loop',
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'slider_loop',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Loop', 'chic-lite' ),
                'description' => __( 'Enable slider loop.', 'chic-lite' ),
                'active_callback' => 'chic_lite_banner_ac'
            )
        )
    );
    
    /** Slider Caption */
    $wp_customize->add_setting(
        'slider_caption',
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'slider_caption',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Slider Caption', 'chic-lite' ),
                'description' => __( 'Enable slider caption.', 'chic-lite' ),
                'active_callback' => 'chic_lite_banner_ac'
            )
        )
    );

    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default'           => __( 'Find Your Best Holiday', 'chic-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_title',
        array(
            'label'           => __( 'Title', 'chic-lite' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'chic_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_title', array(
        'selector' => '.site-banner .banner-caption .banner-title',
        'render_callback' => 'chic_lite_get_banner_title',
    ) );

    /** Sub Title */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default'           => __( 'Find great adventure holidays and activities around the planet.', 'chic-lite' ),
            'sanitize_callback' => 'wp_kses_post',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label'           => __( 'Sub Title', 'chic-lite' ),
            'section'         => 'header_image',
            'type'            => 'textarea',
            'active_callback' => 'chic_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_subtitle', array(
        'selector' => '.site-banner .banner-caption .banner-desc',
        'render_callback' => 'chic_lite_get_banner_sub_title',
    ) );

    /** Banner Button Label */
    $wp_customize->add_setting(
        'banner_button',
        array(
            'default'           => __( 'Read More', 'chic-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'banner_button',
        array(
            'label'           => __( 'Banner Button Label', 'chic-lite' ),
            'section'         => 'header_image',
            'type'            => 'text',
            'active_callback' => 'chic_lite_banner_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'banner_button', array(
        'selector' => '.site-banner .banner-caption .btn',
        'render_callback' => 'chic_lite_get_banner_button',
    ) );

    /** Banner Link */
    $wp_customize->add_setting(
        'banner_url',
        array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        )
    );
    
    $wp_customize->add_control(
        'banner_url',
        array(
            'label'           => __( 'Banner Button Link', 'chic-lite' ),
            'section'         => 'header_image',
            'type'            => 'url',
            'active_callback' => 'chic_lite_banner_ac'
        )
    );

    $wp_customize->add_setting(
        'banner_url_new_tab',
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'banner_url_new_tab',
            array(
                'section'     => 'header_image',
                'label'       => __( 'Open in new tab', 'chic-lite' ),
                'description' => __( 'Enable to open static banner link in new tab.', 'chic-lite' ),
                'active_callback' => 'chic_lite_banner_ac'
            )
        )
    );
    /** Slider Settings Ends*/

    /** Social Media Settings */
    $wp_customize->add_section(
        'social_media_settings',
        array(
            'title'    => __( 'Social Media Settings', 'chic-lite' ),
            'priority' => 30,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_social_links', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_social_links',
            array(
                'section'     => 'social_media_settings',
                'label'       => __( 'Enable Social Links', 'chic-lite' ),
                'description' => __( 'Enable to show social links at header and footer.', 'chic-lite' ),
            )
        )
    );
    
    $wp_customize->add_setting( 
        new Chic_Lite_Repeater_Setting( 
            $wp_customize, 
            'social_links', 
            array(
                'default' => '',
                'sanitize_callback' => array( 'Chic_Lite_Repeater_Setting', 'sanitize_repeater_setting' ),
            ) 
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Control_Repeater(
            $wp_customize,
            'social_links',
            array(
                'section' => 'social_media_settings',               
                'label'   => __( 'Social Links', 'chic-lite' ),
                'fields'  => array(
                    'font' => array(
                        'type'        => 'font',
                        'label'       => __( 'Font Awesome Icon', 'chic-lite' ),
                        'description' => __( 'Example: fab fa-facebook-f', 'chic-lite' ),
                    ),
                    'link' => array(
                        'type'        => 'url',
                        'label'       => __( 'Link', 'chic-lite' ),
                        'description' => __( 'Example: https://facebook.com', 'chic-lite' ),
                    )
                ),
                'row_label' => array(
                    'type' => 'field',
                    'value' => __( 'links', 'chic-lite' ),
                    'field' => 'link'
                )                        
            )
        )
    );
    /** Social Media Settings Ends */

    /** SEO Settings */
    $wp_customize->add_section(
        'seo_settings',
        array(
            'title'    => __( 'SEO Settings', 'chic-lite' ),
            'priority' => 40,
            'panel'    => 'general_settings',
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_post_update_date', 
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_post_update_date',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Last Update Post Date', 'chic-lite' ),
                'description' => __( 'Enable to show last updated post date on listing as well as in single post.', 'chic-lite' ),
            )
        )
    );
    
    /** Enable Social Links */
    $wp_customize->add_setting( 
        'ed_breadcrumb', 
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_breadcrumb',
            array(
                'section'     => 'seo_settings',
                'label'       => __( 'Enable Breadcrumb', 'chic-lite' ),
                'description' => __( 'Enable to show breadcrumb in inner pages.', 'chic-lite' ),
            )
        )
    );
    
    /** Breadcrumb Home Text */
    $wp_customize->add_setting(
        'home_text',
        array(
            'default'           => __( 'Home', 'chic-lite' ),
            'sanitize_callback' => 'sanitize_text_field' 
        )
    );
    
    $wp_customize->add_control(
        'home_text',
        array(
            'type'    => 'text',
            'section' => 'seo_settings',
            'label'   => __( 'Breadcrumb Home Text', 'chic-lite' ),
        )
    );  
    /** SEO Settings Ends */

    /** Posts(Blog) & Pages Settings */
    $wp_customize->add_section(
        'post_page_settings',
        array(
            'title'    => __( 'Posts(Blog) & Pages Settings', 'chic-lite' ),
            'priority' => 50,
            'panel'    => 'general_settings',
        )
    );
    
    /** Prefix Archive Page */
    $wp_customize->add_setting( 
        'ed_prefix_archive', 
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_prefix_archive',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Prefix in Archive Page', 'chic-lite' ),
                'description' => __( 'Enable to hide prefix in archive page.', 'chic-lite' ),
            )
        )
    );
        
    /** Blog Excerpt */
    $wp_customize->add_setting( 
        'ed_excerpt', 
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_excerpt',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Enable Blog Excerpt', 'chic-lite' ),
                'description' => __( 'Enable to show excerpt or disable to show full post content.', 'chic-lite' ),
            )
        )
    );
    
    /** Excerpt Length */
    $wp_customize->add_setting( 
        'excerpt_length', 
        array(
            'default'           => 25,
            'sanitize_callback' => 'chic_lite_sanitize_number_absint'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Slider_Control( 
            $wp_customize,
            'excerpt_length',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Excerpt Length', 'chic-lite' ),
                'description' => __( 'Automatically generated excerpt length (in words).', 'chic-lite' ),
                'choices'     => array(
                    'min'   => 10,
                    'max'   => 100,
                    'step'  => 5,
                )                 
            )
        )
    );
    
    /** Read More Text */
    $wp_customize->add_setting(
        'read_more_text',
        array(
            'default'           => __( 'Continue Reading', 'chic-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'read_more_text',
        array(
            'type'    => 'text',
            'section' => 'post_page_settings',
            'label'   => __( 'Read More Text', 'chic-lite' ),
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'read_more_text', array(
        'selector' => '.entry-footer .btn-readmore',
        'render_callback' => 'chic_lite_get_read_more',
    ) );

    /** Enable Image Cropped Size In Home, Archive And Search Posts */
    $wp_customize->add_setting( 
        'ed_crop_blog', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_crop_blog',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Blog Post Image Crop', 'chic-lite' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in home, archive and search posts.', 'chic-lite' ),
            )
        )
    );

    /** Note */
    $wp_customize->add_setting(
        'post_note_text',
        array(
            'default'           => '',
            'sanitize_callback' => 'wp_kses_post' 
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Note_Control( 
            $wp_customize,
            'post_note_text',
            array(
                'section'     => 'post_page_settings',
                'description' => sprintf( __( '%s These options affect your individual posts.', 'chic-lite' ), '<hr/>' ),
            )
        )
    );

    /** Enable Image Cropped Size In Single Posts */
    $wp_customize->add_setting( 
        'ed_crop_single', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_crop_single',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Single Post Image Crop', 'chic-lite' ),
                'description' => __( 'Enable to avoid automatic cropping of featured image in single post.', 'chic-lite' ),
            )
        )
    );
         
    /** Show Related Posts */
    $wp_customize->add_setting( 
        'ed_related', 
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_related',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Related Posts', 'chic-lite' ),
                'description' => __( 'Enable to show related posts in single page.', 'chic-lite' ),
            )
        )
    );
    
    /** Related Posts section title */
    $wp_customize->add_setting(
        'related_post_title',
        array(
            'default'           => __( 'You may also like...', 'chic-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage' 
        )
    );
    
    $wp_customize->add_control(
        'related_post_title',
        array(
            'type'            => 'text',
            'section'         => 'post_page_settings',
            'label'           => __( 'Related Posts Section Title', 'chic-lite' ),
            'active_callback' => 'chic_lite_post_page_ac'
        )
    );
    
    $wp_customize->selective_refresh->add_partial( 'related_post_title', array(
        'selector' => '.additional-post .post-title',
        'render_callback' => 'chic_lite_get_related_title',
    ) );
        
    /** Comments */
    $wp_customize->add_setting(
        'ed_comments',
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_comments',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Show Comments', 'chic-lite' ),
                'description' => __( 'Enable to show Comments in Single Post/Page.', 'chic-lite' ),
            )
        )
    );

    /** Comment Section After Content */
    $wp_customize->add_setting( 
        'toggle_comments', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'toggle_comments',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Toggle Comment Section', 'chic-lite' ),
                'description' => __( 'Enable to show comment section after post content. Refresh site for changes.', 'chic-lite' ),
                'active_callback' => 'chic_lite_comments_toggle'
            )
        )
    );
    
    /** Hide Category */
    $wp_customize->add_setting( 
        'ed_category', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_category',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Category', 'chic-lite' ),
                'description' => __( 'Enable to hide category.', 'chic-lite' ),
            )
        )
    );
    
    /** Hide Post Author */
    $wp_customize->add_setting( 
        'ed_post_author', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_post_author',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Post Author', 'chic-lite' ),
                'description' => __( 'Enable to hide post author.', 'chic-lite' ),
            )
        )
    );
    
    /** Hide Posted Date */
    $wp_customize->add_setting( 
        'ed_post_date', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_post_date',
            array(
                'section'     => 'post_page_settings',
                'label'       => __( 'Hide Posted Date', 'chic-lite' ),
                'description' => __( 'Enable to hide posted date.', 'chic-lite' ),
            )
        )
    );
    
    /** Posts(Blog) & Pages Settings Ends */

    /** Newsletter Settings */
    $wp_customize->add_section(
        'newsletter_settings',
        array(
            'title'    => __( 'Newsletter Settings', 'chic-lite' ),
            'priority' => 60,
            'panel'    => 'general_settings',
        )
    );
    
    if( chic_lite_is_btnw_activated() ){
        
        /** Enable Newsletter Section */
        $wp_customize->add_setting( 
            'ed_newsletter', 
            array(
                'default'           => false,
                'sanitize_callback' => 'chic_lite_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Chic_Lite_Toggle_Control( 
                $wp_customize,
                'ed_newsletter',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __( 'Newsletter Section', 'chic-lite' ),
                    'description' => __( 'Enable to show Newsletter Section', 'chic-lite' ),
                )
            )
        );
    
        /** Newsletter Shortcode */
        $wp_customize->add_setting(
            'newsletter_shortcode',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post',
            )
        );
        
        $wp_customize->add_control(
            'newsletter_shortcode',
            array(
                'type'        => 'text',
                'section'     => 'newsletter_settings',
                'label'       => __( 'Newsletter Shortcode', 'chic-lite' ),
                'description' => __( 'Enter the BlossomThemes Email Newsletters Shortcode. Ex. [BTEN id="356"]', 'chic-lite' ),
                'active_callback' => 'chic_lite_ed_newsletter'
            )
        ); 
    } else {
        $wp_customize->add_setting(
            'newsletter_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Chic_Lite_Plugin_Recommend_Control(
                $wp_customize,
                'newsletter_recommend',
                array(
                    'section'     => 'newsletter_settings',
                    'label'       => __( 'Newsletter Shortcode', 'chic-lite' ),
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-email-newsletter',//This is the slug of recommended plugin.
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Email Newsletter%2$s. After that option related with this section will be visible.', 'chic-lite' ), '<strong>', '</strong>' ),
                )
            )
        );
    }
    /** Newsletter Settings Ends */

    /** Instagram Settings */
    $wp_customize->add_section(
        'instagram_settings',
        array(
            'title'    => __( 'Instagram Settings', 'chic-lite' ),
            'priority' => 70,
            'panel'    => 'general_settings',
        )
    );
    
    if( chic_lite_is_btif_activated() ){
        /** Enable Instagram Section */
        $wp_customize->add_setting( 
            'ed_instagram', 
            array(
                'default'           => false,
                'sanitize_callback' => 'chic_lite_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Chic_Lite_Toggle_Control( 
                $wp_customize,
                'ed_instagram',
                array(
                    'section'     => 'instagram_settings',
                    'label'       => __( 'Instagram Section', 'chic-lite' ),
                    'description' => __( 'Enable to show Instagram Section', 'chic-lite' ),
                )
            )
        );
        
        /** Note */
        $wp_customize->add_setting(
            'instagram_text',
            array(
                'default'           => '',
                'sanitize_callback' => 'wp_kses_post' 
            )
        );
        
        $wp_customize->add_control(
            new Chic_Lite_Note_Control( 
                $wp_customize,
                'instagram_text',
                array(
                    'section'     => 'instagram_settings',
                    'description' => sprintf( __( 'You can change the setting BlossomThemes Social Feed %1$sfrom here%2$s.', 'chic-lite' ), '<a href="' . esc_url( admin_url( 'admin.php?page=class-blossomthemes-instagram-feed-admin.php' ) ) . '" target="_blank">', '</a>' ),
                    'active_callback'  => 'chic_lite_ed_instagram'   
                )
            )
        ); 

        // Instagram Background Image.
        $wp_customize->add_setting(
            'instagram_bg_image',
            array(
                'sanitize_callback' => 'chic_lite_sanitize_image',
            )
        );
        
        $wp_customize->add_control(
           new WP_Customize_Image_Control(
               $wp_customize,
               'instagram_bg_image',
               array(
                   'label'           => __( 'Instagram Background Image', 'chic-lite' ),
                   'description'     => __( 'Upload your instagram background image.', 'chic-lite' ),
                   'section'         => 'instagram_settings',
                  'active_callback'  => 'chic_lite_ed_instagram'               
               )
           )
        );

    }else{
        $wp_customize->add_setting(
            'instagram_recommend',
            array(
                'sanitize_callback' => 'wp_kses_post',
            )
        );

        $wp_customize->add_control(
            new Chic_Lite_Plugin_Recommend_Control(
                $wp_customize,
                'instagram_recommend',
                array(
                    'section'     => 'instagram_settings',
                    'capability'  => 'install_plugins',
                    'plugin_slug' => 'blossomthemes-instagram-feed',//This is the slug of recommended plugin.
                    'description' => sprintf( __( 'Please install and activate the recommended plugin %1$sBlossomThemes Social Feed%2$s. After that option related with this section will be visible.', 'chic-lite' ), '<strong>', '</strong>' ),
                )
            )
        );
    }
    /** Instagram Settings Ends*/

    /** Shop Settings */
    $wp_customize->add_section(
        'shop_settings',
        array(
            'title'    => __( 'Shop Settings', 'chic-lite' ),
            'priority' => 75,
            'panel'    => 'general_settings',
        )
    );
    
    if( chic_lite_is_woocommerce_activated() ){
        /** Shop Section */
        $wp_customize->add_setting( 
            'ed_shopping_cart', 
            array(
                'default'           => true,
                'sanitize_callback' => 'chic_lite_sanitize_checkbox'
            ) 
        );
        
        $wp_customize->add_control(
            new Chic_Lite_Toggle_Control( 
                $wp_customize,
                'ed_shopping_cart',
                array(
                    'section'     => 'shop_settings',
                    'label'       => __( 'Shopping Cart', 'chic-lite' ),
                    'description' => __( 'Enable to show Shopping cart in the header.', 'chic-lite' ),
                )
            )
        ); 
    }

    // Shop Background Image.
    $wp_customize->add_setting(
        'shop_bg_image',
        array(
            'sanitize_callback' => 'chic_lite_sanitize_image',
        )
    );
    
    $wp_customize->add_control(
       new WP_Customize_Image_Control(
           $wp_customize,
           'shop_bg_image',
           array(
               'label'           => __( 'Shop Background Image', 'chic-lite' ),
               'description'     => __( 'Upload your shop background image.', 'chic-lite' ),
               'section'         => 'shop_settings',
              'active_callback'  => 'chic_lite_is_woocommerce_activated'               
           )
       )
    );
    
    /** Shop Page Description */
    $wp_customize->add_setting( 
        'ed_shop_archive_description', 
        array(
            'default'           => false,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox'
        ) 
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_shop_archive_description',
            array(
                'section'         => 'shop_settings',
                'label'           => __( 'Shop Page Description', 'chic-lite' ),
                'description'     => __( 'Enable to show Shop Page Description.', 'chic-lite' ),
                'active_callback' => 'chic_lite_is_woocommerce_activated'
            )
        )
    );

    /** Shop Settings Ends */

    /** Miscellaneous Settings */
    $wp_customize->add_section(
        'misc_settings',
        array(
            'title'    => __( 'Misc Settings', 'chic-lite' ),
            'priority' => 85,
            'panel'    => 'general_settings',
        )
    );
    
    /** Header Search */
    $wp_customize->add_setting(
        'ed_header_search',
        array(
            'default'           => true,
            'sanitize_callback' => 'chic_lite_sanitize_checkbox',
        )
    );
    
    $wp_customize->add_control(
        new Chic_Lite_Toggle_Control( 
            $wp_customize,
            'ed_header_search',
            array(
                'section'       => 'misc_settings',
                'label'         => __( 'Header Search', 'chic-lite' ),
                'description'   => __( 'Enable to display search form in header.', 'chic-lite' ),
            )
        )
    );

    /** Related Portfolio */
    $wp_customize->add_setting(
        'related_portfolio_title',
        array(
            'default'           => __( 'Related Projects', 'chic-lite' ),
            'sanitize_callback' => 'sanitize_text_field',
            'transport'         => 'postMessage'
        )
    );
    
    $wp_customize->add_control(
        'related_portfolio_title',
        array(
            'label'       => __( 'Related Portfolio Title', 'chic-lite' ),
            'section'     => 'misc_settings',
            'type'        => 'text',
            'active_callback' => 'chic_lite_is_rara_theme_companion_activated'
        )
    );

    $wp_customize->selective_refresh->add_partial( 'related_portfolio_title', array(
        'selector' => '.related-portfolio .related-portfolio-title',
        'render_callback' => 'chic_lite_get_related_portfolio_title',
    ) );

    /** Misc Settings Ends */
}
add_action( 'customize_register', 'chic_lite_customize_register_general' );

if ( ! function_exists( 'chic_lite_slider_options' ) ) :
    /**
     * @return array Content type options
     */
    function chic_lite_slider_options() {
        $slider_options = array(
            'latest_posts' => __( 'Latest Posts', 'chic-lite' ),
            'cat'          => __( 'Category', 'chic-lite' ),
        );
        if ( chic_lite_is_delicious_recipe_activated() ) {
            $slider_options = array_merge( $slider_options, array( 'latest_recipes' => __( 'Latest Recipes', 'chic-lite' ) ) );
        }
        $output = apply_filters( 'chic_lite_slider_options', $slider_options );
        return $output;
    }
endif;