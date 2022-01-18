<?php
/**
 * Chic Lite Standalone Functions.
 *
 * @package Chic_Lite
 */

if ( ! function_exists( 'chic_lite_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time.
 */
function chic_lite_posted_on() {

    $ed_post_date  = get_theme_mod( 'ed_post_date', false );
	$ed_updated_post_date = get_theme_mod( 'ed_post_update_date', true );
    $on = '';
    
    if ( !$ed_post_date ) {

        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
    		if( $ed_updated_post_date ){
                $time_string = '<time class="entry-date published updated" datetime="%3$s" itemprop="dateModified">%4$s</time><time class="updated" datetime="%1$s" itemprop="datePublished">%2$s</time>';
                $on = __( 'Updated on ', 'chic-lite' );		  
    		}else{
                $time_string = '<time class="entry-date published" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';  
    		}        
    	}else{
    	   $time_string = '<time class="entry-date published updated" datetime="%1$s" itemprop="datePublished">%2$s</time><time class="updated" datetime="%3$s" itemprop="dateModified">%4$s</time>';   
    	}

    	$time_string = sprintf( $time_string,
    		esc_attr( get_the_date( 'c' ) ),
    		esc_html( get_the_date() ),
    		esc_attr( get_the_modified_date( 'c' ) ),
    		esc_html( get_the_modified_date() )
    	);
        
        $posted_on = sprintf( '%1$s %2$s', esc_html( $on ), '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>' );
    	
    	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
    }
}
endif;

if ( ! function_exists( 'chic_lite_posted_by' ) ) :
/**
 * Prints HTML with meta information for the current author.
 */
function chic_lite_posted_by( $add_place = true ) {

    $ed_post_author = get_theme_mod( 'ed_post_author', false );    

    if ( ! $ed_post_author ) {

        if( !$add_place ) {
            global $post;
            $author_id = $post->post_author;
            $author = get_the_author_meta( 'display_name', $author_id );
            $byline = sprintf(
                /* translators: %s: post author. */
                esc_html_x( 'by %s', 'post author', 'chic-lite' ),
                '<span itemprop="name"><a class="url fn n" href="' . esc_url( get_author_posts_url( $author_id ) ) . '" itemprop="url">' . esc_html( $author ) . '</a></span>' 
            );
        }else{
            $byline = sprintf(
                /* translators: %s: post author. */
                esc_html_x( 'by %s', 'post author', 'chic-lite' ),
                '<span itemprop="name"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" itemprop="url">' . esc_html( get_the_author() ) . '</a></span>' 
            );
        }
    	echo '<span class="byline" itemprop="author" itemscope itemtype="https://schema.org/Person">' . $byline . '</span>';
    }
}
endif;

if( ! function_exists( 'chic_lite_comment_count' ) ) :
/**
 * Comment Count
*/
function chic_lite_comment_count( $echo = true ){
    $comment    = get_theme_mod( 'ed_comments', true );
    if ( $comment && $echo && !post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments">';
		comments_popup_link(
			sprintf(
				wp_kses(
					/* translators: %s: post title */
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'chic-lite' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			)
		);
		echo '</span>';
	}elseif ( $comment && !$echo && !post_password_required() && ( comments_open() || get_comments_number() ) ) {
        return true;
    }else{
        return false;
    }
       
}
endif;

if ( ! function_exists( 'chic_lite_category' ) ) :
/**
 * Prints categories
 */
function chic_lite_category(){

    $ed_cat_single = get_theme_mod( 'ed_category', false );
    $categories_list = get_the_category_list( ' ' );
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() && ! $ed_cat_single && $categories_list ) {
		echo '<span class="category">' . $categories_list . '</span>';	
	}
}
endif;

if ( ! function_exists( 'chic_lite_tag' ) ) :
/**
 * Prints tags
 */
function chic_lite_tag(){
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		$tags_list = get_the_tag_list();
		if ( $tags_list ) {
            echo '<span class="cat-tags">' . $tags_list . '</span>';
		}
	}
}
endif;

if( ! function_exists( 'chic_lite_get_posts_list' ) ) :
/**
 * Returns Latest, Related & Popular Posts
*/
function chic_lite_get_posts_list( $status ){
    global $post;
    
    $args = array(
        'post_type'           => 'post',
        'ignore_sticky_posts' => true
    );
    
    switch( $status ){
        case 'latest':        
        $args['posts_per_page'] = 4;
        $title                  = __( 'Latest Posts', 'chic-lite' );
        $class                  = 'additional-post';
        $image_size             = 'chic-lite-blog';
        break;
        
        case 'related':
        $args['posts_per_page'] = 4;
        $args['post_type']      = ( chic_lite_is_delicious_recipe_activated() && DELICIOUS_RECIPE_POST_TYPE === get_post_type() ) ? DELICIOUS_RECIPE_POST_TYPE : 'post';
        $args['post__not_in']   = array( $post->ID );
        $args['orderby']        = 'rand';
        $title                  = get_theme_mod( 'related_post_title', __( 'You may also like...', 'chic-lite' ) );
        $class                  = 'additional-post';
        $image_size             = 'chic-lite-blog';
        if( chic_lite_is_delicious_recipe_activated() && DELICIOUS_RECIPE_POST_TYPE === get_post_type() ) {
            $cats = get_the_terms( $post->ID, 'recipe-course' );
            if( !$cats ) return false;       
            $c = array();
            foreach( $cats as $cat ){
                $c[] = $cat->term_id; 
            }
            $args['tax_query']    = array( array( 'taxonomy' => 'recipe-course', 'terms' => $c ) );
        }else{
            $cats                   = get_the_category( $post->ID );        
            if( $cats ){
                $c = array();
                foreach( $cats as $cat ){
                    $c[] = $cat->term_id; 
                }
                $args['category__in'] = $c;
            }        
        }
        break;   
    }
    
    $qry = new WP_Query( $args );
    
    if( $qry->have_posts() ){ ?>    
        <div class="<?php echo esc_attr( $class ); ?>">
    		<?php 
            if( $title ) echo '<h3 class="post-title">' . esc_html( $title ) . '</h3>'; ?>
            <div class="article-wrap">
    			<?php while( $qry->have_posts() ){ $qry->the_post(); ?>
                    <article class="post">
                        <header class="entry-header">
                            <?php 
                            $ed_date   = get_theme_mod( 'ed_post_date', false );
                            
                            if( ! $ed_date ) echo '<div class="entry-meta">'; 
                                   chic_lite_posted_on();
                            if( ! $ed_date ) echo '</div>';

                            the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
                        </header>
                        
                        <figure class="post-thumbnail">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                    if( has_post_thumbnail() ){
                                        the_post_thumbnail( $image_size, array( 'itemprop' => 'image' ) );
                                    }else{ 
                                        chic_lite_get_fallback_svg( $image_size );//fallback
                                    }
                                ?>
                            </a>
                        </figure>
                    </article>
    			<?php } ?>   
            </div> 		
    	</div>
        <?php
        wp_reset_postdata();
    }
}
endif;

