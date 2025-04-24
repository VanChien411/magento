<?php

namespace Packt\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Subscription extends Action
{
    protected $_objectManager;

    public function __construct(Context $context)
    {
        parent::__construct($context);
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    }

    public function execute()
    {
        $subscription = $this->_objectManager->create('Packt\HelloWorld\Model\Subscription');
        $subscription->setFirstname('John');
        $subscription->setLastname('Doe');
        $subscription->setEmail('john.doe@example.com');
        $subscription->setMessage('A short message to test');
        $subscription->setStatus(\Packt\HelloWorld\Model\Subscription::STATUS_DECLINED);
        $subscription->save();

        // Cách trả về thông báo kiểu Raw
        /** @var \Magento\Framework\Controller\Result\Raw $resultRaw */
        $resultRaw = $this->resultFactory->create(ResultFactory::TYPE_RAW);
        $resultRaw->setContents('success');
        return $resultRaw;
    }
}
