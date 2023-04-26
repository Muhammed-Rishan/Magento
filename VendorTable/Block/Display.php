<?php
namespace Codilar\VendorTable\Block;

use Codilar\VendorTable\Api\VendorRepositoryInterface;
use Magento\Framework\View\Element\Template;

class Display extends Template
{
    protected $vendorRepository;

    public function __construct(
        Template\Context $context,
        VendorRepositoryInterface $vendorRepository,
        array $data = []
    ) {
        $this->vendorRepository = $vendorRepository;
        parent::__construct($context, $data);
    }

    public function getCollection()
    {
        $textValue = $this->_scopeConfig->getValue('demo/general/text');
        $textValue1 = $this->_scopeConfig->getValue('demo/general/enable');

        if ($textValue1) {
            $vendors = $this->vendorRepository->getAllVendors($textValue);

            // $vendors->setPageSize($textValue);
            return $vendors;
        } else {
            return 1;
        }
    }
}
