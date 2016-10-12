<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Apptrian\ImageOptimizer\Cron;

class Optimize
{
    /**
     * @var \Apptrian\ImageOptimizer\Helper\Data
     */
    protected $_helper;
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;
    
    /**
     * Constructor
     * 
     * @param \Apptrian\ImageOptimizer\Helper\Data $helper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Apptrian\ImageOptimizer\Helper\Data $helper,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->_helper = $helper;
        $this->_logger = $logger;
    }
    
    /**
     * Cron method for executing optmization process.
     */
    public function execute()
    {
        
        $extensionEnabled = (int) $this->_helper->getConfig(
            'apptrian_imageoptimizer/general/enabled'
        );
        
        $cronJobEnabled = (int) $this->_helper->getConfig(
            'apptrian_imageoptimizer/cron/enabled_optimize'
        );
        
        if ($extensionEnabled && $cronJobEnabled) {
            
            $mPrefix = 'Image Optimizer Cron: Optimization process ';
            
            if ($this->_helper->isExecFunctionEnabled()) {
                
                try {
                    
                    $result = $this->_helper->optimize();
                    
                    if ($result !== true ) {
                        $this->_logger->debug($mPrefix . 'failed.');
                    }
                
                } catch (\Exception $e) {
                    
                    $this->_logger->critical($e);
                    
                }
            
            } else {
                
                $this->_logger->debug(
                    $mPrefix . 'failed because PHP exec() function is disabled.'
                );
                
            }
            
        }
        
    }
    
}
