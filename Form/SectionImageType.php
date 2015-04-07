<?php

namespace Stems\PageBundle\Form;

use Stems\MediaBundle\Form\EmbeddedImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectionImageType extends AbstractType
{
	protected $id;

	public function __construct($link)
	{
		$this->id = $link->getId();
	}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('image', 'hidden', array(
			'label'     		=> 'Image ID',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));	

		$builder->add('position', 'choice', array(
			'label'     		=> 'Positioning',
			'empty_value' 		=> false,
			'choices'			=> array('squared' => 'Squared', 'full-width' => 'Full Width'),
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

	    $builder->add('upload', new EmbeddedImageType('blog'), array(
		    'label'     		=> 'Image File',
		    'required'			=> false,
		    'error_bubbling' 	=> true,
		    'mapped'            => false,
	    ));

	    $builder->add('caption', 'text', array(
			'label'     		=> 'Caption (Optional)',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));	

		$builder->add('link', 'text', array(
			'label'     		=> 'Link (Optional)',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));	
	}

	public function getName()
	{
		return $this->id.'_section_image_type';
	}
}
