<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Test\Unit\Model\Request;

use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Macrew\Paguelofacil\Model\Request\Factory
     */
    protected $requestFactory;

    /**
     * @var \Magento\Framework\ObjectManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $objectManagerMock;

    /**
     * @var \Macrew\Paguelofacil\Model\Request|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $requestMock;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);

        $this->requestMock = $this->getMock('Macrew\Paguelofacil\Model\Request', [], [], '', false);

        $this->objectManagerMock = $this->getMock('Magento\Framework\ObjectManagerInterface', [], [], '', false);
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with('Macrew\Paguelofacil\Model\Request', [])
            ->willReturn($this->requestMock);

        $this->requestFactory = $objectManager->getObject(
            'Macrew\Paguelofacil\Model\Request\Factory',
            ['objectManager' => $this->objectManagerMock]
        );
    }

    public function testCreate()
    {
        $this->assertSame($this->requestMock, $this->requestFactory->create());
    }
}
