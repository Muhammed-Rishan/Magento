<?php

namespace Codilar\VendorTable\Model;

use Codilar\VendorTable\Api\Data\VendorInterface;

use Codilar\VendorTable\Api\VendorRepositoryInterface;
use Codilar\VendorTable\Model\ResourceModel\Vendor;
use Codilar\VendorTable\Model\ResourceModel\Vendor\CollectionFactory;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class
 * @author Suman Kar(suman.jis@gmail.com)
 */
class VendorRepository implements VendorRepositoryInterface
{

    /**
     * @var VendorFactory
     */
    private $vendorFactory;

    /**
     * @var Vendor
     */
    private $vendorResource;

    /**
     * @var VendorCollectionFactory
     */
    private $vendorCollectionFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    public function __construct(
        VendorFactory $vendorFactory,
        Vendor $vendorResource,
        CollectionFactory $vendorCollectionFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->vendorFactory = $vendorFactory;
        $this->vendorResource = $vendorResource;
        $this->vendorCollectionFactory = $vendorCollectionFactory;

        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $id
     * @return \Codilar\VendorTable\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id)
    {
        $vendor = $this->vendorFactory->create();
        $this->vendorResource->load($vendor, $id);
        if (!$vendor->getId()) {
            throw new NoSuchEntityException(__('Unable to find vendor with ID "%1"', $id));
        }
        return $vendor;
    }

    /**
     * @param \Codilar\VendorTable\Api\Data\VendorInterface $vendor
     * @return \Codilar\VendorTable\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(VendorInterface $vendor)
    {
        $this->vendorResource->save($vendor);
        return $vendor;
    }

    /**
     * @param \Codilar\VendorTable\Api\Data\VendorInterface $vendor
     * @return bool true on success
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(VendorInterface $vendor)
    {
        try {
            $this->vendorResource->delete($vendor);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }

    /**
     * Retrieve all vendors
     *
     * @return \Codilar\VendorTable\Api\Data\VendorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getAllVendors($limit = null)
    {
        $collection = $this->vendorCollectionFactory->create();

        if ($limit !== null) {
            $collection->setPageSize($limit);
        }

        return $collection->getItems();
    }

    /**
 * {@inheritdoc}
 */
    public function getNew()
    {
        return $this->vendorFactory->create();
    }
}
