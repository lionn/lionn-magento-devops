<?php
namespace Lionn\ToolbarFix\Plugin;

use Magento\Catalog\Block\Product\ProductList\Toolbar;

class ToolbarPlugin
{
    public function afterGetAvailableOrders(Toolbar $subject, $result)
    {
        // Usa __() para tradução dinâmica
        $result = ['name' => __('Name')] + $result;
        
        if (!isset($result['position'])) {
            $result['position'] = __('Position');
        }
        
        return $result;
    }

    public function afterGetCurrentOrder(Toolbar $subject, $result)
    {
        $request = $subject->getRequest();
        
        $order = $request->getParam('list_order');
        if ($order === null) {
            $order = $request->getParam('product_list_order');
        }
        
        if ($order === 'name' || $order === 'position') {
            return $order;
        }
        
        return 'name';
    }

    public function afterGetCurrentDirection(Toolbar $subject, $result)
    {
        $request = $subject->getRequest();
        
        $direction = $request->getParam('list_dir');
        if ($direction === null) {
            $direction = $request->getParam('product_list_dir');
        }
        
        return ($direction === 'desc') ? 'desc' : 'asc';
    }

    public function afterGetLimit(Toolbar $subject, $result)
    {
        $request = $subject->getRequest();
        $param = (int) $request->getParam('list_limit');
        
        if ($param <= 0) {
            $param = (int) $request->getParam('product_list_limit');
        }

        if ($param > 0) {
            return $param;
        }

        return $result;
    }
    
    public function afterGetOrderUrl(Toolbar $subject, $result, $order, $direction)
    {
        $params = [];
        $params['list_order'] = $order;
        $params['list_dir'] = $direction;
        
        $url = $subject->getPagerUrl($params);
        $url = preg_replace('/[?&]product_list_(order|dir)=[^&]*/', '', $url);
        
        return $url;
    }
}