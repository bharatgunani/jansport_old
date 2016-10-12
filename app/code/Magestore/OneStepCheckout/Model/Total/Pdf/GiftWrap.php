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

namespace Magestore\OneStepCheckout\Model\Total\Pdf;

/**
 * Class GiftWrap
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class GiftWrap extends \Magento\Sales\Model\Order\Pdf\Total\DefaultTotal
{

    /**
     * @return array
     */
    public function getTotalsForDisplay()
    {

        $amount = $this->getOrder()->formatPriceTxt($this->getOrder()->getOnestepcheckoutGiftwrapAmount());
        $fontSize = $this->getFontSize() ? $this->getFontSize() : 7;
        $totals = [[
            'label'     => __('Gift Wrap:'),
            'amount'    => $amount,
            'font_size' => $fontSize,]];

        return $totals;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->getOrder()->getOnestepcheckoutGiftwrapAmount();
    }

}
