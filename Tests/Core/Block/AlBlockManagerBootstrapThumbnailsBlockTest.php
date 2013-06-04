<?php
/*
 * This file is part of the BootstrapLabelBlockBundle and it is distributed
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

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Tests\Core\Block;

use AlphaLemon\AlphaLemonCmsBundle\Tests\Unit\Core\Content\Block\Base\AlBlockManagerContainerBase;
use AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Block\AlBlockManagerBootstrapThumbnailsBlock;

class AlBlockManagerBootstrapThumbnailsTester extends AlBlockManagerBootstrapThumbnailsBlock
{
    public function manageThumbnailsTester($values)
    {
        return $this->manageThumbnails($values);
    }
}


/**
 * AlBlockManagerBootstrapThumbnailsBlockTest
 *
 * @author AlphaLemon <webmaster@alphalemon.com>
 */
class AlBlockManagerBootstrapThumbnailsBlockTest extends AlBlockManagerContainerBase
{  
    public function testDefaultValue()
    {
        $expectedValue = array(
            "Content" =>    '
            {
                "0" : {
                    "type": "BootstrapThumbnailBlock"
                },
                "1" : {
                    "type": "BootstrapThumbnailBlock"
                }
            }'
        );
            
        $this->initContainer(); 
        $blockManager = new AlBlockManagerBootstrapThumbnailsBlock($this->container, $this->validator);
        $this->assertEquals($expectedValue, $blockManager->getDefaultValue());
    }
    
    
    public function testGetHtml()
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
            
        $block = $this->initBlock($value);
        $this->initContainer();
        
        $blockManager = new AlBlockManagerBootstrapThumbnailsTester($this->container, $this->validator);
        $blockManager->set($block);
        
        $expectedResult = array('RenderView' => array(
            'view' => 'BootstrapThumbnailBlockBundle:Thumbnail:thumbnails.html.twig',
            'options' => array(
                'values' => array(
                    array(
                        "type" => "BootstrapThumbnailBlock",
                    ),
                    array(
                        "type" => "BootstrapThumbnailBlock",
                    ),
                ),
                'block_manager' => $blockManager,
            ),
        ));
        
        $this->assertEquals($expectedResult, $blockManager->getHtml());
    }
    
    /**
     * @dataProvider manageThumbnailsProvider
     */
    public function testConvertSerializedDataToJson($values, $expectedResult)
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
        
        if (array_key_exists("Content", $values)) {
            $valuesArray = json_decode($values["Content"], true);        
            if ($valuesArray['operation'] == 'remove') {
                $blocksRepository = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Repository\BlockRepositoryInterface');
                $blocksRepository->expects($this->once())
                      ->method('deleteIncludedBlocks');

                $repository = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Core\Repository\Factory\AlFactoryRepositoryInterface');
                $repository->expects($this->once())
                      ->method('createRepository')
                      ->will($this->returnValue($blocksRepository));

                $this->container->expects($this->at(2))
                      ->method('get')
                      ->will($this->returnValue($repository));
            }
        }
        
        $blockManager = new AlBlockManagerBootstrapThumbnailsTester($this->container, $this->validator);
        if (array_key_exists("Content", $values)) {
            $block = $this->initBlock($value);        
            $blockManager->set($block);            
        }
        $result = $blockManager->manageThumbnailsTester($values);
        
        $this->assertEquals($expectedResult, $result);
    }
    
    public function manageThumbnailsProvider()
    {
        return array(
            array(
                array(
                    'ToDelete' => '0',
                ),
                array(
                    'ToDelete' => '0',
                ),
            ),
            array(
                array(
                    'Content' => '{"operation": "add", "value": { "type": "BootbusinessProductThumbnailBlock" }}',
                ),
                array(
                    'Content' => '[{"type":"BootstrapThumbnailBlock"},{"type":"BootstrapThumbnailBlock"},{"type":"BootbusinessProductThumbnailBlock"}]',
                ),
            ),
            array(
                array(
                    'Content' => '{"operation": "remove", "item": "1", "slotName": "12-1"}',
                ),
                array(
                    'Content' => '[{"type":"BootstrapThumbnailBlock"}]',
                ),
            ),
        );
    }
    
    protected function initBlock($value)
    {
        $block = $this->getMock('AlphaLemon\AlphaLemonCmsBundle\Model\AlBlock');
        $block->expects($this->once())
              ->method('getContent')
              ->will($this->returnValue($value));

        return $block;
    }
    
    protected function initForm()
    {
        $form = $this->getMockBuilder('Symfony\Component\Form\Form')
                    ->disableOriginalConstructor()
                    ->getMock();
        $form->expects($this->once())
            ->method('createView')
        ;
        
        return $form;
    }
}
