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
 * Class Style
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Style extends \Magestore\OneStepCheckout\Block\Adminhtml\Widget\System\Config\ConfigAbstract
{
    /**
     * @var string
     */
    protected $_template = 'Magestore_OneStepCheckout::system/config/style.phtml';

    /**
     * @return array
     */
    public function getFieldOptions()
    {
        return [
            'orange'   => __('Orange'),
            'green'    => __('Green'),
            'black'    => __('Black'),
            'blue'     => __('Blue'),
            'darkblue' => __('Dark Blue'),
            'pink'     => __('Pink'),
            'red'      => __('Red'),
            'violet'   => __('Violet'),
            'custom'   => __('Custom'),
        ];
    }

    /**
     * @param $number
     *
     * @return mixed
     */
    public function getDefaultField($path, $scope, $scopeId)
    {
        return $this->_scopeConfig->getValue($path, $scope, $scopeId);
    }

    /**
     * @param $number
     * @param $scope
     * @param $scopeId
     *
     * @return mixed
     */
    public function getFieldEnableBackEnd($path, $scope, $scopeId)
    {
        $configCollection = $this->_dataConfigCollectionFactory->create()
            ->addFieldToFilter('scope', $scope)
            ->addFieldToFilter('scope_id', $scopeId)
            ->addFieldToFilter('path', $path);
        if (count($configCollection)) {
            return $configCollection->getFirstItem()->getData('value');
        } else {
            return NULL;
        }
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getElementHtmlId($field)
    {
        return 'onestepcheckout_style_management_' . $field;
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getElementHtmlName($configName)
    {
        return 'groups[style_management][fields][' . $configName . '][value]';
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getCheckBoxElementHtmlId($configName)
    {
        return 'onestepcheckout_style_management_' . $configName . '_inherit';
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getCheckBoxElementHtmlName($configName)
    {
        return 'onestepcheckout_style_management_' . $configName . '][inherit]';
    }

    /**
     * @param $color
     *
     * @return string
     */
    public function getImageColor($color)
    {
        return $this->getViewFileUrl('Magestore_OneStepCheckout::images/style/' . $color . '.png');
    }
}