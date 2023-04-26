<?php

namespace Codilar\VendorTable\Controller\Adminhtml\Vendor;

use Codilar\VendorTable\Api\VendorRepositoryInterface;
// use Codilar\VendorTable\Model\VendorFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;

class MassDelete extends Action
{
    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * MassDelete constructor.
     *
     * @param Action\Context $context
     * @param VendorRepositoryInterface $vendorRepository
     */
    public function __construct(
        Action\Context $context,
        VendorRepositoryInterface $vendorRepository
    ) {
        parent::__construct($context);
        $this->vendorRepository = $vendorRepository;
    }

    /**
     * MassDelete action
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected');
        if (empty($ids)) {
            $this->messageManager->addError(__('Please select vendor(s) to delete.'));
        } else {
            try {
                foreach ($ids as $id) {
                    $vendor = $this->vendorRepository->getById($id);
                    $this->vendorRepository->delete($vendor);
                }
                $this->messageManager->addSuccess(__('Total of %1 vendor(s) have been deleted.', count($ids)));
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addError(__('We can\'t delete the vendor(s) right now. Please review the log and try again.'));
                $this->logger->critical($e);
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/');

        return $resultRedirect;
    }

    /**
     * Check for permissions
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Codilar_VendorTable::vendortable_manage');
    }
}
