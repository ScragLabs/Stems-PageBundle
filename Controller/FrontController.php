<?php

namespace Stems\PageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller
{
	/**
	 * Renders the homepage using the entity
	 */
	public function homeAction()
	{
		// Load the page object from the CMS
		$em   = $this->getDoctrine()->getManager();
		$page = $em->getRepository('StemsPageBundle:Page')->load('homepage');

		return $this->render('StemsPageBundle:Front:page.html.twig', array(
			'page' 	=> $page
		))->setMaxAge(300);
	}

	/**
	 * Redirect any requests for homepage to the root uri
	 */
	public function redirectAction()
	{
		return $this->redirect('/', 301);
	}

	/**
	 * Renders a static content page with default fallback values.
	 *
	 * @param $slug string The slug of the page requested
	 */
	public function pageAction($slug)
	{
		// Attempt to load the requested page
		$em   = $this->getDoctrine()->getManager();
		$page = $em->getRepository('StemsPageBundle:Page')->load($slug);

		return $this->render('StemsPageBundle:Front:page.html.twig', array(
			'page' 	=> $page
		))->setMaxAge(300);
	}
}
