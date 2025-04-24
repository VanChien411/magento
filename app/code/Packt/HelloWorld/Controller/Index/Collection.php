<?php

namespace Packt\HelloWorld\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Response\Http;

class Collection extends Action
{public function execute()
    {
        $productCollection = $this->_objectManager
            ->create('Magento\Catalog\Model\ResourceModel\Product\Collection')
            ->addAttributeToSelect('*')
            // ->addAttributeToFilter('entity_id', array(
            //     'in' => array(159, 160, 161)
            // ))
            // ->addAttributeToFilter(
            //     'name',
            //     ['like' => '%Sport%']

            // )
            ->addAttributeToFilter('name', 'Áo thun');

        // $productCollection->addAttributeToFilter('entity_id', ['in' => [159, 160, 161]]);
        // Gán giá trị cho tất cả các sản phẩm trong collection
        $productCollection->setDataToAll('price', 26660);
        $productCollection->save(); 
        $output = '';
        foreach ($productCollection as $product) {
            $product->getResource()->saveAttribute($product, 'price');
            $output .= nl2br(print_r($product->getData(), true));
        }
        // $output = $productCollection->getSelect()->__toString();
        // In ra câu lệnh SQL
        /** @var Http $response */
        $response = $this->getResponse();
        $response->setHeader('Content-Type', 'text/plain', true);
        $response->setBody($output);
    }
}
