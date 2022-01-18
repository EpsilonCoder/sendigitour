<?php
/**
 * Chic Lite Widget Areas
 * 
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @package Chic_Lite
 */

function chic_lite_widgets_init(){    
    $sidebars = array(
        'sidebar'   => array(
            'name'        => __( 'Sidebar', 'chic-lite' ),
            'id'          => 'sidebar', 
            'description' => __( 'Default Sidebar', 'chic-lite' ),
        ),
        'featured-area' => array(
            'name'        => __( 'Featured Area Section', 'chic-lite' ),
            'id'          => 'featured-area', 
            'description' => __( 'Add "Rara: Image Text" widget for featured area section.', 'chic-lite' ),
        ),
        'footer-one'=> array(
            'name'        => __( 'Footer One', 'chic-lite' ),
            'id'          => 'footer-one', 
            'description' => __( 'Add footer one widgets here.', 'chic-lite' ),
        ),
        'footer-two'=> array(
            'name'        => __( 'Footer Two', 'chic-lite' ),
            'id'          => 'footer-two', 
            'description' => __( 'Add footer two widgets here.', 'chic-lite' ),
        ),
        'footer-three'=> array(
            'name'        => __( 'Footer Three', 'chic-lite' ),
            'id'          => 'footer-three', 
            'description' => __( 'Add footer three widgets here.', 'chic-lite' ),
        ),
        'footer-four'=> array(
            'name'        => __( 'Footer Four', 'chic-lite' ),
            'id'          => 'footer-four', 
            'description' => __( 'Add footer four widgets here.', 'chic-lite' ),
        )
    );
    
    foreach( $sidebars as $sidebar ){
        register_sidebar( array(
    		'name'          => esc_html( $sidebar['name'] ),
    		'id'            => esc_attr( $sidebar['id'] ),
    		'description'   => esc_html( $sidebar['description'] ),
    		'before_widget' => '<section id="%1$s" class="widget %2$s">',
    		'after_widget'  => '</section>',
    		'before_title'  => '<h2 class="widget-title" itemprop="name">',
    		'after_title'   => '</h2>',
    	) );
    }

}
add_action( 'widgets_init', 'chic_lite_widgets_init' );