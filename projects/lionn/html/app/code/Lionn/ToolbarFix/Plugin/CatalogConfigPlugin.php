<?php
namespace Lionn\ToolbarFix\Plugin;

class CatalogConfigPlugin
{
    public function afterGetAttributeUsedForSortByArray($subject, $result)
    {
        // Adiciona 'name' como opção de ordenação
        if (!isset($result['name'])) {
            $result['name'] = __('Name');
        }
        return $result;
    }
}