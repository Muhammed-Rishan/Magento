<?php

namespace Codilar\VendorTable\Plugin;

use Magento\Catalog\Model\Product;

class PluginBefore
{
    public function beforeGetName(Product $subject)
    {
        $name = $subject->getData('name');
        if (strpos($name, '#justhere') === false) {
            $modifiedName = $name . '#justhere';
            $subject->setData('name', $modifiedName);
            return $modifiedName;
        }
        return null;
    }
}
