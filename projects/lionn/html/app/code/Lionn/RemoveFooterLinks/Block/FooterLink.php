<?php
namespace Lionn\RemoveFooterLinks\Block;

use Magento\Framework\View\Element\Template;

class FooterLink extends Template
{
    protected function _prepareLayout()
    {
        // Remove links padrão
        $this->getLayout()->getBlock('footer_links')->unsetChildren();
        return parent::_prepareLayout();
    }
}
