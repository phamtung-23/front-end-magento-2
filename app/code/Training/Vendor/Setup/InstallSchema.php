<?php

namespace Training\Vendor\Setup;

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

    $table = $installer->getConnection()->newTable($installer->getTable('training_vendor_entity'))
      ->addColumn(
        'entity_id',
        Table::TYPE_INTEGER,
        null,
        ['identity' => true, 'nullable' => false, 'primary' => true],
        'Entity ID'
      )
      ->addColumn(
        'name',
        Table::TYPE_TEXT,
        255,
        ['nullable' => false],
        'Entity Name'
      )->addColumn(
        'description',
        Table::TYPE_TEXT,
        255,
        ['nullable' => false],
        'Entity Description'
      )->setComment(
        'Training Vendor Entity Table'
      );
    $installer->getConnection()->createTable($table);

    $installer->endSetup();
  }
}
