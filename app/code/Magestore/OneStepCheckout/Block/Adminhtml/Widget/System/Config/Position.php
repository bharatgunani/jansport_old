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
 * Class Position
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Position extends \Magestore\OneStepCheckout\Block\Adminhtml\Widget\System\Config\ConfigAbstract
{
    /**
     * @var string
     */
    protected $_template = 'Magestore_OneStepCheckout::system/config/position.phtml';

    /**
     * @return array
     */
    public function getFieldOptions()
    {
        return [
            '0'          => __('Null'),
            'firstname'  => __('First Name'),
            'lastname'   => __('Last Name'),
            'prefix'     => __('Prefix Name'),
            'middlename' => __('Middle Name'),
            'suffix'     => __('Suffix Name'),
            'email'      => __('Email Address'),
            'company'    => __('Company'),
            'street'     => __('Address'),
            'country_id' => __('Country'),
            'region'     => __('State/Province'),
            'city'       => __('City'),
            'postcode'   => __('Zip/Postal Code'),
            'telephone'  => __('Telephone'),
            'fax'        => __('Fax'),
            'gender'     => __('Gender'),
            'vat_id'     => __('Tax/VAT number'),
        ];
    }

    /**
     * @param $number
     *
     * @return mixed
     */
    public function getDefaultField($number, $scope, $scopeId)
    {
        return $this->_scopeConfig
            ->getValue('onestepcheckout/field_position_management/row_' . $number, $scope, $scopeId);
    }

    /**
     * @param $number
     * @param $scope
     * @param $scopeId
     *
     * @return mixed
     */
    public function getFieldEnableBackEnd($number, $scope, $scopeId)
    {
        $configCollection = $this->_dataConfigCollectionFactory->create()
            ->addFieldToFilter('scope', $scope)
            ->addFieldToFilter('scope_id', $scopeId)
            ->addFieldToFilter('path', 'onestepcheckout/field_position_management/row_' . $number);

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
    public function getElementHtmlId($number)
    {
        return 'onestepcheckout_field_position_management_row_' . $number;
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getElementHtmlName($number)
    {
        return 'groups[field_position_management][fields][row_' . $number . '][value]';
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getCheckBoxElementHtmlId($number)
    {
        return 'onestepcheckout_field_position_management_row_' . $number . '_inherit';
    }

    /**
     * @param $number
     *
     * @return string
     */
    public function getCheckBoxElementHtmlName($number)
    {
        return 'groups[field_position_management][fields][row_' . $number . '][inherit]';
    }
}