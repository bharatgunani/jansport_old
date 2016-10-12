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

namespace Magestore\OneStepCheckout\Controller\GiftWrap;

/**
 * Class Process
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Process extends \Magestore\OneStepCheckout\Controller\Index
{
    /**
     * @return $this
     */
    public function execute()
    {
        $processData = $this->_dataObjectFactory->create([
            'data' => $this->_jsonHelper->jsonDecode($this->getRequest()->getContent()),
        ]);

        if ($processData->getData('isWrap')) {
            $this->_checkoutSession->setData('onestepcheckout_giftwrap', 1);
        } else {
            $this->_checkoutSession->unsetData('onestepcheckout_giftwrap');
            $this->_checkoutSession->unsetData('onestepcheckout_giftwrap_amount');
        }

        $this->getQuote()->collectTotals()->save();

        return $this->_getResultJson(TRUE, TRUE, TRUE);
    }
}
