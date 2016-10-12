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
 * Class OrderPlaceAfter
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class OrderPlaceAfter implements ObserverInterface
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $messageManager;

    /**
     * @var \Magestore\OneStepCheckout\Model\SystemConfig
     */
    protected $_systemConfig;

    /**
     * @var \Magestore\OneStepCheckout\Helper\Data
     */
    protected $_helper;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Payment\Helper\Data
     */
    protected $_paymentHelper;

    /**
     * OrderPlaceAfter constructor.
     *
     * @param \Magento\Checkout\Model\Session                     $checkoutSession
     * @param \Magestore\OneStepCheckout\Model\SystemConfig       $systemConfig
     * @param \Magento\Framework\Mail\Template\TransportBuilder   $transportBuilder
     * @param \Magento\Framework\App\Config\ScopeConfigInterface  $scopeConfig
     * @param \Magento\Framework\Translate\Inline\StateInterface  $inlineTranslation
     * @param \Magento\Sales\Model\Order\Email\Sender\OrderSender $sender
     * @param \Magento\Payment\Helper\Data                        $paymentHelper
     * @param \Magestore\OneStepCheckout\Helper\Data              $helper
     * @param array                                               $data
     */
    public function __construct(
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Sales\Model\Order\Email\Sender\OrderSender $sender,
        \Magento\Payment\Helper\Data $paymentHelper,
        \Magestore\OneStepCheckout\Helper\Data $helper,
        array $data = []
    )
    {
        $this->_checkoutSession = $checkoutSession;
        $this->_systemConfig = $systemConfig;
        $this->_transportBuilder = $transportBuilder;
        $this->_helper = $helper;
        $this->_scopeConfig = $scopeConfig;
        $this->inlineTranslation = $inlineTranslation;
        $this->_paymentHelper = $paymentHelper;
        $this->_sender = $sender;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $order = $observer->getEvent()->getOrder();
        $oscData = $this->_checkoutSession->getData('additional_data', false);
        if ($oscData) {
            $comment = $oscData['osc_comment'];
            if ($comment) {
                $order->setOnestepcheckoutOrderComment($comment);
                $order->addStatusHistoryComment($comment);
            }
            $isSubscriber =  $oscData['is_subscriber'];
            if ($isSubscriber) {
                if ($order->getShippingAddress()) {
                    $sendEmail = $order->getShippingAddress()->getEmail();
                } elseif ($order->getBillingAddress()) {
                    $sendEmail = $order->getBillingAddress()->getEmail();
                } else {
                    $sendEmail = '';
                }
                if ($sendEmail) {
                    $this->_helper->addSubscriber($sendEmail);
                }
            }
            $messageFrom = $oscData['osc_from_message'];
            $messageTo = $oscData['osc_to_message'];
            $message = $oscData['osc_message'];
            $customerId = $order->getCustomerId();
            if ($message) {
                $giftMessageSave = $this->_helper->saveGiftMessage($customerId, $messageFrom, $messageTo, $message);
                $order->setGiftMessageId($giftMessageSave->getId());
            }

        }

        $isGiftWrap = $this->_checkoutSession->getOnestepcheckoutGiftwrap();
        $giftWrapAmount = $this->_checkoutSession->getOnestepcheckoutGiftwrapAmount();
        $baseGiftWrapAmount = $this->_checkoutSession->getOnestepcheckoutGiftwrapAmount();
        if ($giftWrapAmount && $baseGiftWrapAmount && $isGiftWrap) {
            $order->setOnestepcheckoutGiftwrapAmount($giftWrapAmount);
            $order->setOnestepcheckoutBaseGiftwrapAmount($baseGiftWrapAmount);
        }
        $this->_checkoutSession->setOnestepcheckoutGiftwrapAmount(NULL);
        $this->_checkoutSession->setOnestepcheckoutBaseGiftwrapAmount(NULL);
        $this->_checkoutSession->setOnestepcheckoutGiftwrap(NULL);
    }
}
