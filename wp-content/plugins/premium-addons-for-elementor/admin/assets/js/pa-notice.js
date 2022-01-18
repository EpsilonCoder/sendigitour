(function ($) {

    var $noticeWrap = $(".pa-notice-wrap"),
        notice = $noticeWrap.data('notice');

    var adminNotices = {
        'radius': 'radius_notice',
        'ch21': 'ch21_notice',
    };

    if (undefined !== notice) {

        $noticeWrap.find('.pa-notice-reset').on(
            "click",
            function () {

                $noticeWrap.css('display', 'none');

                $.ajax(
                    {
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'pa_reset_admin_notice',
                            notice: $noticeWrap.data('notice'),
                            nonce: PaNoticeSettings.nonce,
                        }
                    }
                );

            }
        );
    }

    $(".pa-notice-close").on(
        "click",
        function () {

            var noticeID = $(this).data('notice');

            if (noticeID) {
                $(this).closest('.pa-new-feature-notice').remove();

                $.ajax(
                    {
                        url: ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'pa_dismiss_admin_notice',
                            notice: adminNotices[noticeID],
                            nonce: PaNoticeSettings.nonce,
                        },
                        success: function (res) {
                            console.log(res);
                        },
                        error: function (err) {
                            console.log(err);
                        }
                    }
                );
            }

        }
    );

})(jQuery);
