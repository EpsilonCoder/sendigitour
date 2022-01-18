<?php
/**
 * Chic Lite Dynamic Styles
 * 
 * @package Chic_Lite
*/

function chic_lite_dynamic_css(){

    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = chic_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Nanum Myeongjo' );
    $secondary_fonts = chic_lite_get_fonts( $secondary_font, 'regular' );
    $font_size       = get_theme_mod( 'font_size', 18 );
    $primary_color    = get_theme_mod( 'primary_color', '#e1bdbd' );
    
    $site_title_font      = get_theme_mod( 'site_title_font', array( 'font-family'=>'Nanum Myeongjo', 'variant'=>'regular' ) );
    $site_title_fonts     = chic_lite_get_fonts( $site_title_font['font-family'], $site_title_font['variant'] );
    $site_title_font_size = get_theme_mod( 'site_title_font_size', 30 );
	$site_logo_size 	  = get_theme_mod( 'site_logo_size', 70 );
    
    $rgb = chic_lite_hex2rgb( chic_lite_sanitize_hex_color( $primary_color ) );
    
    echo "<style type='text/css' media='all'>"; ?>
     
    .content-newsletter .blossomthemes-email-newsletter-wrapper.bg-img:after,
    .widget_blossomthemes_email_newsletter_widget .blossomthemes-email-newsletter-wrapper:after{
        <?php echo 'background: rgba(' . $rgb[0] . ', ' . $rgb[1] . ', ' . $rgb[2] . ', 0.8);'; ?>
    }
    
    /*Typography*/

    body,
    button,
    input,
    select,
    optgroup,
    textarea{
        font-family : <?php echo esc_html( $primary_fonts['font'] ); ?>;
        font-size   : <?php echo absint( $font_size ); ?>px;        
    }

    :root {
	    --primary-font: <?php echo esc_html( $primary_fonts['font'] ); ?>;
	    --secondary-font: <?php echo esc_html( $secondary_fonts['font'] ); ?>;
	    --primary-color: <?php echo chic_lite_sanitize_hex_color( $primary_color ); ?>;
	    --primary-color-rgb: <?php printf('%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ); ?>;
	}
    
    .site-branding .site-title-wrap .site-title{
        font-size   : <?php echo absint( $site_title_font_size ); ?>px;
        font-family : <?php echo esc_html( $site_title_fonts['font'] ); ?>;
        font-weight : <?php echo esc_html( $site_title_fonts['weight'] ); ?>;
        font-style  : <?php echo esc_html( $site_title_fonts['style'] ); ?>;
    }
    
    .custom-logo-link img{
	    width: <?php echo absint( $site_logo_size ); ?>px;
	    max-width: 100%;
	}

    .comment-body .reply .comment-reply-link:hover:before {
		background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15"><path d="M934,147.2a11.941,11.941,0,0,1,7.5,3.7,16.063,16.063,0,0,1,3.5,7.3c-2.4-3.4-6.1-5.1-11-5.1v4.1l-7-7,7-7Z" transform="translate(-927 -143.2)" fill="<?php echo chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ); ?>"/></svg>');
	}

	.site-header.style-five .header-mid .search-form .search-submit:hover {
		background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
	}

	.site-header.style-seven .header-bottom .search-form .search-submit:hover {
		background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
	}

	.site-header.style-fourteen .search-form .search-submit:hover {
		background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
	}

	.search-results .content-area > .page-header .search-submit:hover {
		background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="<?php echo chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ); ?>" d="M508.5 468.9L387.1 347.5c-2.3-2.3-5.3-3.5-8.5-3.5h-13.2c31.5-36.5 50.6-84 50.6-136C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c52 0 99.5-19.1 136-50.6v13.2c0 3.2 1.3 6.2 3.5 8.5l121.4 121.4c4.7 4.7 12.3 4.7 17 0l22.6-22.6c4.7-4.7 4.7-12.3 0-17zM208 368c-88.4 0-160-71.6-160-160S119.6 48 208 48s160 71.6 160 160-71.6 160-160 160z"></path></svg>');
	}
    .main-navigation ul li.menu-item-has-children > a::after {
        background-image: url('data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"> <path fill="<?php echo chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ); ?>" d="M207.029 381.476L12.686 187.132c-9.373-9.373-9.373-24.569 0-33.941l22.667-22.667c9.357-9.357 24.522-9.375 33.901-.04L224 284.505l154.745-154.021c9.379-9.335 24.544-9.317 33.901.04l22.667 22.667c9.373 9.373 9.373 24.569 0 33.941L240.971 381.476c-9.373 9.372-24.569 9.372-33.942 0z"></path></svg>');
    }


    <?php echo "</style>";
}
add_action( 'wp_head', 'chic_lite_dynamic_css', 99 );

/**
 * Function for sanitizing Hex color 
 */
