<?php
/**
 * Templates Loader Error
 */

use PremiumAddons\Includes\Templates;

?>
<div class="elementor-library-error">
	<div class="elementor-library-error-message">
	<?php
		echo wp_kses_post( __( 'Template couldn\'t be loaded. Please activate you license key before.', 'premium-addons-for-elementor' ) );
	?>
	</div>
	<div class="elementor-library-error-link">
	<?php
		printf(
			'<a class="template-library-activate-license" href="%1$s" target="_blank">%2$s %3$s</a>',
			esc_url( Templates\premium_templates()->config->get( 'license_page' ) ),
			'<i class="fa fa-external-link" aria-hidden="true"></i>',
			wp_kses_post( Templates\premium_templates()->config->get( 'pro_message' ) )
		);
		?>
	</div>
</div>
