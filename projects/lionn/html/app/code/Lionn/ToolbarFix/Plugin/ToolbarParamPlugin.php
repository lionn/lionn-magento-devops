<?php
namespace Lionn\ToolbarFix\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;

class ToolbarParamPlugin
{
    public function beforeSetCollection(Toolbar $subject, $collection)
    {
        // Substitui product_list_limit por list_limit se existir
        $request = $subject->getRequest();
        $customLimit = $request->getParam('list_limit');
        if ($customLimit) {
            $request->setParam('product_list_limit', $customLimit);
        }
        return [$collection];
    }
}
