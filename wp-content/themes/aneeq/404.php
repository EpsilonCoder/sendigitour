<?php
get_header();

//404 page theme option setting
$aneeq_option_settings = get_option('aneeq_404_settings');

if(isset($aneeq_option_settings['aneeq_big_icon'])) $aneeq_big_icon = $aneeq_option_settings['aneeq_big_icon']; else $aneeq_big_icon = "fa-arrow-left";
if(isset($aneeq_option_settings['aneeq_big_heading_text'])) $aneeq_big_heading_text = $aneeq_option_settings['aneeq_big_heading_text']; else $aneeq_big_heading_text = "404";
if(isset($aneeq_option_settings['aneeq_description_text'])) $aneeq_description_text = $aneeq_option_settings['aneeq_description_text']; else $aneeq_description_text = "Sorry, Page you're looking for is not found";
if(isset($aneeq_option_settings['aneeq_big_icon_text'])) $aneeq_big_icon_text = $aneeq_option_settings['aneeq_big_icon_text']; else $aneeq_big_icon_text = "Go To Back";
if(isset($aneeq_option_settings['aneeq_four_zero_four_button_link'])) $aneeq_four_zero_four_button_link = $aneeq_option_settings['aneeq_four_zero_four_button_link']; else $aneeq_four_zero_four_button_link = "";
?>
	<section class="wrapper">
        <!--breadcrumb section start-->
		<section class="page_head">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="page_title">
                            <h2><?php the_title(); ?></h2>
                        </div>
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
		<!--breadcrumb section End-->

		<section class="content not_found">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-lg-12 col-md-12">
						<div class="page_404">
							<h1><?php echo esc_html($aneeq_big_heading_text); ?></h1>
							<p><?php echo esc_html($aneeq_description_text); ?></p>							
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-default btn-lg">
								<i class="fa <?php echo esc_attr($aneeq_big_icon); ?>"></i>
								<?php echo esc_html($aneeq_big_icon_text); ?>
								
							</a>	
						</div>
						<?php
							get_search_form();
						?>
					</div>
				</div>
			</div>
		</section>
	</section>
<?php get_footer(); ?>