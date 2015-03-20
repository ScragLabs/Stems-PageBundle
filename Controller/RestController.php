<?php

namespace Stems\PageBundle\Controller;

use Stems\CoreBundle\Controller\BaseRestController;
use	Symfony\Component\HttpFoundation\RedirectResponse;
use	Symfony\Component\HttpFoundation\JsonResponse;
use	Symfony\Component\HttpFoundation\Request;
use Stems\MediaBundle\Entity\Image;
use Stems\MediaBundle\Form\ImageType;
use Stems\PageBundle\Entity\Section;


class RestController extends BaseRestController
{
	/**
	 * Returns form html for the requested section type
	 * @param $id 	Section type id
	 */
	public function addSectionTypeAction($id)
	{
		// get the section type
		$em = $this->getDoctrine()->getManager();
		$type = $em->getRepository('StemsPageBundle:SectionType')->find($id);

		// create a new section of the specified type
		$class = 'Stems\\PageBundle\\Entity\\'.$type->getClass();
		$section = new $class();

		$em->persist($section);
		$em->flush();
		
		// create the section linkage
		$link = new Section();
		$link->setType($type);
		$link->setEntity($section->getId());
		$em->persist($link);
		$em->flush();

		// get the form html
		$html = $this->forward($type->getForm(), array('id' => $link->getId()));
		$html = substr($html, strpos($html, '<h4>'));

		return new JsonResponse(array(
			'html'    => $html,
			'section' => $link->getId(),
		));
	}

	/**
	 * Removes the specified section and its linkage
	 * @param $id 	Section id
	 */
	public function removeSectionAction($id)
	{
		try
		{
			// get the section linkage and the specific section
			$em = $this->getDoctrine()->getManager();
			$link = $em->getRepository('StemsPageBundle:Section')->find($id);
			$section = $em->getRepository('StemsPageBundle:'.$link->getType()->getClass())->find($link->getEntity());

			$em->remove($section);
			$em->remove($link);
			$em->flush();

			return new JsonResponse(array(
				'success'	=> true,
				'message'	=> 'Section deleted.',
			));
		}
		catch (\Exception $e) 
		{
			return new JsonResponse(array(
				'success'	=> false,
				'message'	=> $e->message,
			));
		}
	}

	/**
	 * Updates the image for an image section
	 *
	 * @param  integer 		$id 	The ID of the image section
	 * @param  Request
	 * @return JsonResponse
	 */
	public function setImageSectionImageAction($id, Request $request)
	{
		// Get the section and existing image
		$em      = $this->getDoctrine()->getManager();
		$section = $em->getRepository('StemsPageBundle:SectionImage')->find($id);

		if ($section->getImage()) {
			$image = $em->getRepository('StemsMediaBundle:Image')->find($section->getImage());
		} else {
			$image = new Image();
		}

		// Build the form and handle the request
		$form = $this->createForm(new ImageType(), $image);

		if ($form->bind($request)) {

			// Upload the file and save the entity
			$image->doUpload();
			$em->persist($image);
			$em->flush();

			// Get the html for updating the feature image
			$html = $this->renderView('StemsPageBundle:Rest:setImageSectionImage.html.twig', array(
				'section'	=> $section,
				'image'		=> $image,
			));

			// Set the meta data for the update callback
			$meta = array(
				'imageType' => 'imageGalleryImage',
				'section'	=> $section->getId(),
			);

			return $this->addHtml($html)->addMeta($meta)->setCallback('updateSectionImage')->success('Image updated.')->sendResponse();
		} else {
			return $this->error(array_keys($form->getErrors()), true)->sendResponse();
		}
	}
}
