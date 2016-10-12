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

use Magento\GiftMessage\Helper\Message;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class GiftMessageConfigObserver
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class GiftMessageConfigObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var \Magestore\OneStepCheckout\Model\SystemConfig
     */
    protected $_systemConfig;

    /**
     * GiftMessageConfigObserver constructor.
     *
     * @param \Magento\Store\Model\StoreManagerInterface    $storeManager
     * @param \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig
     */
    public function __construct(
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig
    )
    {
        $this->_storeManager = $storeManager;
        $this->_systemConfig = $systemConfig;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $scopeId = 1;
        $isGiftMessage = $this->_systemConfig->enableGiftMessage();

        $this->_systemConfig->getResourceConfig()->saveConfig(
            Message::XPATH_CONFIG_GIFT_MESSAGE_ALLOW_ORDER,
            $isGiftMessage,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $scopeId
        );
        $this->_systemConfig->getResourceConfig()->saveConfig(
            Message::XPATH_CONFIG_GIFT_MESSAGE_ALLOW_ITEMS,
            $isGiftMessage,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            $scopeId
        );
    }
}
