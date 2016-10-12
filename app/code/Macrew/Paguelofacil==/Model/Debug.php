<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model;

/**
 * @method \Macrew\Paguelofacil\Model\ResourceModel\Debug _getResource()
 * @method \Macrew\Paguelofacil\Model\ResourceModel\Debug getResource()
 * @method string getRequestBody()
 * @method \Macrew\Paguelofacil\Model\Debug setRequestBody(string $value)
 * @method string getResponseBody()
 * @method \Macrew\Paguelofacil\Model\Debug setResponseBody(string $value)
 * @method string getRequestSerialized()
 * @method \Macrew\Paguelofacil\Model\Debug setRequestSerialized(string $value)
 * @method string getResultSerialized()
 * @method \Macrew\Paguelofacil\Model\Debug setResultSerialized(string $value)
 * @method string getRequestDump()
 * @method \Macrew\Paguelofacil\Model\Debug setRequestDump(string $value)
 * @method string getResultDump()
 * @method \Macrew\Paguelofacil\Model\Debug setResultDump(string $value)
 */
class Debug extends \Magento\Framework\Model\AbstractModel
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Macrew\Paguelofacil\Model\ResourceModel\Debug');
    }
}
