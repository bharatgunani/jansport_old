<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Magento\Catalog\Block\Product;

/**
 * New products block
 *
 * @SuppressWarnings(PHPMD.LongVariable)
 */
class Bestsaller extends \Magento\Framework\View\Element\Template
{
    /**
     * Default value for products count that will be shown
     */
    const DEFAULT_PRODUCTS_COUNT = 10;
    protected $_categoryFactory;
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,        
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        array $data = []
    )
    {    
        $this->_categoryFactory = $categoryFactory;
        parent::__construct($context, $data);
    }
    
    public function getCategory($categoryId) 
    {
        $category = $this->_categoryFactory->create();
        $category->load($categoryId);
        return $category;
    }
    
    public function getCategoryProducts($categoryId) 
    {
        $products = $this->getCategory($categoryId)->getProductCollection();
        $products->addAttributeToSelect('*');
        return $products;
    }
}