if( ! function_exists( 'chic_lite_site_branding' ) ) :
/**
 * Site Branding
*/
function chic_lite_site_branding(){ 

    $site_title       = get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    $header_text      = get_theme_mod( 'header_text', 1 );

    if( has_custom_logo() || $site_title || $site_description || $header_text ) :
        if( has_custom_logo() && ( $site_title || $site_description ) && $header_text ) {
            $branding_class = ' has-logo-text';
        }else{
            $branding_class = '';
        }?>
        <div class="site-branding<?php echo esc_attr( $branding_class ); ?>" itemscope itemtype="http://schema.org/Organization">  
            <div class="site-logo">
                <?php 
                if( function_exists( 'has_custom_logo' ) && has_custom_logo() ){
                    the_custom_logo();
                }  ?>
            </div>

            <?php 
            if( $site_title || $site_description ) :
                echo '<div class="site-title-wrap">';
                if( is_front_page() ){ ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php 
                }else{ ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" itemprop="url"><?php bloginfo( 'name' ); ?></a></p>
                <?php }
                
                $description = get_bloginfo( 'description', 'display' );
                if ( $description || is_customize_preview() ){ ?>
                    <p class="site-description" itemprop="description"><?php echo $description; ?></p>
                <?php }
                echo '</div>';
            endif; ?>
        </div>    
    <?php endif;  
}
endif;

if( ! function_exists( 'chic_lite_social_links' ) ) :
/**
 * Social Links 
*/
function chic_lite_social_links( $echo = true ){ 
    $social_links = get_theme_mod( 'social_links' );
    $ed_social    = get_theme_mod( 'ed_social_links', false ); 
    
    if( $ed_social && $social_links && $echo ){ ?>
    <ul class="social-networks">
    	<?php 
        foreach( $social_links as $link ){
    	   if( $link['link'] ){ ?>
            <li>
                <a href="<?php echo esc_url( $link['link'] ); ?>" target="_blank" rel="nofollow noopener">
                    <i class="<?php echo esc_attr( $link['font'] ); ?>"></i>
                </a>
            </li>    	   
            <?php
            } 
        } ?>
	</ul>
    <?php    
    }elseif( $ed_social && $social_links ){
        return true;
    }else{
        return false;
    }                                
}
endif;

if( ! function_exists( 'chic_lite_search_cart' ) ) :
/**
 * Form Icon
*/
function chic_lite_search_cart(){ 

    $ed_search     = get_theme_mod( 'ed_header_search', true );
    $ed_cart       = get_theme_mod( 'ed_shopping_cart', true ); 

    if ( $ed_search ) { ?>
        <div class="header-search">
            <button class="search-toggle" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
                <i class="fas fa-search"></i>
            </button>
            <div id="formModal" class="modal modal-content search-modal cover-modal" data-modal-target-string=".search-modal">
                <?php get_search_form(); ?>
                <button type="button" class="close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" aria-expanded="false" data-set-focus=".search-modal"></button>
            </div>
        </div><!-- .header-search -->
    <?php } 
    if ( chic_lite_is_woocommerce_activated() && $ed_cart ) chic_lite_wc_cart_count(); 
}
endif;

if( ! function_exists( 'chic_lite_primary_nagivation' ) ) :
/**
 * Primary Navigation.
*/
function chic_lite_primary_nagivation(){ 

    ?>
	<nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <?php 
        if( has_nav_menu( 'primary' ) ){ ?>
            <button class="toggle-btn" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>
            <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
                <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal"></button>
                <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'chic-lite' ); ?>">
        <?php } 
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'menu_class'     => 'nav-menu main-menu-modal',                
                        'fallback_cb'    => 'chic_lite_primary_menu_fallback',
                    ) );

        if( has_nav_menu( 'primary' ) ){ ?>
                </div>
            </div>
        <?php } ?>
	</nav><!-- #site-navigation -->
    <?php
}
endif;

if( ! function_exists( 'chic_lite_primary_menu_fallback' ) ) :
/**
 * Fallback for primary menu
*/
function chic_lite_primary_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'chic-lite' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'chic_lite_secondary_navigation' ) ) :
/**
 * Secondary Navigation
*/
function chic_lite_secondary_navigation(){ 
    if( has_nav_menu( 'secondary' ) ){ ?>
    	<nav class="secondary-menu">
            <button class="toggle-btn" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".close-nav-toggle">
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
                <span class="toggle-bar"></span>
            </button>
            <div class="secondary-menu-list menu-modal cover-modal" data-modal-target-string=".menu-modal">
                <button class="close close-nav-toggle" data-toggle-target=".menu-modal" data-toggle-body-class="showing-menu-modal" aria-expanded="false" data-set-focus=".menu-modal"></button>
                <div class="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile', 'chic-lite' ); ?>">
                    <?php 
                    wp_nav_menu( array(
                        'theme_location' => 'secondary',
                        'menu_id'        => 'secondary-menu',
                        'menu_class'     => 'nav-menu menu-modal',
                    ) ); 
                    ?>
                </div>
            </div>
    	</nav>
    <?php }
}
endif;

