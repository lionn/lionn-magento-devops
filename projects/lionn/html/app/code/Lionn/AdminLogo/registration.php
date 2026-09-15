<?php

/**
 * Module: Lionn_AdminLogo
 * [ Módulo: Lionn_AdminLogo ]
 *
 * Description: Replaces the default Magento admin logo with a custom logo.
 * [ Descrição: Substitui o logo padrão do Painel de Admin do Magento por um logo personalizado, além de controlar o estilo do Painel do Admin. ]
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
    'Lionn_AdminLogo',
    __DIR__
);
