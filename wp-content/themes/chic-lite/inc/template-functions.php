<?php
/**
 * Chic Lite Template Functions which enhance the theme by hooking into WordPress
 *
 * @package Chic_Lite
 */

if( ! function_exists( 'chic_lite_doctype' ) ) :
/**
 * Doctype Declaration
*/
function chic_lite_doctype(){ ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
    <?php
}
endif;
add_action( 'chic_lite_doctype', 'chic_lite_doctype' );

if( ! function_exists( 'chic_lite_head' ) ) :
/**
 * Before wp_head 
*/
function chic_lite_head(){ ?>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php
}
endif;
add_action( 'chic_lite_before_wp_head', 'chic_lite_head' );

if( ! function_exists( 'chic_lite_page_start' ) ) :
/**
 * Page Start
*/
function chic_lite_page_start(){ ?>
    <div id="page" class="site">
        <a class="skip-link" href="#content"><?php esc_html_e( 'Skip to Content', 'chic-lite' ); ?></a>
    <?php
}
endif;
add_action( 'chic_lite_before_header', 'chic_lite_page_start', 20 );

if( ! function_exists( 'chic_lite_header' ) ) :
/**
 * Header Start
*/
function chic_lite_header(){ 
    ?>
    <header id="masthead" class="site-header style-two" itemscope itemtype="http://schema.org/WPHeader">
        <div class="header-mid">
            <div class="container">
                <?php chic_lite_site_branding(); ?>
            </div>
        </div><!-- .header-mid -->
        <div class="header-bottom">
            <div class="container">         
                <?php chic_lite_secondary_navigation(); ?>
                <?php chic_lite_primary_nagivation(); ?>
                <div class="right">
                    <div class="header-social">
                        <?php chic_lite_social_links(); ?>
                    </div><!-- .header-social -->
                    <?php chic_lite_search_cart(); ?>
                </div><!-- .right -->
            </div>
        </div><!-- .header-bottom -->
    </header>
    <?php
}
endif;
add_action( 'chic_lite_header', 'chic_lite_header', 20 );

if( ! function_exists( 'chic_lite_banner' ) ) :
/**
 * Banner Section 
*/
function chic_lite_banner(){
    if( is_front_page() || is_home() ) {
        $ed_banner      = get_theme_mod( 'ed_banner_section', 'slider_banner' );
        $slider_type    = get_theme_mod( 'slider_type', 'latest_posts' ); 
        $slider_cat     = get_theme_mod( 'slider_cat' );
        $posts_per_page = get_theme_mod( 'no_of_slides', 3 );
        $ed_caption     = get_theme_mod( 'slider_caption', true ); 
        $banner_title   = get_theme_mod( 'banner_title', __( 'Find Your Best Holiday', 'chic-lite' ) );
        $banner_subtitle = get_theme_mod( 'banner_subtitle' , __( 'Find great adventure holidays and activities around the planet.', 'chic-lite' ) ) ;
        $banner_button   = get_theme_mod( 'banner_button', __( 'Read More', 'chic-lite' ) );
        $banner_url      = get_theme_mod( 'banner_url', '#' );        
        
        $image_size = 'chic-lite-slider';
        
        if( $ed_banner == 'static_banner' && has_custom_header() ){ ?>
            <div class="site-banner<?php if( has_header_video() ) echo esc_attr( ' video-banner' ); echo ' static-cta-banner'; ?>">
                <?php 
                the_custom_header_markup();
                if( $banner_title || $banner_subtitle || ( $banner_button && $banner_url ) ){ ?>
                    <div class="banner-caption">
                        <div class="container">
                            <?php 
                            if( $banner_title ) echo '<h2 class="banner-title">' . esc_html( $banner_title ) . '</h2>';
                            if( $banner_subtitle ) echo '<div class="banner-desc">' . wp_kses_post( $banner_subtitle ) . '</div>';
                            if( $banner_button && $banner_url ) {
                                $banner_url_new_tab = ( get_theme_mod( 'banner_url_new_tab', false ) ) ? 'target="_blank"' : '';
                                echo '<a href="'.esc_url( $banner_url ).'" class="btn btn-green"' . $banner_url_new_tab . '><span>'.esc_html( $banner_button ).'</span></a>';
                            }
                            ?>
                        </div>
                    </div> <?php 
                }
                ?>
            </div>
            <?php
        }elseif( $ed_banner == 'slider_banner' ){

            if( $slider_type == 'latest_posts' || $slider_type == 'cat' || ( chic_lite_is_delicious_recipe_activated() && $slider_type == 'latest_recipes' ) ){
            
                $args = array(
                    'post_status'         => 'publish',            
                    'ignore_sticky_posts' => true
                );
                
                if( chic_lite_is_delicious_recipe_activated() && $slider_type == 'latest_recipes' ){
                    $args['post_type']      = DELICIOUS_RECIPE_POST_TYPE;
                    $args['posts_per_page'] = $posts_per_page;          
                }elseif( $slider_type === 'cat' && $slider_cat ){
                    $args['post_type']      = 'post';
                    $args['cat']            = $slider_cat; 
                    $args['posts_per_page'] = -1;  
                }else{
                    $args['post_type']      = 'post';
                    $args['posts_per_page'] = $posts_per_page;
                }
                    
                $qry = new WP_Query( $args );
            
                if( $qry->have_posts() ){ ?>

                    <div id="banner_section" class="site-banner style-eight">
                        <div class="item-wrap owl-carousel">
                            <?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                                <div class="item">
                                    <?php 
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );    
                                    }else{ 
                                        chic_lite_get_fallback_svg( $image_size );//fallback
                                    }
                                    if( $ed_caption ){ ?>
                                        <div class="banner-caption">
                                            <div class="container">
                                                <div class="cat-links">
                                                    <?php if( chic_lite_is_delicious_recipe_activated() && DELICIOUS_RECIPE_POST_TYPE == get_post_type() ) {
                                                        chic_lite_recipe_category(); 
                                                    }else{
                                                        chic_lite_category(); 
                                                    } ?>
                                                </div>
                                                <h2 class="banner-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h2>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } ?>                            
                        </div>
                    </div>
                    <?php
                    wp_reset_postdata(); 
                }
            
            }           
        }
    }   
}
endif;
add_action( 'chic_lite_after_header', 'chic_lite_banner', 15 );

