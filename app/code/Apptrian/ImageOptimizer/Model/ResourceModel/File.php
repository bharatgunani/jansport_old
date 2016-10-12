<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Apptrian\ImageOptimizer\Model\ResourceModel;

class File extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;
    
    /**
     * Constructor used to inject logger.
     * 
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Psr\Log\LoggerInterface $logger
     * @param string $connectionName
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Psr\Log\LoggerInterface $logger,
        $connectionName = null
    )
    {
        $this->_logger = $logger;
        parent::__construct($context, $connectionName);
    }
    
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init('apptrian_imageoptimizer_files', 'id');
    }
    
    /**
     * Adds entries to the db with one query.
     * Used in scanAndReindex() method.
     *
     * @param array $files
     * @return boolean
     */
    public function addFiles($files)
    {
        
        if (count($files) > 0) {
            
            $table = $this->getConnection()
                ->getTableName('apptrian_imageoptimizer_files');
            
            $wConn = $this->getConnection('core_write');
            
            $query = 'INSERT INTO ' . $table . ' (`id`, `file_path`) VALUES ';
            
            $values = '';
            
            foreach ($files as $id => $path) {
                $values .= '(' . $wConn->quote($id) . ', ' 
                        . $wConn->quote($path) . '),';
            }
            
            $query .= rtrim($values, ',') . ';';
            
            try {
                $wConn->query($query);
                return true;
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                return false;
            }
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**
     * Updates db entries with new data using only one query.
     * Used in optimize() method.
     *
     * @param array $files
     * @return boolean
     */
    public function updateFiles($files)
    {
        
        if (count($files) > 0) {
            
            $table = $this->getConnection()
                ->getTableName('apptrian_imageoptimizer_files');
            
            $wConn = $this->getConnection('core_write');
            
            $query = 'UPDATE ' . $table . ' SET';
            
            $optimized        = ' optimized = CASE id ';
            $optimizationTime = ' optimization_time = CASE id ';
            $oldFileSize      = ' old_file_size = CASE id ';
            $newFileSize      = ' new_file_size = CASE id ';
            
            $where            = ' WHERE id IN (';
            
            foreach ($files as $id => $f) {
                
                $qId = $wConn->quote($id);
                
                $optimized        .= 'WHEN ' . $qId . ' THEN 1 ';
                
                $optimizationTime .= 'WHEN ' . $qId . ' THEN ' 
                    . $f['optimization_time'] . ' ';
                
                $oldFileSize      .= 'WHEN ' . $qId . ' THEN ' 
                    . $f['old_file_size'] . ' ';
                
                $newFileSize      .= 'WHEN ' . $qId . ' THEN ' 
                    . $f['new_file_size'] . ' ';
                 
                $where            .= $qId . ',';
                
            }
            
            $query .= $optimized . 'END,';
            $query .= $optimizationTime . 'END,';
            $query .= $oldFileSize . 'END,';
            $query .= $newFileSize . 'END';
            
            $query .= rtrim($where, ',') . ');';
            
            try {
                $wConn->query($query);
                return true;
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                return false;
            }
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**
     * Updates "optimized" field in db with one query.
     * Used in scanAndReindex() method.
     *
     * @param array $files
     * @return boolean
     */
    public function updateFilesOptimizedField($files)
    {
        
        if (count($files) > 0) {
            
            $table = $this->getConnection()
                ->getTableName('apptrian_imageoptimizer_files');
            
            $wConn = $this->getConnection('core_write');
            
            $query = 'UPDATE ' . $table . ' SET optimized = 0 WHERE id IN (';
            
            $values = '';
            
            foreach ($files as $id) {
                $values .= $wConn->quote($id) . ',';
            }
            
            $query .= rtrim($values, ',') . ');';
            
            try {
                $wConn->query($query);
                return true;
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                return false;
            }
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**
     * Deletes entries from db for files that do not exist anymore.
     * Used in scanAndReindex() and optimize() methods.
     *
     * @param array $files
     * @return boolean
     */
    public function deleteFiles($files)
    {
        
        if (count($files) > 0) {
            
            $table = $this->getConnection()
                ->getTableName('apptrian_imageoptimizer_files');
            
            $wConn = $this->getConnection('core_write');
            
            $query = 'DELETE FROM ' . $table . ' WHERE id IN (';
            
            $values = '';
            
            foreach ($files as $id) {
                $values .= $wConn->quote($id) . ',';
            }
            
            $query .= rtrim($values, ',') . ');';
            
            try {
                $wConn->query($query);
                return true;
            } catch (\Exception $e) {
                $this->_logger->critical($e);
                return false;
            }
            
        } else {
            
            return true;
            
        }
        
    }
    
    /**
     * Returns entry count. If $optimized is provided returns count
     * of optimized or not optimized files.
     *
     * @param int $optimized
     * @return boolean
     */
    public function getFileCount($optimized = null)
    {
        
        $table = $this->getConnection()
            ->getTableName('apptrian_imageoptimizer_files');
        
        $rConn = $this->getConnection('core_read');
        
        $query = 'SELECT COUNT(id) FROM ' . $table;
        
        if ($optimized !== null) {
            $query .= ' WHERE optimized = ' . $optimized;
        }
        
        $query .= ';';
        
        try {
            return $rConn->fetchOne($query);
        } catch (\Exception $e) {
            $this->_logger->critical($e);
            return false;
        }
        
    }
    
    /**
     * Clear index. (Empty db table apptrian_imageoptimizer_files)
     *
     * @return boolean
     */
    public function clearIndex()
    {
        
        $table = $this->getConnection()
            ->getTableName('apptrian_imageoptimizer_files');
        
        $wConn = $this->getConnection('core_write');
        
        $query = 'TRUNCATE ' . $table . ';';
        
        try {
            $wConn->query($query);
            return true;
        } catch (\Exception $e) {
            $this->_logger->critical($e);
            return false;
        }
        
    }
    
}
