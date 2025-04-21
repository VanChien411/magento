<?php

namespace Packt\HelloWorld\Block;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class Newproducts extends Template
{
    /**
     * @var CollectionFactory
     */
    private $_productCollectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_productCollectionFactory = $productCollectionFactory;
    }

    /**
     * Lấy danh sách sản phẩm
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProducts()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('visibility', ['neq' => 1]);
        $collection->setPageSize(5);
        $collection->setCurPage(1);

        return $collection;
    }
}
