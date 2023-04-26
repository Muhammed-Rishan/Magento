<?php
namespace Codilar\VendorTable\Api\Data;

interface VendorInterface
{
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';

    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);



    public function getEmail();

    public function setEmail($email);
}
