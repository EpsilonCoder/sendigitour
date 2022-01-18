<?php

// Get Previous and Next Posts
$prev_post = get_adjacent_post(false, '', false);
$next_post = get_adjacent_post(false, '', true);

?>

<!-- Previous Post -->
<?php if ( ! empty( $prev_post ) ) : ?>
<a href="<?php echo esc_url( get_permalink($prev_post->ID) ); ?>" title="<?php echo esc_attr($prev_post->post_title); ?>" class="single-navigation previous-post">
<?php echo get_the_post_thumbnail($prev_post->ID, 'ashe-single-navigation'); ?>
<i class="fa fa-angle-right"></i>
</a>
<?php endif; ?>

<!-- Next Post -->
<?php if ( ! empty( $next_post ) ) : ?>
<a href="<?php echo esc_url( get_permalink($next_post->ID) ); ?>" title="<?php echo esc_attr($next_post->post_title); ?>" class="single-navigation next-post">
	<?php echo get_the_post_thumbnail($next_post->ID, 'ashe-single-navigation'); ?>
	<i class="fa fa-angle-left"></i>
</a>
<?php endif; ?>