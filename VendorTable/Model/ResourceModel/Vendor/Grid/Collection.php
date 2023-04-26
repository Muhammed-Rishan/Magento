<?php


namespace Codilar\VendorTable\Model\ResourceModel\Vendor\Grid;


use Codilar\VendorTable\Model\Vendor;
use Codilar\VendorTable\Model\ResourceModel\Vendor as VendorResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Vendor::class, VendorResourceModel::class);
    }
}
