<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Apptrian\ImageOptimizer\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfig;
    
    /**
     * @var \Magento\Framework\Module\ModuleListInterface
     */
    protected $_moduleList;
    
    /**
     * @var \Apptrian\ImageOptimizer\Model\FileFactory
     */
    protected $_fileFactory;
    
    /**
     * @var \Magento\Framework\Filesystem
     */
    protected $_fileSystem;
    
    /**
     * @var \Magento\Framework\Component\ComponentRegistrarInterface
     */
    protected $_componentRegistrar;
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;
    
    /**
     * Magento Root full path.
     *
     * @var null|string
     */
    protected $_baseDir = null;
    
    /**
     * Module Root full path.
     *
     * @var null|string
     */
    protected $_moduleDir = null;
    
    /**
     * Logging flag.
     *
     * @var null|int
     */
    protected $_logging = null;
    
    /**
     * Path to utilities.
     *
     * @var null|string
     */
    protected $_utilPath = null;
    
    /**
     * extension (for win binaries)
     *
     * @var null|string
     */
    protected $_utilExt  = null;
    
    /**
     * Constructor
     * 
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Module\ModuleListInterface $moduleList
     * @param \Apptrian\ImageOptimizer\Model\FileFactory $fileFactory
     * @param \Magento\Framework\Filesystem $fileSystem
     * @param \Magento\Framework\Component\ComponentRegistrarInterface $compReg
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Module\ModuleListInterface $moduleList,
        \Apptrian\ImageOptimizer\Model\FileFactory $fileFactory,
        \Magento\Framework\Filesystem $fileSystem,
        \Magento\Framework\Component\ComponentRegistrarInterface $compReg,
        \Psr\Log\LoggerInterface $logger
    )
    {
        
        $this->_scopeConfig        = $context->getScopeConfig();
        $this->_moduleList         = $moduleList;
        $this->_fileFactory        = $fileFactory;
        $this->_fileSystem         = $fileSystem;
        $this->_componentRegistrar = $compReg;
        $this->_logger             = $logger;
        
        parent::__construct($context);
        
    }
    
    /**
     * Returns extension version.
     * 
     * @return string
     */
    public function getExtensionVersion()
    {
        $moduleCode = 'Apptrian_ImageOptimizer';
        $moduleInfo = $this->_moduleList->getOne($moduleCode);
        return $moduleInfo['setup_version'];
    }
    
    /**
     * Based on provided configuration path returns configuration value.
     * 
     * @param string $configPath
     * @return string
     */
    public function getConfig($configPath)
    {
        return $this->_scopeConfig->getValue($configPath);
    }
    
    /**
     * Returns Magento Root full path.
     * 
     * @return string
     */
    public function getBaseDir()
    {
        
        if ($this->_baseDir === null) {
            
            $dir = $this->_fileSystem->getDirectoryRead(
                \Magento\Framework\App\Filesystem\DirectoryList::ROOT
            );
            
            $this->_baseDir = $dir->getAbsolutePath();
            
        }
        
        return $this->_baseDir;
        
    }
    
    /**
     * Returns Module Root full path.
     * 
     * @return null|string
     */
    public function getModuleDir()
    {
    
        if ($this->_moduleDir === null) {
    
            $moduleName = 'Apptrian_ImageOptimizer';
    
            $this->_moduleDir = $this->_componentRegistrar->getPath(
                \Magento\Framework\Component\ComponentRegistrar::MODULE, 
                $moduleName
            );
    
        }
    
        return $this->_moduleDir;
    
    }
    
    /**
     * Optimized way of getting logging flag from config.
     *
     * @return int
     */
    public function isLoggingEnabled()
    {
        if ($this->_logging === null) {
    
            $this->_logging = (int) $this->getConfig(
                'apptrian_imageoptimizer/utility/log_output'
            );
    
        }
    
        return $this->_logging;
    }
    
    /**
     * Checks if exec() function is enabled in php and suhosin config.
     *
     * @return boolean
     */
    public function isExecFunctionEnabled()
    {
        $r = false;
    
        // PHP disabled functions
        $phpDisabledFunctions = array_map(
            'strtolower', 
            array_map('trim', explode(',', ini_get('disable_functions')))
        );
        
        // Suhosin disabled functions
        $suhosinDisabledFunctions = array_map(
            'strtolower', 
            array_map(
                'trim', explode(',', ini_get('suhosin.executor.func.blacklist'))
            )
        );
    
        $disabledFunctions = array_merge(
            $phpDisabledFunctions, $suhosinDisabledFunctions
        );
    
        $disabled = false;
    
        if (in_array('exec', $disabledFunctions)) {
            $disabled = true;
        }
    
        if (function_exists('exec') === true && $disabled === false) {
            $r = true;
        }
    
        return $r;
    }
    
    /**
     * Based on config returns array of all paths that will be scaned 
     * for images.
     *
     * @return array
     */
    public function getPaths()
    {
    
        $paths = array();
    
        $pathsString = trim(
            trim(
                $this->getConfig('apptrian_imageoptimizer/general/paths'), ';'
            )
        );
        
        $rawPaths = explode(';', $pathsString);
    
        foreach ($rawPaths as $p) {
            
            $trimmed = trim(trim($p), '/');
            
            $dirs = explode('/', $trimmed);
            
            $paths[] = implode('/', $dirs);
            
        }
    
        return array_unique($paths);
    
    }
    
    /**
     * Optimizes single file.
     *
     * @param string $filePath
     * @return boolean
     */
    public function optimizeFile($filePath)
    {
    
        $info = pathinfo($filePath);
    
        $output = array();
    
        switch (strtolower($info['extension'])) {
            case 'jpg':
            case 'jpeg':
                exec($this->getJpgUtil($filePath), $output, $returnVar);
                $type = 'jpg';
                break;
            case 'png':
                exec($this->getPngUtil($filePath), $output, $returnVar);
                $type = 'png';
                break;
            case 'gif':
                exec($this->getGifUtil($filePath), $output, $returnVar);
                $type = 'gif';
                break;
        }
    
        if ($returnVar == 126) {
            
            $error = $this->getConfig(
                'apptrian_imageoptimizer/utility/' . $type
            ) . ' is not executable.';
            
            $this->_logger->debug($error);
            
            return false;
            
        } else {
            
            if ($this->isLoggingEnabled()) {
    
                $this->_logger->debug($filePath);
                $this->_logger->debug(implode(' | ', $output));
    
            }
            
            $permissions = $this->getConfig(
                'apptrian_imageoptimizer/utility/permissions'
            );
            
            if ($permissions) {
                chmod($filePath, octdec($permissions));
            }
            
            return true;
            
        }
    
    }
    
    /**
     * Optimization process.
     *
     * @return boolean
     */
    public function optimize()
    {
        // Get Batch Size
        $batchSize = $this->getConfig(
            'apptrian_imageoptimizer/general/batch_size'
        );
        
        $fileModel = $this->_fileFactory->create();
        
        // Get Collection of files for optimization but limited by batch size
        $collection = $fileModel
            ->getCollection()
            ->addFieldToSelect(['id', 'file_path'])
            ->addFieldToFilter('optimized', ['eq' => 0])
            ->setPageSize($batchSize)
            ->load();
    
        $toUpdate    = [];
        $toDelete    = [];
        $oldFileSize = 0;
    
        foreach ($collection as $item) {
            
            $id    = $item->getId();
            $fPath = $item->getFilePath();
            
            $filePath = realpath($fPath);
            
            // If image exists, optimize else remove it from database
            if (file_exists($filePath)) {
    
                $oldFileSize = filesize($filePath);
    
                if ($this->optimizeFile($filePath)) {
                    
                    $toUpdate[$id]['file_path']     = $fPath;
                    $toUpdate[$id]['old_file_size'] = $oldFileSize;
                    $toUpdate[$id]['optimized']     = 1;
                    
                }
    
            } else {
    
                $toDelete[] = $id;
    
            }
            
        }
    
        // Itereate over $toUpdate array and set modified time and new_file_size
        // (mtime etc) takes a split second to update
        foreach ($toUpdate as $i => $f) {
            
            $filePath = realpath($f['file_path']);
            
            if (file_exists($filePath)) {
                $toUpdate[$i]['new_file_size']     = filesize($filePath);
                $toUpdate[$i]['optimization_time'] = filemtime($filePath);
            }
            
        }
        
        $resource = $fileModel->getResource();
        
        $resultA = $resource->deleteFiles($toDelete);
        $resultB = $resource->updateFiles($toUpdate);
    
        if ($resultA === true && $resultB === true) {
            return true;
        } else {
            return false;
        }
    
    }
    
    /**
     * Scan and reindex process.
     *
     * @return boolean
     */
    public function scanAndReindex()
    {
        
        $fileModel = $this->_fileFactory->create();
        
        $collection = $fileModel
            ->getCollection()
            ->addFieldToSelect(['id', 'file_path', 'optimization_time'])
            ->load();
    
        $inIndex  = [];
        $toAdd    = [];
        $toUpdate = [];
        $toDelete = [];
        $id       = 0;
        $filePath = '';
    
        foreach ($collection as $item) {
            
            $id = $item->getId();
            
            $inIndex[$id] = 0;
            
            $filePath = realpath($item->getFilePath());
            
            if (file_exists($filePath)) {
                if (filemtime($filePath) != $item->getOptimizationTime()) {
                    $toUpdate[] = $id;
                }
            } else {
                $toDelete[] = $id;
            }
            
        }
    
    
        $files = [];
        $paths = $this->getPaths();
        
        foreach ($paths as $path) {
            
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator(
                    $this->getBaseDir() . $path,
                    \RecursiveDirectoryIterator::FOLLOW_SYMLINKS
                )
            );
            
            foreach ( $iterator as $filename => $file ) {
                if ($file->isFile() 
                    && preg_match(
                        '/^.+\.(jpe?g|gif|png)$/i', $file->getFilename()
                    )
                ) {
                    $filePath = $file->getRealPath();
                    if (!is_writable($filePath)) {
                        continue;
                    }
                    
                    $files[md5($filePath)] = $filePath;
                    
                }
            }
    
        }
        
        
        $toAdd = array_diff_key($files, $inIndex);
    
        $resource = $fileModel->getResource();
        
        $resultA = $resource->deleteFiles($toDelete);
        $resultB = $resource->updateFilesOptimizedField($toUpdate);
        $resultC = $resource->addFiles($toAdd);
    
        if ($resultA === true && $resultB === true && $resultC === true) {
            return true;
        } else {
            return false;
        }
    
    }
    
    /**
     * Checks if server OS is Windows
     *
     * @return bool
     */
    public function isWindows()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Alias for getUtil() and .gif
     *
     * @param string $filePath
     * @return string
     */
    public function getGifUtil($filePath)
    {
        return $this->getUtil('gif', $filePath);
    }
    
    /**
     * Alias for getUtil() and .jpg
     *
     * @param string $filePath
     * @return string
     */
    public function getJpgUtil($filePath)
    {
        return $this->getUtil('jpg', $filePath);
    }
    
    /**
     * Alias for getUtil() and .png
     *
     * @param string $filePath
     * @return string
     */
    public function getPngUtil($filePath)
    {
        return $this->getUtil('png', $filePath);
    }
    
    /**
     * Formats and returns the shell command string for an image optimization 
     * utility.
     *
     * @param string $type - This is image type. Valid values gif|jpg|png
     * @param string $filePath - Path to the image to be optimized
     * @return string
     */
    public function getUtil($type, $filePath)
    {
        
        $exactPath = $this->getConfig(
            'apptrian_imageoptimizer/utility/' . $type . '_path'
        );
        
        // If utility exact path is set use it
        if ($exactPath != '') {
            
            $cmd = $exactPath;
            
        // Use path to extension's local utilities
        } else {
        
            $cmd = $this->getUtilPath() 
                . '/' 
                . $this->getConfig('apptrian_imageoptimizer/utility/' . $type) 
                . $this->getUtilExt();
                
        }
        
        $cmd .= ' ' . $this->getConfig(
            'apptrian_imageoptimizer/utility/' . $type . '_options'
        );
        
        return str_replace('%filepath%', $filePath, $cmd);
        
    }
    
    /**
     * Gets and stores utility extension.
     * Checks server OS and determine utility extension.
     *
     * @return string
     */
    public function getUtilExt()
    {
        if ($this->_utilExt === null) {
             
            $this->_utilExt = $this->isWindows() ? '.exe' : '';
    
        }
         
        return $this->_utilExt;
    }
    
    /**
     * Gets and stores path to utilities. Checks server OS and config to 
     * determine the path where image optimization utilities are.
     *
     * @return string
     */
    public function getUtilPath()
    {
        if ($this->_utilPath === null) {
            
            $useSixtyFourBit = (int) $this->getConfig(
                'apptrian_imageoptimizer/utility/use64bit'
            );
            
            if ($useSixtyFourBit) {
                $bit = '64';
            } else {
                $bit = '32';
            }
    
            $os = $this->isWindows() ? 'win' . $bit : 'elf' . $bit;
    
            $pathString = trim(
                trim($this->getConfig('apptrian_imageoptimizer/utility/path')),
                '/'
            );
            
            $dirs       = explode('/', $pathString);
            $path       = implode('/', $dirs);
    
            $this->_utilPath = $this->getModuleDir() . '/' . $path . '/' . $os;
    
        }
    
        return $this->_utilPath;
    }
    
}
