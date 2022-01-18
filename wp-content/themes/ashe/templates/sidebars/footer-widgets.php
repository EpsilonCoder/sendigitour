<?php

if ( ! is_active_sidebar( 'footer-widgets' ) && ! ashe_is_preview() ) {
	return;
}

?>

<div class="footer-widgets clear-fix">
	<?php dynamic_sidebar( 'footer-widgets' ); ?>
</div>