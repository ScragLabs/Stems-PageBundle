<?php

namespace Stems\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

use Stems\PageBundle\Form\SectionMagazineType,
	Stems\PageBundle\Form\SectionTextType,
	Stems\PageBundle\Form\SectionScrapbookType,
	Stems\PageBundle\Form\SectionScrapbookImageType,
	Stems\PageBundle\Form\SectionScrapbookTextType,
	Stems\PageBundle\Form\SectionTextAndImageType;

class SectionController extends Controller
{
	/**
	 * Render a text section
	 * @param $id integer 	Id of the text section to render
	 */
	public function textAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionText')->find($id);

		return $this->render('StemsPageBundle:Section:text.html.twig', array(
			'section'	=> $section,
		));
	}

	/**
	 * Render a text section form in the admin edit panel
	 * @param $id integer 	Id of the text section to render
	 */
	public function textFormAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$link = $em->getRepository('StemsPageBundle:Section')->find($id);
		$section = $em->getRepository('StemsPageBundle:SectionText')->find($link->getEntity());

		// get the admin form for the section
		$form = $this->createForm(new SectionTextType($link), $section);

		return $this->render('StemsPageBundle:Section:textForm.html.twig', array(
			'form'		=> $form->createView(),
			'link'		=> $link,
		));
	}

	/**
	 * Update a text section from posted data
	 * @param $id 			integer 		Id of the text section to update
	 * @param $parameters 	array 			Posted params relevant to the section
	 * @param $em 			EntityManager	The entity manager
	 */
	public function textUpdateAction($id, $parameters, $em, $request)
	{
		// get the section
		$section = $em->getRepository('StemsPageBundle:SectionText')->find($id);

		try
		{
			// save the values
			$section->setContent($parameters['content']);
			$em->persist($section);
		}
		catch(\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'There was a problem saving one of the sections!');
			$request->getSession()->setFlash('debug', $e->getMessage());
		}

		return;
	}

	/**
	 * Render a raw html section
	 * @param $id integer 	Id of the html section to render
	 */
	public function htmlAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionHtml')->find($id);

		return $this->render('StemsPageBundle:Section:html.html.twig', array(
			'section'	=> $section,
		));
	}

	/**
	 * Render a raw html section form in the admin edit panel
	 * @param $id integer 	Id of the html section to render
	 */
	public function htmlFormAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$link = $em->getRepository('StemsPageBundle:Section')->find($id);
		$section = $em->getRepository('StemsPageBundle:SectionHtml')->find($link->getEntity());

		// get the admin form for the section
		$form = $this->createForm(new SectionHtmlType($link), $section);

		return $this->render('StemsPageBundle:Section:htmlForm.html.twig', array(
			'form'		=> $form->createView(),
			'link'		=> $link,
		));
	}

	/**
	 * Update a html section from posted data
	 * @param $id 			integer 		Id of the html section to update
	 * @param $parameters 	array 			Posted params relevant to the section
	 * @param $em 			EntityManager	The entity manager
	 */
	public function htmlUpdateAction($id, $parameters, $em, $request)
	{
		// get the section
		$section = $em->getRepository('StemsPageBundle:SectionHtml')->find($id);

		try
		{
			// save the values
			$section->setContent($parameters['content']);
			$em->persist($section);
		}
		catch(\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'There was a problem saving one of the sections!');
			$request->getSession()->setFlash('debug', $e->getMessage());
		}

		return;
	}

	/**
	 * Render a single image section
	 * @param $id integer 	Id of the text section to render
	 */
	public function imageAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionImage')->find($id);

		return $this->render('StemsPageBundle:Section:image.html.twig', array(
			'section'	=> $section,
		));
	}

	/**
	 * Render a single image section form in the admin edit panel
	 * @param $id integer 	Id of the image section to render
	 */
	public function imageFormAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$link = $em->getRepository('StemsPageBundle:Section')->find($id);
		$section = $em->getRepository('StemsPageBundle:SectionImage')->find($link->getEntity());

		// get the admin form for the section
		$form = $this->createForm(new SectionImageType($link), $section);

		return $this->render('StemsPageBundle:Section:imageForm.html.twig', array(
			'form'		=> $form->createView(),
			'link'		=> $link,
		));
	}

	/**
	 * Update a image section from posted data
	 * @param $id 			integer 		Id of the text section to update
	 * @param $parameters 	array 			Posted params relevant to the section
	 * @param $em 			EntityManager	The entity manager
	 */
	public function imageUpdateAction($id, $parameters, $em, $request)
	{
		// get the section
		$section = $em->getRepository('StemsPageBundle:SectionImage')->find($id);

		try
		{
			// save the values
			$section->setImage($parameters['image']);
			$section->setCaption($parameters['caption']);
			$section->setPosition($parameters['position']);
			$section->setLink($parameters['link']);
			$em->persist($section);
		}
		catch(\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'There was a problem saving one of the sections!');
			$request->getSession()->setFlash('debug', $e->getMessage());
		}

		return;
	}

	/**
	 * Render a text and image section
	 * @param $id integer 	Id of the textAndImage section to render
	 */
	public function textAndImageAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionTextAndImage')->find($id);

		// custom code for magazine title embedding
		$textAndImageType = $em->getRepository('StemsPageBundle:SectionType')->findOneBy(array('class' => 'SectionTextAndImage'));
		$link = $em->getRepository('StemsPageBundle:Section')->findOneBy(array('entity' => $id, 'type' => $textAndImageType));

		return $this->render('StemsPageBundle:Section:textAndImage.html.twig', array(
			'section'	=> $section,
			'link'		=> $link,
		));
	}

	/**
	 * Render a text and image section form in the admin edit panel
	 * @param $id integer 	Id of the text section to render
	 */
	public function textAndImageFormAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$link = $em->getRepository('StemsPageBundle:Section')->find($id);
		$section = $em->getRepository('StemsPageBundle:SectionTextAndImage')->find($link->getEntity());

		// get the admin form for the section
		$form = $this->createForm(new SectionTextAndImageType($link), $section);

		return $this->render('StemsPageBundle:Section:textAndImageForm.html.twig', array(
			'form'		=> $form->createView(),
			'link'		=> $link,
		));
	}

	/**
	 * Update a text and image section from posted data
	 * @param $id 			integer 		Id of the text section to update
	 * @param $parameters 	array 			Posted params relevant to the section
	 * @param $em 			EntityManager	The entity manager
	 */
	public function textAndImageUpdateAction($id, $parameters, $em, $request)
	{
		// get the section
		$section = $em->getRepository('StemsPageBundle:SectionTextAndImage')->find($id);

		try
		{
			// save the values
			$section->setContent($parameters['content']);
			$section->setImage($parameters['image']);
			$section->setCaption($parameters['caption']);
			$section->setPosition($parameters['position']);
			$section->setLink($parameters['link']);
			$em->persist($section);
		}
		catch(\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'There was a problem saving one of the sections!');
			$request->getSession()->setFlash('debug', $e->getMessage());
		}

		return;
	}

	/**
	 * Render a scrapbook section
	 * @param $id integer 	Id of the textAndImage section to render
	 */
	public function scrapbookAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionScrapbook')->find($id);

		return $this->render('StemsPageBundle:Section:scrapbook.html.twig', array(
			'section'	=> $section,
		));
	}

	/**
	 * Render a scrapbook section form in the admin edit panel
	 * @param $id integer 	Id of the text section to render
	 */
	public function scrapbookFormAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$link = $em->getRepository('StemsPageBundle:Section')->find($id);
		$section = $em->getRepository('StemsPageBundle:SectionScrapbook')->find($link->getEntity());

		// get forms for the existing images on the scrapbook
		$imageForms = array();
		foreach ($section->getImages() as $image) {
			$imageForm = $this->createForm(new SectionScrapbookImageType($image), $image);
			$imageForms[] = $this->render('StemsPageBundle:Section:scrapbookImageForm.html.twig', array(
				'form'		=> $imageForm->createView(),
				'image'		=> $image,
			));
			//$textForms[] = $textForm, strpos($textForm, '<h4>'));
		}

		// get the admin form for the section
		$form = $this->createForm(new SectionScrapbookType($link), $section);

		return $this->render('StemsPageBundle:Section:scrapbookForm.html.twig', array(
			'form'			=> $form->createView(),
			'imageForms'	=> $imageForms,
			'link'			=> $link,
			'section'		=> $section,
		));
	}

	/**
	 * Update a scrapbook section from posted data
	 * @param $id 			integer 		Id of the scrapbook section to update
	 * @param $parameters 	array 			Posted params relevant to the section
	 * @param $em 			EntityManager	The entity manager
	 */
	public function scrapbookUpdateAction($id, $parameters, $em, $request)
	{
		// get the section
		$section = $em->getRepository('StemsPageBundle:SectionScrapbook')->find($id);

		try
		{
			// save the values
			$section->setTitle($parameters['title']);
			$section->setContent($parameters['content']);
			$section->setContentX($parameters['contentX']);
			$section->setContentY($parameters['contentY']);
			$section->setBackground($parameters['height']);
			$section->setBackground($parameters['background']);
			$em->persist($section);
		}
		catch(\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'There was a problem saving one of the sections!');
			$request->getSession()->setFlash('debug', $e->getMessage());
		}

		return;
	}

	/**
	 * Render a magazine section
	 * @param $id integer 	Id of the magazine section to render
	 */
	public function magazineAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionMagazine')->find($id);

		// custom code for magazine title embedding
		$magazineType = $em->getRepository('StemsPageBundle:SectionType')->findOneBy(array('class' => 'SectionMagazine'));
		$link = $em->getRepository('StemsPageBundle:Section')->findOneBy(array('entity' => $id, 'type' => $magazineType));

		return $this->render('StemsPageBundle:Section:magazine.html.twig', array(
			'section'	=> $section,
			'link'		=> $link,
		));
	}

	/**
	 * Render a magazine section form in the admin edit panel
	 * @param $id integer 	Id of the text section to render
	 */
	public function magazineFormAction($id)
	{
		// get the requested section
		$em = $this->getDoctrine()->getManager();
		$link = $em->getRepository('StemsPageBundle:Section')->find($id);
		$section = $em->getRepository('StemsPageBundle:SectionMagazine')->find($link->getEntity());

		// get the admin form for the section
		$form = $this->createForm(new SectionMagazineType($link), $section);

		return $this->render('StemsPageBundle:Section:magazineForm.html.twig', array(
			'form'		=> $form->createView(),
			'link'		=> $link,
		));
	}

	/**
	 * Update a magazine section from posted data
	 * @param $id 			integer 		Id of the text section to update
	 * @param $parameters 	array 			Posted params relevant to the section
	 * @param $em 			EntityManager	The entity manager
	 */
	public function magazineUpdateAction($id, $parameters, $em, $request)
	{
		// get the section
		$section = $em->getRepository('StemsPageBundle:SectionMagazine')->find($id);

		try
		{
			// save the values
			$section->setContentA($parameters['contentA']);
			$section->setImageA($parameters['imageA']);
			$section->setCaptionA($parameters['captionA']);
			$section->setPositionA($parameters['positionA']);
			$section->setLinkA($parameters['linkA']);

			$section->setContentB($parameters['contentB']);
			$section->setImageB($parameters['imageB']);
			$section->setCaptionB($parameters['captionB']);
			$section->setPositionB($parameters['positionB']);
			$section->setLinkB($parameters['linkB']);

			$section->setContentC($parameters['contentC']);
			$section->setImageC($parameters['imageC']);
			$section->setCaptionC($parameters['captionC']);
			$section->setPositionC($parameters['positionC']);
			$section->setLinkC($parameters['linkC']);
		}
		catch(\Exception $e) 
		{
			$request->getSession()->setFlash('error', 'There was a problem saving one of the sections!');
			$request->getSession()->setFlash('debug', $e->getMessage());
		}

		$em->persist($section);

		return;
	}
}
