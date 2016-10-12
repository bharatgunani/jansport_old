<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Apptrian\ImageOptimizer\Block\Adminhtml;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Stats extends \Magento\Config\Block\System\Config\Form\Field
{
    
    /**
     * @var \Apptrian\ImageOptimizer\Model\ResourceModel\File
     */
    protected $_fileResource;
    
    /**
     * Constructor used to inject file resource model.
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Apptrian\ImageOptimizer\Model\ResourceModel\File $fileResource
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Apptrian\ImageOptimizer\Model\ResourceModel\File $fileResource
    )
    {
        $this->_fileResource = $fileResource;
        parent::__construct($context);
    }
    
    /**
     * Retrieve element HTML markup.
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        
        $element = null;
        
        $indexed   = $this->_fileResource->getFileCount();
        $optimized = $this->_fileResource->getFileCount(1);
        
        // Fix for division by zero possibility
        if ($indexed == 0) {
            $percent = 0;
        } else {
            $percent = round((100 * $optimized) / $indexed, 2);
        }
        
        $html = '<div class="apptrian-imageoptimizer-bar-wrapper">
        <div class="apptrian-imageoptimizer-bar-outer">
        <div class="apptrian-imageoptimizer-bar-inner" style="width:' 
        . $percent .'%;"></div>
        <div class="apptrian-imageoptimizer-bar-text"><span>' . $percent 
        . '% ' . sprintf(__('(%s of %s files)'), $optimized, $indexed) 
        . '</span></div>
        </div></div>';
        
        return $html;
        
    }
    
}
