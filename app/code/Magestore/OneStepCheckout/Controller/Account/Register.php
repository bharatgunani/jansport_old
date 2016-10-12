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

namespace Magestore\OneStepCheckout\Controller\Account;

use Magento\Customer\Api\Data\CustomerInterface;

/**
 * Class Register
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Register extends \Magestore\OneStepCheckout\Controller\Index
{
    /**
     * @return $this
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->_resultJsonFactory->create();

        /** @var \Magento\Framework\DataObject $paramsData */
        $paramsData = $this->_getParamDataObject();

        /** @var \Magento\Store\Model\StoreManagerInterface $storeManager */
        $storeManager = $this->_objectManager->get('Magento\Store\Model\StoreManagerInterface');

        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->_customerFactory->create([
            'data' => [
                CustomerInterface::FIRSTNAME    => $paramsData->getData('firstName'),
                CustomerInterface::LASTNAME     => $paramsData->getData('lastName'),
                CustomerInterface::EMAIL        => $paramsData->getData('userName'),
                CustomerInterface::WEBSITE_ID   => $storeManager->getStore()->getWebsiteId(),
                CustomerInterface::STORE_ID     => $storeManager->getStore()->getId(),
                'password'                      => $paramsData->getData('password'),
                CustomerInterface::CONFIRMATION => $paramsData->getData('confirm'),
            ],
        ]);

        try {
            $customer->save();
            $this->_eventManager->dispatch(
                'customer_register_success',
                ['account_controller' => $this, 'customer' => $customer]
            );
        } catch (\Exception $e) {
            $result = ['success' => FALSE, 'error' => $e->getMessage()];

            return $resultJson->setData($result);
        }

        $result = ['success' => TRUE];
        $this->_customerSession->setCustomerAsLoggedIn($customer);

        return $resultJson->setData($result);
    }

}
