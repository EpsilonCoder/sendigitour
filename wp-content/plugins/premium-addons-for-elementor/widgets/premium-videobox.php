<?php
/**
 * Premium Video Box.
 */

namespace PremiumAddons\Widgets;

// Elementor Classes.
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Elementor\Widget_Base;
use Elementor\Utils;
use Elementor\Embed;
use Elementor\Icons_Manager;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;

// PremiumAddons Classes.
use PremiumAddons\Admin\Includes\Admin_Helper;
use PremiumAddons\Includes\Helper_Functions;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // If this file is called directly, abort.
}

/**
 * Class Premium_Videobox
 */
class Premium_Videobox extends Widget_Base {

	/**
	 * Retrieve Widget Name.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_name() {
		return 'premium-addon-video-box';
	}

	/**
	 * Retrieve Widget Title.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function get_title() {
		return sprintf( '%1$s %2$s', Helper_Functions::get_prefix(), __( 'Video Box', 'premium-addons-for-elementor' ) );
	}

	/**
	 * Retrieve Widget Icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string widget icon.
	 */
	public function get_icon() {
		return 'pa-video-box';
	}

	/**
	 * Retrieve Widget Categories.
	 *
	 * @since 1.5.1
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'premium-elements' );
	}

	/**
	 * Retrieve Widget Dependent CSS.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array CSS style handles.
	 */
	public function get_style_depends() {
		return array(
			'premium-addons',
		);
	}

	/**
	 * Retrieve Widget Dependent JS.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array JS script handles.
	 */
	public function get_script_depends() {
		return array(
			'elementor-waypoints',
			'premium-addons',
		);
	}

	/**
	 * Retrieve Widget Keywords.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget keywords.
	 */
	public function get_keywords() {
		return array( 'youtube', 'vimeo', 'self', 'hosted', 'media', 'list', 'embed' );
	}

	/**
	 * Retrieve Widget Support URL.
	 *
	 * @access public
	 *
	 * @return string support URL.
	 */
	public function get_custom_help_url() {
		return 'https://premiumaddons.com/support/';
	}

