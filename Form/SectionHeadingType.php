<?php

namespace Stems\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectionHeadingType extends AbstractType
{
	protected $id;

	public function __construct($link)
	{
		$this->id = $link->getId();
	}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('content', 'textarea', array(
			'label'     		=> 'Add Text',
			'required'			=> false,
			'error_bubbling' 	=> true
		));

	    $builder->add('style', 'text', array(
		    'label'     		=> 'Heading Style',
		    'error_bubbling' 	=> true,
		    'attr'              => array('class' => 'section-style')
	    ));

	    $builder->add('alignment', 'text', array(
		    'label'     		=> 'Alignment',
		    'error_bubbling' 	=> true,
		    'attr'              => array('class' => 'section-alignment')
	    ));
    }

	public function getName()
	{
		return $this->id.'_section_heading_type';
	}
}
