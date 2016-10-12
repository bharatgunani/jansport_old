<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class UpdateAllEditIncrementsObserver implements ObserverInterface
{
    /**
     *
     * @var \Macrew\Paguelofacil\Helper\Data
     */
    protected $paguelofacilData;

    /**
     * @param \Macrew\Paguelofacil\Helper\Data $paguelofacilData
     */
    public function __construct(
        \Macrew\Paguelofacil\Helper\Data $paguelofacilData
    ) {
        $this->paguelofacilData = $paguelofacilData;
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
        $order = $observer->getEvent()->getData('order');
        $this->paguelofacilData->updateOrderEditIncrements($order);

        return $this;
    }
}
