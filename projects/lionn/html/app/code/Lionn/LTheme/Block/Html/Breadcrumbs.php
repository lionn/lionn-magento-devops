<?php
namespace Lionn\LTheme\Block\Html;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Registry;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Block\Html\Breadcrumbs as MagentoBreadcrumbs;

class Breadcrumbs extends MagentoBreadcrumbs
{
    protected $_catalogData;
    protected $_registry;
    protected $_storeManager;

    public function __construct(
        Context $context,
        Data $catalogData,
        Registry $registry,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_catalogData = $catalogData;
        $this->_registry = $registry;
        $this->_storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * @inheritDoc
     */
    protected function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * Retrieve current product breadcrumbs
     *
     * @return array
     */
    public function getCrumbs()
    {
        $crumbs = parent::getCrumbs();

        // Retrieve Current Product
        $product = $this->_registry->registry('current_product');

        if ($product) {
            // Get all categories of the product
            $categories = $product->getCategoryCollection()->addAttributeToSelect('*');

            // Add Category Crumbs
            foreach ($categories as $category) {
                $crumbInfo = [
                    'label' => $category->getName(),
                    'title' => $category->getName(),
                    'link' => $category->getUrl()
                ];
                $this->addCrumb('category' . $category->getId(), $crumbInfo);
            }

            // Add Product Crumb
            $productCrumbInfo = [
                'label' => $product->getName(),
                'title' => $product->getName(),
                'link' => ''
            ];
            $this->addCrumb('product', $productCrumbInfo);
        }

        return $crumbs;
    }
}
