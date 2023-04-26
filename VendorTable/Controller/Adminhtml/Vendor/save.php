<?php

namespace Codilar\VendorTable\Controller\Adminhtml\Vendor;

use Codilar\VendorTable\Api\VendorRepositoryInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\View\Result\PageFactory;

class save extends Action
{

    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Codilar_VendorTable::entity';

    /**
     * @var VendorRepositoryInterface
     */
    protected $vendorRepository;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var SessionManagerInterface
     */
    protected $sessionManager;

    /**
     * @param Context $context
     * @param VendorRepositoryInterface $vendorRepository
     * @param PageFactory $resultPageFactory
     * @param SessionManagerInterface $sessionManager
     */
    public function __construct(
        Context $context,
        VendorRepositoryInterface $vendorRepository,
        PageFactory $resultPageFactory,
        SessionManagerInterface $sessionManager
    ) {
        parent::__construct($context);
        $this->vendorRepository = $vendorRepository;
        $this->resultPageFactory = $resultPageFactory;
        $this->sessionManager = $sessionManager;
    }

    /**
     * Save action
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $vendor = $this->vendorRepository->getNew();

        $data = $this->getRequest()->getPost();

        try {
            if (!empty($data['id'])) {
                $vendor = $this->vendorRepository->getById($data['id']);
            }

            $vendor->setName($data['name']);
//            $vendor->setDescription($data['description']);
            $vendor->setEmail($data['email']);
            $this->vendorRepository->save($vendor);

            //check for `back` parameter
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $vendor->getId(), '_current' => true, '_use_rewrite' => true]);
            }

            $this->messageManager->addSuccess(__('The Record has been saved.'));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }

        return $resultRedirect->setPath('*/*/');
    }
}
