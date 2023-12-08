<?php

namespace Unit5\CustomEntity\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
  /**
   * @inheritDoc
   */
  public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
  {
    $installer = $setup;
    $installer->startSetup();

    $table = $installer->getConnection()->newTable($installer->getTable('banner_entity'))
      ->addColumn('entity_id', Table::TYPE_INTEGER, null, [
          'identity' => true,
          'unsigned' => true,
          'nullable' => false,
          'primary' => true
        ],'Entity ID')
      ->addColumn( 'linkimg', Table::TYPE_TEXT, 255, ['nullable' => false], 'link image')
      ->addColumn( 'des', Table::TYPE_TEXT, 255, ['nullable' => false], 'descript')
      ->setComment('Banner Entity Table');
    $installer->getConnection()->createTable($table);

    $installer->endSetup();
  }
}
