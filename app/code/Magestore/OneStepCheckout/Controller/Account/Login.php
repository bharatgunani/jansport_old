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

use Magento\Customer\Api\AccountManagementInterface;
use Magento\Framework\Exception\EmailNotConfirmedException;
use Magento\Framework\Exception\InvalidEmailOrPasswordException;

/**
 * Class Login
 *
 * @category Magestore
 * @package  Magestore_OneStepCheckout
 * @module   OneStepCheckout
 * @author   Magestore Developer
 */
class Login extends \Magestore\OneStepCheckout\Controller\Index
{
    /**
     * @var AccountManagementInterface
     */
    protected $_customerAccountManagement;

    /**
     * Login constructor.
     *
     * @param \Magestore\OneStepCheckout\Controller\Context $context
     * @param AccountManagementInterface                    $customerAccountManagement
     */
    public function __construct(
        \Magestore\OneStepCheckout\Controller\Context $context
    ) {
        parent::__construct($context);
        $this->_customerAccountManagement = $context->getAccountManagement();
    }

    /**
     * @return $this
     */
    public function execute()
    {
        $credentials = NULL;
        $httpBadRequestCode = 400;

        $resultRaw = $this->_resultRawFactory->create();
        try {
            $paramsData = $this->_getParamDataObject();

            $username = $paramsData->getData('username');
            $password = $paramsData->getData('password');
            $credentials['username'] = $username;
            $credentials['password'] = $password;
        } catch (\Exception $e) {
            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
        }
        if (!$credentials || $this->getRequest()->getMethod() !== 'POST' || !$this->getRequest()->isXmlHttpRequest()) {
            return $resultRaw->setHttpResponseCode($httpBadRequestCode);
        }

        $response = [
            'errors'  => FALSE,
            'message' => __('Login successful.'),
        ];
        try {
            $customer = $this->_customerAccountManagement->authenticate(
                $credentials['username'],
                $credentials['password']
            );
            $this->_customerSession->setCustomerDataAsLoggedIn($customer);
            $this->_customerSession->regenerateId();
        } catch (EmailNotConfirmedException $e) {
            $response = [
                'errors'  => TRUE,
                'message' => $e->getMessage(),
            ];
        } catch (InvalidEmailOrPasswordException $e) {
            $response = [
                'errors'  => TRUE,
                'message' => $e->getMessage(),
            ];
        } catch (\Exception $e) {
            $response = [
                'errors'  => TRUE,
                'message' => __('Invalid login or password.'),
            ];
        }

        $resultJson = $this->_resultJsonFactory->create();

        return $resultJson->setData($response);
    }
}