if( ! function_exists( 'chic_lite_featured_area' ) ) :
/**
 * Top Section
 * 
*/
function chic_lite_featured_area(){
    if( ( is_front_page() || is_home() ) && is_active_sidebar( 'featured-area' ) ) { ?>
        <section id="featured_area" class="promo-section">
            <div class="container">
                <?php dynamic_sidebar( 'featured-area' ); ?>
            </div>
        </section> <!-- .featured-section -->
    <?php }      
}
endif;
add_action( 'chic_lite_after_header', 'chic_lite_featured_area', 20 );

if( ! function_exists( 'chic_lite_top_bar' ) ) :
/**
 * Top bar for single page and post
 * 
*/
function chic_lite_top_bar(){
    if( ! ( chic_lite_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() ) ) && !( is_front_page() || is_home() ) && ( is_singular() || is_archive() || is_search() ) ){ ?>
        <div class="top-bar">
    		<div class="container">
            <?php
                //Breadcrumb
                chic_lite_breadcrumb(); 
            ?>
    		</div>
    	</div>   
        <?php 
    }    
}
endif;
add_action( 'chic_lite_after_header', 'chic_lite_top_bar', 30 );

if( ! function_exists( 'chic_lite_content_start' ) ) :
/**
 * Content Start
 *  
*/
function chic_lite_content_start(){    

    echo '<div id="content" class="site-content">'; 

    if ( chic_lite_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() ) ) {

        if ( is_shop() ) {
            $background_image = get_theme_mod( 'shop_bg_image' );
        }elseif( is_product_category() ){
            $cat_id = get_queried_object_id();
            $thumbnail_id = get_term_meta( $cat_id, 'thumbnail_id', true );
            $background_image = wp_get_attachment_url( $thumbnail_id );
        }

        ?>
        <header class="page-header" <?php if( $background_image ){ ?> style="background-image: url( '<?php echo esc_url( $background_image ); ?>' );"<?php } ?> >
            <div class="container">
                <?php 
                the_archive_title(); 
                the_archive_description( '<div class="archive-description">', '</div>' ); 
                chic_lite_breadcrumb(); 
                ?>
            </div>
        </header>
        <?php
    }
    ?>
    <div class="container">
        <?php        
}
endif;
add_action( 'chic_lite_content', 'chic_lite_content_start' );

