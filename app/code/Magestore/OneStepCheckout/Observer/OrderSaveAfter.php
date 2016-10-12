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
class OrderSaveAfter implements ObserverInterface
{
    /**
     * @var \Magestore\OneStepCheckout\Model\DeliveryFactory
     */
    protected $_deliveryFactory;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Magento\Checkout\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magestore\OneStepCheckout\Model\SurveyFactory
     */
    protected $_surveyFactory;


    /**
     * @param \Magestore\OneStepCheckout\Model\DeliveryFactory $deliveryFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magestore\OneStepCheckout\Model\SurveyFactory $surveyFactory
     * @param array $data
     */
    public function __construct(
        \Magestore\OneStepCheckout\Model\DeliveryFactory $deliveryFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magestore\OneStepCheckout\Model\SurveyFactory $surveyFactory,
        array $data = []
    )
    {
        $this->_logger = $logger;
        $this->_deliveryFactory = $deliveryFactory;
        $this->_checkoutSession = $checkoutSession;
        $this->_surveyFactory = $surveyFactory;
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
        $orderId = $order->getId();
        $oscData = $this->_checkoutSession->getData('additional_data', true);
        if ($oscData) {
            $deliveryDate = $oscData['osc_delivery_date'];
            $deliveryTime = $oscData['osc_delivery_time'];
            $oscQuestion = $oscData['osc_question'];
            $oscAnswer = $oscData['osc_answer'];
            if ($orderId && $deliveryDate && $deliveryTime) {
                /** @var \Magestore\OneStepCheckout\Model\Delivery $delivery */
                $delivery = $this->_deliveryFactory->create()->setData([
                    'order_id'           => $orderId,
                    'delivery_time_date' => $deliveryDate . ' ' . $deliveryTime,
                ]);
                try {
                    $delivery->save();
                } catch (\Exception $e) {
                    $this->_logger->critical($e);
                }
            }

            if ($orderId && $oscQuestion && $oscAnswer) {
                /** @var \Magestore\OneStepCheckout\Model\Survey $survey */
                $survey = $this->_surveyFactory->create()->setData([
                    'order_id' => $orderId,
                    'question' => $oscQuestion,
                    'answer'   => $oscAnswer,
                ]);
                try {
                    $survey->save();
                } catch (\Exception $e) {
                    $this->_logger->critical($e);
                }
            }
        }

    }
}
