<?php
/**
 * An AlphaLemonCms Block
 */

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;

/**
 * Description of AlBlockManagerBootstrapThumbnailsBlock
 */
class AlBlockManagerBootstrapThumbnailsBlock extends AlBlockManagerContainer
{
    public function getDefaultValue()
    {        
        $value = '
            {
                "0" : {
                    "type": "BootstrapThumbnailBlock"
                },
                "1" : {
                    "type": "BootstrapThumbnailBlock"
                }
            }';
        
        return array('Content' => $value);
    }

    protected function renderHtml()
    {
        $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnails.html.twig',
            'options' => array('values' => $items, 'parent' => $this->alBlock),
        ));
    }
    
    protected function edit(array $values)
    {
        if (array_key_exists('Content', $values)) {
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
                $repository->deleteIncludedBlocks($data["slotName"]);

                $values = array("Content" => json_encode($savedValues));
            }
        }
        
        return parent::edit($values);
    }
}
