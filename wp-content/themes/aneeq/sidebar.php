<?php if( is_active_sidebar('sidebar-widget') ) : ?>
<div class="widget">
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-widget') ) : ?> 
	<?php endif;?>
</div>
<?php endif; ?>