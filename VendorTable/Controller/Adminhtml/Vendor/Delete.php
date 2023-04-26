<?php
/**
 * @package   Vendor_Modulename
 * @author    Ricky Thakur (Kapil Dev Singh)
 * @copyright Copyright (c) 2018 Ricky Thakur
 * @license   MIT license (see LICENSE.txt for details)
 */
namespace Codilar\VendorTable\Controller\Adminhtml\Vendor;

use Codilar\VendorTable\Api\VendorRepositoryInterface;
use Codilar\VendorTable\Api\Data\VendorInterface;
use Codilar\VendorTable\Model\CouldNotDeleteException;
use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

class Delete extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Vendor_Modulename::entity';

    /**
     * @var VendorRepositoryInterface
     */
    private $vendorRepository;

    /**
     * Delete constructor.
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
     * Delete action
     *
     * @return Redirect
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $vendor = $this->vendorRepository->getById($id);
                $this->vendorRepository->delete($vendor);
                // display success message
                $this->messageManager->addSuccess(__('Data has been deleted.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (NoSuchEntityException $e) {
                // display error message
                $this->messageManager->addError(__('We can\'t find the data to delete.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (CouldNotDeleteException $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            } catch (LocalizedException $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go to grid
                return $resultRedirect->setPath('*/*/');
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find the data to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
