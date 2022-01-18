<!-- Footer Widget Secton -->
   <!--start footer-->
	<?php 
		//Widget Section
		$aneeq_widgets_section = get_theme_mod('aneeq_widgets_section', 'active');
		
		// Get Footer Layout Settings
		$aneeq_footer_column_layout = get_theme_mod('aneeq_footer_column_layout', 2);
		if($aneeq_footer_column_layout == 1) $aneeq_footer_class_name = "col-md-12 col-sm-12 col-xs-12";	// one column
		if($aneeq_footer_column_layout == 2) $aneeq_footer_class_name = "col-md-6 col-sm-6 col-xs-12";		// two column
		if($aneeq_footer_column_layout == 3) $aneeq_footer_class_name = "col-md-4 col-sm-6 col-xs-12";		// three column
		if($aneeq_footer_column_layout == 4) $aneeq_footer_class_name = "col-md-3 col-sm-6 col-xs-12";		// four column
	?>
	<?php if($aneeq_widgets_section == 'active') { ?>
		<footer class="footer">
			<div class="container">
				<div class="row">
					<?php 
					// Fetch Aneeq Theme Footer Widget
					if ( is_active_sidebar( 'footer-widget' ) ){
						dynamic_sidebar( 'footer-widget' );
					} 
					?>
				</div>
			</div>
		</footer>
		<!--end footer-->
	<?php } ?>

  <?php get_template_part('/include/widgets/footer-bottom'); ?> 
  <?php wp_footer(); ?> 
</body>
</html>