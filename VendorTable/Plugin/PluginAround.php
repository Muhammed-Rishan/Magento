<?php
namespace Codilar\VendorTable\Plugin;

use Magento\Catalog\Model\Product;

class PluginAround
{
    public function aroundGetPrice(Product $subject, callable $proceed)
    {
        // Perform some action before the original method is called
        $specialPrice = $subject->getData('special_price');
        if ($specialPrice && $specialPrice < $subject->getData('price')) {
            $subject->setData('price', $specialPrice);
        }

        // Call the original method with the modified subject
        $result = $proceed($subject);

        // Perform some action after the original method is called
        if ($result > 100) {
            $newResult = $result * 0.9; // Apply a 10% discount
            return $newResult;
        }

        return $result;
    }
}