if( ! function_exists( 'chic_lite_search_per_page_count' ) ):
/**
*   Counts the Number of total posts in Archive, Search and Author
*/
function chic_lite_search_per_page_count(){
    global $wp_query;
    if( is_archive() || is_search() && $wp_query->found_posts > 0 ) {
        $posts_per_page = get_option( 'posts_per_page' );
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $start_post_number = 0;
        $end_post_number   = 0;

        if( $wp_query->found_posts > 0 && !( chic_lite_is_woocommerce_activated() && is_shop() ) ):                
            $start_post_number = 1;
            if( $wp_query->found_posts < $posts_per_page  ) {
                $end_post_number = $wp_query->found_posts;
            }else{
                $end_post_number = $posts_per_page;
            }

            if( $paged > 1 ){
                $start_post_number = $posts_per_page * ( $paged - 1 ) + 1;
                if( $wp_query->found_posts < ( $posts_per_page * $paged )  ) {
                    $end_post_number = $wp_query->found_posts;
                }else{
                    $end_post_number = $paged * $posts_per_page;
                }
            }

            printf( esc_html__( '%1$s Showing:  %2$s - %3$s of %4$s RESULTS %5$s', 'chic-lite' ), '<span class="post-count">', absint( $start_post_number ), absint( $end_post_number ), esc_html( number_format_i18n( $wp_query->found_posts ) ), '</span>' );
        endif;
    }
}
endif;  

if ( ! function_exists( 'chic_lite_entry_first_header' ) ) :
/**
* Entry Header
*/
function chic_lite_entry_first_header(){
    global $wp_query;

    if ( is_home() && $wp_query->current_post == 0 ) {
        chic_lite_entry_header_first();
    }

    if ( ( is_archive() || is_search() ) && $wp_query->current_post == 0 ) {
        chic_lite_entry_header_first();
    }

    if ( is_page() ) {
        ?>
        <header class="page-header">
            <h1 class="page-title"><?php the_title(); ?></h1>
        </header> 
        <?php
    }

}
endif;
add_action( 'chic_lite_before_page_entry_content', 'chic_lite_entry_first_header', 10 );
add_action( 'chic_lite_before_post_entry_content', 'chic_lite_entry_first_header', 10 ); 

if( ! function_exists( 'chic_lite_entry_header' ) ) :
/**
 * Entry Header
*/
function chic_lite_entry_header(){ 
    global $wp_query;
    
    if( $wp_query->current_post == 0 ) return false;
    
    ?>
    <header class="entry-header">
        <?php                                      
            if( 'post' === get_post_type() ){
                chic_lite_category();
            }   

            the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

            echo '<div class="entry-meta">';
                chic_lite_posted_by();
                chic_lite_posted_on(); 
            echo '</div>'; 
        ?>
    </header> 
    <?php  
}
endif;
add_action( 'chic_lite_post_entry_content', 'chic_lite_entry_header', 10 );

if ( ! function_exists( 'chic_lite_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function chic_lite_post_thumbnail() {
	global $wp_query;
    $image_size  = 'thumbnail';
    $sidebar     = chic_lite_sidebar();
    $ed_crop_blog = get_theme_mod( 'ed_crop_blog', false );

    if( is_home() ){        

        if( $wp_query->current_post == 0 ) :                
            $image_size = ( $sidebar ) ? 'chic-lite-blog-one' : 'chic-lite-slider-one';
        else:
            $image_size = ( $sidebar ) ? 'chic-lite-blog' : 'chic-lite-featured-four';
        endif;

        if ( has_post_thumbnail() ) {
            echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';

                if ( ! $ed_crop_blog ) {
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                }else{
                    the_post_thumbnail();
                }
            echo '</a></figure>';
        }else{
            echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
                chic_lite_get_fallback_svg( $image_size );//fallback
            echo '</a></figure>';
        }

    }elseif( is_archive() || is_search() ){      
        
        if( $wp_query->current_post == 0 ) :                
            $image_size = ( $sidebar ) ? 'chic-lite-blog-one' : 'chic-lite-slider-one';
        else:
            $image_size = ( $sidebar ) ? 'chic-lite-blog' : 'chic-lite-featured-four';
        endif;
        
        if ( has_post_thumbnail() ) {  
            echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';          
                if ( ! $ed_crop_blog ) {
                    the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) ); 
                }else{
                    the_post_thumbnail();
                }
            echo '</a></figure>';
        }else{
            echo '<figure class="post-thumbnail"><a href="' . esc_url( get_permalink() ) . '" class="post-thumbnail">';
                chic_lite_get_fallback_svg( $image_size );//fallback
            echo '</a></figure>';
        }
    }elseif( is_page() ){
        echo '<figure class="post-thumbnail">';
            $image_size = ( $sidebar ) ? 'chic-lite-sidebar' : 'chic-lite-slider-one';
            the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) ); 
        echo '</figure>';
    }
}
endif;
add_action( 'chic_lite_before_page_entry_content', 'chic_lite_post_thumbnail', 20 );
add_action( 'chic_lite_before_post_entry_content', 'chic_lite_post_thumbnail', 20 );

