/**
 * Paguelofacil SA
 *
 * @copyright   Paguelofacil (http://paguelofacil.com)
 */
/*browser:true*/
/*global define*/
define(
    [
        'Magestore_OneStepCheckout/js/view/payment/cc-form-paguelofacil',
        'jquery',
        'Magento_Payment/js/model/credit-card-validation/validator'
    ],
    function (Component, $) {
        'use strict';

        return Component.extend({
            defaults: {
                template: 'Magestore_OneStepCheckout/payment/platform-form'
            },

            getCode: function() {
                return 'paguelofacil_gateway';
            },

            isActive: function() {
                return true;
            },

            validate: function() {
                var $form = $('#' + this.getCode() + '-form');
                return $form.validation() && $form.validation('isValid');
            }
        });
    }
);
