<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class asheRatingNotice {
    private $past_date;

    public function __construct() {
        global $pagenow;
        $this->past_date = strtotime( '-'.get_option('ashe_random_number').' days' );

        if ( current_user_can('administrator') ) {
            if ( empty(get_option('ashe_rating_dismiss_notice', false)) && empty(get_option('ashe_rating_already_rated', false)) ) {
                add_action( 'admin_init', [$this, 'check_theme_install_time'] );
            }
        }

        if ( is_admin() ) {
            add_action( 'admin_head', [$this, 'enqueue_scripts' ] );
        }

        add_action( 'wp_ajax_ashe_rating_dismiss_notice', [$this, 'ashe_rating_dismiss_notice'] );
        add_action( 'wp_ajax_ashe_rating_already_rated', [$this, 'ashe_rating_already_rated'] );
        add_action( 'wp_ajax_ashe_rating_need_help', [$this, 'ashe_rating_need_help'] );
        add_action( 'wp_ajax_ashe_rating_maybe_later', [$this, 'ashe_rating_maybe_later'] );
    }

    public function check_theme_install_time() {   
        $install_date = get_option('ashe_activation_time');

        if ( false !== $install_date && $this->past_date >= $install_date ) {
            add_action( 'admin_notices', [$this, 'render_rating_notice' ]);
        }
    }

    public function ashe_rating_maybe_later() {
        update_option('ashe_random_number', 10);
        update_option('ashe_activation_time', strtotime('now'));
    }
    
    public function ashe_rating_dismiss_notice() {
        update_option( 'ashe_rating_dismiss_notice', true );
    }

    function ashe_rating_already_rated() {    
        update_option( 'ashe_rating_already_rated' , true );
    }

    public function ashe_rating_need_help() {
        // Reset Activation Time if user Needs Help
        update_option('ashe_random_number', 10);
        update_option( 'ashe_activation_time', strtotime('now') );
    }

    public function render_rating_notice() {
        global $pagenow;

        if ( is_admin() ) {

            echo '<div class="notice ashe-rating-notice is-dismissible" style="border-left-color: #0073aa!important; display: flex; align-items: center;">
                        <div class="ashe-rating-notice-logo">
                        <img class="ashe-logo" src="'.get_theme_file_uri().'/assets/images/ashe-blog.png">
                        </div>
                        <div>
                            <h3>Thank you for using Ashe Theme to build this website!</h3>
                            <p>Could you please do us a BIG favor and give it a 5-star rating on WordPress? Just to help us spread the word and boost our motivation.</p>
                            <p>
                                <a href="https://wordpress.org/support/theme/ashe/reviews/#new-post" target="_blank" class="ashe-you-deserve-it button button-primary">OK, you deserve it!</a>
                                <a class="ashe-maybe-later"><span class="dashicons dashicons-clock"></span> Maybe Later</a>
                                <a class="ashe-already-rated"><span class="dashicons dashicons-yes"></span> I Already did</a>
                                <a href="https://wp-royal.com/contact/#!/cform" target="_blank" class="ashe-need-support"><span class="dashicons dashicons-sos"></span> I need support!</a>
                                <a class="ashe-notice-dismiss-2"><span class="dashicons dashicons-thumbs-down"></span> NO, not good enough</a>
                            </p>
                        </div>
                </div>';
        }
    }

    public function enqueue_scripts() { 
        echo "
        <script>
        jQuery( document ).ready( function() {

            jQuery(document).on( 'click', '.ashe-notice-dismiss-2', function() {
                jQuery(document).find('.ashe-rating-notice').slideUp();
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'ashe_rating_dismiss_notice',
                    }
                })
            });

            jQuery(document).on( 'click', '.ashe-maybe-later', function() {
                jQuery(document).find('.ashe-rating-notice').slideUp();
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'ashe_rating_maybe_later',
                    }
                })
            });
        
            jQuery(document).on( 'click', '.ashe-already-rated', function() {
                jQuery(document).find('.ashe-rating-notice').slideUp();
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'ashe_rating_already_rated',
                    }
                })
            });
        
            jQuery(document).on( 'click', '.ashe-need-support', function() {
                jQuery.post({
                    url: ajaxurl,
                    data: {
                        action: 'ashe_rating_need_help',
                    }
                })
            });
        });
        </script>

        <style>
            .ashe-rating-notice {
              padding: 0 15px;
            }

            .ashe-rating-notice-logo {
                margin-right: 20px;
                width: 100px;
                height: 100px;
            }

            .ashe-rating-notice-logo img {
                max-width: 100%;
            }

            .ashe-rating-notice h3 {
              margin-bottom: 0;
            }

            .ashe-rating-notice p {
              margin-top: 3px;
              margin-bottom: 15px;
            }

            .ashe-already-rated,
            .ashe-need-support,
            .ashe-notice-dismiss-2,
            .ashe-maybe-later {
              text-decoration: none;
              margin-left: 12px;
              font-size: 14px;
              cursor: pointer;
            }

            .ashe-already-rated .dashicons,
            .ashe-need-support .dashicons,
            .ashe-maybe-later .dashicons {
              vertical-align: sub;
            }

            .ashe-notice-dismiss-2 .dashicons {
              vertical-align: middle;
            }

            .ashe-rating-notice .notice-dismiss {
                display: none;
            }

            .ashe-logo {
                height: 100%;
                width: auto;
            }

        </style>
        ";
    }
}

if ( 'Ashe' === wp_get_theme()->get('Name')) {
    new asheRatingNotice();
}