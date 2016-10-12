<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class AddFieldsToResponseObserver implements ObserverInterface
{
    /**
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * @var \Macrew\Paguelofacil\Model\Directpost
     */
    protected $payment;

    /**
     * @var \Macrew\Paguelofacil\Model\Directpost\Session
     */
    protected $session;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Macrew\Paguelofacil\Model\Directpost $payment
     * @param \Macrew\Paguelofacil\Model\Directpost\Session $session
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\Registry $coreRegistry,
        \Macrew\Paguelofacil\Model\Directpost $payment,
        \Macrew\Paguelofacil\Model\Directpost\Session $session,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->payment = $payment;
        $this->session = $session;
        $this->storeManager = $storeManager;
    }

    /**
     * Save order into registry to use it in the overloaded controller.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /* @var $order Order */
        $order = $this->coreRegistry->registry('directpost_order');

        if (!$order || !$order->getId()) {
            return $this;
        }

        $payment = $order->getPayment();

        if (!$payment || $payment->getMethod() != $this->payment->getCode()) {
            return $this;
        }

        $result = $observer->getData('result')->getData();

        if (!empty($result['error'])) {
            return $this;
        }

        // if success, then set order to session and add new fields
        $this->session->addCheckoutOrderIncrementId($order->getIncrementId());
        $this->session->setLastOrderIncrementId($order->getIncrementId());

        $requestToPaguelofacil = $payment->getMethodInstance()
            ->generateRequestFromOrder($order);
        $requestToPaguelofacil->setControllerActionName(
            $observer->getData('action')
                ->getRequest()
                ->getControllerName()
        );
        $requestToPaguelofacil->setIsSecure(
            (string)$this->storeManager->getStore()
                ->isCurrentlySecure()
        );

        $result[$this->payment->getCode()] = ['fields' => $requestToPaguelofacil->getData()];

        $observer->getData('result')->setData($result);

        return $this;
    }
}
