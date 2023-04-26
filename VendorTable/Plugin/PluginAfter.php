<?php

namespace Codilar\VendorTable\Plugin;

use Magento\Catalog\Model\Product;

class PluginAfter
{
    public function afterGetPrice(Product $subject, $result)
    {
        // Perform some action after the original method is called
        $newPrice = $result - 45;
        return $newPrice;
    }
}
