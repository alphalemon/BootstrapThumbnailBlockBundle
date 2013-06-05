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

use AlphaLemon\AlphaLemonCmsBundle\Core\Content\Block\JsonBlock\AlBlockManagerJsonBlockCollection;

/**
 * Defines the Block Manager to handle a collection of Bootstrap Thumbnails
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapThumbnailsBlock extends AlBlockManagerJsonBlockCollection
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
        $items = $this->decodeJsonContent($this->alBlock->getContent());
        
        return array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnails.html.twig',
            'options' => array(
                'values' => $items,
            ),
        ));
    }
}
