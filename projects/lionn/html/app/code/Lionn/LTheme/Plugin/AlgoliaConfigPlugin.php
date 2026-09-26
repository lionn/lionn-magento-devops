<?php

namespace Lionn\LTheme\Plugin;

class AlgoliaConfigPlugin
{
    public function afterGetConfiguration(
        \Algolia\AlgoliaSearch\Block\Algolia $subject,
        $result
    ) {
        // translations (já funcionando)
        if (isset($result['translations'])) {
            $result['translations']['seeIn'] = __('See products in');
            $result['translations']['orIn'] = __('or in');
            $result['translations']['allDepartments'] = __('All departments');
            $result['translations']['noResults'] = __('No results');
        }

        // AQUI resolve o "PAGES"
        if (isset($result['autocomplete']['sections'])) {
            foreach ($result['autocomplete']['sections'] as &$section) {
                if ($section['name'] === 'pages') {
                    $section['label'] = __('Pages');
                }
            }
        }

        return $result;
    }
}