if( ! function_exists( 'chic_lite_entry_content' ) ) :
/**
 * Entry Content
*/
function chic_lite_entry_content(){ 
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); 

    echo '<div class="entry-content" itemprop="text">';
        if( is_singular() || ! $ed_excerpt || ( get_post_format() != false ) ){
            the_content();    
            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'chic-lite' ),
                'after'  => '</div>',
            ) );
        }else{
            the_excerpt();
        }
    echo '</div>'; 
}
endif;
add_action( 'chic_lite_page_entry_content', 'chic_lite_entry_content', 15 );
add_action( 'chic_lite_post_entry_content', 'chic_lite_entry_content', 15 );
add_action( 'chic_lite_single_post_entry_content', 'chic_lite_entry_content', 15 );


if( ! function_exists( 'chic_lite_entry_footer' ) ) :
/**
 * Entry Footer
*/
function chic_lite_entry_footer(){
    $ed_excerpt = get_theme_mod( 'ed_excerpt', true ); 
    $readmore   = get_theme_mod( 'read_more_text', __( 'Continue Reading', 'chic-lite' ) );  
 
        echo '<div class="entry-footer">';

            if ( is_single() ) chic_lite_tag();

            if( $ed_excerpt && $readmore && !empty( get_the_content() ) && ! is_single() ){

                echo '<div class="button-wrap"><a href="' . esc_url( get_the_permalink() ) . '" class="btn-readmore">' . esc_html( $readmore ) . '<i class="fas fa-long-arrow-alt-right"></i></a></div>';    
            }

            if( get_edit_post_link() ){
                edit_post_link(
                    sprintf(
                        wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __( 'Edit <span class="screen-reader-text">%s</span>', 'chic-lite' ),
                            array(
                                'span' => array(
                                    'class' => array(),
                                ),
                            )
                        ),
                        get_the_title()
                    ),
                    '<span class="edit-link">',
                    '</span>'
                );
            }            

        echo '</div>';
}
endif;
add_action( 'chic_lite_post_entry_content', 'chic_lite_entry_footer', 20 );
add_action( 'chic_lite_single_post_entry_content', 'chic_lite_entry_footer', 20 );

if( ! function_exists( 'chic_lite_navigation' ) ) :
/**
 * Navigation
*/
function chic_lite_navigation(){

    if( is_single() ){

        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if( $prev_post || $next_post ){?>            
            <nav class="post-navigation pagination" role="navigation">
    			<div class="nav-links">
    				<?php
                       if (!empty( $prev_post )){ ?>
                            <div class="nav-previous">
                                <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" rel="prev">
                                    <span class="meta-nav"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8"><defs><style>.arla{fill:#999596;}</style></defs><path class="arla" d="M16.01,11H8v2h8.01v3L22,12,16.01,8Z" transform="translate(22 16) rotate(180)"/></svg> <?php _e( 'Previous Article', 'chic-lite' ); ?></span>
                                    <span class="post-title"><?php echo esc_html( $prev_post->post_title ); ?></span>
                                </a>
                                <figure class="post-img">
                                    <?php echo get_the_post_thumbnail( $prev_post->ID, 'thumbnail' ); ?>
                                </figure>
                            </div>
                        <?php }

                        if (!empty( $next_post )){ ?>
                            <div class="nav-next">
                                <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" rel="next">
                                    <span class="meta-nav"><?php _e( 'Next Article', 'chic-lite' ); ?><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 8"><defs><style>.arra{fill:#999596;}</style></defs><path class="arra" d="M16.01,11H8v2h8.01v3L22,12,16.01,8Z" transform="translate(-8 -8)"/></svg></span>
                                    <span class="post-title"><?php echo esc_html( $next_post->post_title ); ?></span>
                                </a>
                                <figure class="post-img">
                                    <?php echo get_the_post_thumbnail( $next_post->ID, 'thumbnail' ); ?>
                                </figure>
                            </div>
                        <?php } 
                    ?>
    			</div>
    		</nav> <?php
        }
    }else{
        the_posts_pagination( array(
            'prev_text'          => '<svg xmlns="http://www.w3.org/2000/svg" width="18.479" height="12.689" viewBox="0 0 18.479 12.689"><g transform="translate(17.729 11.628) rotate(180)"><path d="M7820.11-1126.021l5.284,5.284-5.284,5.284" transform="translate(-7808.726 1126.021)" fill="none" stroke="#374757" stroke-linecap="round" stroke-width="1.5"></path><path d="M6558.865-354.415H6542.66" transform="translate(-6542.66 359.699)" fill="none" stroke="#374757" stroke-linecap="round" stroke-width="1.5"></path></g></svg>' . __( 'Previous', 'chic-lite' ),
            'next_text'          => __( 'Next', 'chic-lite' ) . '<svg xmlns="http://www.w3.org/2000/svg" width="18.479" height="12.689" viewBox="0 0 18.479 12.689"><g transform="translate(0.75 1.061)"><path d="M7820.11-1126.021l5.284,5.284-5.284,5.284" transform="translate(-7808.726 1126.021)" fill="none" stroke="#374757" stroke-linecap="round" stroke-width="1.5"></path><path d="M6558.865-354.415H6542.66" transform="translate(-6542.66 359.699)" fill="none" stroke="#374757" stroke-linecap="round" stroke-width="1.5"></path></g></svg>',
            'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'chic-lite' ) . ' </span>',
        ) );     
    }
}
endif;
add_action( 'chic_lite_after_post_content', 'chic_lite_navigation', 20 );
add_action( 'chic_lite_after_posts_content', 'chic_lite_navigation' );

