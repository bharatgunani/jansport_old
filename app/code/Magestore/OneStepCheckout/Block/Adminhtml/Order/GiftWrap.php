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

namespace Magestore\OneStepCheckout\Block\Adminhtml\Order;

/**
 * Class GiftWrap
 * @package Magestore\OneStepCheckout\Block\Adminhtml\Order
 */
class GiftWrap extends \Magento\Sales\Block\Adminhtml\Totals
{
    /**
     * Init totals
     */
    public function initTotals()
    {
        parent::_initTotals();
        $orderTotalsBlock = $this->getParentBlock();
        $order = $orderTotalsBlock->getOrder();
        $giftWrapAmount = $order->getOnestepcheckoutGiftwrapAmount();
        $baseGiftWrapAmount = $order->getOnestepcheckoutBaseGiftwrapAmount();
        if ($giftWrapAmount > 0) {
            $orderTotalsBlock->addTotal(new \Magento\Framework\DataObject([
                'code'       => 'gift_wrap',
                'label'      => __('Gift Wrap'),
                'value'      => $giftWrapAmount,
                'base_value' => $baseGiftWrapAmount,
            ]), 'subtotal');
        }
    }
}