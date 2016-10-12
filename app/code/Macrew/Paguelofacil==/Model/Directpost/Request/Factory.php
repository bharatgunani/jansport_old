<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model\Directpost\Request;

use Macrew\Paguelofacil\Model\Request\Factory as PaguelofacilRequestFactory;

/**
 * Factory class for @see \Macrew\Paguelofacil\Model\Directpost\Request
 */
class Factory extends PaguelofacilRequestFactory
{
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = 'Macrew\Paguelofacil\Model\Directpost\Request'
    ) {
        parent::__construct($objectManager, $instanceName);
    }
}
