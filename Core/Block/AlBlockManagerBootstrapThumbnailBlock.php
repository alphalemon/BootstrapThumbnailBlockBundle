<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\ImagesBlock\AlBlockManagerImages;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;

/**
 * Description of AlBlockManagerBootstrapThumbnailBlock
 */
class AlBlockManagerBootstrapThumbnailBlock extends AlBlockManagerImages
{
    public function getDefaultValue()
    {
        $value = 
            '
                {
                    "0" : {
                        "image": "holder.js/260x180",
                        "title" : "Sample title",
                        "alt" : "Sample alt",
                        "thumbnail_width": "span3",
                        "thumbnail_caption": "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
                    },
                    "1" : {
                        "image": "holder.js/260x180",
                        "title" : "Sample title",
                        "alt" : "Sample alt",
                        "thumbnail_width": "span3",
                        "thumbnail_caption": "Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus."
                    }
                }
            ';
        
        return array('Content' => $value);
    }
    
    public function getHtml()
    {
        $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnail.html.twig',
            'options' => array('images' => $items),
        ));
    }
    
    public function getContentForEditor()
    {
        if (null === $this->alBlock) {
            return "";
        }
        
        $images = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock);
        
        return array_map(function($el)
            { 
                $image = str_replace("\\", "/", $el['image']);
                
                return array_merge($el, array('id' => md5($image), 'image' => $image));             
            }, $images
        );
    }
}