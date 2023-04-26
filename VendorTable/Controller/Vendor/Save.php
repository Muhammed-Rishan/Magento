<?php

namespace Codilar\VendorTable\Controller\Vendor;

use Codilar\VendorTable\Model\Vendor;
use Codilar\VendorTable\Model\ResourceModel\Vendor as VendorResourceModel;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Save extends Action
{
    /**
     * @var Vendor
     */
    private $vendor;
    /**
     * @var VendorResourceModel
     */
    private $vendorResourceModel;

    /**
     * Add constructor.
     * @param Context $contexta
     * @param Vendor $vendor
     * @param VendorResourceModel $vendorResourceModel
     */
    public function __construct(
        Context $context,
        Vendor $vendor,
        VendorResourceModel $vendorResourceModel
    ) {
        $this->vendor = $vendor;
        $this->vendorResourceModel = $vendorResourceModel;
        parent::__construct($context);
    }

    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $vendor = $this->vendor->setData($params);
        try {
            $this->vendorResourceModel->save($vendor);
            $this->messageManager->addSuccessMessage(__("Successfully added the Vendor %1", $params['name']));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Something went wrong."));
        }
        /* Redirect back to hero display page */
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('vendortable');
        return $redirect;
    }
}
