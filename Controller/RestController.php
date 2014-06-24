<?php

namespace Stems\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\JsonResponse,
	Symfony\Component\HttpFoundation\Request;

use Stems\PageBundle\Entity\Section;


class RestController extends Controller
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
}
