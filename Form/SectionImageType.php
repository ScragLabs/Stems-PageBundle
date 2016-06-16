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
		$builder->add('image', 'hidden', [
			'label'     		=> 'Image ID',
			'required'			=> false,
			'error_bubbling' 	=> true,
		]);

		$builder->add('position', 'choice', [
			'label'     		=> 'Layout Style',
			'empty_value' 		=> false,
			'choices'			=> [
				'squared'    => 'Squared',
				'portrait'   => 'Portrait',
				'full-width' => 'Full Width'
			],
			'required'			=> false,
			'error_bubbling' 	=> true,
		]);

	    $builder->add('upload', new EmbeddedImageType('blog'), [
		    'label'     		=> 'Image File',
		    'required'			=> false,
		    'error_bubbling' 	=> true,
		    'mapped'            => false,
	    ]);

	    $builder->add('caption', 'text', [
			'label'     		=> 'Caption (Optional)',
			'required'			=> false,
			'error_bubbling' 	=> true,
		]);

	    $builder->add('effect', 'text', [
		    'label'     		=> 'Image Effect (Optional)',
		    'required'			=> false,
		    'error_bubbling' 	=> true,
		    'attr'              => [
			    'class' => 'section-effect'
		    ]
	    ]);

	    $builder->add('link', 'text', [
			'label'     		=> 'Link (Optional)',
			'required'			=> false,
			'error_bubbling' 	=> true,
		]);
	}

	public function getName()
	{
		return $this->id.'_section_image_type';
	}
}
