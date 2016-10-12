<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Test\Unit\Model\Directpost;

use Macrew\Paguelofacil\Model\Directpost\Session;
use Magento\Framework\Session\StorageInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $storageMock;

    public function setUp()
    {
        $this->storageMock = $this
            ->getMockBuilder('Magento\Framework\Session\StorageInterface')
            ->setMethods(['setQuoteId'])
            ->getMockForAbstractClass();

        $this->objectManager = new ObjectManager($this);
        $this->session = $this->objectManager->getObject(
            'Macrew\Paguelofacil\Model\Directpost\Session',
            [
                'storage' => $this->storageMock,
            ]
        );
    }

    public function testSetQuoteId()
    {
        $quoteId = 1;

        $this->storageMock->expects($this->once())
            ->method('setQuoteId')
            ->with($quoteId);

        $this->assertInstanceOf(
            'Macrew\Paguelofacil\Model\Directpost\Session',
            $this->session->setQuoteId($quoteId)
        );
    }
}
