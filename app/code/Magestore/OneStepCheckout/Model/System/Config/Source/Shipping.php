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

namespace Magestore\OneStepCheckout\Model\System\Config\Source;

/**
 * Class Shipping
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Shipping implements \Magento\Framework\Option\ArrayInterface
{

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * @var \Magento\Shipping\Model\CarrierFactory
     */
    protected $_carrierFactory;

    /**
     * Shipping constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Shipping\Model\CarrierFactory             $carrierFactory
     * @param \Magento\Framework\ObjectManagerInterface          $objectManager
     * @param array                                              $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Shipping\Model\CarrierFactory $carrierFactory,
        array $data = []
    )
    {
        $this->_scopeConfig = $scopeConfig;
        $this->_carrierFactory = $carrierFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $options = [
            [
                'label' => __('-- Please select --'),
                'value' => '',
            ],
        ];

        foreach ($this->_scopeConfig->getValue('carriers') as $code => $carrier) {
            $active = $carrier['active'];
            if ($active == 1 || $active == TRUE) {
                if (isset($carrier['title'])) {
                    $options[] = [
                        'label' => $carrier['title'],
                        'value' => $code,
                    ];
                }
            }
        }

        return $options;
    }
}
