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

namespace Magestore\OneStepCheckout\Observer;

use Magento\Framework\Event\ObserverInterface;

/**
 * Class QuoteSubmitSuccess
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class QuoteSubmitSuccess implements ObserverInterface
{
    /**
     * @var \Magestore\OneStepCheckout\Helper\Data
     */
    protected $_helper;


    /**
     * QuoteSubmitSuccess constructor.
     *
     * @param \Magestore\OneStepCheckout\Helper\Data $helper
     */
    public function __construct(\Magestore\OneStepCheckout\Helper\Data $helper)
    {
        $this->_helper = $helper;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        $this->_helper->sendNewOrderEmail($order);
    }
}
