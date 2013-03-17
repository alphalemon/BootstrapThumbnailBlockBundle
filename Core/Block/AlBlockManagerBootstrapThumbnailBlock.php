<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;

/**
 * Description of AlBlockManagerBootstrapThumbnailBlock
 */
class AlBlockManagerBootstrapThumbnailBlock extends AlBlockManagerContainer
{
    public function getDefaultValue()
    {        
        $value = '
            {
                "0" : {
                    "width": "span3"
                },
                "1" : {
                    "width": "span3"
                }
            }';
        
        return array('Content' => $value);
    }

    public function getHtml()
    {
        $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnail.html.twig',
            'options' => array('values' => $items, 'parent' => $this->alBlock),
        ));
    }
    
    public function getContentForEditor()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $values = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock);
        
        $images = array_map(function($el)
            { 
                $image = str_replace("\\", "/", $el['image']);
                
                return array_merge($el, array('image' => $image));             
            }, $values
        );
        
        $values = array_merge($images, $values);
        
        return $values;
    }
    
    protected function edit(array $values)
    {
        $data = json_decode($values['Content'], true); 
        $savedValues = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock);
        
        if ($data["operation"] == "add") {
            $savedValues[] = $data["value"];
            $values = array("Content" => json_encode($savedValues));
        }
        
        if ($data["operation"] == "remove") {
            unset($savedValues[$data["item"]]);
            
            $blocksRepository = $this->container->get('alpha_lemon_cms.factory_repository');
            $repository = $blocksRepository->createRepository('Block');
            $repository->deleteIncludedBlocks($data["key"]);
            
            $values = array("Content" => json_encode($savedValues));
        }
        
        return parent::edit($values);
    }
}