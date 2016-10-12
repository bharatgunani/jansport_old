<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Model\ResourceModel\Debug;

/**
 * Resource Paguelofacil debug collection model
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Macrew\Paguelofacil\Model\Debug',
            'Macrew\Paguelofacil\Model\ResourceModel\Debug'
        );
    }
}
