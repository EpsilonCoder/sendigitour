<?php
/**
 * Active callback functions.
 *
 * @package aneeq
 */

function aneeq_slider_sec_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_aneeq_slider_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function aneeq_slider_callback_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[aneeq_slider_content_type]' )->value();
    return ( aneeq_slider_sec_active( $control ) && ( 'slider_page' == $content_type ) );
}

function aneeq_slider_callback_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[aneeq_slider_content_type]' )->value();
    return ( aneeq_slider_sec_active( $control ) && ( 'slider_post' == $content_type ) );
}

function aneeq_service_sec_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_aneeq_services_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function aneeq_services_callback_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[aneeq_services_content_type]' )->value();
    return ( aneeq_service_sec_active( $control ) && ( 'services_page' == $content_type ) );
}

function aneeq_services_callback_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[aneeq_services_content_type]' )->value();
    return ( aneeq_service_sec_active( $control ) && ( 'services_post' == $content_type ) );
}

function aneeq_testimonial_sec_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_aneeq_testimonial_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function aneeq_testimonial_callback_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[aneeq_testimonials_content_type]' )->value();
    return ( aneeq_testimonial_sec_active( $control ) && ( 'testimonial_page' == $content_type ) );
}

function aneeq_testimonial_callback_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[aneeq_testimonials_content_type]' )->value();
    return ( aneeq_testimonial_sec_active( $control ) && ( 'testimonial_post' == $content_type ) );
}



function aneeq_blog_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_blog_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function aneeq_woo_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_woo_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}