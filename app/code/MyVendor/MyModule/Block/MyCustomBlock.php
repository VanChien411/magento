<?php

namespace MyVendor\MyModule\Block;

use Magento\Framework\View\Element\Template;

class MyCustomBlock extends Template
{
    /**
     * Get custom message
     *
     * @return string
     */
    public function getCustomMessage()
    {
        return 'This is my custom message!';
    }
}
