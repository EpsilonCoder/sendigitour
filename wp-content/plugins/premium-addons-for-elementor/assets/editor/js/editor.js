(function () {
    var $ = jQuery;

    var selectOptions = elementor.modules.controls.Select2.extend({

        onBeforeRender: function () {
            if (this.container && "section" === this.container.type) {
                var widgetObj = elementor.widgetsCache || elementor.config.widgets,
                    optionsToUpdate = {};

                this.container.children.forEach(function (child) {

                    child.view.$childViewContainer.children("[data-widget_type]").each(function (index, widget) {
                        var name = $(widget).data("widget_type").split('.')[0];

                        if ('undefined' !== typeof widgetObj[name]) {
                            optionsToUpdate[".elementor-widget-" + widgetObj[name].widget_type + " .elementor-widget-container"] = widgetObj[name].title;
                        }
                    });
                });

                this.model.set("options", optionsToUpdate);
            }
        },
    });

    elementor.addControlView("premium-select", selectOptions);

    var filterOptions = elementor.modules.controls.Select2.extend({

        isUpdated: false,

        onReady: function () {
            var self = this,
                type = self.options.elementSettingsModel.attributes.post_type_filter;

            if ('post' !== type) {
                var options = (0 === this.model.get('options').length);

                if (options) {
                    self.fetchData(type);
                }
            }

            elementor.channels.editor.on('change', function (view) {
                var changed = view.elementSettingsModel.changed;

                if (undefined !== changed.post_type_filter && 'post' !== changed.post_type_filter && !self.isUpdated) {
                    self.isUpdated = true;
                    self.fetchData(changed.post_type_filter);
                }
            });
        },

        fetchData: function (type) {
            var self = this;
            $.ajax({
                url: PremiumSettings.ajaxurl,
                dataType: 'json',
                type: 'POST',
                data: {
                    nonce: PremiumSettings.nonce,
                    action: 'premium_update_filter',
                    post_type: type
                },
                success: function (res) {
                    self.updateFilterOptions(JSON.parse(res.data));
                    self.isUpdated = false;

                    self.render();
                },
                error: function (err) {
                    console.log(err);
                },
            });
        },

        updateFilterOptions: function (options) {
            this.model.set("options", options);
        },

        onBeforeDestroy: function () {
            if (this.ui.select.data('select2')) {
                this.ui.select.select2('destroy');
            }

            this.$el.remove();
        }
    });

    elementor.addControlView("premium-post-filter", filterOptions);

    var taxOptions = elementor.modules.controls.Select.extend({

        isUpdated: false,

        onReady: function () {
            var self = this,
                type = self.options.elementSettingsModel.attributes.post_type_filter,
                options = (0 === this.model.get('options').length);

            if (options) {
                self.fetchData(type);
            }

            elementor.channels.editor.on('change', function (view) {
                var changed = view.elementSettingsModel.changed;

                if (undefined !== changed.post_type_filter && !self.isUpdated) {
                    self.isUpdated = true;
                    self.fetchData(changed.post_type_filter);
                }
            });
        },

        fetchData: function (type) {
            var self = this;
            $.ajax({
                url: PremiumSettings.ajaxurl,
                dataType: 'json',
                type: 'POST',
                data: {
                    nonce: PremiumSettings.nonce,
                    action: 'premium_update_tax',
                    post_type: type
                },
                success: function (res) {
                    var options = JSON.parse(res.data);
                    self.updateTaxOptions(options);
                    self.isUpdated = false;

                    if (0 !== options.length) {
                        var $tax = Object.keys(options);
                        self.container.settings.setExternalChange({ 'filter_tabs_type': $tax[0] });
                        self.container.render();
                        self.render();
                    }
                },
                error: function (err) {
                    console.log(err);
                },
            });
        },

        updateTaxOptions: function (options) {
            this.model.set("options", options);
        },
    });

    elementor.addControlView("premium-tax-filter", taxOptions);

    var acfOptions = elementor.modules.controls.Select2.extend({

        isUpdated: false,

        onReady: function () {
            var self = this;

            if (!self.isUpdated ) {
                self.fetchData();
            }
        },

        fetchData: function () {
            var self = this;

            $.ajax({
                url: PremiumSettings.ajaxurl,
                dataType: 'json',
                type: 'POST',
                data: {
                    nonce: PremiumSettings.nonce,
                    action: 'pa_acf_options',
                    query_options: self.model.get('query_options'),
                },
                success: function (res) {
                    self.isUpdated = true;
                    self.updateAcfOptions(JSON.parse(res.data));
                    self.render();
                },
                error: function (err) {
                    console.log(err);
                },
            });
        },

        updateAcfOptions: function (options) {
            this.model.set("options", options);
        },

        onBeforeDestroy: function () {
            if (this.ui.select.data('select2')) {
                this.ui.select.select2('destroy');
            }

            this.$el.remove();
        }
    });

    elementor.addControlView("premium-acf-selector", acfOptions);
    
    elementor.hooks.addFilter("panel/elements/regionViews", function (panel) {

        if (PremiumPanelSettings.papro_installed || PremiumPanelSettings.papro_widgets.length <= 0)
            return panel;


        var paWidgetsPromoHandler, proCategoryIndex,
            elementsView = panel.elements.view,
            categoriesView = panel.categories.view,
            widgets = panel.elements.options.collection,
            categories = panel.categories.options.collection,
            premiumProCategory = [];

        _.each(PremiumPanelSettings.papro_widgets, function (widget, index) {
            widgets.add({
                name: widget.key,
                title: wp.i18n.__('Premium ', 'premium-addons-for-elementor') + widget.title,
                icon: widget.icon,
                categories: ["premium-elements-pro"],
                editable: false
            })
        });

        widgets.each(function (widget) {
            "premium-elements-pro" === widget.get("categories")[0] && premiumProCategory.push(widget)
        });

        proCategoryIndex = categories.findIndex({
            name: "premium-elements"
        });

        proCategoryIndex && categories.add({
            name: "premium-elements-pro",
            title: "Premium Addons Pro",
            defaultActive: !1,
            items: premiumProCategory
        }, {
            at: proCategoryIndex + 1
        });


        paWidgetsPromoHandler = {
            className: function () {

                var className = 'elementor-element-wrapper';

                if (!this.isEditable()) {
                    className += ' elementor-element--promotion';
                }

                if (this.model.get("name")) {
                    if (0 === this.model.get("name").indexOf("premium-"))
                        className += ' premium-promotion-element';
                }

                return className;

            },

            isPremiumWidget: function () {
                return 0 === this.model.get("name").indexOf("premium-");
            },

            getElementObj: function (key) {

                var widgetObj = PremiumPanelSettings.papro_widgets.find(function (widget, index) {
                    if (widget.key == key)
                        return true;
                });

                return widgetObj;

            },

            onMouseDown: function () {

                if (!this.isPremiumWidget())
                    return;

                elementor.promotion.dialog.buttons[0].removeClass("premium-promotion-btn");
                void this.constructor.__super__.onMouseDown.call(this);

                var widgetObject = this.getElementObj(this.model.get("name")),
                    actonURL = widgetObject.action_url;

                // console.log(widgetObject.action_url.indexOf('/?utm_source'));

                elementor.promotion.dialog.buttons[0].addClass("premium-promotion-btn").closest('#elementor-element--promotion__dialog').addClass('premium-promotion-dialog');

                $(".premium-promotion-pro-btn").remove();

                var goProCta = 'https://premiumaddons.com/pro' + actonURL.substring(actonURL.indexOf('/?utm_source'));

                var $goProBtn = $('<a>', { text: wp.i18n.__('Go Pro', 'elementor'), href: goProCta, class: 'premium-promotion-pro-btn dialog-button elementor-button', target: '_blank' });

                elementor.promotion.dialog.buttons[0].after($goProBtn);

                elementor.promotion.showDialog({
                    headerMessage: sprintf(wp.i18n.__('%s', 'elementor'), this.model.get("title")),
                    message: sprintf(wp.i18n.__('Use %s widget and dozens more pro features to extend your toolbox and build sites faster and better.', 'elementor'), this.model.get("title")),
                    top: "-7",
                    element: this.el,
                    actionURL: widgetObject.action_url
                })
            }
        }

        // setTimeout(function () {
        panel.elements.view = elementsView.extend({
            childView: elementsView.prototype.childView.extend(paWidgetsPromoHandler)
        });

        panel.categories.view = categoriesView.extend({
            childView: categoriesView.prototype.childView.extend({
                childView: categoriesView.prototype.childView.prototype.childView.extend(paWidgetsPromoHandler)
            })
        });
        // }, 2000);


        return panel;


    });

})(jQuery);