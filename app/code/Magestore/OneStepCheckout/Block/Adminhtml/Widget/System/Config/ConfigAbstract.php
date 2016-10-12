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

namespace Magestore\OneStepCheckout\Block\Adminhtml\Widget\System\Config;

/**
 * Class ConfigAbstract
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class ConfigAbstract extends \Magento\Backend\Block\Template
{

    /**
     * @var int
     */
    protected $_scopeId = 0;

    /**
     * @var string
     */
    protected $_scope = 'default';

    /**
     * @var \Magestore\OneStepCheckout\Model\SystemConfig
     */
    protected $_systemConfig;

    /**
     * @var \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory
     */
    protected $_dataConfigCollectionFactory;


    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array                                   $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magestore\OneStepCheckout\Model\SystemConfig $systemConfig,
        \Magento\Config\Model\ResourceModel\Config\Data\CollectionFactory $dataConfigCollectionFactory,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->_systemConfig = $systemConfig;
        $this->_dataConfigCollectionFactory = $dataConfigCollectionFactory;
    }

    /**
     * @param int $scopeId
     *
     * @return Position
     */
    public function setScopeId($scopeId)
    {
        $this->_scopeId = $scopeId;

        return $this;
    }

    /**
     * @param string $scope
     *
     * @return Position
     */
    public function setScope($scope)
    {
        $this->_scope = $scope;

        return $this;
    }

    /**
     * @return string
     */
    public function getScope()
    {
        return $this->_scope;
    }

    /**
     * @return int
     */
    public function getScopeId()
    {
        return $this->_scopeId;
    }

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        parent::_construct();
        $storeCode = $this->getRequest()->getParam('store');
        $website = $this->getRequest()->getParam('website');
        if ($storeCode) {
            $scopeId = $this->_storeManager->getStore($storeCode)->getId();
            $scope = 'stores';
        } elseif ($website) {
            $scope = 'websites';
            $scopeId = $this->_storeManager->getWebsite($website)->getId();
        } else {
            $scope = 'default';
            $scopeId = 0;
        }

        $this->setScopeId($scopeId);
        $this->setScope($scope);

        return $this;
    }

}