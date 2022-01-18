<?php
/**
 * PA Admin Helper
 */

namespace PremiumAddons\Admin\Includes;

use PremiumAddons\Includes\Helper_Functions;
use Elementor\Modules\Usage\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Admin_Helper
 */
class Admin_Helper {

	/**
	 * Admin settings tabs
	 *
	 * @var tabs
	 */
	private static $tabs = null;

	/**
	 * Class instance
	 *
	 * @var instance
	 */
	private static $instance = null;

	/**
	 * Premium Addons Settings Page Slug
	 *
	 * @var page_slug
	 */
	protected $page_slug = 'premium-addons';

	/**
	 * Current Screen ID
	 *
	 * @var current_screen
	 */
	public static $current_screen = null;

	/**
	 * Elements List
	 *
	 * @var elements_list
	 */
	public static $elements_list = null;

	/**
	 * Elements Names
	 *
	 * @var elements_names
	 */
	public static $elements_names = null;

	/**
	 * Integrations List
	 *
	 * @var integrations_list
	 */
	public static $integrations_list = null;

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		// Get current screen ID.
		add_action( 'current_screen', array( $this, 'get_current_screen' ) );

		// Insert admin settings submenus.
		$this->set_admin_tabs();
		add_action( 'admin_menu', array( $this, 'add_menu_tabs' ), 100 );

		// Enqueue required admin scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

