<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Test\Unit\Model\Response;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Macrew\Paguelofacil\Model\Response\Factory
     */
    protected $responseFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManagerMock;

    /**
     * @var \Macrew\Paguelofacil\Model\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $responseMock;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->responseMock = $this->getMock('Macrew\Paguelofacil\Model\Response', [], [], '', false);

        $this->objectManagerMock = $this->getMock('Magento\Framework\ObjectManagerInterface', [], [], '', false);
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with('Macrew\Paguelofacil\Model\Response', [])
            ->willReturn($this->responseMock);

        $this->responseFactory = $objectManager->getObject(
            'Macrew\Paguelofacil\Model\Response\Factory',
            ['objectManager' => $this->objectManagerMock]
        );
    }

    public function testCreate()
    {
        $this->assertSame($this->responseMock, $this->responseFactory->create());
    }
}
