<?php
	//footer-bottom setting
	$aneeq_footer_social_icons   = get_theme_mod('aneeq_footer_social_icons', '');
	$aneeq_facebook_url     	 = get_theme_mod('aneeq_facebook_url', '');
	$aneeq_twitter_url  		 = get_theme_mod('aneeq_twitter_url', '');
	$aneeq_insta_url   			 = get_theme_mod('aneeq_insta_url', '');
	$aneeq_youtube_url   		 = get_theme_mod('aneeq_youtube_url', '');
	$aneeq_pintrest_url			 = get_theme_mod('aneeq_pintrest_url', '');
	$aneeq_logo_text_name 		 = get_theme_mod('aneeq_logo_text_name', '');
?> 
<section class="footer_bottom">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-sm-6 col-xs-12">
				<p class="copyright">
					&copy; <?php echo esc_attr(date('Y')); ?> - <?php if($aneeq_logo_text_name != "") { echo esc_html($aneeq_logo_text_name); } else { echo esc_attr( get_bloginfo( 'name' ) ); } ?> | 
					<?php esc_html_e('Aneeq WordPress Theme By', 'aneeq'); ?> <a target="blank" href="https://awplife.com/" rel="nofollow" ><?php esc_html_e('A WP Life', 'aneeq'); ?></a> | 
					<?php esc_html_e('Powered By', 'aneeq'); ?> <a href="https://wordpress.org"><?php esc_html_e('WordPress.org','aneeq'); ?></a>
				</p>
			</div>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<div class="footer_social">
					<?php if($aneeq_footer_social_icons == "show") { ?>
						<ul class="footbot_social">
							<?php if($aneeq_facebook_url != '') { ?><li><a href="<?php echo esc_url(get_theme_mod('aneeq_facebook_url', '')); ?>" target="_new"><i class="fa fa-facebook"></i></a></li><?php } ?>
							<?php if($aneeq_twitter_url != '') { ?><li><a href="<?php echo esc_url(get_theme_mod('aneeq_twitter_url', '')); ?>" target="_new"><i class="fa fa-twitter"></i></a></li><?php } ?>
							<?php if($aneeq_insta_url != '') { ?><li><a href="<?php echo esc_url(get_theme_mod('aneeq_insta_url', '')); ?>" target="_new"><i class="fa fa-instagram"></i></a></li><?php } ?>
							<?php if($aneeq_youtube_url != '') { ?><li><a href="<?php echo esc_url(get_theme_mod('aneeq_youtube_url', '')); ?>" target="_new"><i class="fa fa-youtube"></i></a></li><?php } ?>
							<?php if($aneeq_pintrest_url != '') { ?><li><a href="<?php echo esc_url(get_theme_mod('aneeq_pintrest_url', '')); ?>" target="_new"><i class="fa fa-pinterest"></i></a></li><?php } ?>
						</ul>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>