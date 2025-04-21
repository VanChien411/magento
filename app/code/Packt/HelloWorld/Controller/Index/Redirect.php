<?php

namespace Packt\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;

class Redirect extends Action
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->_redirect('helloworld');
    }
}
