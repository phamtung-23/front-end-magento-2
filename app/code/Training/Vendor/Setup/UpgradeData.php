<?php
namespace Training\Vendor\Setup;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Catalog\Model\Product;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * UpgradeData constructor.
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * @inheritDoc
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            $this->createMultipleSelectAttribute($setup);
        }

        $setup->endSetup();
    }

    /**
     * Create a multiple select attribute
     *
     * @param ModuleDataSetupInterface $setup
     * @return void
     */
    private function createMultipleSelectAttribute(ModuleDataSetupInterface $setup)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Add a new multiselect attribute
        $eavSetup->addAttribute(
            Product::ENTITY,
            'custom_multiselect_attribute',
            [
                'type' => 'text',
                'label' => 'Custom Multiselect Attribute',
                'input' => 'multiselect',
                'required' => false,
                'sort_order' => 20,
                'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
                'used_in_product_listing' => true,
                'backend' => 'Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend',
                'option' => [
                    'values' => [
                        'Option 1',
                        'Option 2',
                        'Option 3',
                    ],
                ],
                'group' => 'General',
                'visible_on_front' => true,
                
            ]
        );
    }
}
