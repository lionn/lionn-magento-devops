<?php
namespace Lionn\ToolbarFix\Block;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template;

class ProductList extends Template
{
    protected $collectionFactory;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getLoadedProductCollection()
    {
        $collection = $this->collectionFactory->create();
        $collection->addAttributeToSelect('*');

        // Definir limites permitidos
        $allowedLimits = [10, 20, 30];

        $limit = (int) $this->getRequest()->getParam('product_list_limit', 10);
        if (!in_array($limit, $allowedLimits)) {
            $limit = 10;
        }

        $page = (int) $this->getRequest()->getParam('p', 1);

        $collection->setPageSize($limit);
        $collection->setCurPage($page);

        return $collection;
    }

    public function getPagerHtml()
    {
        $pager = $this->getLayout()->createBlock(\Magento\Theme\Block\Html\Pager::class, 'toolbarfix.pager');
        if ($pager) {
            $pager->setLimitVarName('product_list_limit')
                ->setPageVarName('p')
                ->setAvailableLimit([10 => 10, 20 => 20, 30 => 30])
                ->setCollection($this->getLoadedProductCollection());

            return $pager->toHtml();
        }
        return '';
    }
}
