(function ($) {

    $(window).on('elementor/frontend/init', function () {
        var ModuleHandler = elementorModules.frontend.handlers.Base;

        /****** Premium Progress Bar Handler ******/
        var PremiumProgressBarWidgetHandler = function ($scope, trigger) {

            var $progressbarElem = $scope.find(".premium-progressbar-container"),
                settings = $progressbarElem.data("settings"),
                length = settings.progress_length,
                speed = settings.speed,
                type = settings.type;


            if ("line" === type) {

                var $progressbar = $progressbarElem.find(".premium-progressbar-bar");

                if (settings.gradient)
                    $progressbar.css("background", "linear-gradient(-45deg, " + settings.gradient + ")");

                $progressbar.animate({
                    width: length + "%"
                }, speed);

            } else if ("circle" === type) {
                if (length > 100)
                    length = 100;

                $progressbarElem.prop({
                    'counter': 0
                }).animate({
                    counter: length
                }, {
                    duration: speed,
                    easing: 'linear',
                    step: function (counter) {
                        var rotate = (counter * 3.6);

                        $progressbarElem.find(".premium-progressbar-right-label span").text(Math.ceil(counter) + "%");

                        $progressbarElem.find(".premium-progressbar-circle-left").css('transform', "rotate(" + rotate + "deg)");
                        if (rotate > 180) {

                            $progressbarElem.find(".premium-progressbar-circle").css({
                                '-webkit-clip-path': 'inset(0)',
                                'clip-path': 'inset(0)',
                            });

                            $progressbarElem.find(".premium-progressbar-circle-right").css('visibility', 'visible');
                        }
                    }
                });

            } else {

                var $progressbar = $progressbarElem.find(".premium-progressbar-bar-wrap"),
                    width = $progressbarElem.outerWidth(),
                    dotSize = settings.dot || 25,
                    dotSpacing = settings.spacing || 10,
                    numberOfCircles = Math.ceil(width / (dotSize + dotSpacing)),
                    circlesToFill = numberOfCircles * (length / 100),
                    numberOfTotalFill = Math.floor(circlesToFill),
                    fillPercent = 100 * (circlesToFill - numberOfTotalFill);

                $progressbar.attr('data-circles', numberOfCircles);
                $progressbar.attr('data-total-fill', numberOfTotalFill);
                $progressbar.attr('data-partial-fill', fillPercent);

                var className = "progress-segment";
                for (var i = 0; i < numberOfCircles; i++) {
                    className = "progress-segment";
                    var innerHTML = '';

                    if (i < numberOfTotalFill) {
                        innerHTML = "<div class='segment-inner'></div>";
                    } else if (i === numberOfTotalFill) {

                        innerHTML = "<div class='segment-inner'></div>";
                    }

                    $progressbar.append("<div class='" + className + "'>" + innerHTML + "</div>");

                }

                if ("frontend" !== trigger) {
                    PremiumProgressDotsHandler($scope);
                }

            }

        };

        var PremiumProgressDotsHandler = function ($scope) {

            var $progressbarElem = $scope.find(".premium-progressbar-container"),
                settings = $progressbarElem.data("settings"),
                $progressbar = $scope.find(".premium-progressbar-bar-wrap"),
                data = $progressbar.data(),
                speed = settings.speed,
                increment = 0;

            var numberOfTotalFill = data.totalFill,
                numberOfCircles = data.circles,
                fillPercent = data.partialFill;

            dotIncrement(increment);

            function dotIncrement(inc) {

                var $dot = $progressbar.find(".progress-segment").eq(inc),
                    dotWidth = 100;

                if (inc === numberOfTotalFill)
                    dotWidth = fillPercent

                $dot.find(".segment-inner").animate({
                    width: dotWidth + '%'
                }, speed / numberOfCircles, function () {
                    increment++;
                    if (increment <= numberOfTotalFill) {
                        dotIncrement(increment);
                    }

                });
            }
        };

        /****** Premium Progress Bar Scroll Handler *****/
        var PremiumProgressBarScrollWidgetHandler = function ($scope, $) {

            var $progressbarElem = $scope.find(".premium-progressbar-container"),
                settings = $progressbarElem.data("settings"),
                type = settings.type;

            if ("dots" === type) {
                PremiumProgressBarWidgetHandler($scope, "frontend");
            }

            elementorFrontend.waypoint($scope, function () {
                if ("dots" !== type) {
                    PremiumProgressBarWidgetHandler($(this));
                } else {
                    PremiumProgressDotsHandler($(this));
                }

            });
        };

        /****** Premium Video Box Handler ******/
        var PremiumVideoBoxWidgetHandler = function ($scope, $) {

            var $videoBoxElement = $scope.find(".premium-video-box-container"),
                $videoListElement = $scope.find(".premium-video-box-playlist-container"),
                $videoContainer = $videoBoxElement.find(".premium-video-box-video-container"), //should be clicked
                $videoInnerContainer = $videoBoxElement.find('.premium-video-box-inner-wrap'),
                $videoImageContainer = $videoInnerContainer.find('.premium-video-box-image-container'),
                type = $videoBoxElement.data("type"),
                thumbnail = $videoBoxElement.data("thumbnail"),
                sticky = $videoBoxElement.data('sticky'),
                stickyOnPlay = $videoBoxElement.data('sticky-play'),
                hoverEffect = $videoBoxElement.data("hover"),
                video, vidSrc;

            // Youtube playlist option
            if ($videoListElement.length) {

                //Make sure that video were pulled from the API.
                if (!$videoContainer.length)
                    return;

                $videoContainer.each(function (index, item) {

                    var vidSrc,
                        $videoContainer = $(item),
                        $videoBoxElement = $videoContainer.closest(".premium-video-box-container"),
                        $trigger = $videoContainer.closest(".premium-video-box-trigger");

                    vidSrc = $videoContainer.data("src");
                    vidSrc = vidSrc + "&autoplay=1";

                    $trigger.on("click", function () {

                        var $iframe = $("<iframe/>");

                        $iframe.attr({
                            "src": vidSrc,
                            "frameborder": "0",
                            "allowfullscreen": "1",
                            "allow": "autoplay;encrypted-media;"
                        });
                        $videoContainer.css("background", "#000");
                        $videoContainer.html($iframe);

                        $videoBoxElement.find(
                            ".premium-video-box-image-container, .premium-video-box-play-icon-container"
                        ).remove();

                    });

                });

                return;
            }

            if ("self" === type) {

                video = $videoContainer.find("video");
                vidSrc = video.attr("src");

            } else {

                vidSrc = $videoContainer.data("src");

                if (!thumbnail || -1 !== vidSrc.indexOf("autoplay=1")) {

                    //Check if Autoplay on viewport option is enabled
                    if ($videoBoxElement.data("play-viewport")) {
                        elementorFrontend.waypoint($videoBoxElement, function () {
                            playVideo();
                        });
                    } else {
                        playVideo();
                    }

                } else {
                    vidSrc = vidSrc + "&autoplay=1";
                }

            }

            function playVideo() {

                if ($videoBoxElement.hasClass("playing")) return;

                $videoBoxElement.addClass("playing");

                if (stickyOnPlay === 'yes')
                    stickyOption();

                if ("self" === type) {

                    $(video).get(0).play();

                    $videoContainer.css({
                        opacity: "1",
                        visibility: "visible"
                    });

                } else {

                    var $iframe = $("<iframe/>");

                    $iframe.attr({
                        "src": vidSrc,
                        "frameborder": "0",
                        "allowfullscreen": "1",
                        "allow": "autoplay;encrypted-media;"
                    });
                    $videoContainer.css("background", "#000");
                    $videoContainer.html($iframe);
                }

                $videoBoxElement.find(
                    ".premium-video-box-image-container, .premium-video-box-play-icon-container, .premium-video-box-description-container"
                ).remove();

                if ("vimeo" === type)
                    $videoBoxElement.find(".premium-video-box-vimeo-wrap").remove();
            }

            $videoBoxElement.on("click", function () {
                playVideo();
            });


            if ("yes" !== sticky || "yes" === stickyOnPlay)
                return;

            stickyOption();

            function stickyOption() {

                var stickyDesktop = $videoBoxElement.data('hide-desktop'),
                    stickyTablet = $videoBoxElement.data('hide-tablet'),
                    stickyMobile = $videoBoxElement.data('hide-mobile'),
                    stickyMargin = $videoBoxElement.data('sticky-margin');

                $videoBoxElement.off('click').on('click', function (e) {
                    // if ('yes' === sticky) {
                    var stickyTarget = e.target.className;
                    if ((stickyTarget.toString().indexOf('premium-video-box-sticky-close') >= 0) || (stickyTarget.toString().indexOf('premium-video-box-sticky-close') >= 0)) {
                        return false;
                    }
                    // }
                    playVideo();

                });

                //Make sure Elementor Waypoint is defined
                if (typeof elementorFrontend.waypoint !== 'undefined') {

                    var stickyWaypoint = elementorFrontend.waypoint(
                        $videoBoxElement,
                        function (direction) {
                            if ('down' === direction) {

                                $videoBoxElement.removeClass('premium-video-box-sticky-hide').addClass('premium-video-box-sticky-apply premium-video-box-filter-sticky');

                                //Fix conflict with Elementor motion effects
                                if ($scope.hasClass("elementor-motion-effects-parent")) {
                                    $scope.removeClass("elementor-motion-effects-perspective").find(".elementor-widget-container").addClass("premium-video-box-transform");
                                }

                                if ($videoBoxElement.data("mask")) {
                                    //Fix Sticky position issue when drop-shadow is applied
                                    $scope.find(".premium-video-box-mask-filter").removeClass("premium-video-box-mask-filter");

                                    $videoBoxElement.find(':first-child').removeClass('premium-video-box-mask-media');

                                    $videoImageContainer.removeClass(hoverEffect).removeClass('premium-video-box-mask-media').css({
                                        'transition': 'width 0.2s, height 0.2s',
                                        '-webkit-transition': 'width 0.2s, height 0.2s'
                                    });
                                }

                                $(document).trigger('premium_after_sticky_applied', [$scope]);

                                // Entrance Animation Option
                                if ($videoInnerContainer.data("video-animation") && " " != $videoInnerContainer.data("video-animation")) {
                                    $videoInnerContainer.css("opacity", "0");
                                    var animationDelay = $videoInnerContainer.data('delay-animation');
                                    setTimeout(function () {

                                        $videoInnerContainer.css("opacity", "1").addClass("animated " + $videoInnerContainer.data("video-animation"));

                                    }, animationDelay * 1000);
                                }

                            } else {

                                $videoBoxElement.removeClass('premium-video-box-sticky-apply  premium-video-box-filter-sticky').addClass('premium-video-box-sticky-hide');

                                //Fix conflict with Elementor motion effects
                                if ($scope.hasClass("elementor-motion-effects-parent")) {
                                    $scope.addClass("elementor-motion-effects-perspective").find(".elementor-widget-container").removeClass("premium-video-box-transform");
                                }

                                if ($videoBoxElement.data("mask")) {
                                    //Fix Sticky position issue when drop-shadow is applied
                                    $videoBoxElement.parent().addClass("premium-video-box-mask-filter");

                                    $videoBoxElement.find(':first-child').eq(0).addClass('premium-video-box-mask-media');
                                    $videoImageContainer.addClass('premium-video-box-mask-media');
                                }

                                $videoImageContainer.addClass(hoverEffect).css({
                                    'transition': 'all 0.2s',
                                    '-webkit-transition': 'all 0.2s'
                                });

                                $videoInnerContainer.removeClass("animated " + $videoInnerContainer.data("video-animation"));
                            }
                        }, {
                        offset: 0 + '%',
                        triggerOnce: false
                    }
                    );
                }

                var closeBtn = $scope.find('.premium-video-box-sticky-close');

                closeBtn.off('click.closetrigger').on('click.closetrigger', function (e) {
                    stickyWaypoint[0].disable();

                    $videoBoxElement.removeClass('premium-video-box-sticky-apply premium-video-box-sticky-hide');

                    //Fix conflict with Elementor motion effects
                    if ($scope.hasClass("elementor-motion-effects-parent")) {
                        $scope.addClass("elementor-motion-effects-perspective").find(".elementor-widget-container").removeClass("premium-video-box-transform");
                    }

                    if ($videoBoxElement.data("mask")) {
                        //Fix Sticky position issue when drop-shadow is applied
                        $videoBoxElement.parent().addClass("premium-video-box-mask-filter");

                        //Necessary classes for mask shape option
                        $videoBoxElement.find(':first-child').eq(0).addClass('premium-video-box-mask-media');
                        $videoImageContainer.addClass('premium-video-box-mask-media');
                    }


                });

                checkResize(stickyWaypoint);

                checkScroll();

                window.addEventListener("scroll", checkScroll);

                $(window).resize(function (e) {
                    checkResize(stickyWaypoint);
                });

                function checkResize(stickyWaypoint) {
                    var currentDeviceMode = elementorFrontend.getCurrentDeviceMode();

                    if ('' !== stickyDesktop && currentDeviceMode == stickyDesktop) {
                        disableSticky(stickyWaypoint);
                    } else if ('' !== stickyTablet && currentDeviceMode == stickyTablet) {
                        disableSticky(stickyWaypoint);
                    } else if ('' !== stickyMobile && currentDeviceMode == stickyMobile) {
                        disableSticky(stickyWaypoint);
                    } else {
                        stickyWaypoint[0].enable();
                    }
                }

                function disableSticky(stickyWaypoint) {
                    stickyWaypoint[0].disable();
                    $videoBoxElement.removeClass('premium-video-box-sticky-apply premium-video-box-sticky-hide');
                }

                function checkScroll() {
                    if ($videoBoxElement.hasClass('premium-video-box-sticky-apply')) {
                        $videoInnerContainer.draggable({
                            start: function () {
                                $(this).css({
                                    transform: "none",
                                    top: $(this).offset().top + "px",
                                    left: $(this).offset().left + "px"
                                });
                            },
                            containment: 'window'
                        });
                    }
                }

                $(document).on('premium_after_sticky_applied', function (e, $scope) {
                    var infobar = $scope.find('.premium-video-box-sticky-infobar');

                    if (0 !== infobar.length) {
                        var infobarHeight = infobar.outerHeight();

                        if ($scope.hasClass('premium-video-sticky-center-left') || $scope.hasClass('premium-video-sticky-center-right')) {
                            infobarHeight = Math.ceil(infobarHeight / 2);
                            $videoInnerContainer.css('top', 'calc( 50% - ' + infobarHeight + 'px )');
                        }

                        if ($scope.hasClass('premium-video-sticky-bottom-left') || $scope.hasClass('premium-video-sticky-bottom-right')) {
                            if ('' !== stickyMargin) {
                                infobarHeight = Math.ceil(infobarHeight);
                                var stickBottom = infobarHeight + stickyMargin;
                                $videoInnerContainer.css('bottom', stickBottom);
                            }
                        }
                    }
                });

            }

        };

        /****** Premium Media Grid Handler ******/
        var PremiumGridWidgetHandler = ModuleHandler.extend({

            settings: {},

            getDefaultSettings: function () {
                return {
                    selectors: {
                        galleryElement: '.premium-gallery-container',
                        filters: '.premium-gallery-cats-container li',
                        gradientLayer: '.premium-gallery-gradient-layer',
                        loadMore: '.premium-gallery-load-more',
                        loadMoreDiv: '.premium-gallery-load-more div',
                        vidWrap: '.premium-gallery-video-wrap',
                    }
                }
            },

            getDefaultElements: function () {

                var selectors = this.getSettings('selectors'),
                    elements = {
                        $galleryElement: this.$element.find(selectors.galleryElement),
                        $filters: this.$element.find(selectors.filters),
                        $gradientLayer: this.$element.find(selectors.gradientLayer),
                        $vidWrap: this.$element.find(selectors.vidWrap)
                    };

                elements.$loadMore = elements.$galleryElement.parent().find(selectors.loadMore)
                elements.$loadMoreDiv = elements.$galleryElement.parent().find(selectors.loadMoreDiv)

                return elements;
            },

            bindEvents: function () {
                this.getGlobalSettings();
                this.run();
            },

            getGlobalSettings: function () {
                var $galleryElement = this.elements.$galleryElement,
                    settings = $galleryElement.data('settings');

                this.settings = {
                    layout: settings.img_size,
                    loadMore: settings.load_more,
                    columnWidth: null,
                    filter: null,
                    isFilterClicked: false,
                    minimum: settings.minimum,
                    imageToShow: settings.click_images,
                    counter: settings.minimum,
                    ltrMode: settings.ltr_mode,
                    shuffle: settings.shuffle,
                    active_cat: settings.active_cat,
                    theme: settings.theme,
                    overlay: settings.overlay,
                    sort_by: settings.sort_by,
                    light_box: settings.light_box,
                    flag: settings.flag,
                    lightbox_type: settings.lightbox_type
                }
            },

            updateCounter: function () {

                if (this.settings.isFilterClicked) {

                    this.settings.counter = this.settings.minimum;

                    this.settings.isFilterClicked = false;

                } else {
                    this.settings.counter = this.settings.counter;
                }

                this.settings.counter = this.settings.counter + this.settings.imageToShow;
            },

            updateGrid: function (gradHeight, $isotopeGallery, $loadMoreDiv) {
                $.ajax({
                    url: this.appendItems(this.settings.counter, gradHeight, $isotopeGallery),
                    beforeSend: function () {
                        $loadMoreDiv.removeClass("premium-gallery-item-hidden");
                    },
                    success: function () {
                        $loadMoreDiv.addClass("premium-gallery-item-hidden");
                    }
                });
            },

            loadMore: function (gradHeight, $isotopeGallery) {

                var $galleryElement = this.elements.$galleryElement,
                    $loadMoreDiv = this.elements.$loadMoreDiv,
                    $loadMore = this.elements.$loadMore,
                    _this = this;

                $loadMoreDiv.addClass("premium-gallery-item-hidden");

                if ($galleryElement.find(".premium-gallery-item").length > this.settings.minimum) {

                    $loadMore.removeClass("premium-gallery-item-hidden");

                    $galleryElement.parent().on("click", ".premium-gallery-load-less", function () {
                        _this.settings.counter = _this.settings.counter - _this.settings.imageToShow;
                    });

                    $galleryElement.parent().on("click", ".premium-gallery-load-more-btn:not(.premium-gallery-load-less)", function () {
                        _this.updateCounter();
                        _this.updateGrid(gradHeight, $isotopeGallery, $loadMoreDiv);
                    });

                }

            },

            getItemsToHide: function (instance, imagesToShow) {
                var items = instance.filteredItems.slice(imagesToShow, instance
                    .filteredItems.length).map(function (item) {
                        return item.element;
                    });

                return items;
            },

            appendItems: function (imagesToShow, gradHeight, $isotopeGallery) {

                var $galleryElement = this.elements.$galleryElement,
                    $gradientLayer = this.elements.$gradientLayer,
                    instance = $galleryElement.data("isotope"),
                    itemsToHide = this.getItemsToHide(instance, imagesToShow);

                $gradientLayer.outerHeight(gradHeight);

                $galleryElement.find(".premium-gallery-item-hidden").removeClass("premium-gallery-item-hidden");

                $galleryElement.parent().find(".premium-gallery-load-more").removeClass("premium-gallery-item-hidden");

                $(itemsToHide).addClass("premium-gallery-item-hidden");

                $isotopeGallery.isotope("layout");

                if (0 == itemsToHide) {

                    $gradientLayer.addClass("premium-gallery-item-hidden");

                    $galleryElement.parent().find(".premium-gallery-load-more").addClass("premium-gallery-item-hidden");
                }
            },

            triggerFilerTabs: function (url) {
                var filterIndex = url.searchParams.get(this.settings.flag),
                    $filters = this.elements.$filters;

                if (filterIndex) {

                    var $targetFilter = $filters.eq(filterIndex).find("a");

                    $targetFilter.trigger('click');

                }
            },

            onReady: function ($isotopeGallery) {
                var _this = this;

                $isotopeGallery.isotope("layout");

                $isotopeGallery.isotope({
                    filter: _this.settings.active_cat
                });

                var url = new URL(window.location.href);

                if (url)
                    _this.triggerFilerTabs(url);

            },

            onResize: function ($isotopeGallery) {
                var _this = this;

                _this.setMetroLayout();

                $isotopeGallery.isotope({
                    itemSelector: ".premium-gallery-item",
                    masonry: {
                        columnWidth: _this.settings.columnWidth
                    },
                });

            },

            lightBoxDisabled: function () {
                var _this = this,
                    $vidWrap = this.elements.$vidWrap;

                $vidWrap.each(function (index, item) {
                    var type = $(item).data("type");

                    $(item).closest(".premium-gallery-item").on("click", function () {
                        var $this = $(this);

                        $this.find(".pa-gallery-img-container").css("background", "#000");

                        $this.find("img, .pa-gallery-icons-caption-container, .pa-gallery-icons-wrapper").css("visibility", "hidden");

                        if ("style3" !== _this.settings.skin)
                            $this.find(".premium-gallery-caption").css("visibility", "hidden");

                        if ("hosted" !== type) {
                            _this.playVid($this);
                        } else {
                            _this.playHostedVid(item);
                        }
                    });
                });

            },

            playVid: function ($this) {
                var $iframeWrap = $this.find(".premium-gallery-iframe-wrap"),
                    src = $iframeWrap.data("src");

                src = src.replace("&mute", "&autoplay=1&mute");

                var $iframe = $("<iframe/>");

                $iframe.attr({
                    "src": src,
                    "frameborder": "0",
                    "allowfullscreen": "1",
                    "allow": "autoplay;encrypted-media;"
                });

                $iframeWrap.html($iframe);

                $iframe.css("visibility", "visible");
            },

            playHostedVid: function (item) {
                var $video = $(item).find("video");

                $video.get(0).play();
                $video.css("visibility", "visible");
            },

            run: function () {

                var $galleryElement = this.elements.$galleryElement,
                    $vidWrap = this.elements.$vidWrap,
                    $filters = this.elements.$filters,
                    _this = this;

                if ('metro' === this.settings.layout) {

                    this.setMetroLayout();

                    this.settings.layout = "masonry";

                    $(window).resize(function () { _this.onResize($isotopeGallery); });
                }

                var $isotopeGallery = $galleryElement.isotope(this.getIsoTopeSettings());

                $isotopeGallery.imagesLoaded().progress(function () {
                    $isotopeGallery.isotope("layout");
                });

                $(document).ready(function () { _this.onReady($isotopeGallery); });

                if (this.settings.loadMore) {

                    var $gradientLayer = this.elements.$gradientLayer,
                        gradHeight = null;

                    setTimeout(function () {
                        gradHeight = $gradientLayer.outerHeight();
                    }, 200);

                    this.loadMore(gradHeight, $isotopeGallery);
                }

                if ("yes" !== this.settings.light_box)
                    this.lightBoxDisabled();

                $filters.find("a").click(function (e) {
                    e.preventDefault();

                    _this.isFilterClicked = true;

                    $filters.find(".active").removeClass("active");

                    $(this).addClass("active");

                    _this.settings.filter = $(this).attr("data-filter");

                    $isotopeGallery.isotope({
                        filter: _this.settings.filter
                    });

                    if (_this.settings.shuffle) $isotopeGallery.isotope("shuffle");

                    if (_this.settings.loadMore) _this.appendItems(_this.settings.minimum, gradHeight, $isotopeGallery);

                    return false;
                });

                if ("default" === this.settings.lightbox_type)
                    this.$element.find(".premium-img-gallery a[data-rel^='prettyPhoto']").prettyPhoto(this.getPrettyPhotoSettings());
            },

            getPrettyPhotoSettings: function () {
                return {
                    theme: this.settings.theme,
                    hook: "data-rel",
                    opacity: 0.7,
                    show_title: false,
                    deeplinking: false,
                    overlay_gallery: this.settings.overlay,
                    custom_markup: "",
                    default_width: 900,
                    default_height: 506,
                    social_tools: ""
                }
            },

            getIsoTopeSettings: function () {
                return {
                    itemSelector: '.premium-gallery-item',
                    percentPosition: true,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear'
                    },
                    filter: this.settings.active_cat,
                    layoutMode: this.settings.layout,
                    originLeft: this.settings.ltrMode,
                    masonry: {
                        columnWidth: this.settings.columnWidth
                    },
                    sortBy: this.settings.sort_by
                }
            },

            getRepeaterSettings: function () {
                return this.getElementSettings('premium_gallery_img_content');
            },

            setMetroLayout: function () {

                var $galleryElement = this.elements.$galleryElement,
                    gridWidth = $galleryElement.width(),
                    cellSize = Math.floor(gridWidth / 12),
                    deviceType = elementorFrontend.getCurrentDeviceMode(),
                    suffix = 'desktop' === deviceType ? '' : '_' + deviceType,
                    repeater = this.getRepeaterSettings();

                $galleryElement.find(".premium-gallery-item").each(function (index, item) { //should be added to selectors and elements

                    var cells = repeater[index]['premium_gallery_image_cell' + suffix].size,
                        vCells = repeater[index]['premium_gallery_image_vcell' + suffix].size;

                    if ("" === cells || undefined == cells) {
                        cells = repeater[index].premium_gallery_image_cell.size;
                    }

                    if ("" === vCells || undefined == vCells) {
                        vCells = repeater[index].premium_gallery_image_vcell.size;
                    }

                    $(item).css({
                        width: Math.ceil(cells * cellSize),
                        height: Math.ceil(vCells * cellSize)
                    });
                });

                this.settings.columnWidth = cellSize;
            }

        });

        /****** Premium Counter Handler ******/
        var PremiumCounterHandler = function ($scope, $) {

            var $counterElement = $scope.find(".premium-counter");

            elementorFrontend.waypoint($counterElement, function () {

                var counterSettings = $counterElement.data(),
                    incrementElement = $counterElement.find(".premium-counter-init"),
                    iconElement = $counterElement.find(".icon");

                $(incrementElement).numerator(counterSettings);

                $(iconElement).addClass("animated " + iconElement.data("animation"));

            });

        };

        /****** Premium Fancy Text Handler ******/
        var PremiumFancyTextHandler = function ($scope, $) {

            var $elem = $scope.find(".premium-fancy-text-wrapper"),
                settings = $elem.data("settings"),
                loadingSpeed = settings.delay || 2500,
                itemCount = $elem.find('.premium-fancy-list-items').length,
                loopCount = ('' === settings.count && !['typing', 'slide', 'autofade'].includes(settings.effect)) ? 'infinite' : (settings.count * itemCount);

            function escapeHtml(unsafe) {
                return unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(
                    /"/g, "&quot;").replace(/'/g, "&#039;");
            }

            if ("typing" === settings.effect) {

                var fancyStrings = [];

                settings.strings.forEach(function (item) {
                    fancyStrings.push(escapeHtml(item));
                });

                $elem.find(".premium-fancy-text").typed({
                    strings: fancyStrings,
                    typeSpeed: settings.typeSpeed,
                    backSpeed: settings.backSpeed,
                    startDelay: settings.startDelay,
                    backDelay: settings.backDelay,
                    showCursor: settings.showCursor,
                    cursorChar: settings.cursorChar,
                    loop: settings.loop
                });

            } else if ("slide" === settings.effect) {
                loadingSpeed = settings.pause;

                $elem.find(".premium-fancy-text").vTicker({
                    speed: settings.speed,
                    showItems: settings.showItems,
                    pause: settings.pause,
                    mousePause: settings.mousePause,
                    direction: "up"
                });

            } else if ('auto-fade' === settings.effect) {
                var $items = $elem.find(".premium-fancy-list-items"),
                    len = $items.length;

                if (0 === len) {
                    return;
                }

                var delay = settings.duration / len,
                    itemDelay = 0;

                loadingSpeed = delay;

                $items.each(function ($index, $item) {
                    $item.style.animationDelay = itemDelay + 'ms';
                    itemDelay += delay;
                });

            } else {

                setFancyAnimation();

                function setFancyAnimation() {

                    var $item = $elem.find(".premium-fancy-list-items"),
                        current = 1;

                    //Get effect settings
                    var delay = settings.delay || 2500,
                        loopCount = settings.count;

                    //If Loop Count option is set
                    if (loopCount) {
                        var currentLoop = 1,
                            fancyStringsCount = $elem.find(".premium-fancy-list-items").length;
                    }

                    var loopInterval = setInterval(function () {

                        var animationClass = "";

                        //Add animation class
                        if (settings.effect === "custom")
                            animationClass = "animated " + settings.animation;

                        //Show current active item
                        $item.eq(current).addClass("premium-fancy-item-visible " + animationClass).removeClass("premium-fancy-item-hidden");

                        var $inactiveItems = $item.filter(function (index) {
                            return index !== current;
                        });

                        //Hide inactive items
                        $inactiveItems.addClass("premium-fancy-item-hidden").removeClass("premium-fancy-item-visible " + animationClass);

                        current++;

                        //Restart loop
                        if ($item.length === current)
                            current = 0;

                        //Increment interval and check if loop count is reached
                        if (loopCount) {
                            currentLoop++;

                            if ((fancyStringsCount * loopCount) === currentLoop)
                                clearInterval(loopInterval);
                        }


                    }, delay);

                }
            }

            //Show the strings after the layout is set.
            if ("typing" !== settings.effect) {
                setTimeout(function () {
                    $elem.find(".premium-fancy-text").css('opacity', '1');
                }, 500);

            }

            if ('loading' === settings.loading && 'typing' !== settings.effect) {
                $scope.find('.premium-fancy-text').append('<span class="premium-loading-bar"></span>');
                $scope.find('.premium-loading-bar').css({
                    'animation-iteration-count': loopCount,
                    'animation-duration': loadingSpeed + 'ms'
                });
            }

        };

        /****** Premium Countdown Handler ******/
        var PremiumCountDownHandler = function ($scope, $) {

            var $countDownElement = $scope.find(".premium-countdown"),
                settings = $countDownElement.data("settings"),
                id = $scope.data('id'),
                label1 = settings.label1,
                label2 = settings.label2,
                newLabe1 = label1.split(","),
                newLabel2 = label2.split(","),
                timerType = settings.timerType,
                until = 'evergreen' === timerType ? settings.until.date : settings.until,
                layout = '',
                map = {
                    y: { index: 0, oldVal: '' },
                    o: { index: 1, oldVal: '' },
                    w: { index: 2, oldVal: '' },
                    d: { index: 3, oldVal: '' },
                    h: { index: 4, oldVal: '' },
                    m: { index: 5, oldVal: '' },
                    s: { index: 6, oldVal: '' }
                };

            if ($countDownElement.find('#countdown-' + id).hasClass('premium-countdown-flip')) {
                settings.format.split('').forEach(function (unit) {
                    var lowercased = unit.toLowerCase();

                    layout += '<div class="premium-countdown-block premium-countdown-' + lowercased + '"><div class="pre_time-mid"> <div class="premium-countdown-figure"><span class="top">{' + lowercased + 'nn}</span><span class="top-back"><span>{' + lowercased + 'nn}</span></span><span class="bottom">{' + lowercased + 'nn}</span><span class="bottom-back"><span>{' + lowercased + 'nn}</span></span></div><span class="premium-countdown-label">{' + lowercased + 'l}</span></div><span class="countdown_separator">{sep}</span></div>';
                });
            }

            $countDownElement.find('#countdown-' + id).countdown({
                layout: layout,
                labels: newLabel2,
                labels1: newLabe1,
                until: new Date(until),
                format: settings.format,
                padZeroes: true,
                timeSeparator: settings.separator,
                onTick: function (periods) {

                    equalWidth();

                    if ($countDownElement.find('#countdown-' + id).hasClass('premium-countdown-flip')) {
                        animateFigure(periods, map);
                    }
                },
                onExpiry: function () {
                    if ('onExpiry' === settings.event) {
                        $countDownElement.find('#countdown-' + id).html(settings.text);
                    }
                },
                serverSync: function () {
                    return new Date(settings.serverSync);
                }
            });

            if (settings.reset) {
                $countDownElement.find('.premium-countdown-init').countdown('option', 'until', new Date(until));
            }

            if ('expiryUrl' === settings.event) {
                $countDownElement.find('#countdown-' + id).countdown('option', 'expiryUrl', (elementorFrontend.isEditMode()) ? '' : settings.text);
            }

            function equalWidth() {
                var width = 0;
                $countDownElement.find('#countdown-' + id + ' .countdown-amount').each(function (index, slot) {
                    if (width < $(slot).outerWidth()) {
                        width = $(slot).outerWidth();
                    }
                });

                $countDownElement.find('#countdown-' + id + ' .countdown-amount').css('width', width);
            }

            function animateFigure(periods, map) {
                settings.format.split('').forEach(function (unit) {

                    var lowercased = unit.toLowerCase(),
                        index = map[lowercased].index,
                        oldVal = map[lowercased].oldVal;

                    if (periods[index] !== oldVal) {

                        map[lowercased].oldVal = periods[index];

                        var $top = $('#countdown-' + id).find('.premium-countdown-' + lowercased + ' .top'),
                            $back_top = $('#countdown-' + id).find('.premium-countdown-' + lowercased + ' .top-back');

                        TweenMax.to($top, 0.8, {
                            rotationX: '-180deg',
                            transformPerspective: 300,
                            ease: Quart.easeOut,
                            onComplete: function () {
                                TweenMax.set($top, { rotationX: 0 });
                            }
                        });

                        TweenMax.to($back_top, 0.8, {
                            rotationX: 0,
                            transformPerspective: 300,
                            ease: Quart.easeOut,
                            clearProps: 'all'
                        });
                    }
                });
            }

            times = $countDownElement.find('#countdown-' + id).countdown("getTimes");

            function runTimer(el) {
                return el == 0;
            }

            if (times.every(runTimer)) {

                if ('onExpiry' === settings.event) {
                    $countDownElement.find('#countdown-' + id).html(settings.text);
                } else if ('expiryUrl' === settings.event && !elementorFrontend.isEditMode()) {
                    var editMode = $('body').find('#elementor').length;
                    if (0 < editMode) {
                        $countDownElement.find('#countdown-' + id).html(
                            "<h1>You can not redirect url from elementor Editor!!</h1>");
                    } else {
                        if (!elementorFrontend.isEditMode()) {
                            window.location.href = settings.text;
                        }
                    }

                }
            }

        };

        /****** Premium Carousel Handler ******/
        var PremiumCarouselHandler = function ($scope, $) {

            var $carouselElem = $scope.find(".premium-carousel-wrapper"),
                settings = $($carouselElem).data("settings"),
                isEdit = elementorFrontend.isEditMode();

            function slideToShow(slick) {

                var slidesToShow = slick.options.slidesToShow,
                    windowWidth = $(window).width();
                if (windowWidth > settings.tabletBreak) {
                    slidesToShow = settings.slidesDesk;
                }
                if (windowWidth <= settings.tabletBreak) {
                    slidesToShow = settings.slidesTab;
                }
                if (windowWidth <= settings.mobileBreak) {
                    slidesToShow = settings.slidesMob;
                }
                return slidesToShow;

            }

            //Get templates content on the editor page
            if (isEdit) {

                $carouselElem.find(".item-wrapper").each(function (index, slide) {

                    var templateID = $(slide).data("template");

                    if (undefined !== templateID) {
                        $.ajax({
                            type: "GET",
                            url: PremiumSettings.ajaxurl,
                            dataType: "html",
                            data: {
                                action: "get_elementor_template_content",
                                templateID: templateID
                            }
                        }).success(function (response) {

                            var data = JSON.parse(response).data;

                            if (undefined !== data.template_content) {

                                $(slide).html(data.template_content);
                                $carouselElem.find(".premium-carousel-inner").slick("refresh");

                            }
                        });
                    }
                });

            }

            $carouselElem.on("init", function (event) {

                event.preventDefault();

                setTimeout(function () {
                    resetAnimations("init");
                }, 500);

                $(this).find("item-wrapper.slick-active").each(function () {
                    var $this = $(this);
                    $this.addClass($this.data("animation"));
                });

                $(".slick-track").addClass("translate");

            });

            $carouselElem.find(".premium-carousel-inner").slick({
                vertical: settings.vertical,
                slidesToScroll: settings.slidesToScroll,
                slidesToShow: settings.slidesToShow,
                responsive: [{
                    breakpoint: settings.tabletBreak,
                    settings: {
                        slidesToShow: settings.slidesTab,
                        slidesToScroll: settings.slidesTab,
                        swipe: settings.touchMove,
                    }
                },
                {
                    breakpoint: settings.mobileBreak,
                    settings: {
                        slidesToShow: settings.slidesMob,
                        slidesToScroll: settings.slidesMob,
                        swipe: settings.touchMove,
                    }
                }
                ],
                useTransform: true,
                fade: settings.fade,
                infinite: settings.infinite,
                speed: settings.speed,
                autoplay: settings.autoplay,
                autoplaySpeed: settings.autoplaySpeed,
                draggable: settings.draggable,
                rtl: settings.rtl,
                adaptiveHeight: settings.adaptiveHeight,
                pauseOnHover: settings.pauseOnHover,
                centerMode: settings.centerMode,
                centerPadding: settings.centerPadding,
                arrows: settings.arrows,
                prevArrow: $carouselElem.find(".premium-carousel-nav-arrow-prev").html(),
                nextArrow: $carouselElem.find(".premium-carousel-nav-arrow-next").html(),
                dots: settings.dots,
                customPaging: function () {
                    var customDot = $carouselElem.find(".premium-carousel-nav-dot").html();
                    return customDot;
                }
            });

            function resetAnimations(event) {

                var $slides = $carouselElem.find(".slick-slide");

                if ("init" === event)
                    $slides = $slides.not(".slick-current");

                $slides.find(".animated").each(function (index, elem) {

                    var settings = $(elem).data("settings");

                    if (!settings)
                        return;

                    if (!settings._animation && !settings.animation)
                        return;

                    var animation = settings._animation || settings.animation;

                    $(elem).removeClass("animated " + animation).addClass("elementor-invisible");
                });
            };

            function triggerAnimation() {

                $carouselElem.find(".slick-active .elementor-invisible").each(function (index, elem) {

                    var settings = $(elem).data("settings");

                    if (!settings)
                        return;

                    if (!settings._animation && !settings.animation)
                        return;

                    var delay = settings._animation_delay ? settings._animation_delay : 0,
                        animation = settings._animation || settings.animation;

                    setTimeout(function () {
                        $(elem).removeClass("elementor-invisible").addClass(animation +
                            ' animated');
                    }, delay);
                });
            }

            $carouselElem.on("afterChange", function (event, slick, currentSlide) {

                var slidesScrolled = slick.options.slidesToScroll,
                    slidesToShow = slideToShow(slick),
                    centerMode = slick.options.centerMode,
                    slideToAnimate = currentSlide + slidesToShow - 1;

                //Trigger Aniamtions for the current slide
                triggerAnimation();

                if (slidesScrolled === 1) {
                    if (!centerMode === true) {
                        var $inViewPort = $(this).find("[data-slick-index='" + slideToAnimate +
                            "']");
                        if ("null" != settings.animation) {
                            $inViewPort.find("p, h1, h2, h3, h4, h5, h6, span, a, img, i, button")
                                .addClass(settings.animation).removeClass(
                                    "premium-carousel-content-hidden");
                        }
                    }
                } else {
                    for (var i = slidesScrolled + currentSlide; i >= 0; i--) {
                        $inViewPort = $(this).find("[data-slick-index='" + i + "']");
                        if ("null" != settings.animation) {
                            $inViewPort.find("p, h1, h2, h3, h4, h5, h6, span, a, img, i, button")
                                .addClass(settings.animation).removeClass(
                                    "premium-carousel-content-hidden");
                        }
                    }
                }
            });

            $carouselElem.on("beforeChange", function (event, slick, currentSlide) {

                //Reset Aniamtions for the other slides
                resetAnimations();

                var $inViewPort = $(this).find("[data-slick-index='" + currentSlide + "']");

                if ("null" != settings.animation) {
                    $inViewPort.siblings().find(
                        "p, h1, h2, h3, h4, h5, h6, span, a, img, i, button").removeClass(
                            settings.animation).addClass(
                                "premium-carousel-content-hidden");
                }
            });

            if (settings.vertical) {

                var maxHeight = -1;

                elementorFrontend.elements.$window.on('load', function () {
                    $carouselElem.find(".slick-slide").each(function () {
                        if ($(this).height() > maxHeight) {
                            maxHeight = $(this).height();
                        }
                    });
                    $carouselElem.find(".slick-slide").each(function () {
                        if ($(this).height() < maxHeight) {
                            $(this).css("margin", Math.ceil(
                                (maxHeight - $(this).height()) / 2) + "px 0");
                        }
                    });
                });
            }
            var marginFix = {
                element: $("a.ver-carousel-arrow"),
                getWidth: function () {
                    var width = this.element.outerWidth();
                    return width / 2;
                },
                setWidth: function (type) {
                    type = type || "vertical";
                    if (type == "vertical") {
                        this.element.css("margin-left", "-" + this.getWidth() + "px");
                    } else {
                        this.element.css("margin-top", "-" + this.getWidth() + "px");
                    }
                }
            };
            marginFix.setWidth();
            marginFix.element = $("a.carousel-arrow");
            marginFix.setWidth("horizontal");

            $(document).ready(function () {

                settings.navigation.map(function (item, index) {

                    if (item) {

                        $(item).on("click", function () {

                            var currentActive = $carouselElem.find(".premium-carousel-inner").slick("slickCurrentSlide");

                            if (index !== currentActive) {
                                $carouselElem.find(".premium-carousel-inner").slick("slickGoTo", index)
                            }

                        })
                    }

                })
            })

        };

        var PremiumBannerHandler = ModuleHandler.extend({

            getDefaultSettings: function () {

                return {
                    selectors: {
                        bannerElement: '.premium-banner',
                        bannerImgWrap: '.premium-banner-ib',
                        bannerImg: 'img',
                    }
                }

            },

            getDefaultElements: function () {

                var selectors = this.getSettings('selectors');

                return {
                    $bannerElement: this.$element.find(selectors.bannerElement),
                    $bannerImgWrap: this.$element.find(selectors.bannerImgWrap),
                    $bannerImg: this.$element.find(selectors.bannerImg)
                }

            },

            bindEvents: function () {

                var _this = this;

                _this.elements.$bannerImgWrap.hover(function () {
                    _this.elements.$bannerImg.addClass("active");
                }, function () {
                    _this.elements.$bannerImg.removeClass("active");
                });

                this.run();
            },

            run: function () {

                var $bannerElement = this.elements.$bannerElement;

                if ($bannerElement.data("box-tilt")) {
                    var reverse = $bannerElement.data("box-tilt-reverse");
                    UniversalTilt.init({
                        elements: $bannerElement,
                        settings: {
                            reverse: reverse
                        },
                        callbacks: {
                            onMouseLeave: function (el) {
                                el.style.boxShadow = "0 45px 100px rgba(255, 255, 255, 0)";
                            },
                            onDeviceMove: function (el) {
                                el.style.boxShadow = "0 45px 100px rgba(255, 255, 255, 0.3)";
                            }
                        }
                    });

                }
            }

        });

        /****** Premium Modal Box Handler ******/
        var PremiumModalBoxHandler = function ($scope, $) {

            var $modalElem = $scope.find(".premium-modal-box-container"),
                settings = $modalElem.data("settings"),
                $modal = $modalElem.find(".premium-modal-box-modal-dialog");

            if (!settings) {
                return;
            }

            if (settings.trigger === "pageload") {
                $(document).ready(function ($) {
                    setTimeout(function () {
                        $modalElem.find(".premium-modal-box-modal").modal();
                    }, settings.delay * 1000);
                });
            }

            if ($modal.data("modal-animation") && " " != $modal.data("modal-animation")) {

                var animationDelay = $modal.data('delay-animation');

                new Waypoint({
                    element: $modal,
                    handler: function () {
                        setTimeout(function () {
                            $modal.css("opacity", "1").addClass("animated " + $modal.data("modal-animation"));
                        }, animationDelay * 1000);
                        this.destroy();
                    },
                    offset: Waypoint.viewportHeight() - 150,
                });
            }
        };

        /****** Premium Blog Handler ******/
        var PremiumBlogHandler = ModuleHandler.extend({

            settings: {},

            getDefaultSettings: function () {
                return {
                    selectors: {
                        user: '.fa-user',
                        activeCat: '.category.active',
                        loading: '.premium-loading-feed',
                        blogElement: '.premium-blog-wrap',
                        blogFilterTabs: '.premium-blog-filter',
                        contentWrapper: '.premium-blog-content-wrapper',
                        blogPost: '.premium-blog-post-outer-container',
                        metaSeparators: '.premium-blog-meta-separator',
                        filterLinks: '.premium-blog-filters-container li a',
                        currentPage: '.premium-blog-pagination-container .page-numbers.current',
                        activeElememnt: '.premium-blog-filters-container li .active',
                    }
                }
            },

            getDefaultElements: function () {
                var selectors = this.getSettings('selectors'),
                    elements = {
                        $blogElement: this.$element.find(selectors.blogElement),
                        $blogFilterTabs: this.$element.find(selectors.blogFilterTabs),
                        $activeCat: this.$element.find(selectors.activeCat),
                        $filterLinks: this.$element.find(selectors.filterLinks),
                        $blogPost: this.$element.find(selectors.blogPost),
                        $contentWrapper: this.$element.find(selectors.contentWrapper)
                    };

                return elements;
            },

            bindEvents: function () {
                this.setLayoutSettings();
                this.removeMetaSeparators();
                this.run();
            },

            setLayoutSettings: function () {

                var settings = this.getElementSettings(),
                    $blogPost = this.elements.$blogPost;

                var layoutSettings = {
                    pageNumber: 1,
                    isLoaded: true,
                    count: 2,
                    equalHeight: settings.force_height,
                    layout: settings.premium_blog_layout,
                    carousel: 'yes' === settings.premium_blog_carousel ? true : false,
                    infinite: 'yes' === settings.premium_blog_infinite_scroll ? true : false,
                    scrollAfter: 'yes' === settings.scroll_to_offset ? true : false,
                    grid: 'yes' === settings.premium_blog_grid ? true : false,
                    total: $blogPost.data('total'),
                };


                if (layoutSettings.carousel) {

                    layoutSettings.slidesToScroll = settings.slides_to_scroll;
                    layoutSettings.spacing = parseInt(settings.premium_blog_carousel_spacing);
                    layoutSettings.autoPlay = 'yes' === settings.premium_blog_carousel_play ? true : false;
                    layoutSettings.arrows = 'yes' === settings.premium_blog_carousel_arrows ? true : false;
                    layoutSettings.fade = 'yes' === settings.premium_blog_carousel_fade ? true : false;
                    layoutSettings.center = 'yes' === settings.premium_blog_carousel_center ? true : false;
                    layoutSettings.dots = 'yes' === settings.premium_blog_carousel_dots ? true : false;
                    layoutSettings.speed = '' !== settings.premium_blog_carousel_autoplay_speed ? parseInt(settings.premium_blog_carousel_autoplay_speed) : 5000;

                }

                this.settings = layoutSettings;

            },

            removeMetaSeparators: function () {

                var selectors = this.getSettings('selectors'),
                    $blogPost = this.$element.find(selectors.blogPost);

                var $metaSeparators = $blogPost.first().find(selectors.metaSeparators),
                    $user = $blogPost.find(selectors.user);

                if (1 === $metaSeparators.length) {
                    //If two meta only are enabled. One of them is author meta.
                    if (!$user.length) {
                        $blogPost.find(selectors.metaSeparators).remove();
                    }

                } else {
                    if (!$user.length) {
                        $blogPost.each(function (index, post) {
                            $(post).find(selectors.metaSeparators).first().remove();
                        });
                    }
                }

            },
            run: function () {

                var _this = this,
                    $blogElement = this.elements.$blogElement,
                    $activeCategory = this.elements.$activeCat.data('filter'),
                    $filterTabs = this.elements.$blogFilterTabs.length,
                    pagination = $blogElement.data("pagination");

                this.settings.activeCategory = $activeCategory;
                this.settings.filterTabs = $filterTabs;



                if (this.settings.filterTabs) {
                    this.filterTabs();
                }

                if (!this.settings.filterTabs || "*" === this.settings.activeCategory) {
                    if ("masonry" === this.settings.layout && !this.settings.carousel) {
                        $blogElement.imagesLoaded(function () {
                            $blogElement.isotope(_this.getIsoTopeSettings());
                        });
                    }
                } else {
                    //If `All` categories not exist, then we need to get posts through AJAX.
                    this.getPostsByAjax(false);
                }

                if (this.settings.carousel) {
                    $blogElement.slick(this.getSlickSettings());
                }

                if ("even" === this.settings.layout && this.settings.equalHeight) {
                    $blogElement.imagesLoaded(function () {
                        _this.forceEqualHeight();
                    });
                }

                if (pagination) {
                    this.paginate();
                }

                if (this.settings.infinite && $blogElement.is(":visible")) {
                    this.getInfiniteScrollPosts();
                }

            },

            paginate: function () {
                var _this = this,
                    $scope = this.$element,
                    selectors = this.getSettings('selectors');

                $scope.on('click', '.premium-blog-pagination-container .page-numbers', function (e) {

                    e.preventDefault();

                    if ($(this).hasClass("current")) return;

                    var currentPage = parseInt($scope.find(selectors.currentPage).html());

                    if ($(this).hasClass('next')) {
                        _this.settings.pageNumber = currentPage + 1;
                    } else if ($(this).hasClass('prev')) {
                        _this.settings.pageNumber = currentPage - 1;
                    } else {
                        _this.settings.pageNumber = $(this).html();
                    }

                    _this.getPostsByAjax(_this.settings.scrollAfter);

                })
            },

            forceEqualHeight: function () {
                var heights = new Array(),
                    contentWrapper = this.getSettings('selectors').contentWrapper,
                    $blogWrapper = this.$element.find(contentWrapper);

                $blogWrapper.each(function (index, post) {

                    var height = $(post).outerHeight();

                    heights.push(height);
                });

                var maxHeight = Math.max.apply(null, heights);

                $blogWrapper.css("height", maxHeight + "px");
            },

            getSlickSettings: function () {

                var settings = this.settings,
                    slickCols = settings.grid ? this.getSlickCols() : null,
                    cols = settings.grid ? slickCols.cols : 1,
                    colsTablet = settings.grid ? slickCols.colsTablet : 1,
                    colsMobile = settings.grid ? slickCols.colsMobile : 1,
                    prevArrow = settings.arrows ? '<a type="button" data-role="none" class="carousel-arrow carousel-prev" aria-label="Previous" role="button" style=""><i class="fas fa-angle-left" aria-hidden="true"></i></a>' : '',
                    nextArrow = settings.arrows ? '<a type="button" data-role="none" class="carousel-arrow carousel-next" aria-label="Next" role="button" style=""><i class="fas fa-angle-right" aria-hidden="true"></i></a>' : '';

                return {
                    infinite: true,
                    slidesToShow: cols,
                    slidesToScroll: settings.slidesToScroll || cols,
                    responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: colsTablet,
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: colsMobile,
                            slidesToScroll: 1
                        }
                    }
                    ],
                    autoplay: settings.autoPlay,
                    rows: 0,
                    autoplaySpeed: settings.speed,
                    nextArrow: nextArrow,
                    prevArrow: prevArrow,
                    fade: settings.fade,
                    centerMode: settings.center,
                    centerPadding: settings.spacing + "px",
                    draggable: true,
                    dots: settings.dots,
                    customPaging: function () {
                        return '<i class="fas fa-circle"></i>';
                    }
                }

            },

            getSlickCols: function () {
                var slickCols = this.getElementSettings(),
                    cols = slickCols.premium_blog_columns_number,
                    colsTablet = slickCols.premium_blog_columns_number_tablet,
                    colsMobile = slickCols.premium_blog_columns_number_mobile;

                return {
                    cols: parseInt(100 / cols.substr(0, cols.indexOf('%'))),
                    colsTablet: parseInt(100 / colsTablet.substr(0, colsTablet.indexOf('%'))),
                    colsMobile: parseInt(100 / colsMobile.substr(0, colsMobile.indexOf('%'))),
                }

            },

            getIsoTopeSettings: function () {
                return {
                    itemSelector: ".premium-blog-post-outer-container",
                    percentPosition: true,
                    filter: this.settings.activeCategory,
                    animationOptions: {
                        duration: 750,
                        easing: "linear",
                        queue: false
                    }
                }
            },

            filterTabs: function () {

                var _this = this,
                    selectors = this.getSettings('selectors'),
                    $filterLinks = this.elements.$filterLinks;

                $filterLinks.click(function (e) {

                    e.preventDefault();

                    _this.$element.find(selectors.activeElememnt).removeClass("active");

                    $(this).addClass("active");

                    //Get clicked tab slug
                    _this.settings.activeCategory = $(this).attr("data-filter");

                    _this.settings.pageNumber = 1;

                    if (_this.settings.infinite) {
                        _this.getPostsByAjax(false);
                        _this.settings.count = 2;
                        _this.getInfiniteScrollPosts();
                    } else {
                        //Make sure to reset pagination before sending our AJAX request
                        _this.getPostsByAjax(_this.settings.scrollAfter);
                    }

                });
            },

            getPostsByAjax: function (shouldScroll) {

                //If filter tabs is not enabled, then always set category to all.
                if ('undefined' === typeof this.settings.activeCategory) {
                    this.settings.activeCategory = '*';
                }

                var _this = this,
                    $blogElement = this.elements.$blogElement,
                    selectors = this.getSettings('selectors');

                $.ajax({
                    url: PremiumSettings.ajaxurl,
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        action: 'pa_get_posts',
                        page_id: $blogElement.data('page'),
                        widget_id: _this.$element.data('id'),
                        page_number: _this.settings.pageNumber,
                        category: _this.settings.activeCategory,
                        nonce: PremiumSettings.nonce,
                    },
                    beforeSend: function () {

                        $blogElement.append('<div class="premium-loading-feed"><div class="premium-loader"></div></div>');

                        if (shouldScroll) {
                            $('html, body').animate({
                                scrollTop: (($blogElement.offset().top) - 50)
                            }, 'slow');
                        }

                    },
                    success: function (res) {
                        if (!res.data)
                            return;

                        $blogElement.find(selectors.loading).remove();

                        var posts = res.data.posts,
                            paging = res.data.paging;

                        if (_this.settings.infinite) {
                            _this.settings.isLoaded = true;
                            if (_this.settings.filterTabs && _this.settings.pageNumber === 1) {
                                $blogElement.html(posts);
                            } else {
                                $blogElement.append(posts);
                            }
                        } else {
                            //Render the new markup into the widget
                            $blogElement.html(posts);

                            _this.$element.find(".premium-blog-footer").html(paging);
                        }

                        _this.removeMetaSeparators();

                        //Make sure grid option is enabled.
                        if (_this.settings.layout) {
                            if ("even" === _this.settings.layout) {
                                if (_this.settings.equalHeight)
                                    _this.forceEqualHeight();

                            } else {

                                $blogElement.imagesLoaded(function () {

                                    $blogElement.isotope('reloadItems');
                                    $blogElement.isotope({
                                        itemSelector: ".premium-blog-post-outer-container",
                                        animate: false
                                    });
                                });
                            }
                        }

                    },
                    error: function (err) {
                        console.log(err);
                    }

                });
            },

            getInfiniteScrollPosts: function () {
                var windowHeight = jQuery(window).outerHeight() / 1.25,
                    _this = this;

                $(window).scroll(function () {

                    if (_this.settings.filterTabs) {
                        $blogPost = _this.elements.$blogElement.find(".premium-blog-post-outer-container");
                        _this.settings.total = $blogPost.data('total');
                    }

                    if (_this.settings.count <= _this.settings.total) {
                        if (($(window).scrollTop() + windowHeight) >= (_this.$element.find('.premium-blog-post-outer-container:last').offset().top)) {
                            if (true == _this.settings.isLoaded) {
                                _this.settings.pageNumber = _this.settings.count;
                                _this.getPostsByAjax(false);
                                _this.settings.count++;
                                _this.settings.isLoaded = false;
                            }

                        }
                    }
                });
            },

        });

        /****** Premium Image Scroll Handler ******/
        var PremiumImageScrollHandler = function ($scope, $) {
            var scrollElement = $scope.find(".premium-image-scroll-container"),
                scrollOverlay = scrollElement.find(".premium-image-scroll-overlay"),
                scrollVertical = scrollElement.find(".premium-image-scroll-vertical"),
                dataElement = scrollElement.data("settings"),
                imageScroll = scrollElement.find("img"),
                direction = dataElement["direction"],
                reverse = dataElement["reverse"],
                transformOffset = null;

            function startTransform() {
                imageScroll.css("transform", (direction === "vertical" ? "translateY" : "translateX") + "( -" +
                    transformOffset + "px)");
            }

            function endTransform() {
                imageScroll.css("transform", (direction === "vertical" ? "translateY" : "translateX") + "(0px)");
            }

            function setTransform() {
                if (direction === "vertical") {
                    transformOffset = imageScroll.height() - scrollElement.height();
                } else {
                    transformOffset = imageScroll.width() - scrollElement.width();
                }
            }
            if (dataElement["trigger"] === "scroll") {
                scrollElement.addClass("premium-container-scroll");
                if (direction === "vertical") {
                    scrollVertical.addClass("premium-image-scroll-ver");
                } else {
                    scrollElement.imagesLoaded(function () {
                        scrollOverlay.css({
                            width: imageScroll.width(),
                            height: imageScroll.height()
                        });
                    });
                }
            } else {
                if (reverse === "yes") {
                    scrollElement.imagesLoaded(function () {
                        scrollElement.addClass("premium-container-scroll-instant");
                        setTransform();
                        startTransform();
                    });
                }
                if (direction === "vertical") {
                    scrollVertical.removeClass("premium-image-scroll-ver");
                }
                scrollElement.mouseenter(function () {
                    scrollElement.removeClass("premium-container-scroll-instant");
                    setTransform();
                    reverse === "yes" ? endTransform() : startTransform();
                });
                scrollElement.mouseleave(function () {
                    reverse === "yes" ? startTransform() : endTransform();
                });
            }
        };


        /****** Premium Contact Form 7 Handler ******/
        var PremiumContactFormHandler = function ($scope, $) {

            var $contactForm = $scope.find(".premium-cf7-container");
            var $input = $contactForm.find(
                'input[type="text"], input[type="email"], textarea, input[type="password"], input[type="date"], input[type="number"], input[type="tel"], input[type="file"], input[type="url"]'
            );

            $input.wrap("<span class='wpcf7-span'>");

            $input.on("focus blur", function () {
                $(this).closest(".wpcf7-span").toggleClass("is-focused");
            });
        };

        /****** Premium Team Members Handler ******/
        var PremiumTeamMembersHandler = ModuleHandler.extend({

            getDefaultSettings: function () {

                return {
                    slick: {
                        infinite: true,
                        rows: 0,
                        prevArrow: '<a type="button" data-role="none" class="carousel-arrow carousel-prev" aria-label="Next" role="button" style=""><i class="fas fa-angle-left" aria-hidden="true"></i></a>',
                        nextArrow: '<a type="button" data-role="none" class="carousel-arrow carousel-next" aria-label="Next" role="button" style=""><i class="fas fa-angle-right" aria-hidden="true"></i></a>',
                        draggable: true,
                        pauseOnHover: true,
                    },
                    selectors: {
                        multiplePersons: '.multiple-persons',
                        person: '.premium-person-container',
                        imgContainer: '.premium-person-image-container',
                        imgWrap: '.premium-person-image-wrap'

                    }
                }
            },

            getDefaultElements: function () {

                var selectors = this.getSettings('selectors');

                return {
                    $multiplePersons: this.$element.find(selectors.multiplePersons),
                    $persons: this.$element.find(selectors.person),
                    $imgWrap: this.$element.find(selectors.imgWrap),
                }

            },
            bindEvents: function () {
                this.run();
            },
            getSlickSettings: function () {

                var settings = this.getElementSettings(),
                    rtl = this.elements.$multiplePersons.data("rtl"),
                    colsNumber = settings.persons_per_row,
                    colsTablet = settings.persons_per_row_tablet,
                    colsMobile = settings.persons_per_row_mobile;

                return Object.assign(this.getSettings('slick'), {

                    slidesToShow: parseInt(100 / colsNumber.substr(0, colsNumber.indexOf('%'))),
                    slidesToScroll: parseInt(100 / colsNumber.substr(0, colsNumber.indexOf('%'))),
                    responsive: [{
                        breakpoint: 1025,
                        settings: {
                            slidesToShow: parseInt(100 / colsTablet.substr(0, colsTablet.indexOf('%'))),
                            slidesToScroll: 1
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: parseInt(100 / colsMobile.substr(0, colsMobile.indexOf('%'))),
                            slidesToScroll: 1
                        }
                    }
                    ],
                    autoplay: settings.carousel_play,
                    rtl: rtl ? true : false,
                    autoplaySpeed: settings.speed || 5000,

                });


            },

            runEqualHeight: function () {

                var $persons = this.elements.$persons,
                    $imgWrap = this.elements.$imgWrap;

                var selectors = this.getSettings('selectors'),
                    heights = new Array();

                $persons.each(function (index, person) {
                    $(person).imagesLoaded(function () { }).done(function () {

                        var imageHeight = $(person).find(selectors.imgContainer).outerHeight();

                        heights.push(imageHeight);
                    });
                });

                $persons.imagesLoaded(function () { }).done(function () {
                    var maxHeight = Math.max.apply(null, heights);
                    $imgWrap.css("height", maxHeight + "px");
                });

            },

            run: function () {

                var $multiplePersons = this.elements.$multiplePersons;

                if (!$multiplePersons.length) return;

                var carousel = this.getElementSettings('carousel');

                if (carousel)
                    $multiplePersons.slick(this.getSlickSettings());

                if ($multiplePersons.hasClass("premium-person-style1")) return;

                if ("yes" !== $multiplePersons.data("persons-equal")) return;

                this.runEqualHeight();

            }

        });

        /****** Premium Title Handler ******/
        var PremiumTitleHandler = function ($scope, $) {

            var $titleContainer = $scope.find(".premium-title-container"),
                $titleElement = $titleContainer.find('.premium-title-text');

            if ($titleContainer.hasClass('style9')) {
                var $style9 = $scope.find(".premium-title-style9");

                $style9.each(function () {
                    var elm = $(this);
                    var holdTime = elm.attr('data-blur-delay') * 1000;
                    elm.attr('data-animation-blur', 'process')
                    elm.find('.premium-title-style9-letter').each(function (index, letter) {
                        index += 1;
                        var animateDelay;
                        if ($('body').hasClass('rtl')) {
                            animateDelay = 0.2 / index + 's';
                        } else {
                            animateDelay = index / 20 + 's';
                        }
                        $(letter).css({
                            '-webkit-animation-delay': animateDelay,
                            'animation-delay': animateDelay
                        });
                    })
                    setInterval(function () {
                        elm.attr('data-animation-blur', 'done')
                        setTimeout(function () {
                            elm.attr('data-animation-blur', 'process')
                        }, 150);
                    }, holdTime);
                });
            }


            if ($titleContainer.hasClass('style8')) {

                var holdTime = $titleElement.attr('data-shiny-delay') * 1000,
                    duration = $titleElement.attr('data-shiny-dur') * 1000;

                function shinyEffect() {
                    $titleElement.get(0).setAttribute('data-animation', 'shiny');
                    setTimeout(function () {
                        $titleElement.removeAttr('data-animation')
                    }, duration);
                }

                (function repeat() {
                    shinyEffect();
                    setTimeout(repeat, holdTime);
                })();
            }

        };

        /****** Premium Bullet List Handler ******/
        var PremiumBulletListHandler = function ($scope, $) {

            var $listItems = $scope.find(".premium-bullet-list-box"),
                items = $listItems.find(".premium-bullet-list-content");

            items.each(function (index, item) {

                if ($listItems.data("list-animation") && " " != $listItems.data("list-animation")) {
                    elementorFrontend.waypoint($(item), function () {

                        var element = $(item),
                            delay = element.data('delay');

                        setTimeout(function () {
                            element.next('.premium-bullet-list-divider , .premium-bullet-list-divider-inline').css("opacity", "1");
                            element.next('.premium-bullet-list-divider-inline , .premium-bullet-list-divider').addClass("animated " + $listItems.data("list-animation"));

                            element.css("opacity", "1").addClass("animated " + $listItems.data("list-animation"));
                        }, delay);

                    });
                }

            });
        };

        /****** Premium Grow Effect Handler ******/
        var PremiumButtonHandler = function ($scope, $) {

            var $btnGrow = $scope.find('.premium-button-style6-bg');

            if ($btnGrow.length !== 0 && $scope.hasClass('premium-mouse-detect-yes')) {
                $scope.on('mouseenter mouseleave', '.premium-button-style6', function (e) {

                    var parentOffset = $(this).offset(),
                        left = e.pageX - parentOffset.left,
                        top = e.pageY - parentOffset.top;

                    $btnGrow.css({
                        top: top,
                        left: left,
                    });

                });
            }

        };

        var PremiumMaskHandler = function ($scope, $) {
            var mask = $scope.hasClass('premium-mask-yes');

            if (!mask) return;

            if ('premium-addon-title.default' === $scope.data('widget_type')) {
                var target = '.premium-title-header';
                $scope.find(target).find('.premium-title-icon, .premium-title-img').addClass('premium-mask-span');
            } else {
                var target = '.premium-dual-header-first-header';
            }

            $scope.find(target).find('span:not(.premium-title-style7-stripe-wrap):not(.premium-title-img)').each(function (index, span) {
                var html = '';

                $(this).text().split(' ').forEach(function (item) {
                    if ('' !== item) {
                        html += ' <span class="premium-mask-span">' + item + '</span>';
                    }
                });

                $(this).text('').append(html);
            });

            elementorFrontend.waypoint($scope, function () {
                $($scope).addClass('premium-mask-active');
            });
        };


        var functionalHandlers = {
            'premium-addon-dual-header.default': PremiumMaskHandler,
            'premium-addon-video-box.default': PremiumVideoBoxWidgetHandler,
            'premium-addon-fancy-text.default': PremiumFancyTextHandler,
            'premium-counter.default': PremiumCounterHandler,
            'premium-addon-title.default': [PremiumTitleHandler, PremiumMaskHandler],
            'premium-countdown-timer.default': PremiumCountDownHandler,
            'premium-carousel-widget.default': PremiumCarouselHandler,
            'premium-addon-modal-box.default': PremiumModalBoxHandler,
            'premium-image-scroll.default': PremiumImageScrollHandler,
            'premium-contact-form.default': PremiumContactFormHandler,
            'premium-icon-list.default': PremiumBulletListHandler,
            'premium-addon-button.default': PremiumButtonHandler,
            'premium-addon-image-button.default': PremiumButtonHandler
        };

        var classHandlers = {
            'premium-addon-person': PremiumTeamMembersHandler,
            'premium-addon-blog': PremiumBlogHandler,
            'premium-img-gallery': PremiumGridWidgetHandler,
            'premium-addon-banner': PremiumBannerHandler,
        };

        $.each(functionalHandlers, function (elemName, func) {
            if ('object' === typeof func) {
                $.each(func, function (index, handler) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/' + elemName, handler);
                })
            } else {
                elementorFrontend.hooks.addAction('frontend/element_ready/' + elemName, func);
            }

        });

        $.each(classHandlers, function (elemName, clas) {
            elementorFrontend.elementsHandler.attachHandler(elemName, clas);
        });


        if (elementorFrontend.isEditMode()) {
            elementorFrontend.hooks.addAction("frontend/element_ready/premium-addon-progressbar.default", PremiumProgressBarWidgetHandler);
        } else {
            elementorFrontend.hooks.addAction("frontend/element_ready/premium-addon-progressbar.default", PremiumProgressBarScrollWidgetHandler);
        }
    });
})(jQuery);