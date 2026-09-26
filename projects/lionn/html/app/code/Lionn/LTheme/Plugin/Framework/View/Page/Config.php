<?php
namespace Lionn\LTheme\Plugin\Framework\View\Page;

class Config
{
    /**
     * Add preload attributes to merged CSS files
     *
     * @param \Magento\Framework\View\Page\Config $subject
     * @param $result
     * @param string $file
     * @param array $properties
     * @return mixed
     */
    public function afterAddPageAsset(
        \Magento\Framework\View\Page\Config $subject,
        $result,
        $file,
        $properties = []
    ) {
        if (isset($properties['attributes'])) {
            return $result;
        }
        
        if (is_string($file) && strpos($file, '.css') !== false && strpos($file, 'merged') !== false) {
            $subject->addElementAttributes($result, [
                'rel' => 'preload',
                'as' => 'style',
                'onload' => "this.onload=null;this.rel='stylesheet'"
            ]);
        }
        
        return $result;
    }
}