<?php
namespace Training\Vendor\Block\Product;

use Magento\Catalog\Block\Product\View\Attributes;
use Magento\Catalog\Model\Product;

class MultiselectList extends \Magento\Catalog\Block\Product\View\Attributes
{
    /**
     * Get multiselect attribute values as an HTML list
     *
     * @return string
     */
    public function getMultiselectList()
    {
        $attributeCode = 'custom_multiselect_attribute'; // Replace with your attribute code
        $product = $this->getProduct();

        $attribute = $product->getResource()->getAttribute($attributeCode);

        if (!$attribute) {
            return '';
        }

        $value = $product->getData($attributeCode);

        if (!$value) {
            return '';
        }

        $options = $attribute->getSource()->getOptionText($value);

        if (!is_array($options)) {
            $options = [$options];
        }

        $listItems = '<ul>';
        foreach ($options as $option) {
            $listItems .= '<li>' . $option . '</li>';
        }
        $listItems .= '</ul>';

        return $listItems;
    }
}
