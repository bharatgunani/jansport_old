<?php

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

namespace Magestore\OneStepCheckout\Model\Total\Order\Invoice;

/**
 * Class GiftWrap
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class GiftWrap extends \Magento\Sales\Model\Order\Total\AbstractTotal
{
    /**
     * @param \Magento\Sales\Model\Order\Invoice $invoice
     *
     * @return $this
     */
    public function collect(\Magento\Sales\Model\Order\Invoice $invoice)
    {
        $invoice->setOnestepcheckoutGiftwrapAmount(0);
        $giftWrapAmount = $invoice->getOrder()->getOnestepcheckoutGiftwrapAmount();
        $baseGiftWrapAmount = $invoice->getOrder()->getOnestepcheckoutBaseGiftwrapAmount();
        if ($giftWrapAmount) {
            $invoice->setOnestepcheckoutGiftwrapAmount($giftWrapAmount);
            $invoice->setOnestepcheckoutBaseGiftwrapAmount($baseGiftWrapAmount);
            $invoice->setGrandTotal($invoice->getGrandTotal() + $giftWrapAmount);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $baseGiftWrapAmount);
        }

        return $this;
    }
}
