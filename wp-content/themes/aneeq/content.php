<article class="post <?php if ( has_post_thumbnail() ) { ?>has-thumbnail <?php } ?>" <?php post_class(); ?>>
	
	<!-- post-thumbnail -->
	<div class="post-thumbnail">
		<a href="<?php esc_url(the_permalink()); ?>"><?php the_post_thumbnail('small-thumbnail'); ?></a>
	</div><!-- /post-thumbnail -->
	
		
		<h2><a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a></h2>
		
		<p class="post-info"><?php get_the_date('F j, Y g:i a'); ?> <?php esc_html_e('| By', 'aneeq'); ?> 
			<a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a><?php esc_html_e('| Posted in', 'aneeq'); ?> 			
			<?php if (has_category()) : ?>	
				<span><i class="fa fa-th-list"></i>
					<a href="#"><?php the_category('&nbsp;,&nbsp');?></a> 
				</span>
			<?php endif; ?>
		</p>
		 
		<?php if( is_search() OR is_archive() ){ ?>
			<p>
				<?php echo esc_attr(get_the_excerpt()); ?>
				<a href="<?php esc_url(the_permalink()); ?>"><?php esc_html_e('Read More', 'aneeq'); ?>&raquo;</a>
			</p>
		<?php } else {
			 if($post->post_excerpt){?>
				<p>
					<?php echo esc_attr(get_the_excerpt()); ?>
					<a href="<?php esc_url(the_permalink()); ?>"><?php esc_html_e('Read More', 'aneeq'); ?>&raquo;</a>
				</p>
				<?php } else{
					the_content();
				}
		} ?>
	</article>