	/**
	 * Register Video Box controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() { // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore

		$this->start_controls_section(
			'premium_video_box_general_settings',
			array(
				'label' => __( 'Video Box', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'premium_video_box_video_type',
			array(
				'label'              => __( 'Video Type', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'youtube',
				'options'            => array(
					'youtube' => __( 'Youtube', 'premium-addons-for-elementor' ),
					'vimeo'   => __( 'Vimeo', 'premium-addons-for-elementor' ),
					'self'    => __( 'Self Hosted', 'premium-addons-for-elementor' ),
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'premium_video_box_video_id_embed_selection',
			array(
				'label'     => __( 'Link', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HIDDEN,
				'default'   => 'id',
				'options'   => array(
					'id'    => __( 'ID', 'premium-addons-for-elementor' ),
					'embed' => __( 'Embed URL', 'premium-addons-for-elementor' ),
				),
				'condition' => array(
					'premium_video_box_video_type!' => 'self',
				),
			)
		);

		$this->add_control(
			'premium_video_box_video_id',
			array(
				'label'       => __( 'Video ID', 'premium-addons-for-elementor' ),
				'description' => __( 'Enter the numbers and letters after the equal sign which located in your YouTube video link or after the slash sign in your Vimeo video link. For example, z1hQgVpfTKU', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::HIDDEN,
				'condition'   => array(
					'premium_video_box_video_type!' => 'self',
					'premium_video_box_video_id_embed_selection' => 'id',
				),
			)
		);

		$this->add_control(
			'premium_video_box_video_embed',
			array(
				'label'       => __( 'Embed URL', 'premium-addons-for-elementor' ),
				'description' => __( 'Enter your YouTube/Vimeo video link. For example, https://www.youtube.com/embed/z1hQgVpfTKU', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::HIDDEN,
				'condition'   => array(
					'premium_video_box_video_type!' => 'self',
					'premium_video_box_video_id_embed_selection' => 'embed',
				),
			)
		);

		$this->add_control(
			'youtube_list',
			array(
				'label'     => __( 'Get Videos From Channel/Playlist', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_responsive_control(
			'source',
			array(
				'label'     => __( 'Source', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'playlist' => __( 'Playlist', 'premium-addons-for-elementor' ),
					'channel'  => __( 'Channel', 'premium-addons-for-elementor' ),
				),
				'default'   => 'playlist',
				'condition' => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
			)
		);

		$this->add_control(
			'playlist_id',
			array(
				'label'       => __( 'Playlist ID', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'PLLpZVOYpMtTArB4hrlpSnDJB36D2sdoTv',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Click <a href="https://premiumaddons.com/docs/how-to-find-youtube-channel-playlist-id/" target="_blank">here</a> to get your playlist ID',
				'condition'   => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
					'source'                       => 'playlist',
				),
			)
		);

		$this->add_control(
			'channel_id',
			array(
				'label'       => __( 'Channel ID', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'UCXcJ9BeO2sKKHor7Q9VglTQ',
				'label_block' => true,
				'dynamic'     => array( 'active' => true ),
				'description' => 'Click <a href="https://premiumaddons.com/docs/how-to-find-youtube-channel-playlist-id/" target="_blank">here</a> to get your channel ID',
				'condition'   => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
					'source'                       => 'channel',
				),
			)
		);

		$this->add_control(
			'reload',
			array(
				'label'     => __( 'Reload Video Once Every', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'hour'  => __( 'Hour', 'premium-addons-for-elementor' ),
					'day'   => __( 'Day', 'premium-addons-for-elementor' ),
					'week'  => __( 'Week', 'premium-addons-for-elementor' ),
					'month' => __( 'Month', 'premium-addons-for-elementor' ),
					'year'  => __( 'Year', 'premium-addons-for-elementor' ),
				),
				'default'   => 'day',
				'condition' => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
			)
		);

		$this->add_control(
			'youtube_videos_title',
			array(
				'label'     => __( 'Show Video Title', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'premium-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'premium-addons-for-elementor' ),
				'condition' => array(
					'youtube_list'                 => 'yes',
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'youtube_videos_title_link',
			array(
				'label'     => __( 'Link Title To Videos', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'youtube_list'                 => 'yes',
					'youtube_videos_title'         => 'yes',
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'youtube_videos_title_tag',
			array(
				'label'       => __( 'Title HTML Tag', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'h4',
				'options'     => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'span' => 'Span',
					'p'    => 'P',
				),
				'label_block' => true,
				'condition'   => array(
					'youtube_list'                 => 'yes',
					'youtube_videos_title'         => 'yes',
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'youtube_videos_title_pos',
			array(
				'label'     => __( 'Title Position', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'column',
				'options'   => array(
					'column-reverse' => __( 'Top', 'premium-addons-for-elementor' ),
					'column'         => __( 'Bottom', 'premium-addons-for-elementor' ),
				),
				'condition' => array(
					'youtube_list'                 => 'yes',
					'youtube_videos_title'         => 'yes',
					'premium_video_box_video_type' => 'youtube',
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-container' => 'flex-direction: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'premium_video_box_link',
			array(
				'label'       => __( 'Link', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'https://www.youtube.com/watch?v=07d2dXHYb94',
				'dynamic'     => array(
					'active'     => true,
					'categories' => array(
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					),
				),
				'conditions'  => array(
					'relation' => 'or',
					'terms'    => array(
						array(
							'name'  => 'premium_video_box_video_type',
							'value' => 'vimeo',
						),
						array(
							'relation' => 'and',
							'terms'    => array(
								array(
									'name'  => 'premium_video_box_video_type',
									'value' => 'youtube',
								),
								array(
									'name'  => 'youtube_list',
									'value' => '',
								),
							),
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'video_columns',
			array(
				'label'           => __( 'Videos/Row', 'premium-addons-for-elementor' ),
				'type'            => Controls_Manager::SELECT,
				'options'         => array(
					'100%'    => __( '1 Column', 'premium-addons-for-elementor' ),
					'50%'     => __( '2 Columns', 'premium-addons-for-elementor' ),
					'33.33%'  => __( '3 Columns', 'premium-addons-for-elementor' ),
					'25%'     => __( '4 Columns', 'premium-addons-for-elementor' ),
					'20%'     => __( '5 Columns', 'premium-addons-for-elementor' ),
					'16.667%' => __( '6 Columns', 'premium-addons-for-elementor' ),
				),
				'desktop_default' => '50%',
				'tablet_default'  => '50%',
				'mobile_default'  => '100%',
				'render_type'     => 'template',
				'separator'       => 'before',
				'selectors'       => array(
					'{{WRAPPER}} .premium-video-box-container' => 'width: {{VALUE}}',
				),
				'condition'       => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
			)
		);

		$this->add_control(
			'limit_num',
			array(
				'label'       => __( 'Number of Videos', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'min'         => 0,
				'default'     => 6,
				'description' => __( 'Set a number of videos to retrieve', 'premium-addons-for-elementor' ),
				'condition'   => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
			)
		);

		$this->add_control(
			'featured_video',
			array(
				'label'     => __( 'Featured The First Video', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-container:first-of-type' => 'width: 100%',
				),
			)
		);

		$this->add_control(
			'premium_video_box_self_hosted',
			array(
				'label'      => __( 'URL', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::MEDIA,
				'dynamic'    => array(
					'active'     => true,
					'categories' => array(
						TagsModule::MEDIA_CATEGORY,
					),
				),
				'media_type' => 'video',
				'condition'  => array(
					'premium_video_box_video_type' => 'self',
				),
			)
		);

		$this->add_control(
			'premium_video_box_self_hosted_remote',
			array(
				'label'       => __( 'Remote Video URL', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'label_block' => true,
				'condition'   => array(
					'premium_video_box_video_type' => 'self',
				),
			)
		);

		$playlist_condition = array(
			'relation' => 'or',
			'terms'    => array(
				array(
					'name'     => 'premium_video_box_video_type',
					'operator' => '!==',
					'value'    => 'youtube',
				),
				array(
					'name'  => 'youtube_list',
					'value' => '',
				),
			),
		);

		$this->add_control(
			'premium_video_box_controls',
			array(
				'label'       => __( 'Player Controls', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'Show/hide player controls', 'premium-addons-for-elementor' ),
				'default'     => 'yes',
				'conditions'  => array(
					'terms' => array(
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'premium_video_box_mute',
			array(
				'label'       => __( 'Mute', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'This will play the video muted', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'privacy_mode',
			array(
				'label'       => __( 'Privacy Mode', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'description' => __( 'When turned on, YouTube won\'t store information about visitors on your website unless they play the video.', 'premium-addons-for-elementor' ),
				'condition'   => array(
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'premium_video_box_self_autoplay',
			array(
				'label'      => __( 'Autoplay', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => array(
					'terms' => array(
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'autoplay_viewport',
			array(
				'label'      => __( 'Autoplay On Viewport', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => array(
					'terms' => array(
						array(
							'name'  => 'premium_video_box_self_autoplay',
							'value' => 'yes',
						),
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'autoplay_notice',
			array(
				'raw'             => __( 'Please note that autoplay option works only when Overlay option is disabled', 'premium-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				'conditions'      => array(
					'terms' => array(
						array(
							'name'  => 'premium_video_box_self_autoplay',
							'value' => 'yes',
						),
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'premium_video_box_loop',
			array(
				'label'     => __( 'Loop', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'youtube_list!' => 'yes',
				),
			)
		);

		$this->add_control(
			'download_button',
			array(
				'label'     => __( 'Download Button', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'condition' => array(
					'premium_video_box_video_type' => 'self',
				),
			)
		);

		$this->add_control(
			'premium_video_box_sticky_switcher',
			array(
				'label'       => __( 'Sticky', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'separator'   => 'before',
				'conditions'  => array(
					'terms' => array(
						$playlist_condition,
					),
				),
			)
		);

		$sticky_condition = array(
			'terms' => array(
				array(
					'name'  => 'premium_video_box_sticky_switcher',
					'value' => 'yes',
				),
				$playlist_condition,
			),
		);

		$this->add_control(
			'premium_video_box_sticky_on_play',
			array(
				'label'       => __( 'Sticky Only After Played', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SWITCHER,
				'render_type' => 'template',
				'conditions'  => array(
					'terms' => array(
						$sticky_condition,
					),
				),
			)
		);

		$left_direction = is_rtl() ? 'right' : 'left';

		$right_direction = is_rtl() ? 'left' : 'right';

		$this->add_control(
			'premium_video_box_sticky_position',
			array(
				'label'        => __( 'Position', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'top-left'     => sprintf( __( 'Top %s', 'premium-addons-for-elementor' ), ucfirst( $left_direction ) ),
					'top-right'    => sprintf( __( 'Top %s', 'premium-addons-for-elementor' ), ucfirst( $right_direction ) ),
					'bottom-left'  => sprintf( __( 'Bottom %s', 'premium-addons-for-elementor' ), ucfirst( $left_direction ) ),
					'bottom-right' => sprintf( __( 'Bottom %s', 'premium-addons-for-elementor' ), ucfirst( $right_direction ) ),
					'center-left'  => sprintf( __( 'Center %s', 'premium-addons-for-elementor' ), ucfirst( $left_direction ) ),
					'center-right' => sprintf( __( 'Center %s', 'premium-addons-for-elementor' ), ucfirst( $right_direction ) ),
				),
				'default'      => 'bottom-left',
				'conditions'   => $sticky_condition,
				'prefix_class' => 'premium-video-sticky-',
				'render_type'  => 'template',
			)
		);

		$this->add_control(
			'premium_video_box_sticky_hide',
			array(
				'label'              => __( 'Disable Sticky On', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SELECT2,
				'multiple'           => true,
				'label_block'        => true,
				'options'            => array(
					'desktop' => __( 'Desktop', 'premium-addons-for-elementor' ),
					'tablet'  => __( 'Tablet', 'premium-addons-for-elementor' ),
					'mobile'  => __( 'Mobile', 'premium-addons-for-elementor' ),
				),
				'conditions'         => $sticky_condition,
				'render_type'        => 'template',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'premium_video_box_animation',
			array(
				'label'              => __( 'Entrance Animation', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::ANIMATION,
				'label_block'        => true,
				'frontend_available' => true,
				'render_type'        => 'template',
				'conditions'         => $sticky_condition,
			)
		);

		$this->add_control(
			'premium_video_box_animation_duration',
			array(
				'label'      => __( 'Animation Duration', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SELECT,
				'default'    => '',
				'options'    => array(
					'slow' => __( 'Slow', 'premium-addons-for-elementor' ),
					''     => __( 'Normal', 'premium-addons-for-elementor' ),
					'fast' => __( 'Fast', 'premium-addons-for-elementor' ),
				),
				'conditions' => array(
					'terms' => array(
						array(
							'name'     => 'premium_video_box_animation',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'name'  => 'premium_video_box_sticky_switcher',
							'value' => 'yes',
						),
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'premium_video_box_animation_delay',
			array(
				'label'              => __( 'Animation Delay', 'premium-addons-for-elementor' ) . ' (s)',
				'type'               => Controls_Manager::NUMBER,
				'default'            => '',
				'step'               => 0.1,
				'conditions'         => array(
					'terms' => array(
						array(
							'name'     => 'premium_video_box_animation',
							'operator' => '!==',
							'value'    => '',
						),
						array(
							'name'  => 'premium_video_box_sticky_switcher',
							'value' => 'yes',
						),
						$playlist_condition,
					),
				),
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'sticky_info_bar_switch',
			array(
				'label'      => __( 'Info Section', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'conditions' => $sticky_condition,
			)
		);

		$this->add_control(
			'sticky_info_bar_text',
			array(
				'label'      => __( 'Text', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::TEXTAREA,
				'default'    => __( 'Watching: Sticky Video', 'premium-addons-for-elementor' ),
				'rows'       => 2,
				'dynamic'    => array(
					'active' => true,
				),
				'conditions' =>
					array(
						'terms' => array(
							array(
								'name'  => 'premium_video_box_sticky_switcher',
								'value' => 'yes',
							),
							array(
								'name'  => 'sticky_info_bar_switch',
								'value' => 'yes',
							),
							$playlist_condition,
						),
					),
			)
		);

		$this->add_control(
			'premium_video_box_start',
			array(
				'label'       => __( 'Start Time', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'separator'   => 'before',
				'dynamic'     => array(
					'active' => true,
				),
				'description' => __( 'Specify a start time (in seconds)', 'premium-addons-for-elementor' ),
				'condition'   => array(
					'premium_video_box_video_type!' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'premium_video_box_end',
			array(
				'label'       => __( 'End Time', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Specify an end time (in seconds)', 'premium-addons-for-elementor' ),
				'separator'   => 'after',
				'dynamic'     => array(
					'active' => true,
				),
				'condition'   => array(
					'premium_video_box_video_type!' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'premium_video_box_suggested_videos',
			array(
				'label'     => __( 'Suggested Videos From', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					''    => __( 'Current Channel', 'premium-addons-for-elementor' ),
					'yes' => __( 'Any Channel', 'premium-addons-for-elementor' ),
				),
				'condition' => array(
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_control(
			'vimeo_controls_color',
			array(
				'label'       => __( 'Controls Color', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::COLOR,
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-vimeo-title a, {{WRAPPER}} .premium-video-box-vimeo-byline a, {{WRAPPER}} .premium-video-box-vimeo-title a:hover, {{WRAPPER}} .premium-video-box-vimeo-byline a:hover, {{WRAPPER}} .premium-video-box-vimeo-title a:focus, {{WRAPPER}} .premium-video-box-vimeo-byline a:focus' => 'color: {{VALUE}}',
				),
				'render_type' => 'template',
				'condition'   => array(
					'premium_video_box_video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_title',
			array(
				'label'     => __( 'Intro Title', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'premium-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'premium-addons-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'premium_video_box_video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_portrait',
			array(
				'label'     => __( 'Intro Portrait', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'premium-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'premium-addons-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'premium_video_box_video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'vimeo_byline',
			array(
				'label'     => __( 'Intro Byline', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Show', 'premium-addons-for-elementor' ),
				'label_off' => __( 'Hide', 'premium-addons-for-elementor' ),
				'default'   => 'yes',
				'condition' => array(
					'premium_video_box_video_type' => 'vimeo',
				),
			)
		);

		$this->add_control(
			'aspect_ratio',
			array(
				'label'              => __( 'Aspect Ratio', 'premium-addons-for-elementor' ),
				'type'               => Controls_Manager::SELECT,
				'options'            => array(
					'11'  => '1:1',
					'169' => '16:9',
					'43'  => '4:3',
					'32'  => '3:2',
					'219' => '21:9',
					'916' => '9:16',
				),
				'default'            => '169',
				'prefix_class'       => 'pa-aspect-ratio-',
				'frontend_available' => true,
			)
		);

		$this->add_responsive_control(
			'premium_video_box_video_height',
			array(
				'label'       => __( 'Video Height (%)', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'render_type' => 'template',
				'condition'   => array(
					'youtube_list'                 => 'yes',
					'premium_video_box_video_type' => 'youtube',
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-container > div' => 'padding-bottom: {{SIZE}}%;',
				),

			)
		);

		$this->add_control(
			'premium_video_box_image_switcher',
			array(
				'label'      => __( 'Overlay', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SWITCHER,
				'default'    => 'yes',
				'conditions' => array(
					'terms' => array(
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'premium_video_box_yt_thumbnail_size',
			array(
				'label'       => __( 'Thumbnail Size', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'maxresdefault' => __( 'Maximum Resolution', 'premium-addons-for-elementor' ),
					'hqdefault'     => __( 'High Quality', 'premium-addons-for-elementor' ),
					'mqdefault'     => __( 'Medium Quality', 'premium-addons-for-elementor' ),
					'sddefault'     => __( 'Standard Quality', 'premium-addons-for-elementor' ),
				),
				'default'     => 'maxresdefault',
				'conditions'  => array(
					'terms' => array(
						array(
							'name'  => 'premium_video_box_video_type',
							'value' => 'youtube',
						),
						array(
							'relation' => 'or',
							'terms'    => array(
								array(
									'name'  => 'premium_video_box_image_switcher',
									'value' => '',
								),
								array(
									'name'  => 'youtube_list',
									'value' => 'yes',
								),
							),
						),
					),
				),
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'premium_video_box_img_effect',
			array(
				'label'       => __( 'Hover Effect', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SELECT,
				'description' => __( 'Choose a hover effect for the image', 'premium-addons-for-elementor' ),
				'options'     => array(
					'none'    => __( 'None', 'premium-addons-for-elementor' ),
					'zoomin'  => __( 'Zoom In', 'premium-addons-for-elementor' ),
					'zoomout' => __( 'Zoom Out', 'premium-addons-for-elementor' ),
					'scale'   => __( 'Scale', 'premium-addons-for-elementor' ),
					'gray'    => __( 'Grayscale', 'premium-addons-for-elementor' ),
					'blur'    => __( 'Blur', 'premium-addons-for-elementor' ),
					'bright'  => __( 'Bright', 'premium-addons-for-elementor' ),
					'sepia'   => __( 'Sepia', 'premium-addons-for-elementor' ),
					'trans'   => __( 'Translate', 'premium-addons-for-elementor' ),
				),
				'default'     => 'none',
				'label_block' => true,
			)
		);

		$this->add_control(
			'mask_video_box_switcher',
			array(
				'label'     => esc_html__( 'Mask Video Shape', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SWITCHER,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'mask_shape_video_box',
			array(
				'label'       => esc_html__( 'Mask Image', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'default'     => array(
					'url' => '',
				),
				'description' => __( 'Use PNG image with the shape you want to mask around feature video.', 'premium-addons-for-elementor' ),
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-mask-media ' => 'mask-image: url("{{URL}}");-webkit-mask-image: url("{{URL}}")',
				),
				'condition'   => array(
					'mask_video_box_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'mask_size',
			array(
				'label'     => __( 'Mask Size', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'contain' => __( 'Contain', 'premium-addons-for-elementor' ),
					'cover'   => __( 'Cover', 'premium-addons-for-elementor' ),
				),
				'default'   => 'contain',
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-mask-media' => 'mask-size: {{VALUE}};-webkit-mask-size: {{VALUE}};',
				),
				'condition' => array(
					'mask_video_box_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'mask_position_cover',
			array(
				'label'     => __( 'Mask Position', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => __( 'Center Center', 'premium-addons-for-elementor' ),
					'center left'   => __( 'Center Left', 'premium-addons-for-elementor' ),
					'center right'  => __( 'Center Right', 'premium-addons-for-elementor' ),
					'top center'    => __( 'Top Center', 'premium-addons-for-elementor' ),
					'top left'      => __( 'Top Left', 'premium-addons-for-elementor' ),
					'top right'     => __( 'Top Right', 'premium-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'premium-addons-for-elementor' ),
					'bottom left'   => __( 'Bottom Left', 'premium-addons-for-elementor' ),
					'bottom right'  => __( 'Bottom Right', 'premium-addons-for-elementor' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-mask-media' => 'mask-position: {{VALUE}}; -webkit-mask-position: {{VALUE}}',
				),
				'condition' => array(
					'mask_video_box_switcher' => 'yes',
					'mask_size'               => 'cover',
				),
			)
		);

		$this->add_control(
			'mask_position_contain',
			array(
				'label'     => __( 'Mask Position', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'center center' => __( 'Center Center', 'premium-addons-for-elementor' ),
					'top center'    => __( 'Top Center', 'premium-addons-for-elementor' ),
					'bottom center' => __( 'Bottom Center', 'premium-addons-for-elementor' ),
				),
				'default'   => 'center center',
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-mask-media' => 'mask-position: {{VALUE}}; -webkit-mask-position: {{VALUE}}',
				),
				'condition' => array(
					'mask_video_box_switcher' => 'yes',
					'mask_size'               => 'contain',
				),
			)
		);

		$this->add_control(
			'video_box_shadow',
			array(
				'label'        => __( 'Mask Shadow', 'premium-addons-for-elementor' ),
				'type'         => Controls_Manager::POPOVER_TOGGLE,
				'condition'    => array(
					'mask_video_box_switcher' => 'yes',
				),
				'return_value' => 'yes',
				'render_type'  => 'template',
			)
		);

		$this->start_popover();

		$this->add_control(
			'video_box_shadow_color',
			array(
				'label'   => __( 'Color', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::COLOR,
				'default' => 'rgba(0,0,0,0.5)',
			)
		);

		$this->add_control(
			'video_box_shadow_h',
			array(
				'label'   => __( 'Horizontal', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default' => array(
					'size' => 0,
					'unit' => 'px',
				),
			)
		);

		$this->add_control(
			'video_box_shadow_v',
			array(
				'label'   => __( 'Vertical', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default' => array(
					'size' => 0,
					'unit' => 'px',
				),
			)
		);

		$this->add_control(
			'video_box_shadow_blur',
			array(
				'label'     => __( 'Blur', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'   => array(
					'size' => 10,
					'unit' => 'px',
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-mask-filter' => 'filter: drop-shadow({{video_box_shadow_h.SIZE}}px {{video_box_shadow_v.SIZE}}px {{SIZE}}px {{video_box_shadow_color.VALUE}})',
				),
			)
		);

		$this->end_popover();

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_image_settings',
			array(
				'label'      => __( 'Overlay', 'premium-addons-for-elementor' ),
				'conditions' => array(
					'terms' => array(
						array(
							'name'  => 'premium_video_box_image_switcher',
							'value' => 'yes',
						),
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'premium_video_box_image',
			array(
				'label'       => __( 'Image', 'premium-addons-for-elementor' ),
				'description' => __( 'Choose an image for the video box', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::MEDIA,
				'dynamic'     => array( 'active' => true ),
				'default'     => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'label_block' => true,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_play_icon_settings',
			array(
				'label' => __( 'Play Icon', 'premium-addons-for-elementor' ),
			)
		);

		$this->add_control(
			'premium_video_box_play_icon_switcher',
			array(
				'label'   => __( 'Play Icon', 'premium-addons-for-elementor' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->add_responsive_control(
			'premium_video_box_icon_hor_position',
			array(
				'label'       => __( 'Horizontal Position', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', '%' ),
				'label_block' => true,
				'default'     => array(
					'size' => 50,
					'unit' => '%',
				),
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition'   => array(
					'premium_video_box_play_icon_switcher' => 'yes',
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-play-icon-container' => $left_direction . ': {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_box_icon_ver_position',
			array(
				'label'       => __( 'Vertical Position', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', '%' ),
				'label_block' => true,
				'default'     => array(
					'size' => 50,
					'unit' => '%',
				),
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition'   => array(
					'premium_video_box_play_icon_switcher' => 'yes',
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-play-icon-container' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_description_text_section',
			array(
				'label'      => __( 'Description', 'premium-addons-for-elementor' ),
				'conditions' => array(
					'terms' => array(
						$playlist_condition,
					),
				),
			)
		);

		$this->add_control(
			'premium_video_box_video_text_switcher',
			array(
				'label' => __( 'Video Text', 'premium-addons-for-elementor' ),
				'type'  => Controls_Manager::SWITCHER,
			)
		);

		$this->add_control(
			'premium_video_box_description_text',
			array(
				'label'       => __( 'Text', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::TEXTAREA,
				'default'     => __( 'Play Video', 'premium-addons-for-elementor' ),
				'condition'   => array(
					'premium_video_box_video_text_switcher' => 'yes',
				),
				'dynamic'     => array( 'active' => true ),
				'label_block' => true,
			)
		);

		$this->add_responsive_control(
			'premium_video_box_description_hor_position',
			array(
				'label'       => __( 'Horizontal Position', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', '%' ),
				'label_block' => true,
				'default'     => array(
					'size' => 50,
					'unit' => '%',
				),
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition'   => array(
					'premium_video_box_video_text_switcher' => 'yes',
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-description-container' => $left_direction . ': {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_box_description_ver_position',
			array(
				'label'       => __( 'Vertical Position', 'premium-addons-for-elementor' ),
				'type'        => Controls_Manager::SLIDER,
				'size_units'  => array( 'px', 'em', '%' ),
				'label_block' => true,
				'default'     => array(
					'size' => 60,
					'unit' => '%',
				),
				'range'       => array(
					'px' => array(
						'min' => 1,
						'max' => 500,
					),
					'em' => array(
						'min' => 1,
						'max' => 50,
					),
				),
				'condition'   => array(
					'premium_video_box_video_text_switcher' => 'yes',
				),
				'selectors'   => array(
					'{{WRAPPER}} .premium-video-box-description-container' => 'top: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_pa_docs',
			array(
				'label' => __( 'Helpful Documentations', 'premium-addons-for-elementor' ),
			)
		);

		$docs = array(
			'https://premiumaddons.com/docs/video-box-widget-tutorial/' => __( 'Getting started »', 'premium-addons-for-elementor' ),
			'https://premiumaddons.com/docs/how-to-enable-youtube-data-api-for-premium-video-box-widget/' => __( 'How to Enable Youtube Data API for Premium Video Box Widget »', 'premium-addons-for-elementor' ),
			'https://premiumaddons.com/docs/how-to-find-youtube-channel-playlist-id/' => __( 'How to Find Youtube Channel/Playlist ID »', 'premium-addons-for-elementor' ),
		);

		$doc_index = 1;
		foreach ( $docs as $url => $title ) {

			$doc_url = Helper_Functions::get_campaign_link( $url, 'editor-page', 'wp-editor', 'get-support' );

			$this->add_control(
				'doc_' . $doc_index,
				array(
					'type'            => Controls_Manager::RAW_HTML,
					'raw'             => sprintf( '<a href="%s" target="_blank">%s</a>', $doc_url, $title ),
					'content_classes' => 'editor-pa-doc',
				)
			);

			$doc_index++;

		}

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_text_style_section',
			array(
				'label' => __( 'Video Box', 'premium-addons-for-elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .premium-video-box-image-container, {{WRAPPER}} .premium-video-box-video-container',
			)
		);

		// Border Radius Properties sepearated for responsive issues.
		$this->add_responsive_control(
			'premium_video_box_image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-image-container, {{WRAPPER}} .premium-video-box-video-container'  => 'border-top-left-radius: {{SIZE}}{{UNIT}}; border-top-right-radius: {{SIZE}}{{UNIT}}; border-bottom-left-radius: {{SIZE}}{{UNIT}}; border-bottom-right-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .premium-video-box-video-container',
			)
		);

		$this->add_control(
			'image_shadow_notice',
			array(
				'raw'             => __( 'Please note that in case Sticky and Mask Shape options are both enabled, image shadow will be applied only on sticky overlay image', 'premium-addons-for-elementor' ),
				'type'            => Controls_Manager::RAW_HTML,
				'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
			)
		);

		$this->add_responsive_control(
			'columns_spacing',
			array(
				'label'      => __( 'Rows Spacing', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 200,
					),
				),
				'default'    => array(
					'size' => 5,
					'unit' => 'px',
				),
				'condition'  => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-container' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'premium_blog_posts_spacing',
			array(
				'label'     => __( 'Columns Spacing', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 5,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-container' => 'padding-right: calc( {{SIZE}}{{UNIT}}/2 ); padding-left: calc( {{SIZE}}{{UNIT}}/2 )',
					'{{WRAPPER}} .premium-video-box-playlist-container' => 'margin-left: calc( -{{SIZE}}{{UNIT}}/2 ); margin-right: calc( -{{SIZE}}{{UNIT}}/2 );',
				),
				'condition' => array(
					'premium_video_box_video_type' => 'youtube',
					'youtube_list'                 => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_icon_style',
			array(
				'label'     => __( 'Play Icon', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'premium_video_box_play_icon_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_video_box_play_icon_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-play-icon'  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'premium_video_box_play_icon_color_hover',
			array(
				'label'     => __( 'Hover Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-play-icon-container:hover .premium-video-box-play-icon'  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'premium_video_box_play_icon_size',
			array(
				'label'      => __( 'Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => 30,
				),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-play-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'premium_video_box_play_icon_background_color',
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .premium-video-box-play-icon-container',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'icon_border',
				'selector' => '{{WRAPPER}} .premium-video-box-play-icon-container',
			)
		);

		$this->add_control(
			'premium_video_box_icon_border_radius',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'unit' => 'px',
					'size' => 100,
				),
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-play-icon-container'  => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_box_icon_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'top'    => 20,
					'right'  => 20,
					'bottom' => 20,
					'left'   => 20,
					'unit'   => 'px',
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-play-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_box_icon_padding_hover',
			array(
				'label'      => __( 'Hover Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-play-icon:hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_text_style',
			array(
				'label'      => __( 'Video Text', 'premium-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' =>
					array(
						'terms' => array(
							array(
								'name'  => 'premium_video_box_video_text_switcher',
								'value' => 'yes',
							),
							$playlist_condition,
						),
					),
			)
		);

		$this->add_control(
			'premium_video_box_text_color',
			array(
				'label'     => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-text' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'premium_video_box_text_color_hover',
			array(
				'label'     => __( 'Hover Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-description-container:hover .premium-video-box-text'   => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'global'   => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector' => '{{WRAPPER}} .premium-video-box-text',
			)
		);

		$this->add_control(
			'premium_video_box_text_background_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-description-container'   => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_box_text_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-description-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'    => __( 'Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'premium_text_shadow',
				'selector' => '{{WRAPPER}} .premium-video-box-text',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_box_sticky_options',
			array(
				'label'      => __( 'Sticky Options', 'premium-addons-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'conditions' => $sticky_condition,
			)
		);

		$this->add_responsive_control(
			'sticky_video_width',
			array(
				'label'          => __( 'Video Size', 'premium-addons-for-elementor' ),
				'type'           => Controls_Manager::SLIDER,
				'size_units'     => array( 'px', 'em', '%' ),
				'range'          => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
				),
				'default'        => array(
					'size' => 320,
					'unit' => 'px',
				),
				'mobile_default' => array(
					'size' => 250,
					'unit' => 'px',
				),
				'selectors'      => array(
					'{{WRAPPER}}.pa-aspect-ratio-169 .premium-video-box-container.premium-video-box-sticky-apply .premium-video-box-inner-wrap,
                    {{WRAPPER}}.pa-aspect-ratio-169 .premium-video-box-sticky-apply .premium-video-box-image-container' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.5625 );',
					'{{WRAPPER}}.pa-aspect-ratio-43 .premium-video-box-container.premium-video-box-sticky-apply .premium-video-box-inner-wrap,
                    {{WRAPPER}}.pa-aspect-ratio-43 .premium-video-box-sticky-apply .premium-video-box-image-container' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.75 );',
					'{{WRAPPER}}.pa-aspect-ratio-32 .premium-video-box-container.premium-video-box-sticky-apply .premium-video-box-inner-wrap,
                    {{WRAPPER}}.pa-aspect-ratio-32 .premium-video-box-sticky-apply .premium-video-box-image-container' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.6666666666666667 );',
					'{{WRAPPER}}.pa-aspect-ratio-916 .premium-video-box-container.premium-video-box-sticky-apply .premium-video-box-inner-wrap,
                    {{WRAPPER}}.pa-aspect-ratio-916 .premium-video-box-sticky-apply .premium-video-box-image-container' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.1778 );',
					'{{WRAPPER}}.pa-aspect-ratio-11 .premium-video-box-container.premium-video-box-sticky-apply .premium-video-box-inner-wrap,
                    {{WRAPPER}}.pa-aspect-ratio-11 .premium-video-box-sticky-apply .premium-video-box-image-container' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 1 );',
					'{{WRAPPER}}.pa-aspect-ratio-219 .premium-video-box-container.premium-video-box-sticky-apply .premium-video-box-inner-wrap,
                    {{WRAPPER}}.pa-aspect-ratio-219 .premium-video-box-sticky-apply .premium-video-box-image-container' => 'width: {{SIZE}}px; height: calc( {{SIZE}}px * 0.4285 );',
				),
			)
		);

		$this->add_responsive_control(
			'sticky_video_margin',
			array(
				'label'      => __( 'Spaces Around', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}.premium-video-sticky-top-right .premium-video-box-sticky-apply .premium-video-box-inner-wrap' => 'top: {{TOP}}{{UNIT}}; ' . $right_direction . ': {{RIGHT}}{{UNIT}}',
					'{{WRAPPER}}.premium-video-sticky-top-left .premium-video-box-sticky-apply .premium-video-box-inner-wrap' => 'top: {{TOP}}{{UNIT}}; ' . $left_direction . ': {{LEFT}}{{UNIT}}',
					'{{WRAPPER}}.premium-video-sticky-bottom-right .premium-video-box-sticky-apply .premium-video-box-inner-wrap' => 'bottom: {{BOTTOM}}{{UNIT}}; ' . $right_direction . ': {{RIGHT}}{{UNIT}}',
					'{{WRAPPER}}.premium-video-sticky-bottom-left .premium-video-box-sticky-apply .premium-video-box-inner-wrap' => 'bottom: {{BOTTOM}}{{UNIT}}; ' . $left_direction . ': {{LEFT}}{{UNIT}}',
					'{{WRAPPER}}.premium-video-sticky-center-left .premium-video-box-sticky-apply .premium-video-box-inner-wrap' => $left_direction . ': {{LEFT}}{{UNIT}}',
					'{{WRAPPER}}.premium-video-sticky-center-right .premium-video-box-sticky-apply .premium-video-box-inner-wrap' => $right_direction . ': {{RIGHT}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'sticky_box_shadow',
				'selector'  => '{{WRAPPER}} .premium-video-box-sticky-apply .premium-video-box-inner-wrap',
				'condition' => array(
					'sticky_info_bar_switch!' => 'yes',
				),
			)
		);

		$this->add_control(
			'info_bar_shadow_color',
			array(
				'label'     => __( 'Shadow Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.5)',
				'condition' => array(
					'sticky_info_bar_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'sticky_play_icon',
			array(
				'label'     => __( 'Play Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => array(
					'premium_video_box_play_icon_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_video_box_play_icon_sticky_size',
			array(
				'label'      => __( 'Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-sticky-apply .premium-video-box-play-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'premium_video_box_play_icon_switcher' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_box_icon_sticky_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'default'    => array(
					'top'    => 40,
					'right'  => 40,
					'bottom' => 40,
					'left'   => 40,
					'unit'   => 'px',
				),
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-sticky-apply .premium-video-box-play-icon ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
				'condition'  => array(
					'premium_video_box_play_icon_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_video_box_text_sticky_size',
			array(
				'label'      => __( 'Video Text Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-sticky-apply .premium-video-box-text' => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'premium_video_box_video_text_switcher' => 'yes',
				),
			)
		);

		$this->add_control(
			'sticky_close',
			array(
				'label'     => __( 'Close Icon', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'premium_video_box_sticky_close_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-sticky-close i' => 'color: {{VALUE}}!important',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
			)
		);

		$this->add_control(
			'premium_video_box_sticky_close_bg_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-sticky-close' => 'background: {{VALUE}}',
				),
				'default'   => '#FFF',
			)
		);

		$this->add_responsive_control(
			'sticky_video_icon_size',
			array(
				'label'      => __( 'Size', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'size' => 15,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .premium-video-box-sticky-close i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'sticky_hint',
			array(
				'label'     => __( 'Info Section', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::HEADING,
				'condition' => array(
					'sticky_info_bar_switch' => 'yes',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'premium_video_box_sticky_info_color',
			array(
				'label'     => __( 'Text Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-sticky-infobar' => 'color: {{VALUE}}',
				),
				'global'    => array(
					'default' => Global_Colors::COLOR_SECONDARY,
				),
				'condition' => array(
					'sticky_info_bar_switch' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'info_typography',
				'global'    => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
				'selector'  => '{{WRAPPER}} .premium-video-box-sticky-infobar',
				'condition' => array(
					'sticky_info_bar_switch' => 'yes',
				),
			)
		);

		$this->add_control(
			'premium_video_box_sticky_info_bg_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-video-box-sticky-apply .premium-video-box-sticky-infobar' => 'background: {{VALUE}}',
				),
				'default'   => '#FFF',
				'condition' => array(
					'sticky_info_bar_switch' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'premium_video_title_style',
			array(
				'label'     => __( 'Video Title', 'premium-addons-for-elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'youtube_list'                 => 'yes',
					'youtube_videos_title'         => 'yes',
					'premium_video_box_video_type' => 'youtube',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_title_align',
			array(
				'label'     => __( 'Alignment', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => __( 'Left', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => __( 'Right', 'premium-addons-for-elementor' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'toggle'    => false,
				'default'   => 'center',
				'selectors' => array(
					'{{WRAPPER}} .premium-youtube-vid-title' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'premium_video_title_typo',
				'selector' => '{{WRAPPER}} .premium-youtube-vid-title',
			)
		);

		$this->add_control(
			'premium_video_title_color',
			array(
				'label'     => __( 'Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'global'    => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} .premium-youtube-vid-title'  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'premium_video_title_bg_color',
			array(
				'label'     => __( 'Background Color', 'premium-addons-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .premium-youtube-vid-title'  => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			array(
				'label'    => __( 'Text Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'premium_video_title_text_shadow',
				'selector' => '{{WRAPPER}} .premium-youtube-vid-title',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'label'    => __( 'Box Shadow', 'premium-addons-for-elementor' ),
				'name'     => 'premium_video_title_shadow',
				'selector' => '{{WRAPPER}} .premium-youtube-vid-title',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'premium_video_title_border',
				'selector' => '{{WRAPPER}} .premium-youtube-vid-title',
			)
		);

		$this->add_control(
			'premium_video_title_border_rad',
			array(
				'label'      => __( 'Border Radius', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-youtube-vid-title'  => 'border-radius: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_title_padding',
			array(
				'label'      => __( 'Padding', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-youtube-vid-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'premium_video_title_margin',
			array(
				'label'      => __( 'Margin', 'premium-addons-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .premium-youtube-vid-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render video box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$video_type = $settings['premium_video_box_video_type'];

		if ( 'youtube' === $video_type && 'yes' === $settings['youtube_list'] ) {

			$this->fetch_youtube_playlist_data();

			return;

		}

		$id = $this->get_id();

		$params = $this->get_video_params();

		$autoplay = $settings['premium_video_box_self_autoplay'];

		$image = 'transparent';

		// Make sure autoplay is disabled before getting any thumbnails.
		if ( 'yes' !== $autoplay ) {

			$thumbnail = $this->get_thumbnail( $params['id'] );

			if ( ! empty( $thumbnail ) ) {
				$image = sprintf( 'url(\'%s\')', $thumbnail );
			}
		}

		$mute = $settings['premium_video_box_mute'];

		$loop = $settings['premium_video_box_loop'];

		$controls = $settings['premium_video_box_controls'];

		if ( 'self' === $video_type ) {

			$overlay = $settings['premium_video_box_image_switcher'];

			if ( 'yes' !== $overlay ) {
				$image = 'transparent';
			}

			if ( empty( $settings['premium_video_box_self_hosted_remote'] ) ) {
				$hosted_url = $settings['premium_video_box_self_hosted']['url'];
			} else {
				$hosted_url = $settings['premium_video_box_self_hosted_remote'];
			}

			$video_params = '';

			if ( $controls ) {
				$video_params .= 'controls ';
			}
			if ( $mute ) {
				$video_params .= 'muted ';
			}
			if ( $loop ) {
				$video_params .= 'loop ';
			}
			if ( $autoplay ) {
				$video_params .= 'autoplay playsinline ';
			}

			if ( ! $settings['download_button'] ) {
				$video_params .= ' controlsList="nodownload"';
			}
		} else {

			$link = $params['link'];

			$related = $settings['premium_video_box_suggested_videos'];

			$options  = 'youtube' === $video_type ? '&rel=' : '?rel';
			$options .= 'yes' === $related ? '1' : '0';
			$options .= 'youtube' === $video_type ? '&mute=' : '&muted=';
			$options .= 'yes' === $mute ? '1' : '0';
			$options .= '&loop=';
			$options .= 'yes' === $loop ? '1' : '0';
			$options .= '&controls=';
			$options .= 'yes' === $controls ? '1' : '0';

			if ( 'yes' === $autoplay && ! $this->has_image_overlay() ) {

				// Autoplay on Viewport.
				if ( 'yes' === $settings['autoplay_viewport'] ) {
					$this->add_render_attribute( 'container', 'data-play-viewport', 'true' );
				}

				$options .= '&autoplay=1';
			}

			if ( 'vimeo' === $video_type ) {
				$options .= '&color=' . str_replace( '#', '', $settings['vimeo_controls_color'] );

				if ( 'yes' === $settings['vimeo_title'] ) {
					$options .= '&title=1';
				}

				if ( 'yes' === $settings['vimeo_portrait'] ) {
					$options .= '&portrait=1';
				}

				if ( 'yes' === $settings['vimeo_byline'] ) {
					$options .= '&byline=1';
				}

				$options .= '&autopause=0';
			}

			if ( $loop ) {
				$options .= '&playlist=' . $params['id'];
			}
		}

		if ( $settings['premium_video_box_start'] || $settings['premium_video_box_end'] ) {

			if ( 'youtube' === $video_type ) {

				if ( $settings['premium_video_box_start'] ) {
					$options .= '&start=' . $settings['premium_video_box_start'];
				}

				if ( $settings['premium_video_box_end'] ) {
					$options .= '&end=' . $settings['premium_video_box_end'];
				}
			} elseif ( 'self' === $video_type ) {

				$hosted_url .= '#t=';

				if ( $settings['premium_video_box_start'] ) {
					$hosted_url .= $settings['premium_video_box_start'];
				}

				if ( $settings['premium_video_box_end'] ) {
					$hosted_url .= ',' . $settings['premium_video_box_end'];
				}
			}
		}

		if ( 'self' !== $video_type ) {

			if ( 'youtube' === $video_type && 'yes' === $settings['privacy_mode'] ) {
				$link = str_replace( '.com', '-nocookie.com', $link );
			}

			$this->add_render_attribute(
				'video_container',
				array(
					'data-src' => $link . $options,
				)
			);
		}

		$sticky = $settings['premium_video_box_sticky_switcher'];

		if ( 'yes' === $sticky ) {

			$sticky_play = $settings['premium_video_box_sticky_on_play'];

			$sticky_desktop = '';

			$sticky_tablet = '';

			$sticky_mobile = '';

			$sticky_infobar = ( 'yes' === $settings['sticky_info_bar_switch'] ) ? 'premium-video-box-sticky-infobar-wrap' : '';

			if ( $settings['premium_video_box_sticky_hide'] ) {
				foreach ( $settings['premium_video_box_sticky_hide'] as $element ) {

					switch ( $element ) {
						case 'desktop':
							$sticky_desktop = 'desktop';
							break;
						case 'tablet':
							$sticky_tablet = 'tablet';
							break;
						case 'mobile':
							$sticky_mobile = 'mobile';
							break;
					}
				}
			}

			$this->add_render_attribute(
				'container',
				array(
					'class'             => $sticky_infobar,
					'data-sticky'       => $sticky,
					'data-hide-desktop' => $sticky_desktop,
					'data-hide-tablet'  => $sticky_tablet,
					'data-hide-mobile'  => $sticky_mobile,
					'data-sticky-play'  => $sticky_play,
				)
			);

			if ( ! empty( $settings['sticky_video_margin'] ) ) {
				$this->add_render_attribute( 'container', 'data-sticky-margin', $settings['sticky_video_margin']['bottom'] );
			}
		}

		$this->add_inline_editing_attributes( 'premium_video_box_description_text' );

		$this->add_render_attribute(
			'container',
			array(
				'id'             => 'premium-video-box-container-' . $id,
				'class'          => 'premium-video-box-container',
				'data-overlay'   => 'yes' === $settings['premium_video_box_image_switcher'] ? 'true' : 'false',
				'data-type'      => $video_type,
				'data-thumbnail' => ! empty( $thumbnail ),
				'data-hover'     => $settings['premium_video_box_img_effect'],
			)
		);

		$this->add_render_attribute(
			'video_container',
			array(
				'class' => 'premium-video-box-video-container',
			)
		);

		$this->add_render_attribute(
			'video_wrap',
			array(
				'class' => 'premium-video-box-inner-wrap',
			)
		);

		$animation_class = $settings['premium_video_box_animation'];

		if ( '' !== $settings['premium_video_box_animation'] ) {

			$animation_dur = 'animated-' . $settings['premium_video_box_animation_duration'];

			$this->add_render_attribute(
				'video_wrap',
				'data-video-animation',
				array(
					$animation_class,
					$animation_dur,
				)
			);

			$delay = '' !== $settings['premium_video_box_animation_delay'] ? $settings['premium_video_box_animation_delay'] : 0;

			$this->add_render_attribute( 'video_wrap', 'data-delay-animation', $delay );
		}

		$this->add_render_attribute( 'info_bar', 'class', 'premium-video-box-sticky-infobar' );

		if ( 'yes' === $settings['sticky_info_bar_switch'] ) {
			$this->add_render_attribute( 'info_bar', 'style', 'box-shadow:' . $settings['info_bar_shadow_color'] . ' 0px 5px 10px -5px ' );
		}

		$this->add_render_attribute(
			'image_container',
			array(
				'style' => 'background-image:' . $image,
				'class' => array(
					'premium-video-box-image-container',
					$settings['premium_video_box_img_effect'],
				),
			)
		);

		if ( 'yes' === $settings['mask_video_box_switcher'] ) {

			$this->add_render_attribute( 'container', 'data-mask', 'true' );
			$this->add_render_attribute( 'mask', 'class', 'premium-video-box-mask-media' );

			if ( 'blur' === $settings['premium_video_box_img_effect'] ) {
				$this->add_render_attribute( 'image_container', 'class', 'premium-video-box-mask-media' );
			}

			if ( '' !== $settings['mask_shape_video_box']['url'] && 'yes' === $settings['video_box_shadow'] ) {

				$this->add_render_attribute( 'mask_filter', 'class', 'premium-video-box-mask-filter' );

			}
		}

		?>

		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'mask_filter' ) ); ?>>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'mask' ) ); ?> >
					<?php $this->get_vimeo_header( $params['id'] ); ?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'video_wrap' ) ); ?>>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'video_container' ) ); ?>>
							<?php if ( 'self' === $video_type ) : ?>
								<video src="<?php echo esc_url( $hosted_url ); ?>" <?php echo wp_kses_post( $video_params ); ?>></video>
							<?php endif; ?>
						</div>
							<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'image_container' ) ); ?>></div>
							<?php if ( 'yes' === $sticky ) { ?>
								<span class="premium-video-box-sticky-close"><i class="fas fa-times"></i></span>
							<?php } ?>
							<?php if ( 'yes' === $settings['sticky_info_bar_switch'] && '' !== $settings['sticky_info_bar_text'] ) { ?>
									<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'info_bar' ) ); ?>><?php echo wp_kses_post( $settings['sticky_info_bar_text'] ); ?></div>
							<?php } ?>
						<?php if ( 'yes' === $settings['premium_video_box_play_icon_switcher'] && 'yes' !== $autoplay && ! empty( $thumbnail ) ) : ?>
							<div class="premium-video-box-play-icon-container">
								<i class="premium-video-box-play-icon fa fa-play fa-lg"></i>
							</div>
						<?php endif; ?>
						<?php if ( 'yes' === $settings['premium_video_box_video_text_switcher'] && ! empty( $settings['premium_video_box_description_text'] ) ) : ?>
							<div class="premium-video-box-description-container">
								<p class="premium-video-box-text">
									<span <?php echo wp_kses_post( $this->get_render_attribute_string( 'premium_video_box_description_text' ) ); ?>>
										<?php echo wp_kses_post( $settings['premium_video_box_description_text'] ); ?>
									</span>
								</p>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Get video thumbnail
	 *
	 * @access public
	 *
	 * @param string $video_id video ID.
	 */
	private function get_thumbnail( $video_id = '' ) {

		$settings = $this->get_settings_for_display();

		$type = $settings['premium_video_box_video_type'];

		$overlay = $settings['premium_video_box_image_switcher'];

		if ( 'yes' === $overlay || 'self' === $type ) {
			$thumbnail_src = $settings['premium_video_box_image']['url'];
			return $thumbnail_src;
		}

		// Check thumbnail size option only for Youtube videos.
		$size = '';
		if ( 'youtube' === $type ) {
			$size = $settings['premium_video_box_yt_thumbnail_size'];
		}

		$thumbnail_src = Helper_Functions::get_video_thumbnail( $video_id, $type, $size );

		return $thumbnail_src;

	}

