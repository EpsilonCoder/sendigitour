<!--breadcrumb section start-->
<?php //$enabled_sections = aneeq_get_sections(); 
	//$enable_aneeq_slider_section = aneeq_get_option( 'enable_aneeq_slider_section' );
	//if( true != $enable_aneeq_slider_section){ ?>
			<section class="page_head">
				<div class="container">
					<div class="row">
						<div class="col-md-8 col-sm-6 col-xs-12">
							<div class="page_title">
								<h2><?php the_title(); ?></h2>
							</div>
						</div>		
						<div class="col-md-4 col-sm-6 col-xs-12">	
							<nav id="breadcrumbs">
								<ul>
									<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home', 'aneeq'); ?></a>/</li>
									<li><?php the_title(); ?></li>
								</ul>
							</nav>
						</div>		
					</div>
				</div>
			</section>
		<?php 
	//} ?>
<!--breadcrumb section End-->