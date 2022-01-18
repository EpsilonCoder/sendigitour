<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use PremiumAddons\Includes\Helper_Functions;

$elements = self::get_elements_list();

$used_widgets = self::get_used_widgets();

// Get elements settings
$enabled_elements = self::get_enabled_elements();

$global_btn  = get_option( 'pa_global_btn_value', 'true' );
$enable_btn  = 'true' === $global_btn ? 'active' : '';
$disable_btn = 'true' === $global_btn ? '' : 'active';

$row_meta = Helper_Functions::is_hide_row_meta();

?>

<div class="pa-section-content">
	<div class="row">
		<div class="col-full">
		<form action="" method="POST" id="pa-settings" name="pa-settings" class="pa-settings-form">
			<div id="pa-modules" class="pa-settings-tab">

				<div class="pa-section-info-wrap">
					<div class="pa-section-info">
						<h4><?php echo __( 'Master Switch', 'premium-addons-for-elementor' ); ?></h4>
						<p><?php echo __( 'Use this to switch on or off ALL Widgets & Add-ons at once.', 'premium-addons-for-elementor' ); ?></p>
					</div>

					<div class="pa-btn-group">
						<button type="button" class="pa-btn pa-btn-enable <?php echo esc_attr( $enable_btn ); ?>"><?php echo __( 'Switch On', 'premium-addons-for-elementor' ); ?></button>
						<button type="button" class="pa-btn pa-btn-disable <?php echo esc_attr( $disable_btn ); ?>"><?php echo __( 'Switch Off', 'premium-addons-for-elementor' ); ?></button>
						<?php if ( $used_widgets ) { ?>
							<button type="button" class="pa-btn-unused"><?php echo __( 'Disable Unused Widgets', 'premium-addons-for-elementor' ); ?></button>
						<?php } ?>	
					</div>
				</div>

				<div class="pa-elements-settings">

					<div class="pa-elements-filter">
						<label for="premium-elements-filter"><?php _e( 'Filter Widgets', 'premium-addons-for-elementor' ); ?></label>
						<select name="premium-elements-filter" id="premium-elements-filter" class="placeholder placeholder-active">
							<option value=""><?php _e( 'All Widgets', 'premium-addons-for-elementor' ); ?></option>
							<option value="free"><?php _e( 'Free Widgets', 'premium-addons-for-elementor' ); ?></option>
							<option value="pro"><?php _e( 'PRO Widgets', 'premium-addons-for-elementor' ); ?></option>
						</select>
					</div>

					<div class="pa-elements-tabs">
						<ul class="pa-elements-tabs-list">
						<?php
						foreach ( $elements as $index => $cat ) :
							if ( 'cat-11' !== $index ) :
								?>
							<li class="pa-elements-tab">
								<a class="pa-elements-tab-link" href="pa-elements-tab-<?php echo $index; ?>">
									<i class="<?php echo esc_attr( 'pa-dash-cat-' . $cat['icon'] ); ?>"></i>
								</a>
								<span class="pa-element-tab-tooltip"><?php echo esc_html( $cat['title'] ); ?></span>
							</li>
							<?php endif; ?>
						<?php endforeach; ?>
						</ul>
					</div>

					<?php
					foreach ( $elements as $index => $cat ) :
						if ( 'cat-11' !== $index ) :
							?>
						<div id="pa-elements-tab-<?php echo $index; ?>" class="pa-switchers-container hidden">
						<h3 class="pa-elements-tab-title"><?php echo __( $cat['title'] ); ?></h3>
						<div class="pa-switchers">
							<?php
							foreach ( $cat['elements'] as $index => $elem ) :
								$status         = ( isset( $elem['is_pro'] ) && ! Helper_Functions::check_papro_version() ) ? 'disabled' : checked( 1, $enabled_elements[ $elem['key'] ], false );
								$class          = ( isset( $elem['is_pro'] ) && ! Helper_Functions::check_papro_version() ) ? 'pro-' : '';
								$switcher_class = $class . 'slider round';
								?>
								<div class="pa-switcher
								<?php
								echo isset( $elem['is_pro'] ) ? 'pro-element' : '';
								echo isset( $elem['name'] ) ? ' ' . $elem['name'] : '';
								?>
								">
									<div class="pa-element-info">
										<div class="pa-element-icon-wrap">
											<i class="pa-dash-<?php echo esc_attr( $elem['key'] ); ?> pa-element-icon"></i>
										</div>
										<div class="pa-element-meta-wrap">
											<p class="pa-element-name">
												<?php echo $elem['title']; ?>
											<span class="pa-total-use" title="Total Use">
											<?php
											if ( ! isset( $elem['is_global'] ) && is_array( $used_widgets ) ) {
												echo esc_html__( in_array( $elem['name'], array_keys( $used_widgets ) ) ? '(' . $used_widgets[ $elem['name'] ] . ')' : '(0)' );}
											?>
											</span>
												<?php if ( isset( $elem['is_pro'] ) ) : ?>
													<span><?php echo __( 'pro', 'premium-addons-for-elementor' ); ?></span>
												<?php endif; ?>
											</p>
											<?php if ( ! $row_meta ) : ?>
												<div>
													<?php if ( isset( $elem['demo'] ) ) : ?>
														<a class="pa-element-link" href="<?php echo esc_url( $elem['demo'] ); ?>" target="_blank">
															<?php echo __( 'Live Demo', 'premium-addons-for-elementor' ); ?>
															<span class="pa-element-link-separator"></span>
														</a>
													<?php endif; ?>
													<?php if ( isset( $elem['doc'] ) ) : ?>
														<a class="pa-element-link" href="<?php echo esc_url( $elem['doc'] ); ?>" target="_blank">
															<?php echo __( 'Docs', 'premium-addons-for-elementor' ); ?>
															<?php if ( isset( $elem['tutorial'] ) ) : ?>
																<span class="pa-element-link-separator"></span>
															<?php endif; ?>
														</a>
													<?php endif; ?>
													<?php if ( isset( $elem['tutorial'] ) ) : ?>
														<a class="pa-element-link" href="<?php echo esc_url( $elem['tutorial'] ); ?>" target="_blank">
															<?php echo __( 'Video Tutorial', 'premium-addons-for-elementor' ); ?>
														</a>
													<?php endif; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>
									<label class="switch">
										<input type="checkbox" id="<?php echo esc_attr( $elem['key'] ); ?>" name="<?php echo esc_attr( $elem['key'] ); ?>" <?php echo $status; ?>>
										<span class="<?php echo esc_attr( $switcher_class ); ?>"></span>
									</label>
								</div>
							<?php endforeach; ?>
						</div>
						</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>

			</div>
		</form> <!-- End Form -->
		</div>
	</div>
</div> <!-- End Section Content -->
