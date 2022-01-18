<?php
get_header();
global $woocommerce; ?>
<!--breadcrumb section start-->
	<section class="page_head">
		<div class="container">
			<div class="row">
				<div class="col-md-8 col-sm-6 col-xs-12">
					<div class="page_title">
						<h2><?php 
							if( class_exists( 'WooCommerce' ) && is_shop() ) :
								$aneeq_shop_text = get_theme_mod('shop_prefix', esc_html('Shop','aneeq'));
								printf( esc_html( '%1$s %2$s', 'aneeq' ), esc_html($aneeq_shop_text), single_tag_title( '', false ));
							elseif( is_product() ): 
								the_title( '<h2>', '</h2>' ); 
							endif; ?>
						</h2>
					</div>
				</div>
				<div class="col-md-4 col-sm-6 col-xs-12">
					<nav id="breadcrumbs">
						<ul>
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html('Home', 'aneeq'); ?></a>/</li>
							<li><?php 
								if( class_exists( 'WooCommerce' ) && is_shop() ) :
									$aneeq_shop_text = get_theme_mod('shop_prefix',esc_html('Shop','aneeq'));
									printf( esc_html( '%1$s %2$s', 'aneeq' ), esc_html($aneeq_shop_text), single_tag_title( '', false ));
								elseif( is_product() ): 
									the_title(); 
								endif; ?>
							</li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</section>
<!--breadcrumb section End-->

<!-- woocommerce Section with Sidebar123133 -->
<section class="site-content woocommerce-title">
	<div class="container">
		<div class="row">
			<div class="col-md-<?php echo ( !is_active_sidebar( 'woocommerce' ) ? '12' :'8' ); ?> col-xs-12">
				<?php woocommerce_content(); ?>
			</div>
			<!--/woocommerce Section-->
			<?php if ( is_active_sidebar( 'woocommerce' )  )  { ?>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="sidebar">
						<?php get_sidebar('woocommerce'); ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</section>
<!-- /woocommerce Section with Sidebar -->
<?php get_footer(); ?>