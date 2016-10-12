<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magestore\OneStepCheckout\Block\Checkout;

class LayoutProcessor implements \Magento\Checkout\Block\Checkout\LayoutProcessorInterface
{
    /**
     * Process js Layout of block
     *
     * @param array $jsLayout
     * @return array
     */
    public function process($jsLayout)
    {
        // The following code is a workaround for custom address attributes
        if (isset($jsLayout['components']['payment']['children']
        )) {
            if (!isset($jsLayout['components']['payment']['children']['payments-list']['children'])) {
                $jsLayout['components']['payment']['children']['payments-list']['children'] = [];
            }

            $jsLayout['components']['payment']['children']['payments-list']['children'] =
                array_merge_recursive(
                    $jsLayout['components']['payment']['children']['payments-list']['children'],
                    $this->processPaymentConfiguration(
                        $jsLayout['components']['payment']['children']['renders']['children']
                    )
                );
        }

        return $jsLayout;
    }

    /**
     * Inject billing address component into every payment component
     *
     * @param array $configuration list of payment components
     * @param array $elements attributes that must be displayed in address form
     * @return array
     */
    protected function processPaymentConfiguration(array &$configuration)
    {
        $output = [];
        foreach ($configuration as $paymentGroup => $groupConfig) {
            if (empty($groupConfig['methods'])) {
                continue;
            }
            foreach ($groupConfig['methods'] as $paymentCode => $paymentComponent) {
                if (empty($paymentComponent['isBillingAddressRequired'])) {
                    continue;
                }
                $output[$paymentCode . '-form'] = [
                    'component' => 'Magestore_OneStepCheckout/js/view/billing-address',
                    'displayArea' => 'billing-address-form-' . $paymentCode,
                    'dataScopePrefix' => 'billingAddress' . $paymentCode,
                    'sortOrder' => 1,
                ];
            }
            unset($configuration[$paymentGroup]['methods']);
        }

        return $output;
    }
}
