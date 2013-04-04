<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlockContainer;

/**
 * Description of AlBlockManagerBootstrapThumbnailBlock
 */
class AlBlockManagerBootstrapThumbnailBlock extends AlBlockManagerJsonBlockContainer
{
    protected $blockTemplate = 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnail.html.twig';
    protected $editorTemplate = 'BootstrapThumbnailBlockBundle:Editor:_editor.html.twig';
    
    public function getDefaultValue()
    {
        $value = '
            {
                "0" : {
                    "width": "span3"
                }
            }';
        
        return array('Content' => $value);
    }

    protected function renderHtml()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        
        return array('RenderView' => array(
            'view' => $this->blockTemplate,
            'options' => array(
                'thumbnail' => $item,
                'parent' => $this->alBlock,
            ),
        ));
    }
    
    public function editorParameters()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        
        $formClass = $this->container->get('bootstrap_thumbnail.form');
        $form = $this->container->get('form.factory')->create($formClass, $item);
        
        return array(
            "template" => $this->editorTemplate,
            "title" => "Thumbnail editor",
            "form" => $form->createView(),
        );
    }
    
    public function getIsInternalBlock()
    {
        return true;
    }
}
