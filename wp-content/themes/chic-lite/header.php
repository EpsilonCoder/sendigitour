<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Chic_Lite
 */
    /**
     * Doctype Hook
     * 
     * @hooked chic_lite_doctype
    */
    do_action( 'chic_lite_doctype' );
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<?php 
    /**
     * Before wp_head
     * 
     * @hooked chic_lite_head
    */
    do_action( 'chic_lite_before_wp_head' );
    
    wp_head(); ?>
</head>

<body <?php body_class(); ?> itemscope itemtype="http://schema.org/WebPage">

<?php
    wp_body_open();
    
    /**
     * Before Header
     * 
     * 
     * @hooked chic_lite_page_start - 20 
    */
    do_action( 'chic_lite_before_header' );
    
    /**
     * Header
     * 
     * @hooked chic_lite_header           - 20     
    */
    do_action( 'chic_lite_header' );
    
    /**
     * Before Content
     * 
     * @hooked chic_lite_banner             - 15
     * @hooked chic_lite_featured_area      - 20
     * @hooked chic_lite_top_bar            - 30
    */
    do_action( 'chic_lite_after_header' );
    
    /**
     * Content
     * 
     * @hooked chic_lite_content_start
    */
    do_action( 'chic_lite_content' );