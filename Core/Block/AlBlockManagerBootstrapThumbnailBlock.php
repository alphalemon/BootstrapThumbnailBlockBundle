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

    public function getHtml()
    {
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        $item = $items[0];
        
        return array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnail.html.twig',
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
            "template" => 'BootstrapThumbnailBlockBundle:Editor:_editor.html.twig',
            "title" => "Thumbnail editor",
            "form" => $form->createView(),
        );
    }
}
