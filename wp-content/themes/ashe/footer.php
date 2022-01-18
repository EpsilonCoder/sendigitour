		</div><!-- .page-content -->

		<!-- Page Footer -->
		<footer id="page-footer" class="<?php echo esc_attr(ashe_options( 'general_footer_width' )) === 'boxed' ? 'boxed-wrapper ': ''; ?>clear-fix">
			
			<!-- Scroll Top Button -->
			<?php if ( ashe_options( 'page_footer_show_scrolltop' ) === true ) : ?>
			<span class="scrolltop">
				<i class="fa fa fa-angle-up"></i>
			</span>
			<?php endif; ?>

			<div class="page-footer-inner <?php echo ashe_options( 'general_footer_width' ) === 'contained' ? 'boxed-wrapper': ''; ?>">

			<!-- Footer Widgets -->
			<?php echo get_template_part( 'templates/sidebars/footer', 'widgets' ); ?>

			<div class="footer-copyright">
				<div class="copyright-info">
				<?php

				$copyright = ashe_options( 'page_footer_copyright' );
				$copyright = str_replace( '$year', date_i18n( 'Y' ), $copyright );
				$copyright = str_replace( '$copy', '&copy;', $copyright );

				echo wp_kses_post( $copyright );

				?>
				</div>

				<?php 
				wp_nav_menu( array(
					'theme_location' 	=> 'footer',
					'menu_id' 		 	=> 'footer-menu',
					'menu_class' 		=> '',
					'container' 	 	=> 'nav',
					'container_class'	=> 'footer-menu-container',
					'depth'				=> 1,
					'fallback_cb' 		=> false
				) );
				?>
				
				<div class="credit">
					<?php
					$theme_data	= wp_get_theme();
					/* translators: %1$s: theme name, %2$s link, %3$s theme author */
					printf( __( '%1$s Theme by <a href="%2$s">%3$s.</a>', 'ashe' ), esc_html( $theme_data->Name ), esc_url( 'http://wp-royal.com/' ), $theme_data->Author );
					?>
				</div>

			</div>

			</div><!-- .boxed-wrapper -->

		</footer><!-- #page-footer -->

	</div><!-- #page-wrap -->

<?php wp_footer(); ?>

</body>
</html>