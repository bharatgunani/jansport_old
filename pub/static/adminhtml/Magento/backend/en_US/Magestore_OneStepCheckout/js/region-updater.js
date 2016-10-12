/**
 * Magestore
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magestore.com license that is
 * available through the world-wide-web at this URL:
 * http://www.magestore.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magestore
 * @package     Magestore_OneStepCheckout
 * @copyright   Copyright (c) 2012 Magestore (http://www.magestore.com/)
 * @license     http://www.magestore.com/license-agreement.html
 */
define([
    'jquery',
    'mage/template',
    'underscore',
    'jquery/ui',
], function($, mageTemplate, _) {

    $.widget('magestore.regionUpdater', {
        options: {
            container: '',
            regionJson: {},
            regionTemplate: '<option value="<%- data.value %>" data-region-code="<%- data.code %>" title="<%- data.title %>" <% if (data.isSelected) { %>selected="selected"<% } %>>' +
            '<%- data.title %>' +
            '</option>',
            currentRegion: '',
            regionList: {},
            regionInput: {}
        },

        _create: function () {
            var options = this.options,
                regionList = options.regionList,
                regionInput = options.regionInput;
            this._initCountryElement();
            this._initRegionElement();

            this.currentRegionOption = options.currentRegion;
            this.regionTmpl = mageTemplate(options.regionTemplate);
            this._updateRegion(this.element.find('option:selected').val());
        },

        /**
         * init region element
         * @private
         */
        _initRegionElement: function () {
            var options = this.options,
                regionList = options.regionList,
                regionInput = options.regionInput;

            if($.isNumeric(options.defaultRegion)) {
                regionList.val(options.defaultRegion);
            } else {
                regionInput.val(options.defaultRegion);
            }

            regionList.on('change', $.proxy(function (e) {
                this.setOption = false;
                this.currentRegionOption = $(e.target).val();
            }, this));

            regionInput.on('focusout', $.proxy(function () {
                this.setOption = true;
            }, this));
        },

        /**
         * init country element
         * @private
         */
        _initCountryElement: function() {
            this.element.on('change', $.proxy(function (e) {
                this._updateRegion($(e.target).val());
            }, this));
        },

        /**
         * Remove options from dropdown list
         * @param {Object} selectElement - jQuery object for dropdown list
         * @private
         */
        _removeSelectOptions: function (selectElement) {
            selectElement.find('option').each(function (index) {
                if ($(this).val()) {
                    $(this).remove();
                }
            });
        },

        /**
         * Render dropdown list
         * @param {Object} selectElement - jQuery object for dropdown list
         * @param {String} key - region code
         * @param {Object} value - region object
         * @private
         */
        _renderSelectOption: function (selectElement, key, value) {
            selectElement.append($.proxy(function () {
                var name = value.name.replace(/[!"#$%&'()*+,.\/:;<=>?@[\\\]^`{|}~]/g, '\\$&'),
                    tmplData,
                    tmpl;

                if (value.code && $(name).is('span')) {
                    key = value.code;
                    value.name = $(name).text();
                }

                tmplData = {
                    value: key,
                    title: value.name,
                    isSelected: false,
                    code: value.code
                };

                if (this.options.defaultRegion === key) {
                    tmplData.isSelected = true;
                }

                tmpl = this.regionTmpl({
                    data: tmplData
                });

                return $(tmpl);
            }, this));
        },

        /**
         * Update dropdown list based on the country selected
         * @param {String} country - 2 uppercase letter for country code
         * @private
         */
        _updateRegion: function (country) {
            // Clear validation error messages
            var options = this.options,
                regionList = options.regionList,
                regionInput = options.regionInput;

            // Populate state/province dropdown list if available or use input box
            if (options.regionJson[country]) {
                this._removeSelectOptions(regionList);
                $.each(options.regionJson[country], $.proxy(function (key, value) {
                    this._renderSelectOption(regionList, key, value);
                }, this));

                if($.isNumeric(this.currentRegionOption)) {
                    regionList.val(this.currentRegionOption);
                } else {
                    regionInput.val(this.currentRegionOption);
                }


                if (this.setOption) {
                    regionList.find('option').filter(function () {
                        return this.text === regionInput.val();
                    }).prop('selected', true);
                }

                if(regionList.find('option:selected').length == 0) {
                    regionList.find('option').first().prop('selected', true);
                }

                regionList.prop('disabled', false).show();
                regionInput.prop('disabled', true).hide();
            } else {
                regionList.prop('disabled', true).hide();
                regionInput.prop('disabled', false).show();
            }

            // Add defaultvalue attribute to state/province select element
            regionList.attr('defaultvalue', this.options.defaultRegion);
        },

    });

    return $.magestore.regionUpdater;
});
