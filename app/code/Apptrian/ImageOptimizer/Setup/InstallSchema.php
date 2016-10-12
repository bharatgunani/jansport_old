<?php
/**
 * @category  Apptrian
 * @package   Apptrian_ImageOptimizer
 * @author    Apptrian
 * @copyright Copyright (c) 2016 Apptrian (http://www.apptrian.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License
 */
 
namespace Apptrian\ImageOptimizer\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(
        SchemaSetupInterface $setup, 
        ModuleContextInterface $context
    )
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'apptrian_imageoptimizer_files'
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable('apptrian_imageoptimizer_files')
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            32,
            ['nullable' => false, 'primary' => true, 'default' => ''],
            'File ID'
        )->addColumn(
            'file_path',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            4096,
            ['nullable' => false, 'default' => ''],
            'File Path'
        )->addColumn(
            'optimized',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '0'],
            'Is File Optimized'
        )->addColumn(
            'optimization_time',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'default' => '0', 'unsigned' => true],
            'File Optimization Timestamp'
        )->addColumn(
            'old_file_size',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'default' => '0', 'unsigned' => true],
            'Old File Size'
        )->addColumn(
            'new_file_size',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'default' => '0', 'unsigned' => true],
            'New File Size'
        )->setComment(
            'Apptrian Image Optimizer Files Table'
        );
        
        $installer->getConnection()->createTable($table);
        
        $installer->endSetup();
    }
}