if( ! function_exists( 'chic_lite_footer_navigation' ) ) :
/**
 * Footer Navigation
*/
function chic_lite_footer_navigation(){
    wp_nav_menu( array(
        'theme_location' => 'footer',
        'menu_id'        => 'footer-menu',
        'menu_class'     => 'nav-menu',
        'fallback_cb'    => 'chic_lite_footer_menu_fallback',
    ) ); 
}
endif;

if( ! function_exists( 'chic_lite_footer_menu_fallback' ) ) :
/**
 * Fallback for footer menu
*/
function chic_lite_footer_menu_fallback(){
    if( current_user_can( 'manage_options' ) ){
        echo '<ul id="footer-menu" class="menu">';
        echo '<li><a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '">' . esc_html__( 'Click here to add a menu', 'chic-lite' ) . '</a></li>';
        echo '</ul>';
    }
}
endif;

if( ! function_exists( 'chic_lite_breadcrumb' ) ) :
/**
 * Breadcrumbs
*/
function chic_lite_breadcrumb() {
    global $post;
    $post_page  = get_option('page_for_posts'); //The ID of the page that displays posts.
    $show_front = get_option('show_on_front'); //What to show on the front page
    $home       = get_theme_mod('home_text', __('Home', 'chic-lite')); // text for the 'Home' link
    $delimiter  = '<i class="fa fa-angle-right"></i>';
    $before     = '<span class="current" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'; // tag before the current crumb
    $after      = '</span>'; // tag after the current crumb

    if( get_theme_mod( 'ed_breadcrumb', true ) ){
            
        $depth = 1;
        echo '<div class="breadcrumb-wrapper">
                <div id="crumbs" itemscope itemtype="http://schema.org/BreadcrumbList"> 
                    <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                        <a itemprop="item" href="' . esc_url( home_url() ) . '"><span itemprop="name">' . esc_html( $home ) . '</span></a>
                        <meta itemprop="position" content="'. absint( $depth ).'" />
                        <span class="separator">' .  $delimiter  . '</span>
                    </span>';
        if( is_home() ){
            $depth = 2;
            echo $before . '<a itemprop="item" href="'. esc_url( get_the_permalink() ) .'"><span itemprop="name">' . esc_html( single_post_title( '', false ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" /> '. $after;
            
        }elseif( is_category() ){
            
            $depth = 2;
            $thisCat = get_category( get_query_var( 'cat' ), false );

            if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                $p = get_post( $post_page );
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_permalink( $post_page ) ) . '"><span itemprop="name">' . esc_html( $p->post_title ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                $depth ++;  
            }

            if ( $thisCat->parent != 0 ) {
                $parent_categories = get_category_parents( $thisCat->parent, false, ',' );
                $parent_categories = explode( ',', $parent_categories );

                foreach ( $parent_categories as $parent_term ) {
                    $parent_obj = get_term_by( 'name', $parent_term, 'category' );
                    if( is_object( $parent_obj ) ){
                        $term_url    = get_term_link( $parent_obj->term_id );
                        $term_name   = $parent_obj->name;
                        echo ' <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span> ';
                        $depth ++;
                    }
                }
            }
            echo $before . ' <a itemprop="item" href="' . esc_url( get_term_link( $thisCat->term_id) ) . '"><span itemprop="name">' .  esc_html( single_cat_title( '', false ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /> ' . $after;
        
        }elseif( chic_lite_is_woocommerce_activated() && ( is_product_category() || is_product_tag() ) ){ //For Woocommerce archive page
        
            $depth = 2;
            $current_term = $GLOBALS['wp_query']->get_queried_object();
            
            if ( wc_get_page_id( 'shop' ) ) { //Displaying Shop link in woocommerce archive page
                $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                $shop_url = wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
                if ( ! $_name ) {
                    $product_post_type = get_post_type_object( 'product' );
                    $_name = $product_post_type->labels->singular_name;
                }
                echo ' <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $shop_url ) . '"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /> <span class="separator">' . $delimiter . '</span></span> ';
                $depth++;
            }

            if( is_product_category() ){
                $ancestors = get_ancestors( $current_term->term_id, 'product_cat' );
                $ancestors = array_reverse( $ancestors );
                foreach ( $ancestors as $ancestor ) {
                    $ancestor = get_term( $ancestor, 'product_cat' );    
                    if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                        echo ' <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $ancestor ) ) . '"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /> <span class="separator">' . $delimiter . '</span></span> ';
                        $depth++;
                    }
                }
            }           
            echo $before .'<a itemprop="item" href="' . esc_url( get_term_link( $current_term->term_id ) ) . '"><span itemprop="name">'. esc_html( $current_term->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            
        }elseif( chic_lite_is_woocommerce_activated() && is_shop() ){ //Shop Archive page

            $depth = 2;
            if ( get_option( 'page_on_front' ) == wc_get_page_id( 'shop' ) ) {
                return;
            }
            $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
            $shop_url = wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );

            if ( ! $_name ) {
                $product_post_type = get_post_type_object( 'product' );
                $_name = $product_post_type->labels->singular_name;
            }
            echo $before .'<a itemprop="item" href="' . esc_url( $shop_url ) . '"><span itemprop="name">'. esc_html( $_name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after; 

        }elseif( is_tax( 'blossom_portfolio_categories' ) ){
            $depth = 2;
            $queried_object = get_queried_object();
            $taxonomy = 'blossom_portfolio_categories';
            $ancestors = get_ancestors( $queried_object->term_id, $taxonomy );
            if( !empty( $ancestors ) ){
            $termz = get_term( $ancestors[0], $taxonomy );
            $ancestors_title = !empty( $termz->name ) ? esc_html( $termz->name ) : ''; 
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $termz->term_id ) ) . '"><span itemprop="name">' . $ancestors_title . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';
                $depth++;
            }
            
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( $queried_object->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_tax( 'recipe-cuisine' ) ){
            $depth = 2;
            $queried_object = get_queried_object();
            $taxonomy = 'recipe-cuisine';
            $ancestors = get_ancestors( $queried_object->term_id, $taxonomy );
            if( !empty( $ancestors ) ){
            $termz = get_term( $ancestors[0], $taxonomy );
            $ancestors_title = !empty( $termz->name ) ? esc_html( $termz->name ) : ''; 
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $termz->term_id ) ) . '"><span itemprop="name">' . $ancestors_title . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';

                $depth++;
            }
            
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( $queried_object->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_tax( 'recipe-course' ) ){
            $depth = 2;
            $queried_object = get_queried_object();
            $taxonomy = 'recipe-course';
            $ancestors = get_ancestors( $queried_object->term_id, $taxonomy );
            if( !empty( $ancestors ) ){
            $termz = get_term( $ancestors[0], $taxonomy );
            $ancestors_title = !empty( $termz->name ) ? esc_html( $termz->name ) : ''; 
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $termz->term_id ) ) . '"><span itemprop="name">' . $ancestors_title . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';

                $depth++;
            }
            
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( $queried_object->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_tax( 'recipe-cooking-method' ) ){
            $depth = 2;
            $queried_object = get_queried_object();
            $taxonomy = 'recipe-cooking-method';
            $ancestors = get_ancestors( $queried_object->term_id, $taxonomy );
            if( !empty( $ancestors ) ){
            $termz = get_term( $ancestors[0], $taxonomy );
            $ancestors_title = !empty( $termz->name ) ? esc_html( $termz->name ) : ''; 
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $termz->term_id ) ) . '"><span itemprop="name">' . $ancestors_title . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';

                $depth++;
            }
            
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( $queried_object->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_tax( 'recipe-tag' ) ){
            $depth = 2;
            $queried_object = get_queried_object();
            $taxonomy = 'recipe-tag';
            $ancestors = get_ancestors( $queried_object->term_id, $taxonomy );
            if( !empty( $ancestors ) ){
            $termz = get_term( $ancestors[0], $taxonomy );
            $ancestors_title = !empty( $termz->name ) ? esc_html( $termz->name ) : ''; 
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $termz->term_id ) ) . '"><span itemprop="name">' . $ancestors_title . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';

                $depth++;
            }
            
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( $queried_object->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_tax( 'recipe-key' ) ){
            $depth = 2;
            $queried_object = get_queried_object();
            $taxonomy = 'recipe-key';
            $ancestors = get_ancestors( $queried_object->term_id, $taxonomy );
            if( !empty( $ancestors ) ){
            $termz = get_term( $ancestors[0], $taxonomy );
            $ancestors_title = !empty( $termz->name ) ? esc_html( $termz->name ) : ''; 
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_term_link( $termz->term_id ) ) . '"><span itemprop="name">' . $ancestors_title . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';

                $depth++;
            }
            
            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( $queried_object->name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        }elseif( is_tag() ){
            
            $queried_object = get_queried_object();
            $depth = 2;

            echo $before . '<a itemprop="item" href="' . esc_url( get_term_link( $queried_object->term_id ) ) . '"><span itemprop="name">' . esc_html( single_tag_title( '', false ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
     
        }elseif( is_author() ){
            
            $depth = 2;
            global $author;

            $userdata = get_userdata( $author );
            echo $before . '<a itemprop="item" href="' . esc_url( get_author_posts_url( $author ) ) . '"><span itemprop="name">' . esc_html( $userdata->display_name ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
     
        }elseif( is_search() ){
            
            $depth = 2;
            $request_uri = $_SERVER['REQUEST_URI'];
            echo $before .'<a itemprop="item" href="'. esc_url( $request_uri ) .'"><span itemprop="name">'. esc_html__( 'Search Results for "', 'chic-lite' ) . esc_html( get_search_query() ) . esc_html__( '"', 'chic-lite' ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        
        }elseif( is_day() ){
            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'chic-lite' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'chic-lite' ) ) ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'"/><span class="separator">' . $delimiter . '</span></span> ';
            $depth ++;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'chic-lite' ) ), get_the_time( __( 'm', 'chic-lite' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'F', 'chic-lite' ) ) ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span> ';
            $depth ++;
            echo $before .'<a itemprop="item" href="' . esc_url( get_day_link( get_the_time( __( 'Y', 'chic-lite' ) ), get_the_time( __( 'm', 'chic-lite' ) ), get_the_time( __( 'd', 'chic-lite' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'd', 'chic-lite' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        
        }elseif( is_month() ){
            
            $depth = 2;
            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'chic-lite' ) ) ) ) . '"><span itemprop="name">' . esc_html( get_the_time( __( 'Y', 'chic-lite' ) ) ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span> ';
            $depth++;
            echo $before .'<a itemprop="item" href="' . esc_url( get_month_link( get_the_time( __( 'Y', 'chic-lite' ) ), get_the_time( __( 'm', 'chic-lite' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'F', 'chic-lite' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        
        }elseif( is_year() ){
            
            $depth = 2;
            echo $before .'<a itemprop="item" href="' . esc_url( get_year_link( get_the_time( __( 'Y', 'chic-lite' ) ) ) ) . '"><span itemprop="name">'. esc_html( get_the_time( __( 'Y', 'chic-lite' ) ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;

        }elseif( is_single() && !is_attachment() ){
            
            if( chic_lite_is_woocommerce_activated() && 'product' === get_post_type() ){ //For Woocommerce single product
                
                $depth = 2;
                if ( wc_get_page_id( 'shop' ) ) { //Displaying Shop link in woocommerce archive page
                    $_name = wc_get_page_id( 'shop' ) ? get_the_title( wc_get_page_id( 'shop' ) ) : '';
                    $shop_url = wc_get_page_id( 'shop' ) && wc_get_page_id( 'shop' ) > 0  ? get_the_permalink( wc_get_page_id( 'shop' ) ) : home_url( '/shop' );
                    if ( ! $_name ) {
                        $product_post_type = get_post_type_object( 'product' );
                        $_name = $product_post_type->labels->singular_name;
                    }
                    echo ' <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $shop_url ) . '"><span itemprop="name">' . esc_html( $_name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /> <span class="separator">' . $delimiter . '</span></span> ';
                    $depth++;
                }
            
                if ( $terms = wc_get_product_terms( $post->ID, 'product_cat', array( 'orderby' => 'parent', 'order' => 'DESC' ) ) ) {
                    $main_term = apply_filters( 'woocommerce_breadcrumb_main_term', $terms[0], $terms );
                    $ancestors = get_ancestors( $main_term->term_id, 'product_cat' );
                    $ancestors = array_reverse( $ancestors );
                    foreach ( $ancestors as $ancestor ) {
                        $ancestor = get_term( $ancestor, 'product_cat' );    
                        if ( ! is_wp_error( $ancestor ) && $ancestor ) {
                            echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $ancestor ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $ancestor->name ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                            $depth++;
                        }
                    }
                    echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_term_link( $main_term ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $main_term->name ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span> ';
                    $depth ++;
                }
                
                echo $before .'<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                
            }elseif( get_post_type() != 'post' ){
                $depth = 2;
                $post_type = get_post_type_object( get_post_type() );

                if( $post_type->has_archive == true ){// For CPT Archive Link
                   
                   // Add support for a non-standard label of 'archive_title' (special use case).
                   $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
                   
                   echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.esc_url( get_post_type_archive_link( get_post_type() ) ) .'" itemprop="item"><span itemprop="name">'.esc_html($label).'</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';

                   $depth ++;    
                }

                if( get_post_type() =='rara-portfolio' ){
                    // Add support for a non-standard label of 'archive_title' (special use case).
                   $label = !empty( $post_type->labels->archive_title ) ? $post_type->labels->archive_title : $post_type->labels->name;
                   $portfolio_link = chic_lite_get_page_template_url( 'templates/portfolio.php' );
                   echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="'.esc_url( $portfolio_link) .'" itemprop="item"><span itemprop="name">'.esc_html($label).'</span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span>';
                   $depth ++;    
                }

                echo $before .'<a href="' . esc_url( get_the_permalink() ) . '" itemprop="item"><span itemprop="name">'. esc_html( strip_tags( get_the_title() ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
                
            }else{ //For Post
                
                $cat_object       = get_the_category();
                $potential_parent = 0;
                $depth            = 2;
                
                if( $show_front === 'page' && $post_page ){ //If static blog post page is set
                    $p = get_post( $post_page );
                    echo ' <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $post_page ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $p->post_title ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span> ';  
                    $depth++;
                }
                
                if( is_array( $cat_object ) ){ //Getting category hierarchy if any
        
                    //Now try to find the deepest term of those that we know of
                    $use_term = key( $cat_object );
                    foreach( $cat_object as $key => $object )
                    {
                        //Can't use the next($cat_object) trick since order is unknown
                        if( $object->parent > 0  && ( $potential_parent === 0 || $object->parent === $potential_parent ) ){
                            $use_term = $key;
                            $potential_parent = $object->term_id;
                        }
                    }
                    
                    $cat = $cat_object[$use_term];
              
                    $cats = get_category_parents( $cat, false, ',' );
                    $cats = explode( ',', $cats );

                    foreach ( $cats as $cat ) {
                        $cat_obj = get_term_by( 'name', $cat, 'category' );
                        if( is_object( $cat_obj ) ){
                            $term_url    = get_term_link( $cat_obj->term_id );
                            $term_name   = $cat_obj->name;
                            echo ' <span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a itemprop="item" href="' . esc_url( $term_url ) . '"><span itemprop="name">' . esc_html( $term_name ) . ' </span></a><meta itemprop="position" content="'. absint( $depth ).'" /><span class="separator">' . $delimiter . '</span></span> ';
                            $depth ++;
                        }
                    }
                }

                 echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;     
                
            }
        
        }elseif( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ){
            
            $depth = 2;
            $post_type = get_post_type_object(get_post_type());
            if( get_query_var('paged') ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $post_type->label ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" />';
                echo ' <span class="separator">' . $delimiter . '</span></span> ' . $before . sprintf( __('Page %s', 'chic-lite'), get_query_var('paged') ) . $after;
            }elseif( is_archive() ){
                echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( post_type_archive_title( '', false ) ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            }else{
                echo $before .'<a itemprop="item" href="' . esc_url( get_post_type_archive_link( $post_type->name ) ) . '"><span itemprop="name">'. esc_html( $post_type->label ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
            }

        }elseif( is_attachment() ){
            
            $depth = 2;
            $parent = get_post( $post->post_parent );
            $cat = get_the_category( $parent->ID ); 
            if( $cat ){
                $cat = $cat[0];
                echo get_category_parents( $cat, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $parent ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $parent->post_title ) . '<span></a><meta itemprop="position" content="'. absint( $depth ).'" />' . ' <span class="separator">' . $delimiter . '</span></span>';
            }
            echo  $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;
        
        }elseif( is_page() && !$post->post_parent ){
            
           $depth = 2;
            echo $before .'<a itemprop="item" href="' . esc_url( get_the_permalink() ) . '"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" />'. $after;

        }elseif( is_page() && $post->post_parent ){
            
            global $post;
            $depth = 2;
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            
            while( $parent_id ){
                $current_page = get_post( $parent_id );
                $breadcrumbs[] = $current_page->ID;
                $parent_id  = $current_page->post_parent;
            }

            $breadcrumbs = array_reverse( $breadcrumbs );

            for ( $i = 0; $i < count( $breadcrumbs); $i++ ){
                echo '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="' . esc_url( get_permalink( $breadcrumbs[$i] ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $breadcrumbs[$i] ) ) . '</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>';
                if ( $i != count( $breadcrumbs ) - 1 ) echo ' <span class="separator">' . $delimiter . '</span> ';
                $depth++;
            }

            echo ' <span class="separator">' .  $delimiter . '</span> ' . $before .'<a href="' . get_permalink() . '" itemprop="item"><span itemprop="name">'. esc_html( get_the_title() ) .'</span></a><meta itemprop="position" content="'. absint( $depth ).'" /></span>'. $after;
        
        }elseif( is_404() ){
            echo $before . esc_html__( '404 Error - Page Not Found', 'chic-lite' ) . $after;
        }
                
        echo '</div></div><!-- .breadcrumb-wrapper -->';
        
    }  
}
endif;

if( ! function_exists( 'chic_lite_theme_comment' ) ) :
/**
 * Callback function for Comment List *
 * 
 * @link https://codex.wordpress.org/Function_Reference/wp_list_comments 
 */
function chic_lite_theme_comment( $comment, $args, $depth ){
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	}else{
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<<?php echo $tag ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body" itemscope itemtype="http://schema.org/UserComments">
	<?php endif; ?>
    	
        <footer class="comment-meta">
            <div class="comment-author vcard">
        	   <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
        	</div><!-- .comment-author vcard -->
        </footer>
        
        <div class="text-holder">
        	<div class="top">
                <div class="left">
                    <?php if ( $comment->comment_approved == '0' ) : ?>
                		<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'chic-lite' ); ?></em>
                		<br />
                	<?php endif; ?>
                    <?php printf( __( '<b class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</b>', 'chic-lite' ), get_comment_author_link() ); ?>
                	<div class="comment-metadata commentmetadata">
                        <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>">
                    		<time itemprop="commentTime" datetime="<?php echo esc_attr( get_gmt_from_date( get_comment_date() . get_comment_time(), 'Y-m-d H:i:s' ) ); ?>"><?php printf( esc_html__( '%1$s at %2$s', 'chic-lite' ), get_comment_date(),  get_comment_time() ); ?></time>
                        </a>
                	</div>
                </div>                
            </div>            
            <div class="comment-content" itemprop="commentText"><?php comment_text(); ?></div>
            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div>        
        </div><!-- .text-holder -->
        
	<?php if ( 'div' != $args['style'] ) : ?>
    </div><!-- .comment-body -->
	<?php endif; 
}
endif;

if( ! function_exists( 'chic_lite_sidebar' ) ) :
/**
 * Return sidebar layouts for pages/posts
*/
function chic_lite_sidebar( $class = false ){
    global $post;
    $return = false;
    $page_layout = get_theme_mod( 'page_sidebar_layout', 'right-sidebar' ); //Default Layout Style for Pages
    $post_layout = get_theme_mod( 'post_sidebar_layout', 'right-sidebar' ); //Default Layout Style for Posts
    $layout      = get_theme_mod( 'layout_style', 'right-sidebar' ); //Default Layout Style for Styling Settings
    
    if( is_singular( array( 'page', 'post' ) ) ){         
        if( get_post_meta( $post->ID, '_chic_lite_sidebar_layout', true ) ){
            $sidebar_layout = get_post_meta( $post->ID, '_chic_lite_sidebar_layout', true );
        }else{
            $sidebar_layout = 'default-sidebar';
        }
        
        if( is_page() ){
            $dr_template = array( 'templates/pages/recipe-courses.php', 'templates/pages/recipe-cuisines.php', 'templates/pages/recipe-cooking-methods.php', 'templates/pages/recipe-keys.php', 'templates/pages/recipe-tags.php' );
            if( is_page_template( $dr_template ) ){
                if( $page_layout == 'no-sidebar' ){
                    $return = $class ? 'full-width' : false;
                }elseif( $page_layout == 'centered' ){
                    $return = $class ? 'full-width-centered' : false;
                }elseif( is_active_sidebar( 'delicious-recipe-sidebar' ) ){            
                    if( $class ){
                        if( $page_layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                        if( $page_layout == 'left-sidebar' ) $return = 'leftsidebar';
                    }else{
                        $return = 'delicious-recipe-sidebar';    
                    }                         
                }else{
                    $return = $class ? 'full-width' : false;
                } 
            }elseif( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' || ( $sidebar_layout == 'default-sidebar' && $page_layout == 'no-sidebar' ) ){
                    $return = $class ? 'full-width' : false;
                }elseif( $sidebar_layout == 'centered' || ( $sidebar_layout == 'default-sidebar' && $page_layout == 'centered' ) ){
                    $return = $class ? 'full-width-centered' : false;
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = $class ? 'rightsidebar' : 'sidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $page_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = $class ? 'leftsidebar' : 'sidebar';
                }
            }else{
                $return = $class ? 'full-width' : false;
            }
        }elseif( is_single() ){
            if( is_active_sidebar( 'sidebar' ) ){
                if( $sidebar_layout == 'no-sidebar' || ( $sidebar_layout == 'default-sidebar' && $post_layout == 'no-sidebar' ) ){
                    $return = $class ? 'full-width' : false;
                }elseif( $sidebar_layout == 'centered' || ( $sidebar_layout == 'default-sidebar' && $post_layout == 'centered' ) ){
                    $return = $class ? 'full-width-centered' : false;
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'right-sidebar' ) || ( $sidebar_layout == 'right-sidebar' ) ){
                    $return = $class ? 'rightsidebar' : 'sidebar';
                }elseif( ( $sidebar_layout == 'default-sidebar' && $post_layout == 'left-sidebar' ) || ( $sidebar_layout == 'left-sidebar' ) ){
                    $return = $class ? 'leftsidebar' : 'sidebar';
                }
            }else{
                $return = $class ? 'full-width' : false;
            }
        }
    }elseif( chic_lite_is_woocommerce_activated() && ( is_shop() || is_product_category() || is_product_tag() || get_post_type() == 'product' ) ){
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false;
        }elseif( is_active_sidebar( 'shop-sidebar' ) ){            
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }         
        }else{
            $return = $class ? 'full-width' : false;
        } 
    }elseif( chic_lite_is_delicious_recipe_activated() && ( is_post_type_archive( 'recipe' ) || is_tax( 'recipe-course' ) || is_tax( 'recipe-cuisine' ) || is_tax( 'recipe-cooking-method' ) || is_tax( 'recipe-key' ) || is_tax( 'recipe-tag' ) ) ){            
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false; //Fullwidth
        }elseif( is_active_sidebar( 'delicious-recipe-sidebar' ) ){
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }else{
                $return = 'delicious-recipe-sidebar';
            }
        }else{
            $return = $class ? 'full-width' : false; //Fullwidth
        } 
    }elseif( chic_lite_is_delicious_recipe_activated() && is_singular( DELICIOUS_RECIPE_POST_TYPE ) ){ 
        if( $post_layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false; //Fullwidth
        }elseif( $post_layout == 'centered' ){
            $return = $class ? 'full-width-centered' : false;
        }elseif( is_active_sidebar( 'delicious-recipe-sidebar' ) ){
            if( $class ){
                if( $post_layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $post_layout == 'left-sidebar' ) $return = 'leftsidebar';
            }else{
                $return = 'delicious-recipe-sidebar';    
            }  
        }else{
            $return = $class ? 'full-width' : false; //Fullwidth
        }
    }elseif( is_singular( 'rara-portfolio' ) ){ //For Product Post Type
        $return = $class ? 'full-width' : false; //Fullwidth
    }elseif( is_404() ){ //For Product Post Type
        $return = $class ? 'full-width' : false; //Fullwidth
    }else{
        if( $layout == 'no-sidebar' ){
            $return = $class ? 'full-width' : false;
        }elseif( is_active_sidebar( 'sidebar' ) ){            
            if( $class ){
                if( $layout == 'right-sidebar' ) $return = 'rightsidebar'; //With Sidebar
                if( $layout == 'left-sidebar' ) $return = 'leftsidebar';
            }else{
                $return = 'sidebar';    
            }                         
        }else{
            $return = $class ? 'full-width' : false;
        } 
    }    
    return $return; 
}
endif;

if( ! function_exists( 'chic_lite_get_posts' ) ) :
/**
 * Fuction to list Custom Post Type
*/
function chic_lite_get_posts( $post_type = 'post', $slug = false ){    
    $args = array(
    	'posts_per_page'   => -1,
    	'post_type'        => $post_type,
    	'suppress_filters' => true 
    );
    $posts_array = get_posts( $args );
    
    // Initate an empty array
    $post_options = array();
    $post_options[''] = __( ' -- Choose -- ', 'chic-lite' );
    if ( ! empty( $posts_array ) ) {
        foreach ( $posts_array as $posts ) {
            if( $slug ){
                $post_options[ $posts->post_title ] = $posts->post_title;
            }else{
                $post_options[ $posts->ID ] = $posts->post_title;    
            }
        }
    }
    return $post_options;
    wp_reset_postdata();
}
endif;

if( ! function_exists( 'chic_lite_get_categories' ) ) :
/**
 * Function to list post categories in customizer options
*/
function chic_lite_get_categories( $select = true, $taxonomy = 'category', $slug = false ){    
    /* Option list of all categories */
    $categories = array();
    
    $args = array( 
        'hide_empty' => false,
        'taxonomy'   => $taxonomy 
    );
    
    $catlists = get_terms( $args );
    if( $select ) $categories[''] = __( 'Choose Category', 'chic-lite' );
    foreach( $catlists as $category ){
        if( $slug ){
            $categories[$category->slug] = $category->name;
        }else{
            $categories[$category->term_id] = $category->name;    
        }        
    }
    
    return $categories;
}
endif;

if( ! function_exists( 'chic_lite_get_page_template_url' ) ) :
/**
 * Returns page template url if not found returns home page url
*/
function chic_lite_get_page_template_url( $page_template ){
    $args = array(
        'meta_key'   => '_wp_page_template',
        'meta_value' => $page_template,
        'post_type'  => 'page',
        'fields'     => 'ids',
    );
    
    $posts_array = get_posts( $args );
    
    $url = ( $posts_array ) ? get_permalink( $posts_array[0] ) : get_permalink( get_option( 'page_on_front' ) );
    return $url;    
}
endif;

if( ! function_exists( 'chic_lite_get_image_sizes' ) ) :
/**
 * Get information about available image sizes
 */
function chic_lite_get_image_sizes( $size = '' ) {
 
    global $_wp_additional_image_sizes;
 
    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();
 
    // Create the full array with sizes and crop info
    foreach( $get_intermediate_image_sizes as $_size ) {
        if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
            $sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
            $sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
            $sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array( 
                'width' => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
            );
        }
    } 
    // Get only 1 size if found
    if ( $size ) {
        if( isset( $sizes[ $size ] ) ) {
            return $sizes[ $size ];
        } else {
            return false;
        }
    }
    return $sizes;
}
endif;

if ( ! function_exists( 'chic_lite_get_fallback_svg' ) ) :    
/**
 * Get Fallback SVG
*/
function chic_lite_get_fallback_svg( $post_thumbnail ) {
    if( ! $post_thumbnail ){
        return;
    }
    
    $image_size = chic_lite_get_image_sizes( $post_thumbnail );
     
    if( $image_size ){ ?>
        <div class="svg-holder">
             <svg class="fallback-svg" viewBox="0 0 <?php echo esc_attr( $image_size['width'] ); ?> <?php echo esc_attr( $image_size['height'] ); ?>" preserveAspectRatio="none">
                    <rect width="<?php echo esc_attr( $image_size['width'] ); ?>" height="<?php echo esc_attr( $image_size['height'] ); ?>" style="fill:rgba(var(--primary-color-rgb), 0.10);"></rect>
            </svg>
        </div>
        <?php
    }
}
endif;

if( ! function_exists( 'wp_body_open' ) ) :
/**
 * Fire the wp_body_open action.
 * Added for backwards compatibility to support pre 5.2.0 WordPress versions.
*/
function wp_body_open() {
	/**
	 * Triggered after the opening <body> tag.
    */
	do_action( 'wp_body_open' );
}
endif;

/**
 * Is RaraTheme Companion active or not
 */
function chic_lite_is_rara_theme_companion_activated() {
    return class_exists('Raratheme_Companion') ? true : false;
}

/**
 * Is BlossomThemes Email Newsletters active or not
*/
function chic_lite_is_btnw_activated(){
    return class_exists( 'Blossomthemes_Email_Newsletter' ) ? true : false;        
}

/**
 * Is BlossomThemes Instagram Feed active or not
*/
function chic_lite_is_btif_activated(){
    return class_exists( 'Blossomthemes_Instagram_Feed' ) ? true : false;
}

/**
 * Query WooCommerce activation
 */
function chic_lite_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

/**
 * Check if Delicious Recipe Plugin is installed
*/
function chic_lite_is_delicious_recipe_activated(){
    return class_exists( 'WP_Delicious\DeliciousRecipes' ) ? true : false;
}

/**
 * Check if Contact Form 7 Plugin is installed
*/
function chic_lite_is_cf7_activated(){
    return class_exists( 'WPCF7' ) ? true : false;
}

/**
 * Query Jetpack activation
*/
function chic_lite_is_jetpack_activated( $gallery = false ){
	if( $gallery ){
        return ( class_exists( 'jetpack' ) && Jetpack::is_module_active( 'tiled-gallery' ) ) ? true : false;
	}else{
        return class_exists( 'jetpack' ) ? true : false;
    }           
}

/**
 * Checks if classic editor is active or not
*/
function chic_lite_is_classic_editor_activated(){
    return class_exists( 'Classic_Editor' ) ? true : false; 
}

if( ! function_exists( 'chic_lite_entry_header_first' ) ) :
/**
 * Entry Header
*/
function chic_lite_entry_header_first(){ ?>
    <header class="entry-header">
        <?php      
            chic_lite_category();

            if ( is_singular() ) :
                the_title( '<h1 class="entry-title">', '</h1>' );
            else :
                the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif; 

            if( 'post' === get_post_type() || 'rara-portfolio' === get_post_type() ){
                echo '<div class="entry-meta">';
                    chic_lite_posted_by(); 
                    chic_lite_posted_on(); 
                echo '</div>';
            }  
            ?>
    </header>         
    <?php    
}
endif;

if ( ! function_exists( 'chic_lite_search' ) ) :
/**
 * Search Heading
 * 
*/
function chic_lite_search(){
    if( is_search() ){ 
        ?>
        <header class="page-header">
            <div class="container">
                <?php 
                echo '<h1 class="screen-reader-text">' . esc_html__( 'Search Page', 'chic-lite' ) . '</h1>';
                echo '<span class="sub-title">' . esc_html__( 'Search Results For: ', 'chic-lite' ) . '</span>';
                get_search_form(); 
                ?>
            </div>
        </header>
        <?php
        chic_lite_search_per_page_count();
    }
}
endif;

if ( ! function_exists ( 'chic_lite_archive_heading' ) ) :
/**
 * Archive Heading
 * 
*/
function chic_lite_archive_heading(){

    if( is_author() ){
        chic_lite_author(); 
    }else{ ?>
        <header class="page-header">
            <div class="container">
                <?php 
                the_archive_description( '<div class="archive-description">', '</div>' ); 
                the_archive_title(); 
                ?>
            </div>
        </header>
        <?php  
    } 
    chic_lite_search_per_page_count();
}
endif;

if ( ! function_exists( 'chic_lite_author_desc' )) :

/**
* Author profile for single post.
*/

function chic_lite_author_desc(){
    $comment    = chic_lite_comment_count( false );
    $ed_author  = get_theme_mod( 'ed_post_author', false );
    $ed_sharing = get_theme_mod( 'ed_social_sharing', true );

    if ( $ed_author || ( $comment && !is_single() ) || $ed_sharing ) {
        ?>
        <div class="article-meta">
            <?php  
            if( $ed_author || is_single() ){ ?>
                <span class="byline" itemprop="author">
                    <span class="author">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="url fn">
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 70 ); ?>
                            <?php the_author_meta( 'display_name'); ?>
                        </a>
                    </span>
                </span>
            <?php
            } 
            if( $comment && !is_single() ) chic_lite_comment_count(); 
            ?>
        </div>
        <?php
    }
}
endif;

if ( ! function_exists( 'chic_lite_single_layout' ) ) :
/**
* Single Layout 
*/
function chic_lite_single_layout(){
    $image          = get_the_post_thumbnail_url();
    $sidebar        = chic_lite_sidebar();
    $image_crop     = get_theme_mod( 'ed_crop_single', false );
    ?>
    <header class="entry-header">

        <div class="container">
            <?php chic_lite_category(); ?>

            <h1 class="entry-title"><?php the_title(); ?></h1>        
            
            <div class="entry-meta">
                <?php
                chic_lite_posted_by( false );
                chic_lite_posted_on();
                chic_lite_comment_count();
                ?>
            </div>
        </div>
    </header> <!-- .page-header -->

    <?php     
    $image = ( $sidebar ) ? 'chic-lite-sidebar' : 'chic-lite-slider';
    
    if ( has_post_thumbnail() ){
        echo '<figure class="post-thumbnail">';
            if ( ! $image_crop ) {
                the_post_thumbnail( $image, array( 'itemprop' => 'image' ) );
            }else{
                the_post_thumbnail();
            }
        echo '</figure>';
    }
}
endif;


if ( ! function_exists( 'chic_lite_comment_toggle' ) ):
/**
 * Function toggle comment section position
*/
function chic_lite_comment_toggle(){
    $comment_postion = get_theme_mod( 'toggle_comments', false );

    if ( $comment_postion ) {
        $priority = 10;
    }else{
        $priority = 45;
    }
    return intval( $priority ) ;
}
endif;
