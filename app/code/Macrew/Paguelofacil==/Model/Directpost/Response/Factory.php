<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model\Directpost\Response;

use Macrew\Paguelofacil\Model\Response\Factory as PaguelofacilResponseFactory;

/**
 * Factory class for @see \Macrew\Paguelofacil\Model\Directpost\Response
 */
class Factory extends PaguelofacilResponseFactory
{
    /**
     * Factory constructor
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param string $instanceName
     */
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager,
        $instanceName = 'Macrew\Paguelofacil\Model\Directpost\Response'
    ) {
        parent::__construct($objectManager, $instanceName);
    }
}