		// Plugin Action Links.
		add_filter( 'plugin_action_links_' . PREMIUM_ADDONS_BASENAME, array( $this, 'insert_action_links' ) );
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );

		// Register AJAX HOOKS.
		add_action( 'wp_ajax_pa_save_global_btn', array( $this, 'save_global_btn_value' ) );
		add_action( 'wp_ajax_pa_elements_settings', array( $this, 'save_settings' ) );
		add_action( 'wp_ajax_pa_additional_settings', array( $this, 'save_additional_settings' ) );
		add_action( 'wp_ajax_pa_get_unused_widgets', array( $this, 'get_unused_widgets' ) );

		add_action( 'wp_ajax_subscribe_newsletter', array( $this, 'subscribe_newsletter' ) );

		add_action( 'pa_before_render_admin_tabs', array( $this, 'render_dashboard_header' ) );

		// Register Rollback hooks.
		add_action( 'admin_post_premium_addons_rollback', array( $this, 'run_pa_rollback' ) );

		// Beta_Testers::get_instance();

		if ( is_admin() ) {
			$current_page = $_SERVER['REQUEST_URI'];
			if ( false === strpos( $current_page, 'action=elementor' ) ) {
				Admin_Notices::get_instance();

				// PA Duplicator.
				if ( self::check_duplicator() ) {
					Duplicator::get_instance();
				}
			}
		}

	}

	/**
	 * Checks user credentials for specific action
	 *
	 * @since 2.6.8
	 *
	 * @return boolean
	 */
	public static function check_user_can( $action ) {
		return current_user_can( $action );
	}

	/**
	 * Get Elements List
	 *
	 * Get a list of all the elements available in the plugin
	 *
	 * @since 3.20.9
	 * @access private
	 *
	 * @return array widget_list
	 */
	private static function get_elements_list() {

		if ( null === self::$elements_list ) {

			self::$elements_list = require_once PREMIUM_ADDONS_PATH . 'admin/includes/elements.php';

		}

		return self::$elements_list;

	}

	/**
	 * Get Integrations List
	 *
	 * Get a list of all the integrations available in the plugin
	 *
	 * @since 3.20.9
	 * @access private
	 *
	 * @return array integrations_list
	 */
	private static function get_integrations_list() {

		if ( null === self::$integrations_list ) {

			self::$integrations_list = array(
				'premium-map-api',
				'premium-youtube-api',
				'premium-map-disable-api',
				'premium-map-cluster',
				'premium-map-locale',
				'is-beta-tester',
			);

		}

		return self::$integrations_list;

	}

	/**
	 * Admin Enqueue Scripts
	 *
	 * Enqueue the required assets on our admin pages
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_enqueue_scripts() {

		wp_enqueue_style(
			'pa_admin_icon',
			PREMIUM_ADDONS_URL . 'admin/assets/fonts/style.css',
			array(),
			PREMIUM_ADDONS_VERSION,
			'all'
		);

		$suffix = is_rtl() ? '-rtl' : '';

		$current_screen = self::get_current_screen();

		wp_enqueue_style(
			'pa-notice-css',
			PREMIUM_ADDONS_URL . 'admin/assets/css/notice' . $suffix . '.css',
			array(),
			PREMIUM_ADDONS_VERSION,
			'all'
		);

		if ( strpos( $current_screen, $this->page_slug ) !== false ) {

			wp_enqueue_style(
				'pa-admin-css',
				PREMIUM_ADDONS_URL . 'admin/assets/css/admin' . $suffix . '.css',
				array(),
				PREMIUM_ADDONS_VERSION,
				'all'
			);

			wp_enqueue_style(
				'pa-sweetalert-style',
				PREMIUM_ADDONS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.css',
				array(),
				PREMIUM_ADDONS_VERSION,
				'all'
			);

			wp_enqueue_script(
				'pa-admin',
				PREMIUM_ADDONS_URL . 'admin/assets/js/admin.js',
				array( 'jquery' ),
				PREMIUM_ADDONS_VERSION,
				true
			);

			wp_enqueue_script(
				'pa-sweetalert-core',
				PREMIUM_ADDONS_URL . 'admin/assets/js/sweetalert2/core.js',
				array( 'jquery' ),
				PREMIUM_ADDONS_VERSION,
				true
			);

			wp_enqueue_script(
				'pa-sweetalert',
				PREMIUM_ADDONS_URL . 'admin/assets/js/sweetalert2/sweetalert2.min.js',
				array( 'jquery', 'pa-sweetalert-core' ),
				PREMIUM_ADDONS_VERSION,
				true
			);

			$theme_slug = Helper_Functions::get_installed_theme();

			$localized_data = array(
				'settings'               => array(
					'ajaxurl'          => admin_url( 'admin-ajax.php' ),
					'nonce'            => wp_create_nonce( 'pa-settings-tab' ),
					'theme'            => $theme_slug,
					'isTrackerAllowed' => 'yes' === get_option( 'elementor_allow_tracking', 'no' ) ? true : false,
				),
				'premiumRollBackConfirm' => array(
					'home_url' => home_url(),
					'i18n'     => array(
						'rollback_to_previous_version' => __( 'Rollback to Previous Version', 'premium-addons-for-elementor' ),
						/* translators: %s: PA stable version */
						'rollback_confirm'             => sprintf( __( 'Are you sure you want to reinstall version %s?', 'premium-addons-for-elementor' ), PREMIUM_ADDONS_STABLE_VERSION ),
						'yes'                          => __( 'Continue', 'premium-addons-for-elementor' ),
						'cancel'                       => __( 'Cancel', 'premium-addons-for-elementor' ),
					),
				),
			);

			// Add PAPRO Rollback Confirm message if PAPRO installed.
			if ( Helper_Functions::check_papro_version() ) {
				/* translators: %s: PA stable version */
				$localized_data['premiumRollBackConfirm']['i18n']['papro_rollback_confirm'] = sprintf( __( 'Are you sure you want to reinstall version %s?', 'premium-addons-for-elementor' ), PREMIUM_ADDONS_STABLE_VERSION );
			}

			wp_localize_script( 'pa-admin', 'premiumAddonsSettings', $localized_data );

		}
	}

	/**
	 * Insert action links.
	 *
	 * Adds action links to the plugin list table
	 *
	 * Fired by `plugin_action_links` filter.
	 *
	 * @param array $links plugin action links.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function insert_action_links( $links ) {

		$papro_path = 'premium-addons-pro/premium-addons-pro-for-elementor.php';

		$is_papro_installed = Helper_Functions::is_plugin_installed( $papro_path );

		$settings_link = sprintf( '<a href="%1$s">%2$s</a>', admin_url( 'admin.php?page=' . $this->page_slug . '#tab=elements' ), __( 'Settings', 'premium-addons-for-elementor' ) );

		$rollback_link = sprintf( '<a href="%1$s">%2$s %3$s</a>', wp_nonce_url( admin_url( 'admin-post.php?action=premium_addons_rollback' ), 'premium_addons_rollback' ), __( 'Rollback to Version ', 'premium-addons-for-elementor' ), PREMIUM_ADDONS_STABLE_VERSION );

		$new_links = array( $settings_link, $rollback_link );

		if ( ! $is_papro_installed ) {

			$link = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/pro', 'plugins-page', 'wp-dash', 'get-pro' );

			$pro_link = sprintf( '<a href="%s" target="_blank" style="color: #FF6000; font-weight: bold;">%s</a>', $link, __( 'Go Pro', 'premium-addons-for-elementor' ) );
			array_push( $new_links, $pro_link );
		}

		$new_links = array_merge( $links, $new_links );

		return $new_links;
	}

	/**
	 * Plugin row meta.
	 *
	 * Extends plugin row meta links
	 *
	 * Fired by `plugin_row_meta` filter.
	 *
	 * @since 3.8.4
	 * @access public
	 *
	 * @param array  $meta array of the plugin's metadata.
	 * @param string $file path to the plugin file.
	 *
	 *  @return array An array of plugin row meta links.
	 */
	public function plugin_row_meta( $meta, $file ) {

		if ( Helper_Functions::is_hide_row_meta() ) {
			return $meta;
		}

		if ( PREMIUM_ADDONS_BASENAME === $file ) {

			$link = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/support', 'plugins-page', 'wp-dash', 'get-support' );

			$row_meta = array(
				'docs'   => '<a href="' . esc_attr( $link ) . '" aria-label="' . esc_attr( __( 'View Premium Addons for Elementor Documentation', 'premium-addons-for-elementor' ) ) . '" target="_blank">' . __( 'Docs & FAQs', 'premium-addons-for-elementor' ) . '</a>',
				'videos' => '<a href="https://www.youtube.com/watch?v=D3INxWw_jKI&list=PLLpZVOYpMtTArB4hrlpSnDJB36D2sdoTv" aria-label="' . esc_attr( __( 'View Premium Addons Video Tutorials', 'premium-addons-for-elementor' ) ) . '" target="_blank">' . __( 'Video Tutorials', 'premium-addons-for-elementor' ) . '</a>',
			);

			$meta = array_merge( $meta, $row_meta );
		}

		return $meta;

	}

	/**
	 * Gets current screen slug
	 *
	 * @since 3.3.8
	 * @access public
	 *
	 * @return string current screen slug
	 */
	public static function get_current_screen() {

		self::$current_screen = get_current_screen()->id;

		return isset( self::$current_screen ) ? self::$current_screen : false;

	}

	/**
	 * Set Admin Tabs
	 *
	 * @access private
	 * @since 3.20.8
	 */
	private function set_admin_tabs() {

		$slug = $this->page_slug;

		self::$tabs = array(
			'general'         => array(
				'id'       => 'general',
				'slug'     => $slug . '#tab=general',
				'title'    => __( 'General', 'premium-addons-for-elementor' ),
				'href'     => '#tab=general',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/general',
			),
			'elements'        => array(
				'id'       => 'elements',
				'slug'     => $slug . '#tab=elements',
				'title'    => __( 'Widgets & Add-ons', 'premium-addons-for-elementor' ),
				'href'     => '#tab=elements',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/modules-settings',
			),
			'features'        => array(
				'id'       => 'features',
				'slug'     => $slug . '#tab=features',
				'title'    => __( 'Global Features', 'premium-addons-for-elementor' ),
				'href'     => '#tab=features',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/features',
			),
			'integrations'    => array(
				'id'       => 'integrations',
				'slug'     => $slug . '#tab=integrations',
				'title'    => __( 'Integrations', 'premium-addons-for-elementor' ),
				'href'     => '#tab=integrations',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/integrations',
			),
			'version-control' => array(
				'id'       => 'vcontrol',
				'slug'     => $slug . '#tab=vcontrol',
				'title'    => __( 'Version Control', 'premium-addons-for-elementor' ),
				'href'     => '#tab=vcontrol',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/version-control',
			),
			'white-label'     => array(
				'id'       => 'white-label',
				'slug'     => $slug . '#tab=white-label',
				'title'    => __( 'White Labeling', 'premium-addons-for-elementor' ),
				'href'     => '#tab=white-label',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/white-label',
			),
			'info'            => array(
				'id'       => 'system-info',
				'slug'     => $slug . '#tab=system-info',
				'title'    => __( 'System Info', 'premium-addons-for-elementor' ),
				'href'     => '#tab=system-info',
				'template' => PREMIUM_ADDONS_PATH . 'admin/includes/templates/info',
			),
		);

		self::$tabs = apply_filters( 'pa_admin_register_tabs', self::$tabs );

	}

	/**
	 * Add Menu Tabs
	 *
	 * Create Submenu Page
	 *
	 * @since 3.20.9
	 * @access public
	 *
	 * @return void
	 */
	public function add_menu_tabs() {

		$plugin_name = Helper_Functions::name();

		call_user_func(
			'add_menu_page',
			$plugin_name,
			$plugin_name,
			'manage_options',
			$this->page_slug,
			array( $this, 'render_setting_tabs' ),
			'',
			100
		);

		foreach ( self::$tabs as $tab ) {

			call_user_func(
				'add_submenu_page',
				$this->page_slug,
				$tab['title'],
				$tab['title'],
				'manage_options',
				$tab['slug'],
				'__return_null'
			);
		}

		remove_submenu_page( $this->page_slug, $this->page_slug );
	}

	/**
	 * Render Setting Tabs
	 *
	 * Render the final HTML content for admin setting tabs
	 *
	 * @access public
	 * @since 3.20.8
	 */
	public function render_setting_tabs() {

		?>
		<div class="pa-settings-wrap">
			<?php do_action( 'pa_before_render_admin_tabs' ); ?>
			<div class="pa-settings-tabs">
				<ul class="pa-settings-tabs-list">
					<?php
					foreach ( self::$tabs as $key => $tab ) {
						$link          = '<li class="pa-settings-tab">';
							$link     .= '<a id="pa-tab-link-' . esc_attr( $tab['id'] ) . '"';
							$link     .= ' href="' . esc_url( $tab['href'] ) . '">';
								$link .= '<i class="pa-dash-' . esc_attr( $tab['id'] ) . '"></i>';
								$link .= '<span>' . esc_html( $tab['title'] ) . '</span>';
							$link     .= '</a>';
						$link         .= '</li>';

						echo $link;
					}
					?>
				</ul>
			</div> <!-- Settings Tabs -->

			<div class="pa-settings-sections">
				<?php
				foreach ( self::$tabs as $key => $tab ) {
					echo wp_kses_post( '<div id="pa-section-' . $tab['id'] . '" class="pa-section pa-section-' . $key . '">' );
						include_once $tab['template'] . '.php';
					echo '</div>';
				}
				?>
			</div> <!-- Settings Sections -->
			<?php do_action( 'pa_after_render_admin_tabs' ); ?>
		</div> <!-- Settings Wrap -->
		<?php
	}

	/**
	 * Render Dashboard Header
	 *
	 * @since 4.0.0
	 * @access public
	 */
	public function render_dashboard_header() {

		$url = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/pro/', 'settings-page', 'wp-dash', 'dashboard' );

		$show_logo = Helper_Functions::is_hide_logo();

		?>

		<div class="papro-admin-notice">
			<?php if ( ! $show_logo ) : ?>
				<div class="papro-admin-notice-left">
					<div class="papro-admin-notice-logo">
						<img class="pa-notice-logo" src="<?php echo esc_attr( PREMIUM_ADDONS_URL . 'admin/images/papro-notice-logo.png' ); ?>">
					</div>
					<a href="https://premiumaddons.com" target="_blank"></a>
				</div>
			<?php endif; ?>

			<?php if ( ! Helper_Functions::check_papro_version() ) : ?>
				<div class="papro-admin-notice-right">
					<div class="papro-admin-notice-info">
						<h4>
							<?php echo esc_html( __( 'Get Premium Addons PRO', 'premium-addons-for-elementor' ) ); ?>
						</h4>
						<p>
							<?php
								/* translators: %s: html tags */
								echo wp_kses_post( sprintf( __( 'Supercharge your Elementor with %1$sPRO Widgets & Addons%2$s that you won\'t find anywhere else.', 'premium-addons-for-elementor' ), '<span>', '</span>' ) );
							?>
						</p>
					</div>
					<div class="papro-admin-notice-cta">
						<a class="papro-notice-btn" href="<?php echo esc_url( $url ); ?>" target="_blank">
							<?php echo esc_html( __( 'Get PRO', 'premium-addons-for-elementor' ) ); ?>
						</a>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<?php
	}

	/**
	 * Save Settings
	 *
	 * Save elements settings using AJAX
	 *
	 * @access public
	 * @since 3.20.8
	 */
	public function save_settings() {

		check_ajax_referer( 'pa-settings-tab', 'security' );

		if ( ! isset( $_POST['fields'] ) ) {
			return;
		}

		parse_str( sanitize_text_field( $_POST['fields'] ), $settings );

		$defaults = self::get_default_elements();

		$elements = array_fill_keys( array_keys( array_intersect_key( $settings, $defaults ) ), true );

		update_option( 'pa_save_settings', $elements );

		wp_send_json_success();
	}

	/**
	 * Save Integrations Control Settings
	 *
	 * Stores integration and version control settings
	 *
	 * @since 3.20.8
	 * @access public
	 */
	public function save_additional_settings() {

		check_ajax_referer( 'pa-settings-tab', 'security' );

		if ( ! isset( $_POST['fields'] ) ) {
			return;
		}

		parse_str( sanitize_text_field( $_POST['fields'] ), $settings );

		$new_settings = array(
			'premium-map-api'         => sanitize_text_field( $settings['premium-map-api'] ),
			'premium-youtube-api'     => sanitize_text_field( $settings['premium-youtube-api'] ),
			'premium-map-disable-api' => intval( $settings['premium-map-disable-api'] ? 1 : 0 ),
			'premium-map-cluster'     => intval( $settings['premium-map-cluster'] ? 1 : 0 ),
			'premium-map-locale'      => sanitize_text_field( $settings['premium-map-locale'] ),
			'is-beta-tester'          => intval( $settings['is-beta-tester'] ? 1 : 0 ),
		);

		update_option( 'pa_maps_save_settings', $new_settings );

		wp_send_json_success( $settings );

	}

	/**
	 * Save Global Button Value
	 *
	 * Saves value for elements global switcher
	 *
	 * @since 4.0.0
	 * @access public
	 */
	public function save_global_btn_value() {

		check_ajax_referer( 'pa-settings-tab', 'security' );

		if ( ! isset( $_POST['isGlobalOn'] ) ) {
			wp_send_json_error();
		}

		$global_btn_value = sanitize_text_field( $_POST['isGlobalOn'] );

		update_option( 'pa_global_btn_value', $global_btn_value );

		wp_send_json_success();

	}

	/**
	 * Get default Elements
	 *
	 * @since 3.20.9
	 * @access private
	 *
	 * @return $default_keys array keys defaults
	 */
	private static function get_default_elements() {

		$elements = self::get_elements_list();

		$keys = array();

		// Now, we need to fill our array with elements keys.
		foreach ( $elements as $cat ) {
			if ( count( $cat['elements'] ) ) {
				foreach ( $cat['elements'] as $elem ) {
					array_push( $keys, $elem['key'] );
				}
			}
		}

		$default_keys = array_fill_keys( $keys, true );

		return $default_keys;

	}

	/**
	 * Get Pro Elements
	 *
	 * @since 4.5.3
	 * @access public
	 */
	public static function get_pro_elements() {

		$elements = self::get_elements_list();

		$pro_elements = array();

		$all_elements = $elements['cat-1'];

		if ( count( $all_elements['elements'] ) ) {
			foreach ( $all_elements['elements'] as $elem ) {
				if ( isset( $elem['is_pro'] ) && ! isset( $elem['is_global'] ) ) {
					array_push( $pro_elements, $elem );
				}
			}
		}

		return $pro_elements;

	}

	/**
	 * Get Default Interations
	 *
	 * @since 3.20.9
	 * @access private
	 *
	 * @return $default_keys array default keys
	 */
	private static function get_default_integrations() {

		$settings = self::get_integrations_list();

		$default_keys = array_fill_keys( $settings, true );

		// Beta Tester should NOT be enabled by default.
		$default_keys['is-beta-tester'] = false;

		return $default_keys;

	}

	/**
	 * Get enabled widgets
	 *
	 * @since 3.20.9
	 * @access public
	 *
	 * @return array $enabled_keys enabled elements
	 */
	public static function get_enabled_elements() {

		$defaults = self::get_default_elements();

		$enabled_keys = get_option( 'pa_save_settings', $defaults );

		foreach ( $defaults as $key => $value ) {
			if ( ! isset( $enabled_keys[ $key ] ) ) {
				$defaults[ $key ] = 0;
			}
		}

		return $defaults;

	}

	/**
	 * Check If Premium Templates is enabled
	 *
	 * @since 3.6.0
	 * @access public
	 *
	 * @return boolean
	 */
	public static function check_premium_templates() {

		$settings = self::get_enabled_elements();

		if ( ! isset( $settings['premium-templates'] ) ) {
			return true;
		}

		$is_enabled = $settings['premium-templates'];

		return $is_enabled;
	}


	/**
	 * Check If Premium Duplicator is enabled
	 *
	 * @since 3.20.9
	 * @access public
	 *
	 * @return boolean
	 */
	public static function check_duplicator() {

		$settings = self::get_enabled_elements();

		if ( ! isset( $settings['premium-duplicator'] ) ) {
			return true;
		}

		$is_enabled = $settings['premium-duplicator'];

		return $is_enabled;
	}

	/**
	 * Get Integrations Settings
	 *
	 * Get plugin integrations settings
	 *
	 * @since 3.20.9
	 * @access public
	 *
	 * @return array $settings integrations settings
	 */
	public static function get_integrations_settings() {

		$enabled_keys = get_option( 'pa_maps_save_settings', self::get_default_integrations() );

		return $enabled_keys;

	}

	/**
	 * Run PA Rollback
	 *
	 * Trigger PA Rollback actions
	 *
	 * @since 4.2.5
	 * @access public
	 */
	public function run_pa_rollback() {

		check_admin_referer( 'premium_addons_rollback' );

		$plugin_slug = basename( PREMIUM_ADDONS_FILE, '.php' );

		$pa_rollback = new PA_Rollback(
			array(
				'version'     => PREMIUM_ADDONS_STABLE_VERSION,
				'plugin_name' => PREMIUM_ADDONS_BASENAME,
				'plugin_slug' => $plugin_slug,
				'package_url' => sprintf( 'https://downloads.wordpress.org/plugin/%s.%s.zip', $plugin_slug, PREMIUM_ADDONS_STABLE_VERSION ),
			)
		);

		$pa_rollback->run();

		wp_die(
			'',
			esc_html( __( 'Rollback to Previous Version', 'premium-addons-for-elementor' ) ),
			array(
				'response' => 200,
			)
		);

	}

	/**
	 * Disable unused widgets.
	 *
	 * @access public
	 * @since 4.5.8
	 */
	public function get_unused_widgets() {

		check_ajax_referer( 'pa-settings-tab', 'security' );

		if ( ! current_user_can( 'install_plugins' ) ) {
			wp_send_json_error();
		}

		$pa_elements = self::get_pa_elements_names();

		$used_widgets = self::get_used_widgets();

		$unused_widgets = array_diff( $pa_elements, array_keys( $used_widgets ) );

		wp_send_json_success( $unused_widgets );

	}

	/**
	 * Get PA widget names.
	 *
	 * @access public
	 * @since 4.5.8
	 *
	 * @return array
	 */
	public static function get_pa_elements_names() {

		$names = self::$elements_names;

		if ( null === $names ) {

			$names = array_map(
				function( $item ) {
					return isset( $item['name'] ) ? $item['name'] : 'global';
				},
				self::get_elements_list()['cat-1']['elements']
			);

			$names = array_filter(
				$names,
				function( $name ) {
					return 'global' !== $name;
				}
			);

		}

		return $names;
	}

	/**
	 * Get used widgets.
	 *
	 * @access public
	 * @since 4.5.8
	 *
	 * @return array
	 */
	public static function get_used_widgets() {

		$used_widgets = array();

		if ( ! \Elementor\Tracker::is_allow_track() ) {
			return false;
		}

		if ( class_exists( 'Elementor\Modules\Usage\Module' ) ) {

			$module   = Module::instance();
			$elements = $module->get_formatted_usage( 'raw' );

			$pa_elements = self::get_pa_elements_names();

			if ( is_array( $elements ) || is_object( $elements ) ) {

				foreach ( $elements as $post_type => $data ) {

					foreach ( $data['elements'] as $element => $count ) {

						if ( in_array( $element, $pa_elements, true ) ) {

							if ( isset( $used_widgets[ $element ] ) ) {
								$used_widgets[ $element ] += $count;
							} else {
								$used_widgets[ $element ] = $count;
							}
						}
					}
				}
			}
		}

		return $used_widgets;
	}

	/**
	 * Subscribe Newsletter
	 *
	 * Adds an email to Premium Addons subscribers list
	 *
	 * @since 4.7.0
	 *
	 * @access public
	 */
	public function subscribe_newsletter() {

		check_ajax_referer( 'pa-settings-tab', 'security' );

		if ( ! self::check_user_can( 'manage_options' ) ) {
			wp_send_json_error();
		}

		$email = isset( $_POST['email'] ) ? $_POST['email'] : '';

		$api_url = 'https://premiumaddons.com/wp-json/mailchimp/v2/add';

		$request = add_query_arg(
			array(
				'email' => $email,
			),
			$api_url
		);

		$response = wp_remote_get(
			$request,
			array(
				'timeout'   => 60,
				'sslverify' => true,
			)
		);

		$body = wp_remote_retrieve_body( $response );
		$body = json_decode( $body, true );

		wp_send_json_success( $body );

	}

	/**
	 * Get PA News
	 *
	 * Gets a list of the latest three blog posts
	 *
	 * @since 4.7.0
	 *
	 * @access public
	 */
	public function get_pa_news() {

		$posts = get_transient( 'pa_news' );

		if ( empty( $posts ) ) {

			$api_url = 'https://premiumaddons.com/wp-json/wp/v2/posts';

			$request = add_query_arg(
				array(
					'per_page' => 3,
				),
				$api_url
			);

			$response = wp_remote_get(
				$request,
				array(
					'timeout'   => 60,
					'sslverify' => true,
				)
			);

			$body  = wp_remote_retrieve_body( $response );
			$posts = json_decode( $body, true );

			set_transient( 'pa_news', $posts, WEEK_IN_SECONDS );

		}

		return $posts;

	}

	/**
	 * Creates and returns an instance of the class
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return object
	 */
	public static function get_instance() {

		if ( ! isset( self::$instance ) ) {

			self::$instance = new self();

		}

		return self::$instance;
	}
}