	/**
	 * Get video params
	 *
	 * Get video ID and url
	 *
	 * @access public
	 *
	 * @param string $video_url video URL.
	 *
	 * @return array video parameters
	 */
	private function get_video_params( $video_url = '' ) {

		$settings = $this->get_settings_for_display();

		$type = $settings['premium_video_box_video_type'];

		if ( 'self' === $type ) {
			return array(
				'link' => '',
				'id'   => '',
			);
		}

		$identifier = $settings['premium_video_box_video_id_embed_selection'];

		$id = $settings['premium_video_box_video_id'];

		$embed = $settings['premium_video_box_video_embed'];

		$link = $video_url;

		if ( empty( $video_url ) ) {
			$link = $settings['premium_video_box_link'];
		}

		if ( ! empty( $link ) ) {
			if ( 'youtube' === $type ) {
				$video_props = Embed::get_video_properties( $link );
				$link        = Embed::get_embed_url( $link );
				$video_id    = $video_props['video_id'];

			} elseif ( 'vimeo' === $type ) {
				$mask     = '/^.*vimeo\.com\/(?:[a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
				$video_id = substr( $link, strpos( $link, '.com/' ) + 5 );
				$matches  = '';
				preg_match( $mask, $link, $matches );
				if ( is_array( $matches ) ) {
					$video_id = $matches[1];
				} else {
					$video_id = substr( $link, strpos( $link, '.com/' ) + 5 );
				}
				$link = sprintf( 'https://player.vimeo.com/video/%s', $video_id );
			}

			$id = $video_id;
		} elseif ( ! empty( $id ) || ! empty( $embed ) ) {

			if ( 'id' === $identifier ) {
				$link = 'youtube' === $type ? sprintf( 'https://www.youtube.com/embed/%s', $id ) : sprintf( 'https://player.vimeo.com/video/%s', $id );
			} else {
				$link = $embed;
			}
		}

		return array(
			'link' => $link,
			'id'   => $id,
		);

	}

