<?php

namespace Stems\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AdminPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder->add('title', null, array(
			'label'  			=> 'Title',
			'error_bubbling' 	=> true,
		));

		$builder->add('windowTitle', null, array(
			'label'     		=> 'Window Title',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

		$builder->add('slug', null, array(
			'label'     		=> 'Url',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

		$builder->add('excerpt', 'textarea', array(
			'label'     		=> 'Excerpt',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

		$builder->add('layout', null, array(
			'label'     		=> 'Layout Type',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));	

		// $builder->add('type', 'choice', array(
		// 	'label'     		=> 'Type',
		// 	'required'			=> false,
		// 	'error_bubbling' 	=> true,
		// ));

		// $builder->add('content', null, array(
		// 	'label'     		=> 'Content',
		// 	'required'			=> false,
		// 	'error_bubbling' 	=> true,
		// ));	

		// $builder->add('image', 'text', array(
		// 	'label'     		=> 'Feature Image',
		// 	'error_bubbling' 	=> true,
		// ));	

		$builder->add('noIndex', null, array(
			'label'  			=> 'No Index',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

		$builder->add('metaTitle', null, array(
			'label'  			=> 'Meta Title',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

		$builder->add('metaKeywords', null, array(
			'label'  			=> 'Meta Keywords',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));

		$builder->add('metaDescription', 'textarea', array(
			'label'  			=> 'Meta Description',
			'required'			=> false,
			'error_bubbling' 	=> true,
		));
	}

	public function getName()
	{
		return 'admin_page_type';
	}
}
