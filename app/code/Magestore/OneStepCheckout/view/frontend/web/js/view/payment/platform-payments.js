define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'paguelofacil_gateway',
                component: 'Magestore_OneStepCheckout/js/view/payment/method-renderer/platform-method'
            }
        );
        /** Add view logic here if needed */
        return Component.extend({});
    }
);