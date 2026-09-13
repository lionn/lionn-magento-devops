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

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'Lionn_EditorFix',
    __DIR__
);
