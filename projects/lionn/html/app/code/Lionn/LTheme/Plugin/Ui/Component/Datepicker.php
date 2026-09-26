<?php
namespace Lionn\LTheme\Plugin\Ui\Component;

class Datepicker
{
    public function afterPrepare(\Magento\Ui\Component\Datepicker $subject, $result)
    {
        $config = $subject->getConfig();
        $config['template'] = str_replace(
            '<a class="ui-datepicker-prev',
            '<a href="#prev" title="Anterior" aria-label="Anterior" class="ui-datepicker-prev',
            $config['template']
        );
        $config['template'] = str_replace(
            '<a class="ui-datepicker-next',
            '<a href="#next" title="Próximo" aria-label="Próximo" class="ui-datepicker-next',
            $config['template']
        );
        $subject->setConfig($config);
        return $result;
    }
}