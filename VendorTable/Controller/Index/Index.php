<?php
namespace Codilar\VendorTable\Controller\Index;

use Codilar\VendorTable\Model\ResourceModel\Vendor\CollectionFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

// use Magento\Framework\App\Config\ScopeConfigInterface;
// use Magento\Store\Model\ScopeInterface;

class Index extends Action
{
    protected $_pageFactory;
    protected $_collectionFactory;

    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_collectionFactory = $collectionFactory;

        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->_collectionFactory->create();
        // $collection->addFieldToSelect('*');

        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('VENDOR DATA'));

        $block = $resultPage->getLayout()->getBlock('my_module_block');

        // if ($block) {
        //     $block->setCollection($collection);
        // }

        return $resultPage;
    }
}
