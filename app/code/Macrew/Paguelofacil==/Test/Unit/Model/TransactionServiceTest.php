<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Test\Unit\Model;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Framework\Simplexml\Element;
use Macrew\Paguelofacil\Model\TransactionService;

class TransactionServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\Framework\HTTP\ZendClient|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $httpClientMock;

    /**
     * @var \Macrew\Paguelofacil\Model\Paguelofacil|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $paguelofacilMock;

    /**
     * @var \Macrew\Paguelofacil\Model\TransactionService
     */
    protected $transactionService;

    protected function setUp()
    {
        $httpClientFactoryMock = $this->getHttpClientFactoryMock();

        $this->paguelofacilMock = $this->getMockBuilder('Macrew\Paguelofacil\Model\Directpost')
            ->disableOriginalConstructor()
            ->getMock();

        $this->paguelofacilMock->method('getConfigData')
            ->willReturnMap([
                ['login', 'test login'],
                ['trans_key', 'test key'],
                ['cgi_url_td', 'https://apitest.authorize.net/xml/v1/request.api']
            ]);

        $objectManagerHelper = new ObjectManager($this);
        $xmlSecurity = $objectManagerHelper->getObject('Magento\Framework\Xml\Security');
        $this->transactionService = $objectManagerHelper->getObject('\Macrew\Paguelofacil\Model\TransactionService', [
            'xmlSecurityHelper' => $xmlSecurity,
            'httpClientFactory' => $httpClientFactoryMock
        ]);
    }

    /**
     * @covers \Macrew\Paguelofacil\Model\TransactionService::loadTransactionDetails
     * @param $transactionId
     * @param $resultStatus
     * @param $responseStatus
     * @param $responseCode
     * @return void
     *
     * @dataProvider dataProviderTransaction
     */
    public function testLoadVoidedTransactionDetails($transactionId, $resultStatus, $responseStatus, $responseCode)
    {
        $document = $this->getResponseBody(
            $transactionId,
            TransactionService::PAYMENT_UPDATE_STATUS_CODE_SUCCESS,
            $resultStatus,
            $responseStatus,
            $responseCode
        );
        $this->httpClientMock->expects(static::once())
            ->method('getBody')
            ->willReturn($document);

        $result = $this->transactionService->getTransactionDetails($this->paguelofacilMock, $transactionId);

        static::assertEquals($responseCode, (string)$result->transaction->responseCode);
        static::assertEquals($responseCode, (string)$result->transaction->responseReasonCode);
        static::assertEquals($responseStatus, (string)$result->transaction->transactionStatus);
    }

    /**
     * Get data for tests
     * @return array
     */
    public function dataProviderTransaction()
    {
        return [
            [
                'transactionId' => '9941997799',
                'resultStatus' => 'Successful.',
                'responseStatus' => 'voided',
                'responseCode' => 1
            ]
        ];
    }

    /**
     * Create and return mock for http client factory
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getHttpClientFactoryMock()
    {
        $this->httpClientMock = $this->getMockBuilder('Magento\Framework\HTTP\ZendClient')
            ->disableOriginalConstructor()
            ->setMethods(['request', 'getBody', '__wakeup'])
            ->getMock();

        $this->httpClientMock->expects(static::once())
            ->method('request')
            ->willReturnSelf();

        $httpClientFactoryMock = $this->getMockBuilder('Magento\Framework\HTTP\ZendClientFactory')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $httpClientFactoryMock->expects(static::once())
            ->method('create')
            ->willReturn($this->httpClientMock);
        return $httpClientFactoryMock;
    }

    /**
     * Get body for xml request
     * @param string $transactionId
     * @param int $resultCode
     * @param string $resultStatus
     * @param string $responseStatus
     * @param string $responseCode
     * @return string
     */
    private function getResponseBody($transactionId, $resultCode, $resultStatus, $responseStatus, $responseCode)
    {
        return sprintf(
            '<?xml version="1.0" encoding="utf-8"?>
            <getTransactionDetailsResponse
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                <messages>
                    <resultCode>%s</resultCode>
                    <message>
                        <code>I00001</code>
                        <text>%s</text>
                    </message>
                </messages>
                <transaction>
                    <transId>%s</transId>
                    <transactionType>authOnlyTransaction</transactionType>
                    <transactionStatus>%s</transactionStatus>
                    <responseCode>%s</responseCode>
                    <responseReasonCode>%s</responseReasonCode>
                </transaction>
            </getTransactionDetailsResponse>',
            $resultCode,
            $resultStatus,
            $transactionId,
            $responseStatus,
            $responseCode,
            $responseCode
        );
    }
}
