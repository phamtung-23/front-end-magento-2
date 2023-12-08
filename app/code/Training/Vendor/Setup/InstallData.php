<?php
namespace Training\Vendor\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Eav\Model\Config;
use Magento\Customer\Model\ResourceModel\Attribute;
use Magento\Customer\Model\Customer;
use Magento\Framework\Setup\InstallDataInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    private $eavConfig;

    private $attributeResoure;

    public function __construct(EavSetupFactory $eavSetupFactory, Config $eavConfig, Attribute $attributeResoure) 
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
        $this->attributeResoure = $attributeResoure;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'pham_tung',
            [
                'label' => 'Pham Tung',
                'type' => 'text',
                'input' => 'text',
                'source' => '',
                'required' => false,
                'sort_order' => 30,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,
                'used_in_product_listing' => true,
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'visible_on_front' => true,
            ]

        );

        $setup->endSetup();
    }
}