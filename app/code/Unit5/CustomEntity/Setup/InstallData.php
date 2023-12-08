<?php

namespace Unit5\CustomEntity\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @inheritDoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = [
            [
                'linkimg' => 'example_link_1.jpg',
                'des' => 'Example Description 1',
            ],
            [
                'linkimg' => 'example_link_2.jpg',
                'des' => 'Example Description 2',
            ],
        ];

        $setup->getConnection()->insertMultiple($setup->getTable('banner_entity'),$data);
    }
}