<?php
/*
 * This file is part of the BusinessDropCapBundle and it is distributed
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

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Form;

use AlphaLemon\AlphaLemonCmsBundle\Core\Form\JsonBlock\JsonBlockType;
use Symfony\Component\Form\FormBuilderInterface;

class AlThumbnailType extends JsonBlockType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('image');
        $builder->add('title');
        $builder->add('alt');
        $builder->add('width', 'choice', 
            array('choices' => 
                array(
                    'none' => 'none',
                    'span1' => 'span1 (60)',
                    'span2' => 'span2 (140)',
                    'span3' => 'span3 (220)',
                    'span4' => 'span4 (300)',
                    'span5' => 'span5 (380)',
                    'span6' => 'span6 (460)',
                    'span7' => 'span7 (540)',
                    'span8' => 'span8 (620)',
                    'span9' => 'span9 (700)',
                    'span10' => 'span10 (780)',
                    'span11' => 'span11 (860)',
                    'span12' => 'span12 (940)',
                )
            )
        );        
        $builder->add('thumbnail_caption');
    }
}
