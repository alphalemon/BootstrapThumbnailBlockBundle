<?php

namespace AlphaLemon\Block\BootstrapThumbnailBlockBundle\Core\Form;

use AlphaLemon\AlphaLemonCmsBundle\Core\Form\JsonBlock\JsonBlockType;
use Symfony\Component\Form\FormBuilderInterface;

class AlThumbnailType extends JsonBlockType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder->add('width', 'choice', 
            array('choices' => 
                array(
                    'none' => 'none',
                    'span1' => 'span1 (60px)',
                    'span2' => 'span2 (140px)',
                    'span3' => 'span3 (220px)',
                    'span4' => 'span4 (300px)',
                    'span5' => 'span5 (380px)',
                    'span6' => 'span6 (460px)',
                    'span7' => 'span7 (540px)',
                    'span8' => 'span8 (620px)',
                    'span9' => 'span9 (700px)',
                    'span10' => 'span10 (780px)',
                    'span11' => 'span11 (860px)',
                    'span12' => 'span12 (940px)',
                )
            )
        );     
    }
}
