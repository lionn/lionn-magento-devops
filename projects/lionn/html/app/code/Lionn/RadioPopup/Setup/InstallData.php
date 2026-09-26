<?php
namespace Lionn\RadioPopup\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Atributo para o link do YouTube
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'youtube_link',
            [
                'type' => 'varchar',
                'label' => 'YouTube Link',
                'input' => 'text',
                'required' => false,
                'user_defined' => true,
                'sort_order' => 200,
            ]
        );

        // Atributo para o tempo do YouTube (formato hh:mm:ss)
        $eavSetup->addAttribute(
            \Magento\Catalog\Model\Product::ENTITY,
            'youtube_time',
            [
                'type' => 'varchar',
                'label' => 'YouTube Time',
                'input' => 'text',
                'required' => false,
                'user_defined' => true,
                'sort_order' => 210,
            ]
        );
    }
}
