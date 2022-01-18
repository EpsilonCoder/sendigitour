<?php /*

@package aneeqtheme

*/
	//password check
	if ( post_password_required() ) {
		echo '<p class="nocomments">This post is password protected. Enter the password to view comments.</p>';
		return;
	}
	
	//comments
 	if ( have_comments() ) : ?>
		<h2><?php comments_number ( __('No Comments', 'aneeq'), __( 'One Comment', 'aneeq'), __('% Comments', 'aneeq') ); ?> <?php esc_html_e('on', 'aneeq');?> "<?php the_title(); ?>"</h2>
		<ul class="commentlist">
			<?php 
				$args = array (
						'walker'				=> null,
						'max_depth'				=> '4',
						'style'					=> 'div',
						'callback'				=> null,
						'end-callback'			=> null,
						'type'					=> 'all',
						'reply_text'			=> 'Reply &raquo;',
						'page'					=> null,
						'per_page'				=> null,
						'avatar_size'			=> 32,
						'reverse_top_level'		=> null,
						'reverse_children'		=> '',
						'format'				=> 'html5',
						'short_ping'			=> false,
						'echo'					=> true
				);
				
				wp_list_comments( $args );
			?>
		</ul>
		<div class="navigation">
			<div class="alignleft"><?php previous_comments_link() ?></div>
			<div class="alignright"><?php next_comments_link() ?></div>
		</div>
<?php 	
	endif;
			
	//change button display
	$args = array(
	  'class_submit'      => 'submit btn btn-default btn-lg',
	);
	
	comment_form( $args ); ?>