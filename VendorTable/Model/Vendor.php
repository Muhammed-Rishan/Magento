<?php

namespace Codilar\VendorTable\Model;

use Codilar\VendorTable\Api\Data\VendorInterface;

use Magento\Framework\Model\AbstractModel;

// class Vendor extends AbstractModel
// {
//     protected function _construct()
//     {
//         $this->_init(ResourceModel\Vendor::class);
//     }
// }

class Vendor extends AbstractModel implements VendorInterface
{
    protected function _construct()
    {
        $this->_init('Codilar\VendorTable\Model\ResourceModel\Vendor');
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        $this->setData(self::ID, $id);
        return $this;
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        $this->setData(self::NAME, $name);
        return $this;
    }

//    public function getDescription()
//    {
//        return $this->getData(self::DESCRIPTION);
//    }
//
//    public function setDescription($description)
//    {
//        $this->setData(self::DESCRIPTION, $description);
//        return $this;
//    }
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function setEmail($email)
    {
        $this->setData(self::EMAIL, $email);
        return $this;
    }
}
