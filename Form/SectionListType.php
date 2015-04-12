<?php

namespace Stems\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SectionListType extends AbstractType
{
	protected $id;

	public function __construct($link)
	{
		$this->id = $link->getId();
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('title', 'textarea', array(
			'label'     		=> 'Add Text',
			'required'			=> false,
			'error_bubbling' 	=> true
		));

		$builder->add('style', 'text', array(
			'label'     		=> 'Style',
			'error_bubbling' 	=> true,
			'attr'              => array('class' => 'section-style')
		));

		$builder->add('alignment', 'text', array(
			'label'     		=> 'Alignment',
			'error_bubbling' 	=> true,
			'attr'              => array('class' => 'section-alignment')
		));

		$builder->add('items', 'collection', array(
			'type'              => 'textarea',
		    'label'     		=> 'Items',
			'required'          => false,
		    'error_bubbling' 	=> true,
		    'allow_add'         => true,
		    'allow_delete'      => true,
	        'prototype'         => true
	    ));
    }

	public function getName()
	{
		return $this->id.'_section_list_type';
	}
}
