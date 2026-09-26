<?php
namespace Lionn\LTheme\Plugin\Framework\View\Asset;

class MergeService
{
    /**
     * After plugin for getCssFiles to make merged CSS load non-blocking
     *
     * @param \Magento\Framework\View\Asset\MergeService $subject
     * @param array $result
     * @return array
     */
    public function afterGetCssFiles(\Magento\Framework\View\Asset\MergeService $subject, $result)
    {
        if (!is_array($result)) {
            return $result;
        }

        foreach ($result as &$file) {
            if ($this->shouldModifyCssFile($file)) {
                $file['attributes'] = $this->getNonBlockingAttributes();
                
                // Adiciona fallback para noscript
                if (!isset($file['noscript'])) {
                    $file['noscript'] = true;
                }
            }
        }
        
        return $result;
    }

    /**
     * Check if file should be modified
     *
     * @param array $file
     * @return bool
     */
    protected function shouldModifyCssFile($file)
    {
        return isset($file['url']) && 
               is_string($file['url']) && 
               strpos($file['url'], 'merged') !== false && 
               strpos($file['url'], '.css') !== false;
    }

    /**
     * Get attributes for non-blocking CSS
     *
     * @return array
     */
    protected function getNonBlockingAttributes()
    {
        return [
            'rel' => 'preload',
            'as' => 'style',
            'onload' => "this.onload=null;this.rel='stylesheet'",
            'media' => 'print', // Fallback para navegadores antigos
            'onerror' => "this.remove()" // Remove se houver erro no carregamento
        ];
    }
}