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
		$em = $this->getDoctrine()->getManager();
		
		// load the page object from the CMS
		$page = $em->getRepository('StemsPageBundle:Page')->load('homepage');

		// render the requested page
		return $this->render('StemsPageBundle:Front:page.html.twig', array(
			'page' 	=> $page
		));
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
	 * @param $slug string The slug of the page requested
	 */
	public function pageAction($slug)
	{
		$em = $this->getDoctrine()->getManager();

		try
		{
			// load the page object from the CMS
			$page = $em->getRepository('StemsPageBundle:Page')->load($slug);
		}
		catch (\Exception $e) 
		{
			// 301 for product error pages indexed by google
			// get the id from the slug
			$id = explode('-', $slug);
			$id = end($id);

			// get the product
			$product = $em->getRepository('StemsSaleSirenBundle:Product')->find($id);

			// escape if it not longer exists
			if ($product) {
				return $this->redirect('/product/'.$product->getSlug(), 301);
			}
		}

		// render the requested page
		return $this->render('StemsPageBundle:Front:page.html.twig', array(
			'page' 	=> $page
		));
	}

	public function emailTestAction()
	{
		$em = $this->getDoctrine()->getManager();
		$user = $em->getRepository('StemsUserBundle:User')->find(2);

		// send the alert
        $message = \Swift_Message::newInstance()
	        ->setSubject('Test message')
	        ->setFrom('alerts@threadandmirror.com')
	        ->setTo('join@threadandmirror.com')
	        ->setBody('<p>woooohooooooo</p>')
	    ;
	    $this->get('mailer')->send($message);

	    return new Response('Test message sent to '.'join@threadandmirror.com');
	}
}
