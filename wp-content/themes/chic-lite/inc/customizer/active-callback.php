<?php

/**
 * Active Callback for Banner Slider
*/
function chic_lite_banner_ac( $control ){
    $banner        = $control->manager->get_setting( 'ed_banner_section' )->value();
    $slider_type   = $control->manager->get_setting( 'slider_type' )->value();
    $control_id    = $control->id;
    
    if ( $control_id == 'header_image' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'header_video' && $banner == 'static_banner' ) return true;
    if ( $control_id == 'external_header_video' && $banner == 'static_banner' ) return true;    
    if ( $control_id == 'slider_type' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_auto' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_loop' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'slider_caption' && $banner == 'slider_banner' ) return true; 
    if ( $control_id == 'slider_cat' && $banner == 'slider_banner' && $slider_type == 'cat' ) return true;
    if ( $control_id == 'no_of_slides' && $banner == 'slider_banner' && ( $slider_type == 'latest_posts' || ( chic_lite_is_delicious_recipe_activated() && $slider_type == 'latest_recipes' ) ) ) return true;
    if ( $control_id == 'banner_hr' && $banner == 'slider_banner' ) return true;
    if ( $control_id == 'include_repetitive_posts' && $banner == 'slider_banner' && ( $slider_type == 'cat' || $slider_type == 'latest_posts' ) ) return true;
    if ( $control_id == 'banner_title' && $banner == 'static_banner' ) return true;    
    if ( $control_id == 'banner_subtitle' && $banner == 'static_banner' ) return true;    
    if ( $control_id == 'banner_button' && $banner == 'static_banner' ) return true;    
    if ( $control_id == 'banner_url' && $banner == 'static_banner' ) return true;    
    if ( $control_id == 'banner_url_new_tab' && $banner == 'static_banner' ) return true;  


    return false;
}

/**
 * Active Callback for comment toggle.
*/
function chic_lite_comments_toggle( $control ){
    
    $comment_toggle = $control->manager->get_setting( 'ed_comments' )->value();
    
    if ( $comment_toggle == true ) return true;
    
    return false;
}

/**
 * Active Callback for post/page
*/
function chic_lite_post_page_ac( $control ){
    
    $ed_related    = $control->manager->get_setting( 'ed_related' )->value();
    $control_id    = $control->id;
    
    if ( $control_id == 'related_post_title' && $ed_related == true ) return true;
    
    return false;
}

/**
 * Active Callback for Newsletter.
*/
function chic_lite_ed_newsletter(){
    
    $ed_newsletter = get_theme_mod( 'ed_newsletter', true );

    if ( $ed_newsletter ) return true;

    return false;
}

/**
 * Active Callback for Instagram.
*/
function chic_lite_ed_instagram(){
    
    $ed_instagram = get_theme_mod( 'ed_instagram', false );

    if ( $ed_instagram ) return true;

    return false;
}