<?php
namespace Lionn\ToolbarFix\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;

class ToolbarAfterGetLimitPlugin
{
    public function afterGetLimit(Toolbar $subject, $result)
    {
        $request = $subject->getRequest();
        $limit = (int) $request->getParam('list_limit');
        if ($limit > 0) {
            return $limit;
        }
        return $result;
    }
}