function chic_lite_sanitize_hex_color( $color ){
	if ( '' === $color )
		return '';

    // 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;
}

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
*/
function chic_lite_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

/**
 * Convert '#' to '%23'
*/
function chic_lite_hash_to_percent23( $color_code ){
    $color_code = str_replace( "#", "%23", $color_code );
    return $color_code;
}

if ( ! function_exists( 'chic_lite_gutenberg_inline_style' ) ) : 
/**
 * Gutenberg Dynamic Style
 */
function chic_lite_gutenberg_inline_style(){
 
    $child_theme_support = get_theme_mod( 'child_additional_support', 'default' );

    /* Get Link Color */
    $primary_font    = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $primary_fonts   = chic_lite_get_fonts( $primary_font, 'regular' );
    $secondary_font  = get_theme_mod( 'secondary_font', 'Nanum Myeongjo' );
    $secondary_fonts = chic_lite_get_fonts( $secondary_font, 'regular' );
    $primary_color    = get_theme_mod( 'primary_color', '#e1bdbd' );

    $rgb = chic_lite_hex2rgb( chic_lite_sanitize_hex_color( $primary_color ) );
 
    $custom_css = ':root .block-editor-page {
        --primary-color: ' . chic_lite_sanitize_hex_color( $primary_color ) . ';
        --primary-color-rgb: ' . sprintf( '%1$s, %2$s, %3$s', $rgb[0], $rgb[1], $rgb[2] ) . ';
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
    }
    
    blockquote.wp-block-quote::before {
    background-image: url(\'data:image/svg+xml; utf-8, <svg xmlns="http://www.w3.org/2000/svg" width="16.139" height="12.576" viewBox="0 0 16.139 12.576"><path d="M154.714,262.991c-.462.312-.9.614-1.343.9-.3.2-.612.375-.918.56a2.754,2.754,0,0,1-2.851.133,1.764,1.764,0,0,1-.771-.99,6.549,6.549,0,0,1-.335-1.111,5.386,5.386,0,0,1-.219-1.92,16.807,16.807,0,0,1,.3-1.732,2.392,2.392,0,0,1,.424-.8c.394-.534.808-1.053,1.236-1.56a3.022,3.022,0,0,1,.675-.61,2.962,2.962,0,0,0,.725-.749c.453-.576.923-1.137,1.38-1.71a3.035,3.035,0,0,0,.208-.35c.023-.038.044-.09.079-.107.391-.185.777-.383,1.179-.54.284-.11.5.141.739.234a.316.316,0,0,1-.021.2c-.216.411-.442.818-.663,1.226-.5.918-1.036,1.817-1.481,2.761a7.751,7.751,0,0,0-.915,3.069c-.009.326.038.653.053.98.009.2.143.217.288.2a1.678,1.678,0,0,0,1.006-.491c.2-.2.316-.207.537-.027.283.23.552.479.825.723a.174.174,0,0,1,.06.116,1.424,1.424,0,0,1-.327,1C154.281,262.714,154.285,262.755,154.714,262.991Z" transform="translate(-139.097 -252.358)" fill="' . chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ) . '"/><path d="M222.24,262.76a5.243,5.243,0,0,1-2.138,1.427,1.623,1.623,0,0,0-.455.26,3.112,3.112,0,0,1-2.406.338,1.294,1.294,0,0,1-1.021-1.2,6.527,6.527,0,0,1,.449-2.954c.015-.043.04-.083.053-.127a13.25,13.25,0,0,1,1.295-2.632,14.155,14.155,0,0,1,1.224-1.677c.084.14.132.238.2.324.133.176.3.121.414-.06a1.248,1.248,0,0,0,.1-.23c.055-.149.143-.214.315-.111-.029-.308,0-.607.3-.727.114-.045.295.079.463.131.093-.161.227-.372.335-.6.029-.06-.012-.16-.033-.238-.042-.154-.1-.3-.137-.458a1.117,1.117,0,0,1,.27-.933c.154-.207.286-.431.431-.646a.586.586,0,0,1,1.008-.108,2.225,2.225,0,0,0,.336.306.835.835,0,0,0,.356.087,1.242,1.242,0,0,0,.294-.052c-.067.145-.114.257-.17.364-.7,1.34-1.422,2.665-2.082,4.023-.488,1.005-.891,2.052-1.332,3.08a.628.628,0,0,0-.032.11c-.091.415.055.542.478.461.365-.07.607-.378.949-.463a2.8,2.8,0,0,1,.823-.064c.174.01.366.451.317.687a2.48,2.48,0,0,1-.607,1.26C222.081,262.492,222.011,262.615,222.24,262.76Z" transform="translate(-216.183 -252.301)" fill="' . chic_lite_hash_to_percent23( chic_lite_sanitize_hex_color( $primary_color ) ) . '"/></svg>\');
    }';

    return $custom_css;
}
endif;