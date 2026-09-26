<?php
declare(strict_types=1);

namespace Lionn\LTheme\Block;

use Magento\Framework\View\Element\Template;

class ThemeSwitcher extends Template
{
    /**
     * Retorna o label acessível (aria-label) traduzível
     */
    public function getAriaLabel(): string
    {
        return (string)__('Alternar tema claro/escuro');
    }

    public function getSunUrl(): string
    {
        return $this->getViewFileUrl('Lionn_LTheme::images/sun.svg');
    }

    public function getMoonUrl(): string
    {
        return $this->getViewFileUrl('Lionn_LTheme::images/moon.svg');
    }
}