(function ($) {

    var PremiumWooProductsHandler = function ($scope, $) {

        var instance = null;

        instance = new premiumWooProducts($scope);
        instance.init();

    };

    window.premiumWooProducts = function ($scope) {

        var self = this,
            $elem = $scope.find(".premium-woocommerce");

        //Check Quick View
        var isQuickView = $elem.data("quick-view");

        if ("yes" === isQuickView) {

            var widgetID = $scope.data("id"),
                $modal = $elem.siblings(".premium-woo-quick-view-" + widgetID),
                $qvModal = $modal.find('#premium-woo-quick-view-modal'),
                $contentWrap = $qvModal.find('#premium-woo-quick-view-content'),
                $wrapper = $qvModal.find('.premium-woo-content-main-wrapper'),
                $backWrap = $modal.find('.premium-woo-quick-view-back'),
                $qvLoader = $modal.find('.premium-woo-quick-view-loader');

        }

        self.init = function () {

            self.handleProductsCarousel();

            if ("yes" === isQuickView)
                self.handleProductQuickView();

            self.handleProductPagination();

            var skin = $scope.data("widget_type");

            self.handleAddToCart();

            if ("premium-woo-products.grid-6" === skin)
                self.handleGalleryImages();

            if ($elem.hasClass("premium-woo-products-metro")) {

                self.handleGridMetro();

                $(window).on("resize", self.handleGridMetro);

            }


        };

        self.handleProductsCarousel = function () {

            var carousel = $elem.data("woo_carousel");

            if (!carousel)
                return;

            var $products = $elem.find('ul.products');

            carousel['customPaging'] = function () {
                return '<i class="fas fa-circle"></i>';
            };

            $products.slick(carousel);

        };

        self.handleGridMetro = function () {

            var $products = $elem.find("ul.products"),
                currentDevice = elementorFrontend.getCurrentDeviceMode(),
                suffix = "";

            //Grid Parameters
            var gridWidth = $products.width(),
                cellSize = Math.floor(gridWidth / 12);


            var metroStyle = $elem.data("metro-style");

            if ("tablet" === currentDevice) {
                suffix = "_tablet";
            } else if ("mobile" === currentDevice) {
                suffix = "_mobile";
            }

            if ('custom' === metroStyle) {

                var wPatternLength = 0,
                    hPatternLength = 0;

                var settings = $elem.data("metro");

                //Get Products Width/Height Pattern
                var wPattern = settings['wPattern' + suffix],
                    hPattern = settings['hPattern' + suffix];

                if ("" === wPattern)
                    wPattern = "12";

                if ("" === hPattern)
                    hPattern = "12";

                wPattern = wPattern.split(',');
                hPattern = hPattern.split(',');

                wPatternLength = wPatternLength + wPattern.length;
                hPatternLength = hPatternLength + hPattern.length;

                $products.find("li.product").each(function (index, product) {

                    var wIndex = index % wPatternLength,
                        hIndex = index % hPatternLength;

                    var wCell = (parseInt(wPattern[wIndex])),
                        hCell = (parseInt(hPattern[hIndex]));

                    $(product).css({
                        width: Math.floor(wCell) * cellSize,
                        height: Math.floor(hCell) * cellSize
                    });
                });

            }

            $products
                .imagesLoaded(function () { })
                .done(
                    function () {
                        $products.isotope({
                            itemSelector: "li.product",
                            percentPosition: true,
                            animationOptions: {
                                duration: 750,
                                easing: "linear"
                            },
                            layoutMode: "masonry",
                            masonry: {
                                columnWidth: cellSize
                            }
                        });
                    });
        };

        self.handleProductQuickView = function () {

            $modal.appendTo(document.body);

            $elem.on('click', '.premium-woo-qv-btn, .premium-woo-qv-data', self.triggerQuickViewModal);

            window.addEventListener("resize", function () {
                self.updateQuickViewHeight();
            });

        };

        self.triggerQuickViewModal = function (event) {

            event.preventDefault();

            var $this = $(this),
                productID = $this.data('product-id');

            if (!$qvModal.hasClass('loading'))
                $qvModal.addClass('loading');

            if (!$backWrap.hasClass('premium-woo-quick-view-active'))
                $backWrap.addClass('premium-woo-quick-view-active');

            self.getProductByAjax(productID);

            self.addCloseEvents();
        };

        self.getProductByAjax = function (itemID) {

            $.ajax({
                url: PremiumWooSettings.ajaxurl,
                data: {
                    action: 'get_woo_product_qv',
                    product_id: itemID,
                    security: PremiumWooSettings.qv_nonce
                },
                dataType: 'html',
                type: 'GET',
                beforeSend: function () {

                    $qvLoader.append('<div class="premium-loading-feed"><div class="premium-loader"></div></div>');

                },
                success: function (data) {

                    $qvLoader.find('.premium-loading-feed').remove();

                    //Insert the product content in the quick view modal.
                    $contentWrap.html(data);
                    self.handleQuickViewModal();
                },
                error: function (err) {
                    console.log(err);
                }
            });

        };

        self.addCloseEvents = function () {

            var $closeBtn = $qvModal.find('#premium-woo-quick-view-close');

            $(document).keyup(function (e) {
                if (e.keyCode === 27)
                    self.closeModal();
            });

            $closeBtn.on('click', function (e) {
                e.preventDefault();
                self.closeModal();
            });

            $wrapper.on('click', function (e) {

                if (this === e.target)
                    self.closeModal();

            });
        };

        self.handleQuickViewModal = function () {

            $contentWrap.imagesLoaded(function () {
                self.handleQuickViewSlider();
            });

        };

        self.getBarWidth = function () {

            var div = $('<div style="width:50px;height:50px;overflow:hidden;position:absolute;top:-200px;left:-200px;"><div style="height:100px;"></div>');
            // Append our div, do our calculation and then remove it
            $('body').append(div);
            var w1 = $('div', div).innerWidth();
            div.css('overflow-y', 'scroll');
            var w2 = $('div', div).innerWidth();
            $(div).remove();

            return (w1 - w2);
        };

        self.handleQuickViewSlider = function () {

            var $productSlider = $qvModal.find('.premium-woo-qv-image-slider');

            if ($productSlider.find('li').length > 1) {

                $productSlider.flexslider({
                    animation: "slide",
                    start: function (slider) {
                        setTimeout(function () {
                            self.updateQuickViewHeight(true, true);
                        }, 300);
                    },
                });

            } else {
                setTimeout(function () {
                    self.updateQuickViewHeight(true);
                }, 300);
            }

            if (!$qvModal.hasClass('active')) {

                setTimeout(function () {
                    $qvModal.removeClass('loading').addClass('active');

                    var barWidth = self.getBarWidth();

                    $("html").css('margin-right', barWidth);
                    $("html").addClass('premium-woo-qv-opened');
                }, 350);

            }

        };

        self.updateQuickViewHeight = function (update_css, isCarousel) {
            var $quickView = $contentWrap,
                imgHeight = $quickView.find('.product .premium-woo-qv-image-slider').first().height(),
                summary = $quickView.find('.product .summary.entry-summary'),
                content = summary.css('content');

            if ('undefined' != typeof content && 544 == content.replace(/[^0-9]/g, '') && 0 != imgHeight && null !== imgHeight) {
                summary.css('height', imgHeight);
            } else {
                summary.css('height', '');
            }

            if (true === update_css)
                $qvModal.css('opacity', 1);

            //Make sure slider images have same height as summary.
            if (isCarousel)
                $quickView.find('.product .premium-woo-qv-image-slider img').height(summary.outerHeight());

        };

        self.closeModal = function () {

            $backWrap.removeClass('premium-woo-quick-view-active');

            $qvModal.removeClass('active').removeClass('loading');

            $('html').removeClass('premium-woo-qv-opened');

            $('html').css('margin-right', '');

            setTimeout(function () {
                $contentWrap.html('');
            }, 600);

        };

        self.handleAddToCart = function () {

            $elem
                .on('click', '.premium-woo-cart-btn.product_type_simple', self.onAddCartBtnClick).on('premium_product_add_to_cart', self.handleAddCartBtnClick)
                .on('click', '.premium-woo-atc-button .button.product_type_simple', self.onAddCartBtnClick).on('premium_product_add_to_cart', self.handleAddCartBtnClick);

        };

        self.onAddCartBtnClick = function (event) {

            var $this = $(this);

            if (!$this.data("added-to-cart")) {
                event.preventDefault();
            } else {
                return;
            }

            var productID = $this.data('product_id'),
                quantity = 1;

            $this.removeClass('added').addClass('adding');

            if (!$this.hasClass('premium-woo-cart-btn')) {
                $this.append('<span class="fas fa-cog"></span>')
            }

            $.ajax({
                url: PremiumWooSettings.ajaxurl,
                type: 'POST',
                data: {
                    action: 'premium_woo_add_cart_product',
                    product_id: productID,
                    quantity: quantity,
                },
                success: function () {
                    $(document.body).trigger('wc_fragment_refresh');
                    $elem.trigger('premium_product_add_to_cart', [$this]);

                    if (!$this.hasClass('premium-woo-cart-btn')) {
                        setTimeout(function () {
                            var cartURL = $this.siblings('.added_to_cart').attr('href');
                            $this.removeClass('add_to_cart_button').attr('href', cartURL).text('View Cart');

                            $this.attr('data-added-to-cart', true);
                        }, 200);

                    }

                }
            });

        };

        self.handleAddCartBtnClick = function (event, $btn) {

            if (!$btn)
                return;

            $btn.removeClass('adding').addClass('added');

        };

        self.handleGalleryImages = function () {

            $elem.on('click', '.premium-woo-product__gallery_image', function () {
                var $thisImg = $(this),
                    $closestThumb = $thisImg.closest(".premium-woo-product-thumbnail"),
                    imgSrc = $thisImg.attr('src');

                if ($closestThumb.find(".premium-woo-product__on_hover").length < 1) {
                    $closestThumb.find(".woocommerce-loop-product__link img").replaceWith($thisImg.clone(true));
                } else {
                    $closestThumb.find(".premium-woo-product__on_hover").attr('src', imgSrc);
                }

            });

        };

        self.handleProductPagination = function () {

            $elem.on('click', '.premium-woo-products-pagination a.page-numbers', function (e) {

                var $targetPage = $(this);

                if ($elem.hasClass('premium-woo-query-main'))
                    return;

                e.preventDefault();

                $elem.find('ul.products').after('<div class="premium-loading-feed"><div class="premium-loader"></div></div>');

                var pageID = $elem.data('page-id'),
                    currentPage = parseInt($elem.find('.page-numbers.current').html()),
                    skin = $elem.data('skin'),
                    page_number = 1;

                if ($targetPage.hasClass('next')) {
                    page_number = currentPage + 1;
                } else if ($targetPage.hasClass('prev')) {
                    page_number = currentPage - 1;
                } else {
                    page_number = $targetPage.html();
                }

                $.ajax({
                    url: PremiumWooSettings.ajaxurl,
                    data: {
                        action: 'get_woo_products',
                        pageID: pageID,
                        elemID: $scope.data('id'),
                        category: '',
                        skin: skin,
                        page_number: page_number,
                        nonce: PremiumWooSettings.products_nonce,
                    },
                    dataType: 'json',
                    type: 'POST',
                    success: function (data) {

                        $elem.find('.premium-loading-feed').remove();

                        $('html, body').animate({
                            scrollTop: (($scope.find('.premium-woocommerce').offset().top) - 100)
                        }, 'slow');

                        var $currentProducts = $elem.find('ul.products');

                        $currentProducts.replaceWith(data.data.html);

                        $elem.find('.premium-woo-products-pagination').replaceWith(data.data.pagination);

                        if ($elem.hasClass("premium-woo-products-metro"))
                            self.handleGridMetro();

                    },
                    error: function (err) {
                        console.log(err);
                    }
                });

            });

        };


    };


    //Elementor JS Hooks
    $(window).on("elementor/frontend/init", function () {
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-1", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-2", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-3", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-4", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-5", PremiumWooProductsHandler);
        elementorFrontend.hooks.addAction("frontend/element_ready/premium-woo-products.grid-6", PremiumWooProductsHandler);

    });
})(jQuery);
