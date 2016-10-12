<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */

namespace Apptrian\ImageOptimizer\Controller\Adminhtml\Optimizer;

class Clear extends \Magento\Backend\App\Action
{
    /**
     * @var \Apptrian\ImageOptimizer\Model\ResourceModel\File
     */
    protected $_fileResource;
    
    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Apptrian\ImageOptimizer\Model\ResourceModel\File $fileResource
     */
    public function __construct (
        \Magento\Backend\App\Action\Context $context,
        \Apptrian\ImageOptimizer\Model\ResourceModel\File $fileResource
    )
    {
        $this->_fileResource = $fileResource;
    
        parent::__construct($context);
    }
    
    /**
     * Clear index action.
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        
        try {
            
            $this->_fileResource->clearIndex();
            
            $this->messageManager->addSuccess(
                __('Clear index operation completed successfully.')
            );
            
        } catch (\Exception $e) {
            
            $message = __('Clear index operation failed.');
            $this->messageManager->addError($message);
            $this->messageManager->addError($e->getMessage());
            
        }
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        
        return $resultRedirect->setPath(
            'adminhtml/system_config/edit',
            ['section' => 'apptrian_imageoptimizer']
        );
        
    }
    
}
