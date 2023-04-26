<?php

namespace Codilar\VendorTable\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class CustomerLogin implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * CustomerLogin constructor.
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    /**
     * Handle the customer_login event
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        // Display a message to the user when they log in
        $this->messageManager->addSuccessMessage(__('Welcome back, %1   !!Nice to meet you again', $observer->getEvent()->getCustomer()->getName()));
    }
}
