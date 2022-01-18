jQuery(window).on("elementor/frontend/init", function () {

    elementorFrontend.hooks.addAction(
        "frontend/element_ready/premium-addon-maps.default",
        function ($scope, $) {

            var mapElement = $scope.find(".premium_maps_map_height");

            var mapSettings = mapElement.data("settings");

            var mapStyle = mapElement.data("style");

            var premiumMapMarkers = [];

            premiumMap = newMap(mapElement, mapSettings, mapStyle);

            var markerCluster = JSON.parse(mapSettings["cluster"]);

            function newMap(map, settings, mapStyle) {
                var scrollwheel = JSON.parse(settings["scrollwheel"]);
                var streetViewControl = JSON.parse(settings["streetViewControl"]);
                var fullscreenControl = JSON.parse(settings["fullScreen"]);
                var zoomControl = JSON.parse(settings["zoomControl"]);
                var mapTypeControl = JSON.parse(settings["typeControl"]);
                var centerLat = JSON.parse(settings["centerlat"]);
                var centerLong = JSON.parse(settings["centerlong"]);
                var autoOpen = JSON.parse(settings["automaticOpen"]);
                var hoverOpen = JSON.parse(settings["hoverOpen"]);
                var hoverClose = JSON.parse(settings["hoverClose"]);
                var args = {
                    zoom: settings["zoom"],
                    mapTypeId: settings["maptype"],
                    center: { lat: centerLat, lng: centerLong },
                    scrollwheel: scrollwheel,
                    streetViewControl: streetViewControl,
                    fullscreenControl: fullscreenControl,
                    zoomControl: zoomControl,
                    mapTypeControl: mapTypeControl,
                    styles: mapStyle
                };

                if ("yes" === mapSettings.drag)
                    args.gestureHandling = "none";

                var markers = map.find(".premium-pin");

                var map = new google.maps.Map(map[0], args);

                map.markers = [];
                // add markers
                markers.each(function (index) {
                    add_marker(jQuery(this), map, autoOpen, hoverOpen, hoverClose, index);
                });

                return map;
            }

            var activeInfoWindow;
            function add_marker(pin, map, autoOpen, hoverOpen, hoverClose, zIndex) {
                var latlng = new google.maps.LatLng(
                    pin.attr("data-lat"),
                    pin.attr("data-lng")
                ),
                    icon_img = pin.attr("data-icon"),
                    maxWidth = pin.attr("data-max-width"),
                    customID = pin.attr("data-id"),
                    iconSize = parseInt(pin.attr("data-icon-size"));

                if (icon_img != "") {
                    var icon = {
                        url: pin.attr("data-icon")
                    };

                    if (iconSize) {

                        icon.scaledSize = new google.maps.Size(iconSize, iconSize);
                        icon.origin = new google.maps.Point(0, 0);
                        icon.anchor = new google.maps.Point(iconSize / 2, iconSize);
                    }
                }



                // create marker
                var marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    icon: icon,
                    zIndex: zIndex
                });


                // add to array
                map.markers.push(marker);

                premiumMapMarkers.push(marker);

                //Used with Carousel Custom Navigation option
                if (customID) {
                    google.maps.event.addListener(marker, "click", function () {

                        var $carouselWidget = $(".premium-carousel-wrapper");

                        if ($carouselWidget.length) {
                            $carouselWidget.map(function (index, item) {
                                var carouselSettings = $(item).data("settings");

                                if (carouselSettings.navigation) {
                                    if (-1 != carouselSettings.navigation.indexOf("#" + customID)) {
                                        var slideIndex = carouselSettings.navigation.indexOf("#" + customID);
                                        $(item).find(".premium-carousel-inner").slick("slickGoTo", slideIndex);
                                    }
                                }
                            })

                        }

                    });
                }

                // if marker contains HTML, add it to an infoWindow
                if (
                    pin.find(".premium-maps-info-title").html() ||
                    pin.find(".premium-maps-info-desc").html()
                ) {
                    // create info window
                    var infowindow = new google.maps.InfoWindow({
                        maxWidth: maxWidth,
                        content: pin.html()
                    });
                    if (autoOpen) {
                        infowindow.open(map, marker);
                    }
                    if (hoverOpen) {

                        var isTouch = checkTouchDevice(),
                            triggerEvent = isTouch ? "click" : "mouseover"

                        google.maps.event.addListener(marker, triggerEvent, function () {
                            if (isTouch) {
                                if (activeInfoWindow) { activeInfoWindow.close(); }
                            }

                            infowindow.open(map, marker);
                            activeInfoWindow = infowindow;
                        });

                        if (hoverClose && !isTouch) {
                            google.maps.event.addListener(marker, "mouseout", function () {
                                infowindow.close(map, marker);
                            });
                        }
                    }
                    // show info window when marker is clicked
                    google.maps.event.addListener(marker, "click", function () {

                        //Used with Carousel Custom Navigation option
                        if (customID) {

                            var $carouselWidget = $(".premium-carousel-wrapper");

                            if ($carouselWidget.length) {
                                $carouselWidget.map(function (index, item) {
                                    var carouselSettings = $(item).data("settings");

                                    if (carouselSettings.navigation) {
                                        if (-1 != carouselSettings.navigation.indexOf("#" + customID)) {
                                            var slideIndex = carouselSettings.navigation.indexOf("#" + customID);
                                            $carouselWidget.find(".premium-carousel-inner").slick("slickGoTo", slideIndex);
                                        }
                                    }
                                })

                            }

                        }
                        infowindow.open(map, marker);
                    });
                }
            }

            function checkTouchDevice() {

                var isTouchDevice = navigator.userAgent.match(/(iPhone|iPod|iPad|Android|playbook|silk|BlackBerry|BB10|Windows Phone|Tizen|Bada|webOS|IEMobile|Opera Mini)/),
                    isTouch = (('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0) || (navigator.maxTouchPoints));

                return isTouchDevice || isTouch;

            }

            if (markerCluster) {
                var markerCluster = new MarkerClusterer(premiumMap, premiumMapMarkers, {
                    imagePath:
                        "https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
                });
            }
        }
    );
});
