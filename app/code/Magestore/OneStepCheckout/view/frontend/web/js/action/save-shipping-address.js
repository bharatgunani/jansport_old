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

define(
    [
        'jquery',
        "underscore",
        'Magento_Checkout/js/model/quote',
        'Magestore_OneStepCheckout/js/action/convert-shipping-method-code',
        'Magento_Checkout/js/model/address-converter',
        'Magestore_OneStepCheckout/js/model/custom-checkout-data',
        'Magestore_OneStepCheckout/js/model/loading-manager',
        'Magestore_OneStepCheckout/js/action/get-payment-information',
        'mage/storage',
        'mage/url',
        'Magestore_OneStepCheckout/js/model/full-screen-loader',
    ],
    function (
        $,
        _,
        quote,
        convertShippingMethodCode,
        addressConverter,
        customCheckoutData,
        loadingManager,
        getPaymentInformation,
        storage,
        url,
        fullScreenLoader
    ) {
        'use strict';
        var updateSectionConfig = window.oneStepCheckoutConfig.updateOnChangeAddress,
            $orderReviewContainer = $('#checkout-review-load'),
            $shippingMethodContainer = $('#shipping-method-wrapper');

        return function (allowLoadPaymentInformation) {
            if (quote.isVirtual()) {
                return;
            }
            var serviceUrl = window.oneStepCheckoutConfig.saveAddressUrl,
                payload = {
                    shipping_address: addressConverter.quoteAddressToFormAddressData(quote.shippingAddress()),
                    shipping_address_id: customCheckoutData.shippingAddressId(),
                    shipping_method: convertShippingMethodCode.hashToString(quote.shippingMethod()),
                    payment_method_data:  quote.paymentMethod(),
                    additional_data: customCheckoutData.getAdditionalData()
                };

            loadingManager.startLoaderShippingMethod(updateSectionConfig.shippingMethod, true);
            loadingManager.startLoaderPaymentMethod(updateSectionConfig.payment, true);
            loadingManager.startLoaderOrderReviewMethod(updateSectionConfig.review, true);
            loadingManager.disablePlaceOrder(true);

            return storage.post(
                serviceUrl, JSON.stringify(payload), false
            ).done(
                function (response) {
                    customCheckoutData.isSavedCheckoutData(true);

                    if (response.shipping_method) {
                        $shippingMethodContainer.shippingMethod('updateShippingMethodInfo', response.shipping_method);
                    }

                    if (response.review_info) {
                        $orderReviewContainer.orderReview('updateOrderReview', response.review_info);
                    }

                    if (response.payment_method && allowLoadPaymentInformation) {
                        getPaymentInformation();
                    }
                }
            ).fail(
                function (response) {
                }
            ).always(
                function (response) {
                    loadingManager.stopLoaderAll();
                    loadingManager.disablePlaceOrder(false);
                }
            );
        };
    }
);