if( ! function_exists( 'chic_lite_author' ) ) :
/**
 * Author Section
*/
function chic_lite_author(){

    $ed_author = get_theme_mod( 'ed_post_author', false );

    if( ( ( is_single() && ! $ed_author ) || is_archive() ) && get_the_author_meta( 'description' ) ){ 
        ?>
        <div class="author-section">
            <figure class="author-img">
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 95 ); ?>
            </figure>
            <div class="author-content-wrap">
                <h3 class="author-name">
                    <?php 
                    if ( is_archive() && is_author() ) echo '<span class="sub-title">' . esc_html__( 'ALL POSTS BY: ', 'chic-lite' ) . '</span>';
                    the_author_meta( 'display_name'); ?>                        
                </h3>
                <div class="author-content">
                    <?php echo wpautop( wp_kses_post( get_the_author_meta( 'description' ) ) ); ?>
                </div>
            </div>
        </div> <!-- .author-section -->
        <?php
    }
}
endif;
add_action( 'chic_lite_after_post_content', 'chic_lite_author', 15 );

if( ! function_exists( 'chic_lite_newsletter' ) ) :
/**
 * Newsletter
*/
function chic_lite_newsletter(){ 
    $ed_newsletter = get_theme_mod( 'ed_newsletter', false );
    $newsletter    = get_theme_mod( 'newsletter_shortcode' );
    if( chic_lite_is_btnw_activated() && $ed_newsletter && $newsletter ){ ?>
        <div class="newsletter-block">
            <?php echo do_shortcode( $newsletter ); ?>
        </div>
        <?php
    }
}
endif;
add_action( 'chic_lite_after_post_content', 'chic_lite_newsletter', 30 );

if( ! function_exists( 'chic_lite_related_posts' ) ) :
/**
 * Related Posts 
*/
function chic_lite_related_posts(){ 
    $ed_related_post = get_theme_mod( 'ed_related', true );
    
    if( $ed_related_post ){
        chic_lite_get_posts_list( 'related' );    
    }
}
endif;                                                                               
add_action( 'chic_lite_after_post_content', 'chic_lite_related_posts', 35 );


if( ! function_exists( 'chic_lite_latest_posts' ) ) :
/**
 * Latest Posts
*/
function chic_lite_latest_posts(){ 
    chic_lite_get_posts_list( 'latest' );
}
endif;
add_action( 'chic_lite_latest_posts', 'chic_lite_latest_posts' );

if( ! function_exists( 'chic_lite_comment' ) ) :
/**
 * Comments Template 
*/
function chic_lite_comment(){
    // If comments are open or we have at least one comment, load up the comment template.
	if( get_theme_mod( 'ed_comments', true ) && ( comments_open() || get_comments_number() ) ) :
		comments_template();
	endif;
}
endif;
add_action( 'chic_lite_after_post_content', 'chic_lite_comment', chic_lite_comment_toggle() );

add_action( 'chic_lite_after_page_content', 'chic_lite_comment' );

