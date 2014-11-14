<?php

namespace Stems\PageBundle\Controller;

use Stems\CoreBundle\Controller\BaseRestController,
	Symfony\Component\HttpFoundation\Request,
	Stems\BlogBundle\Entity\SectionProductGalleryProduct,
	Stems\BlogBundle\Form\SectionProductGalleryProductType,
	Stems\MediaBundle\Entity\Image,
	Stems\MediaBundle\Form\ImageType;


class PopupController extends BaseRestController
{
	/**
	 * Build a popup to set the image of an image section
	 *
	 * @param  integer 		$id 	The ID of the section
	 * @param  Request
	 * @return JsonResponse
	 */
	public function setImageSectionImageAction($id, Request $request)
	{
		// Get the blog post and existing image
		$em      = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionImage')->find($id);

		if ($section->getImage()) {
			$image = $em->getRepository('StemsMediaBundle:Image')->find($section->getImage());
		} else {
			$image = new Image();
		}

		// Build the form 
		$mediaCategories = $this->container->getParameter('stems.media.image.categories');
		$form = $this->createForm(new ImageType($mediaCategories), $image);

		// Get the html for the popup
		$html = $this->renderView('StemsPageBundle:Popup:setImageSectionImage.html.twig', array(
			'section'	=> $section,
			'existing'	=> rawurldecode($request->query->get('existing')),
			'title'		=> $section->getImage() ? 'Change Image' : 'Add Image',
			'form'		=> $form->createView(),
		));

		return $this->addHtml($html)->success('The popup was successfully created.')->sendResponse();
	}

	/**
	 * Build a popup to set the image of an image section
	 *
	 * @param  integer 		$id 	The ID of the section
	 * @param  Request
	 * @return JsonResponse
	 */
	public function setTextAndImageSectionImageAction($id, Request $request)
	{
		// Get the blog post and existing image
		$em      = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionTextAndImage')->find($id);

		if ($section->getImage()) {
			$image = $em->getRepository('StemsMediaBundle:Image')->find($section->getImage());
		} else {
			$image = new Image();
		}

		// Build the form 
		$mediaCategories = $this->container->getParameter('stems.media.image.categories');
		$form = $this->createForm(new ImageType($mediaCategories), $image);

		// Get the html for the popup
		$html = $this->renderView('StemsPageBundle:Popup:setTextAndImageSectionImage.html.twig', array(
			'section'	=> $section,
			'existing'	=> rawurldecode($request->query->get('existing')),
			'title'		=> $section->getImage() ? 'Change Image' : 'Add Image',
			'form'		=> $form->createView(),
		));

		return $this->addHtml($html)->success('The popup was successfully created.')->sendResponse();
	}
}