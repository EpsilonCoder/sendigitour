jQuery( document ).ready( function ($) {
    "use strict";
    
    // Get URL
    var getURL  = window.location.href,
        baseURL = getURL.substring(0, getURL.indexOf('/wp-admin') + 9);

    // Install and Activate
    $( '#ashe-demo-content-inst' ).on( 'click', function() {

            $('#ashe-demo-content-inst').html( 'Installing Import Plugin...' );

            var data = {
                action: 'ashe_plugin_auto_activation'
            };

            wp.updates.installPlugin({
                slug: 'ashe-extra',
                success: function(){
                    $.post(ajaxurl, data, function(response) {
                        $('#ashe-demo-content-inst').html( 'Redirecting...' );
                        window.location.replace( baseURL + '/admin.php?page=ashe-extra' );
                    })
                }
            });

        }
    );

    // Activate
    $( '#ashe-demo-content-act' ).on( 'click', function() {

            $('#ashe-demo-content-act').html( 'Installing Import Plugin...' );

            var data = {
                action: 'ashe_plugin_auto_activation'
            };

            $.post(ajaxurl, data, function(response) {
                $('#ashe-demo-content-act').html( 'Redirecting...' );
                window.location.replace( baseURL + '/admin.php?page=ashe-extra' );
            })

        }
    );

});