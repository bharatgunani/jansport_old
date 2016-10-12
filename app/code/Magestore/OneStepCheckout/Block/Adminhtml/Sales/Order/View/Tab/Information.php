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

namespace Magestore\OneStepCheckout\Block\Adminhtml\Sales\Order\View\Tab;

/**
 * Class Information
 * @package Magestore\OneStepCheckout\Block\Adminhtml\Sales\Order\View\Tab
 */
class Information extends \Magento\Backend\Block\Template implements \Magento\Backend\Block\Widget\Tab\TabInterface
{

    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Backend\Block\Template\Context   $context
     * @param \Magento\Framework\Registry               $registry
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array                                     $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = []
    )
    {
        $this->_coreRegistry = $registry;
        $this->_objectManager = $objectManager;
        parent::__construct($context);
    }


    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel()
    {
        return __('Information');
    }

    /**
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle()
    {
        return __('Information');
    }

    /**
     * @return bool
     */
    public function canShowTab()
    {
        return TRUE;
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return FALSE;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->_coreRegistry->registry('current_order');
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->getRequest()->getParam('order_id');
    }

    /**
     * @return mixed
     */
    public function getDelivery()
    {
        $orderId = $this->getOrderId();
        $delivery = $this->_objectManager->create('Magestore\OneStepCheckout\Model\Delivery')
            ->load($orderId, 'order_id');

        return $delivery;
    }

    /**
     * @return mixed
     */
    public function getSurvey()
    {
        $orderId = $this->getOrderId();
        $survey = $this->_objectManager->create('Magestore\OneStepCheckout\Model\Survey')
            ->load($orderId, 'order_id');

        return $survey;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        $orderId = $this->getOrderId();
        $comment = $this->_objectManager->create('Magento\Sales\Model\Order')
            ->load($orderId)->getOnestepcheckoutOrderComment();

        return $comment;
    }

    /**
     * @param null $orderId
     *
     * @return bool
     */
    public function getLastItem($orderId = NULL)
    {
        if (!$orderId) {
            $order_id = $this->getOrderId();
        } else {
            $order_id = $orderId;
        }

        $order = $this->_loadOrder($order_id);
        $itemCollection = $order->getItemsCollection();
        $lastItem = $itemCollection->setPageSize(1)->setCurPage($itemCollection->getLastPageNumber())->getLastItem();

        if ($lastItem->getParentItemId()) {
            $lastId = $lastItem->getParentItemId();
        } else {
            $lastId = $lastItem->getId();
        }
        if ($lastId != $this->getParentBlock()->getItem()->getId()) {
            return FALSE;
        }

        return TRUE;
    }

    /**
     * @param $order_id
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function _loadOrder($order_id)
    {
        if ($order_id) {
            /** @var \Magento\Sales\Model\Order $order */
            $order = $this->_objectManager->create('Magento\Sales\Model\Order');

            return $order->load($order_id);
        } elseif ($invoiceId = $this->getRequest()->getParam('invoice_id')) {
            /** @var \Magento\Sales\Model\Order\Invoice $invoice */
            $invoice = $this->_objectManager->create('Magento\Sales\Model\Order\Invoice');

            return $invoice->load($invoiceId)->getOrder();
        } elseif ($shipmentId = $this->getRequest()->getParam('shipment_id')) {
            /** @var \Magento\Sales\Model\Order\Shipment $shipment */
            $shipment = $this->_objectManager->create('Magento\Sales\Model\Order\Shipment');

            return $shipment->load($shipmentId)->getOrder();
        } else {
            /** @var \Magento\Sales\Model\Order\Creditmemo $creditmemo */
            $creditmemo = $this->_objectManager->create('Magento\Sales\Model\Order\Creditmemo');

            return $creditmemo->load($this->getRequest()->getParam('creditmemo_id'))->getOrder();
        }
    }

}