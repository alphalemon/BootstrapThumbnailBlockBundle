<?php
/*
 * This file is part of the BootstrapThumbnailBlockBundle and it is distributed
 * under the MIT LICENSE. To use this application you must leave intact this copyright 
 * notice.
 *
 * Copyright (c) AlphaLemon <webmaster@alphalemon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * For extra documentation and help please visit http://www.alphalemon.com
 * 
 * @license    MIT LICENSE
 * 
 */

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlock;
use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\AlBlockManagerContainer;

/**
 * Defines the Block Manager to handle a collection of Bootstrap Thumbnails
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapThumbnailsBlock extends AlBlockManagerContainer
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    protected function renderHtml()
    {
        $items = AlBlockManagerJsonBlock::decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnails.html.twig',
            'options' => array(
                'values' => $items,
            ),
        ));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function edit(array $values)
    {
        $values = $this->manageThumbnails($values);
        
        return parent::edit($values);
    }
    
    /**
     * Manages the thumbnails, adding and removing them from the json block
     */
    protected function manageThumbnails($values)
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
        
        return $values;
    }
}