	/**
	 * Get Vimeo header
	 *
	 * Get Vimeo video meta data
	 *
	 * @access private
	 *
	 * @param string $id video ID.
	 */
	private function get_vimeo_header( $id ) {

		$settings = $this->get_settings_for_display();

		if ( 'vimeo' !== $settings['premium_video_box_video_type'] ) {
			return;
		}

		$vimeo_data = Helper_Functions::get_vimeo_video_data( $id );

		if ( 'yes' === $settings['vimeo_portrait'] || 'yes' === $settings['vimeo_title'] || 'yes' === $settings['vimeo_byline']
		) {
			?>
		<div class="premium-video-box-vimeo-wrap">
			<?php if ( 'yes' === $settings['vimeo_portrait'] && ! empty( $vimeo_data['portrait'] ) ) { ?>
			<div class="premium-video-box-vimeo-portrait">
				<a href="<?php echo esc_url( $vimeo_data['url'] ); ?>" target="_blank">
					<img src="<?php echo esc_url( $vimeo_data['portrait'] ); ?>" alt="<?php echo esc_attr( $vimeo_data['user'] ); ?>">
				</a>
			</div>
			<?php } ?>
			<?php
			if ( 'yes' === $settings['vimeo_title'] || 'yes' === $settings['vimeo_byline'] ) {
				?>
			<div class="premium-video-box-vimeo-headers">
				<?php if ( 'yes' === $settings['vimeo_title'] && ! empty( $vimeo_data['title'] ) ) { ?>
				<div class="premium-video-box-vimeo-title">
					<a href="<?php echo esc_url( $settings['premium_video_box_link'] ); ?>" target="_blank">
						<?php echo wp_kses_post( $vimeo_data['title'] ); ?>
					</a>
				</div>
				<?php } ?>
				<?php if ( 'yes' === $settings['vimeo_byline'] && ! empty( $vimeo_data['user'] ) ) { ?>
				<div class="premium-video-box-vimeo-byline">
					<?php echo esc_html__( 'from ', 'premium-addons-for-elementor' ); ?> <a href="<?php echo esc_url( $vimeo_data['url'] ); ?>" target="_blank"><?php echo wp_kses_post( $vimeo_data['user'] ); ?></a>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<?php } ?>
		<?php

		return isset( $vimeo_data['user'] ) ? true : false;
	}

	/**
	 * Has Image Overlay
	 *
	 * Check if video overlay option is enabled
	 *
	 * @access private
	 *
	 * @return boolean video overlay.
	 */
	private function has_image_overlay() {

		$settings = $this->get_settings_for_display();

		return ! empty( $settings['premium_video_box_image']['url'] ) && 'yes' === $settings['premium_video_box_image_switcher'];

	}

	/**
	 * Render Youtube Playlist
	 *
	 * Render the HTML Markup for a Youtube playlist
	 *
	 * @since 4.0.0
	 * @access private
	 *
	 * @param array $playlist_videos Playlist Videos.
	 */
	private function render_grid_youtube_playlist( $playlist_videos ) {

		$settings = $this->get_settings_for_display();

		$source = $settings['source'];

		$limit = 9999;

		if ( ! empty( $settings['limit_num'] ) ) {
			$limit = $settings['limit_num'];
		}

		?>
		<div class="premium-video-box-playlist-container">
		<?php
		if ( count( $playlist_videos ) ) {

			$limit_counter = 0;

			foreach ( $playlist_videos as $video ) {

				$id = 'playlist' === $source ? $video->snippet->resourceId->videoId : $video->id->videoId;

				if ( 'playlist' === $source && 'public' !== $video->status->privacyStatus ) {
					continue;
				}

				if ( $limit_counter === $limit ) {
					break;
				}

				$limit_counter++;

				$video_url = sprintf( 'https://www.youtube.com/watch?v=%s', $id );

				$video_params = $this->get_video_params( $video_url );

				$link = $video_params['link'];

				$size = $settings['premium_video_box_yt_thumbnail_size'];

				$thumbnails_url = sprintf( 'url(\'https://i.ytimg.com/vi/%s/%s.jpg\')', $id, $size );

				$related = $settings['premium_video_box_suggested_videos'];

				$mute = $settings['premium_video_box_mute'];

				$loop = $settings['premium_video_box_loop'];

				$options  = '&rel=';
				$options .= 'yes' === $related ? '1' : '0';
				$options .= '&mute=';
				$options .= 'yes' === $mute ? '1' : '0';
				$options .= '&loop=';
				$options .= 'yes' === $loop ? '1' : '0';

				if ( $settings['premium_video_box_start'] ) {
					$options .= '&start=' . $settings['premium_video_box_start'];
				}

				if ( $settings['premium_video_box_end'] ) {
					$options .= '&end=' . $settings['premium_video_box_end'];
				}

				if ( 'yes' === $settings['youtube_videos_title'] ) {
					$video_title = $video->snippet->title;

					$vid_title_tag = Helper_Functions::validate_html_tag( $settings['youtube_videos_title_tag'] );

				}

				$title_link = 'yes' === $settings['youtube_videos_title_link'] ? '<a href="' . $video_url . '" target="_blank">' : '';

				$link_close = 'yes' === $settings['youtube_videos_title_link'] ? '</a>' : '';

				$this->add_render_attribute(
					'container' . $id,
					array(
						'id'    => 'premium-video-box-container-' . $id,
						'class' => 'premium-video-box-container',
					)
				);

				if ( 'yes' === $settings['privacy_mode'] ) {
					$link = str_replace( '.com', '-nocookie.com', $link );
				}

				$this->add_render_attribute(
					'video_container' . $id,
					array(
						'data-src' => $link . $options,
						'class'    => 'premium-video-box-video-container',
					)
				);

				$this->add_render_attribute(
					'image_container' . $id,
					array(
						'style' => 'background-image:' . $thumbnails_url,
						'class' => array(
							'premium-video-box-image-container',
							$settings['premium_video_box_img_effect'],
						),
					)
				);

				$this->add_render_attribute( 'mask' . $id, 'class', 'premium-video-box-trigger' );

				if ( 'yes' === $settings['mask_video_box_switcher'] ) {

					$this->add_render_attribute( 'container' . $id, 'data-mask', 'true' );
					$this->add_render_attribute( 'mask' . $id, 'class', 'premium-video-box-mask-media' );

					if ( 'blur' === $settings['premium_video_box_img_effect'] ) {
						$this->add_render_attribute( 'image_container' . $id, 'class', 'premium-video-box-mask-media' );
					}

					if ( '' !== $settings['mask_shape_video_box']['url'] && 'yes' === $settings['video_box_shadow'] ) {

						$this->add_render_attribute( 'container' . $id, 'class', 'premium-video-box-mask-filter' );

					}
				}

				?>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' . $id ) ); ?>>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'mask' . $id ) ); ?>>
						<div  <?php echo wp_kses_post( $this->get_render_attribute_string( 'video_container' . $id ) ); ?>>
						</div>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'image_container' . $id ) ); ?> ></div>
						<?php if ( 'yes' === $settings['premium_video_box_play_icon_switcher'] ) : ?>
							<div class="premium-video-box-play-icon-container">
								<i class="premium-video-box-play-icon fa fa-play fa-lg"></i>
							</div>
						<?php endif; ?>
					</div>
					<?php
					if ( 'yes' === $settings['youtube_videos_title'] ) :
						echo wp_kses_post( $title_link );
						?>
						<<?php echo wp_kses_post( $vid_title_tag ); ?> class="premium-youtube-vid-title" > <?php echo esc_html( $video_title ); ?> </<?php echo wp_kses_post( $vid_title_tag ); ?>>
						<?php
						echo wp_kses_post( $link_close );
						endif;
					?>
				</div>
				<?php

			}
		}
		?>
		</div>
		<?php
	}

