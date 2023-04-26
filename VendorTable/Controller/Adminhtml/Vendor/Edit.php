<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Codilar\VendorTable\Controller\Adminhtml\Vendor;

use Codilar\VendorTable\Api\VendorRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;

class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Codilar_VendorTable::entity';

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * @var \Codilar\VendorTable\Model\VendorFactory
     */
    private $vendorFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,
     * @param \Codilar\VendorTable\Model\VendorFactory $vendorFactory
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Codilar\VendorTable\Model\VendorFactory $vendorFactory,
        VendorRepositoryInterface $vendorRepository
    ) {
        parent::__construct($context);
        $this->coreRegistry = $coreRegistry;
        $this->vendorFactory = $vendorFactory;
        $this->vendorRepository = $vendorRepository;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParams('id');

        $model = $this->vendorFactory->create();

        if ($id) {
            if (!$vendor = $this->vendorRepository->getById($id)) {
                $this->messageManager->addError(__('This entity no longer exists.'));
                return $this->_redirect('*/*/');
            }
        }

        $this->coreRegistry->register('vendor_data', $model);

        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->setActiveMenu('Codilar_VendorTable::vendor_menu');
        $resultPage->getConfig()->getTitle()->prepend(__('Vendor Information'));

        return $resultPage;
    }
}
