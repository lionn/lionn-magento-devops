<?php

/**
 * Module: Lionn_EditorFix
 * [ Módulo: Lionn_EditorFix ]
 *
 * Description: Fixes the CMS editor (TinyMCE/Hugerte) to show the full menubar.
 * [ Descrição: Corrige o editor do CMS (TinyMCE/Hugerte) para exibir o menubar completo. ]
 *
 * © Lionn - https://www.lionn.net
 * [ © Lionn - https://www.lionn.net ]
 *
 * Licensed under the MIT License.
 * [ Licenciado sob a Licença MIT. ]
 * See LICENSE file for details.
 * [ Veja o arquivo LICENSE para detalhes. ]
 */

namespace Lionn\EditorFix\Plugin;

class WysiwygConfigPlugin
{
    /**
     * @param \Magento\Cms\Model\Wysiwyg\Config $subject
     * @param \Magento\Framework\DataObject $result
     * @return \Magento\Framework\DataObject
     */
    public function afterGetConfig(
        \Magento\Cms\Model\Wysiwyg\Config $subject,
        $result
    ) {
        $settings = $result->getData('settings') ?? [];
        $settings['menubar'] = 'file edit view insert format tools table help';
        $result->setData('settings', $settings);

        return $result;
    }
}