	/**
	 * Fetch Youtube Playlist Data
	 *
	 * Fetch API Data for a Youtube playlist
	 *
	 * @since 4.0.0
	 * @access private
	 */
	private function fetch_youtube_playlist_data() {

		$settings = $this->get_settings_for_display();

		$widget_id = $this->get_id();

		$api_key = Admin_Helper::get_integrations_settings()['premium-youtube-api'];

		if ( empty( $api_key ) || '1' == $api_key ) { // phpcs:ignore WordPress.PHP.StrictComparisons
			?>
			<div class="premium-error-notice">
				<?php
					$doc_url  = Helper_Functions::get_campaign_link( 'https://premiumaddons.com/docs/how-to-enable-youtube-data-api-for-premium-video-box-widget/', 'editor-page', 'wp-editor', 'get-support' );
					$message  = __( 'Please make sure to set your Youtube API key in ', 'premium-addons-for-elementor' );
					$message .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', admin_url( 'admin.php?page=premium-addons#tab=integrations' ), __( 'Integrations', 'premium-addons-for-elementor' ) );
					$message .= __( ' tab. For further information about getting an API key, please check this ', 'premium-addons-for-elementor' );
					$message .= sprintf( '<a href="%1$s" target="_blank">%2$s</a>', $doc_url, __( 'article', 'premium-addons-for-elementor' ) );
					echo wp_kses_post( $message );
				?>
			</div>
			<?php
			return false;
		}

		if ( empty( $api_key ) || ( empty( $settings['playlist_id'] ) && empty( $settings['channel_id'] ) ) ) {
			?>
			<div class="premium-error-notice">
				<?php echo esc_html__( 'Please Enter a Valid API Key & Channel/Playlist ID', 'premium-addons-for-elementor' ); ?>
			</div>
			<?php
			return false;
		}

		if ( 'playlist' === $settings['source'] ) {
			$source  = $settings['playlist_id'];
			$api_url = 'https://www.googleapis.com/youtube/v3/playlistItems?key=' . $api_key . '&playlistId=' . $source . '&part=snippet,id,status&order=date&maxResults=50';
		} else {
			$source  = $settings['channel_id'];
			$api_url = 'https://www.googleapis.com/youtube/v3/search?key=' . $api_key . '&channelId=' . $source . '&part=snippet,id&order=date&maxResults=50';
		}

		$transient_name = sprintf( 'pa_videos_%s_%s', $source, $widget_id );

		$response_json = get_transient( $transient_name );

		if ( false === $response_json ) {

			sleep( 2 );

			$api_response = rplg_urlopen( $api_url );

			$response_data = $api_response['data'];

			$response_json = rplg_json_decode( $response_data );

			$transient = $settings['reload'];

			$expire_time = Helper_Functions::transient_expire( $transient );

			if ( isset( $response_json->items ) ) {
				set_transient( $transient_name, $response_json, $expire_time );
			}
		}

		$playlist_videos = isset( $response_json->items ) ? $response_json->items : '';

		if ( empty( $playlist_videos ) ) {
			?>
			<div class="premium-error-notice">
				<?php echo esc_html__( 'Something went wrong. It seems like the playlist you selected does not have any videos', 'premium-addons-for-elementor' ); ?>
			</div>
			<?php
			return false;
		}

		$this->render_grid_youtube_playlist( $playlist_videos );

	}


}
