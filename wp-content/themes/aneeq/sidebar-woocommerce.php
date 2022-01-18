<?php
/**
 * side bar template
 */
 if ( is_active_sidebar( 'woocommerce' )  ) : ?>
<!--Sidebar-->
<?php dynamic_sidebar( 'woocommerce' ); ?>
<!--/End of Sidebar-->
<?php endif; ?>