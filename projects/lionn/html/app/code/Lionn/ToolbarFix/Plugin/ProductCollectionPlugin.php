<?php
namespace Lionn\ToolbarFix\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class ProductCollectionPlugin
{
    protected $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function beforeLoad(Collection $collection)
    {
        if ($collection->isLoaded()) {
            return null;
        }

        /*
         * 🔥 LIMITE PADRÃO
         */
        $limit = (int) $this->request->getParam('list_limit');
        if ($limit <= 0) {
            $limit = (int) $this->request->getParam('product_list_limit');
        }
        if ($limit <= 0) {
            $limit = 27;
        }
        $collection->setPageSize($limit);

        /*
         * 🔥 PAGINAÇÃO
         */
        $curPage = (int) $this->request->getParam('p', 1);
        $collection->setCurPage($curPage);

        /*
         * 🔥 ORDENAÇÃO - APENAS NOME E POSIÇÃO
         */
        $order = $this->request->getParam('list_order');
        if (!$order) {
            $order = $this->request->getParam('product_list_order');
        }
        
        $dir = $this->request->getParam('list_dir');
        if (!$dir) {
            $dir = $this->request->getParam('product_list_dir');
        }
        
        $dir = ($dir === 'desc') ? 'desc' : 'asc';
        
        // Força ordenação
        if ($order === 'name') {
            $collection->addAttributeToSort('name', $dir);
        } elseif ($order === 'position') {
            $collection->addAttributeToSort('position', $dir);
        } else {
            // Padrão: ordenar por nome
            $collection->addAttributeToSort('name', 'asc');
        }

        return null;
    }
}