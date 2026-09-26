require(['jquery', 'domReady!'], function ($) {
    'use strict';

    $(function () {
        
        // Verifica se é uma página de listagem (tem toolbar)
        function isListingPage() {
            return $('.toolbar').length > 0;
        }
        
        // Se não for página de listagem, não faz nada
        if (!isListingPage()) {
            return;
        }
        
        // Força o select de ordenação para sempre usar 'list_order'
        function fixOrderSelect() {
            var $select = $('.toolbar .sorter-options');
            if ($select.length && !$select.data('fixed')) {
                $select.data('fixed', true);
                
                // Adiciona opção Name se não existir
                if ($select.find('option[value="name"]').length === 0) {
                    $select.append('<option value="name">Name</option>');
                }
                
                // Força o valor atual baseado na URL
                var urlParams = new URLSearchParams(window.location.search);
                var currentOrder = urlParams.get('list_order') || urlParams.get('product_list_order') || 'name';
                $select.val(currentOrder);
            }
        }
        
        // Intercepta a mudança do select
        $(document).off('change', '.toolbar .sorter-options');
        $(document).on('change', '.toolbar .sorter-options', function() {
            var order = $(this).val();
            var url = new URL(window.location.href);
            
            // Remove parâmetros antigos
            url.searchParams.delete('product_list_order');
            url.searchParams.delete('product_list_dir');
            
            // Adiciona novos parâmetros
            url.searchParams.set('list_order', order);
            
            // Mantém a direção atual ou usa asc como padrão
            var currentDir = url.searchParams.get('list_dir');
            if (!currentDir) {
                url.searchParams.set('list_dir', 'asc');
            }
            
            // Reseta página
            url.searchParams.delete('p');
            
            window.location.href = url.toString();
        });
        
        // Intercepta o clique na seta de direção
        $(document).off('click', '.toolbar .sorter-action');
        $(document).on('click', '.toolbar .sorter-action', function(e) {
            e.preventDefault();
            
            var url = new URL(window.location.href);
            var currentDir = url.searchParams.get('list_dir');
            var newDir = (currentDir === 'desc') ? 'asc' : 'desc';
            
            // Garante que temos list_order
            var currentOrder = url.searchParams.get('list_order');
            if (!currentOrder) {
                currentOrder = 'name';
                url.searchParams.set('list_order', currentOrder);
            }
            
            // Remove parâmetros antigos
            url.searchParams.delete('product_list_order');
            url.searchParams.delete('product_list_dir');
            
            // Define nova direção
            url.searchParams.set('list_dir', newDir);
            
            // Reseta página
            url.searchParams.delete('p');
            
            window.location.href = url.toString();
        });
        
        // Limpa a URL na primeira carga (APENAS se já tiver parâmetros)
        function cleanInitialUrl() {
            var url = new URL(window.location.href);
            var changed = false;
            
            // Só modifica se já existirem parâmetros de ordenação
            var hasOrderParams = url.searchParams.has('product_list_order') || 
                                 url.searchParams.has('product_list_dir') ||
                                 url.searchParams.has('list_order') ||
                                 url.searchParams.has('list_dir');
            
            if (!hasOrderParams) {
                return true; // Não faz nada se não tem parâmetros
            }
            
            if (url.searchParams.has('product_list_order')) {
                var order = url.searchParams.get('product_list_order');
                url.searchParams.delete('product_list_order');
                url.searchParams.set('list_order', order);
                changed = true;
            }
            
            if (url.searchParams.has('product_list_dir')) {
                var dir = url.searchParams.get('product_list_dir');
                url.searchParams.delete('product_list_dir');
                url.searchParams.set('list_dir', dir);
                changed = true;
            }
            
            // SÓ adiciona parâmetros padrão se já existir algum parâmetro de ordenação
            if (!url.searchParams.has('list_order') && hasOrderParams) {
                url.searchParams.set('list_order', 'name');
                changed = true;
            }
            
            if (!url.searchParams.has('list_dir') && hasOrderParams) {
                url.searchParams.set('list_dir', 'asc');
                changed = true;
            }
            
            if (changed) {
                window.location.href = url.toString();
                return false;
            }
            return true;
        }
        
        // Executa as correções
        setTimeout(function() {
            fixOrderSelect();
            cleanInitialUrl();
        }, 100);
        
        // Observa mudanças no DOM
        var observer = new MutationObserver(function() {
            fixOrderSelect();
        });
        observer.observe(document.body, { childList: true, subtree: true });
        
        // Limite por página (seu código original)
        $(document).on('change', '#limiter, .limiter-options, select[name="product_list_limit"], select[name="list_limit"]', function () {
            var val = $(this).val();
            if (!val) return;
            
            var url = new URL(window.location.href);
            url.searchParams.set('list_limit', val);
            url.searchParams.delete('product_list_limit');
            url.searchParams.delete('p');
            window.location.href = url.toString();
        });
    });
});