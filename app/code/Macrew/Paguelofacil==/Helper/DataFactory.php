<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Macrew\Paguelofacil\Helper;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\ObjectManagerInterface;

/**
 * Class DataFactory
 */
class DataFactory
{
    const AREA_FRONTEND = 'frontend';
    const AREA_BACKEND = 'adminhtml';
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var array
     */
    protected $helperMap = [
        self::AREA_FRONTEND => 'Macrew\Paguelofacil\Helper\Data',
        self::AREA_BACKEND => 'Macrew\Paguelofacil\Helper\Backend\Data'
    ];

    /**
     * Constructor
     *
     * @param ObjectManagerInterface $objectManager
     */
    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create data helper
     *
     * @param string $area
     * @return \Macrew\Paguelofacil\Helper\Backend\Data|\Macrew\Paguelofacil\Helper\Data
     * @throws LocalizedException
     */
    public function create($area)
    {
        if (!isset($this->helperMap[$area])) {
            throw new LocalizedException(__(sprintf('For this area <%s> no suitable helper', $area)));
        }

        return $this->objectManager->get($this->helperMap[$area]);
    }
}
