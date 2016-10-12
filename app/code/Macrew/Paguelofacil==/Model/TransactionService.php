<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\HTTP\ZendClientFactory;
use Magento\Framework\Simplexml\Element;
use Magento\Framework\Xml\Security;
use Macrew\Paguelofacil\Model\Paguelofacil;
use Magento\Payment\Model\Method\Logger;

/**
 * Class TransactionService
 * @package Macrew\Paguelofacil\Model
 */
class TransactionService
{
    /**
     * Transaction Details gateway url
     */
    const POST_URL_ACTION = 'https://apitest.paguelofacil.net/';

    const PAYMENT_UPDATE_STATUS_CODE_SUCCESS = 'Ok';

    const CONNECTION_TIMEOUT = 45;

    /**
     * Stored information about transaction
     *
     * @var array
     */
    protected $transactionDetails = [];

    /**
     * @var \Magento\Framework\Xml\Security
     */
    protected $xmlSecurityHelper;

    /**
     * @var \Magento\Payment\Model\Method\Logger
     */
    protected $logger;

    /**
     * @var \Magento\Framework\HTTP\ZendClientFactory
     */
    protected $httpClientFactory;

    /**
     * Fields that should be replaced in debug with '***'
     *
     * @var array
     */
    protected $debugReplacePrivateDataKeys = ['merchantAuthentication', 'x_login'];

    /**
     * @param Security $xmlSecurityHelper
     * @param Logger $logger
     * @param ZendClientFactory $httpClientFactory
     */
    public function __construct(
        Security $xmlSecurityHelper,
        Logger $logger,
        ZendClientFactory $httpClientFactory
    ) {
        $this->xmlSecurityHelper = $xmlSecurityHelper;
        $this->logger = $logger;
        $this->httpClientFactory = $httpClientFactory;
    }

    /**
     * Get transaction information
     * @param \Macrew\Paguelofacil\Model\Paguelofacil $context
     * @param string $transactionId
     * @return \Magento\Framework\Simplexml\Element
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getTransactionDetails(Paguelofacil $context, $transactionId)
    {
        return isset($this->transactionDetails[$transactionId])
            ? $this->transactionDetails[$transactionId]
            : $this->loadTransactionDetails($context, $transactionId);
    }

    /**
     * Load transaction details
     *
     * @param \Macrew\Paguelofacil\Model\Paguelofacil $context
     * @param string $transactionId
     * @return \Magento\Framework\Simplexml\Element
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function loadTransactionDetails(Paguelofacil $context, $transactionId)
    {

        $requestBody = $this->getRequestBody(
            $context->getConfigData('cclw'),
            $transactionId
        );

        /** @var \Magento\Framework\HTTP\ZendClient $client */
        $client = $this->httpClientFactory->create();
        $url = $context->getConfigData('post_url_action') ?: self::POST_URL_ACTION;
        $client->setUri($url);
        $client->setConfig(['timeout' => self::CONNECTION_TIMEOUT]);
        $client->setHeaders(['Content-Type: text/xml']);
        $client->setMethod(\Zend_Http_Client::POST);
        $client->setRawData($requestBody);

        $debugData = ['url' => $url];

        try {
            $responseBody = $client->request()->getBody();
            if (!$this->xmlSecurityHelper->scan($responseBody)) {
                $this->logger->critical('Attempt loading of external XML entities in response from Paguelofacil.');
                throw new \Exception();
            }
            $debugData['response'] = $responseBody;
            libxml_use_internal_errors(true);
            $responseXmlDocument = new Element($responseBody);
            libxml_use_internal_errors(false);
        } catch (\Exception $e) {
            throw new LocalizedException(__('Unable to get transaction details. Try again later.'));
        } finally {
            $context->debugData($debugData);
        }

        if (!isset($responseXmlDocument->messages->resultCode)
            || $responseXmlDocument->messages->resultCode != static::PAYMENT_UPDATE_STATUS_CODE_SUCCESS
        ) {
            throw new LocalizedException(__('Unable to get transaction details. Try again later.'));
        }

        $this->transactionDetails[$transactionId] = $responseXmlDocument;
        return $responseXmlDocument;
    }

    /**
     * Create request body to get transaction details
     * @param string $login
     * @param string $transactionKey
     * @param string $transactionId
     * @return string
     */
    private function getRequestBody($cclw, $transactionId)
    {
        $requestBody = sprintf(
            '<?xml version="1.0" encoding="utf-8"?>' .
            '<getTransactionDetailsRequest xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">' .
            '<merchantAuthentication><name>%s</name></merchantAuthentication>' .
            '<transId>%s</transId>' .
            '</getTransactionDetailsRequest>',
            $cclw,
            $transactionId
        );
        return $requestBody;
    }
}
