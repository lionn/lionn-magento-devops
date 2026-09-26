<?php
namespace Lionn\RadioPopup\Block;

use Magento\Framework\View\Element\Template;
use Lionn\RadioPopup\Model\SomeModel; // Alterar para o nome correto do seu modelo

class RadioPopup extends Template
{
    protected $_someObject;

    // Construtor injetando a dependência
    public function __construct(
        Template\Context $context,
        SomeModel $someObject, // Verifique se o nome do modelo está correto
        array $data = []
    ) {
        $this->_someObject = $someObject;
        parent::__construct($context, $data);
    }

    public function getSomeObject()
    {
        return $this->_someObject; // Método para retornar o modelo ou os dados
    }
}
