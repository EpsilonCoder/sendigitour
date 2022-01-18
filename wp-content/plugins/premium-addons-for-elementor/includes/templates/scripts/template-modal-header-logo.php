<?php
/**
 * Template Library Modal Header
 */

use PremiumAddons\Includes\Helper_Functions;

?>
<span class="premium-template-modal-header-logo-icon">
	<img src="<?php echo esc_url( PREMIUM_ADDONS_URL . 'admin/images/pa-logo-symbol.png' ); ?>">
</span>
<span class="premium-template-modal-header-logo-label">
	<?php echo wp_kses_post( sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __( 'Templates', 'premium-addons-for-elementor' ) ) ); ?>
</span>

