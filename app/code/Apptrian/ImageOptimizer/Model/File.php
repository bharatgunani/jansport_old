<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Apptrian\ImageOptimizer\Model;

class File extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('Apptrian\ImageOptimizer\Model\ResourceModel\File');
    }
    
}