if( ! function_exists( 'chic_lite_content_end' ) ) :
/**
 * Content End
*/
function chic_lite_content_end(){ ?>            
        </div><!-- .container/ -->        
    </div><!-- .error-holder/site-content -->
    <?php
}
endif;
add_action( 'chic_lite_before_footer', 'chic_lite_content_end', 20 );

if( ! function_exists( 'chic_lite_instagram_section' ) ) :
/**
 * Bottom Shop Section
*/
function chic_lite_instagram_section(){ 
    if( chic_lite_is_btif_activated() ){
        $ed_instagram = get_theme_mod( 'ed_instagram', false );
        $image        = get_theme_mod( 'instagram_bg_image' );
        
        if( $ed_instagram ){ ?>
            <div class="instagram-section" <?php if( $image ){ ?>style="background-image: url( '<?php echo esc_url( $image ); ?>' );" <?php } ?> >
               <?php echo do_shortcode( '[blossomthemes_instagram_feed]' );  ?> 
            </div><?php 
        }
    }
}
endif;
add_action( 'chic_lite_footer', 'chic_lite_instagram_section', 15 );

if( ! function_exists( 'chic_lite_footer_start' ) ) :
/**
 * Footer Start
*/
function chic_lite_footer_start(){
    ?>
    <footer id="colophon" class="site-footer" itemscope itemtype="http://schema.org/WPFooter">
    <?php
}
endif;
add_action( 'chic_lite_footer', 'chic_lite_footer_start', 25 );

if( ! function_exists( 'chic_lite_footer_top' ) ) :
/**
 * Footer Top
*/
function chic_lite_footer_top(){    
    $footer_sidebars = array( 'footer-one', 'footer-two', 'footer-three', 'footer-four' );
    $active_sidebars = array();
    $sidebar_count   = 0;
    
    foreach ( $footer_sidebars as $sidebar ) {
        if( is_active_sidebar( $sidebar ) ){
            array_push( $active_sidebars, $sidebar );
            $sidebar_count++ ;
        }
    }
                 
    if( $active_sidebars ){ ?>
        <div class="footer-t">
    		<div class="container">
    			<div class="grid column-<?php echo esc_attr( $sidebar_count ); ?>">
                <?php foreach( $active_sidebars as $active ){ ?>
    				<div class="col">
    				   <?php dynamic_sidebar( $active ); ?>	
    				</div>
                <?php } ?>
                </div>
    		</div>
    	</div>
        <?php 
    }   
}
endif;
add_action( 'chic_lite_footer', 'chic_lite_footer_top', 30 );

if( ! function_exists( 'chic_lite_footer_bottom' ) ) :
/**
 * Footer Bottom
*/
function chic_lite_footer_bottom(){ ?>
    <div class="footer-b">
        <div class="container">
            <div class="copyright">
                <?php 
                chic_lite_get_footer_copyright();
                echo esc_html__( ' Chic Lite | Developed By ', 'chic-lite' ); 
                echo '<a href="' . esc_url( 'https://rarathemes.com/' ) .'" rel="nofollow" target="_blank">' . esc_html__( 'Rara Themes', 'chic-lite' ) . '</a>.';                
                printf( esc_html__( ' Powered by %s. ', 'chic-lite' ), '<a href="'. esc_url( __( 'https://wordpress.org/', 'chic-lite' ) ) .'" target="_blank">WordPress</a>' );

                if( function_exists( 'the_privacy_policy_link' ) ){
                    the_privacy_policy_link();
                } ?>
                
            </div>
            <div class="footer-menu">
                <?php chic_lite_footer_navigation(); ?>
            </div>
            
        </div>
    </div> <!-- .footer-b -->
    <?php
}
endif;
add_action( 'chic_lite_footer', 'chic_lite_footer_bottom', 40 );

if( ! function_exists( 'chic_lite_footer_end' ) ) :
/**
 * Footer End 
*/
function chic_lite_footer_end(){ ?>
    </footer><!-- #colophon -->
    <?php
}
endif;
add_action( 'chic_lite_footer', 'chic_lite_footer_end', 50 );

if( ! function_exists( 'chic_lite_back_to_top' ) ) :
/**
 * Back to top
*/
function chic_lite_back_to_top(){ ?>
    <button class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <?php
}
endif;
add_action( 'chic_lite_after_footer', 'chic_lite_back_to_top', 15 );

if( ! function_exists( 'chic_lite_page_end' ) ) :
/**
 * Page End
*/
function chic_lite_page_end(){ ?>
    </div><!-- #page -->
    <?php
}
endif;
add_action( 'chic_lite_after_footer', 'chic_lite_page_end', 20 );