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

namespace Magestore\OneStepCheckout\Model\Total\Quote;

/**
 * Class GiftWrap
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
/**
 * Class GiftWrap
 * @package Magestore\OneStepCheckout\Model\Total\Quote
 */
class GiftWrap extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{

    /**
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    )
    {
        $this->setCode('gift_wrap');
        $this->priceCurrency = $priceCurrency;
        $this->_checkoutSession = $checkoutSession;
        $this->_systemConfig = $systemConfig;
    }


    /**
     * @param \Magento\Quote\Model\Quote                          $quote
     * @param \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment
     * @param \Magento\Quote\Model\Quote\Address\Total            $total
     *
     * @return $this
     */
    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    )
    {
        parent::collect($quote, $shippingAssignment, $total);
        $active = $this->_systemConfig->isEnableGiftWrap();
        if (!$active) {
            return $this;
        }

        $giftWrap = $this->_checkoutSession->getData('onestepcheckout_giftwrap');
        if (!$giftWrap) {
            return $this;
        }

        $items = $quote->getAllVisibleItems();
        if (!count($items)) {
            return $this;
        }

        $giftWrapType = $this->_systemConfig->getGiftWrapType();
        $giftWrapAmount = $this->_systemConfig->getGiftWrapAmount();
        $baseWrapTotal = 0;
        if ($giftWrapType == 1) {
            foreach ($items as $item) {
                if ($item->getProduct()->isVirtual() || $item->getParentItem()) {
                    continue;
                }
                $baseWrapTotal += $giftWrapAmount * ($item->getQty());
            }
        } else {
            $baseWrapTotal = $giftWrapAmount;
        }
        $wrapTotal = $this->priceCurrency->convert($baseWrapTotal);
        $this->_checkoutSession->setData('onestepcheckout_giftwrap_amount', $wrapTotal);
        $this->_checkoutSession->setData('onestepcheckout_base_giftwrap_amount', $baseWrapTotal);
        $total->setOnestepcheckoutGiftwrapAmount($wrapTotal);
        $total->setOnestepcheckoutBaseGiftwrapAmount($baseWrapTotal);
        $total->setGrandTotal($total->getGrandTotal() + $total->getOnestepcheckoutGiftwrapAmount());
        $total->setBaseGrandTotal($total->getBaseGrandTotal() + $total->getOnestepcheckoutBaseGiftwrapAmount());

        return $this;
    }


    /**
     * @param \Magento\Quote\Model\Quote               $quote
     * @param \Magento\Quote\Model\Quote\Address\Total $total
     *
     * @return array|null
     */
    public function fetch(\Magento\Quote\Model\Quote $quote, \Magento\Quote\Model\Quote\Address\Total $total)
    {
        $result = NULL;
        $amount = $total->getOnestepcheckoutGiftwrapAmount();
        if ($amount != 0) {
            $result = [
                'code'  => $this->getCode(),
                'title' => __('Gift Wrap'),
                'value' => $amount,
            ];
        }

        return $result;
    }
}
