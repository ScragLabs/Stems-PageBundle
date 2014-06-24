<?php

namespace Stems\PageBundle\Controller;

// Dependencies
use Stems\CoreBundle\Controller\BaseAdminController,
	Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Response,
	Symfony\Component\HttpFoundation\Request;

// Forms
use Stems\PageBundle\Form\AdminPageType;

// Entities
use Stems\PageBundle\Entity\Page;

// Exceptions
use Doctrine\ORM\NoResultException;

class AdminController extends BaseAdminController
{
	protected $home = 'stems_admin_page_overview';

	/**
	 * Render the dialogue for the module's dashboard entry in the admin panel
	 */
	public function dashboardAction()
	{
		return $this->render('StemsPageBundle:Admin:dashboard.html.twig', array());
	}

	/**
	 * Build the sitemap entries for the bundle
	 */
	public function sitemapAction()
	{
		$em = $this->getDoctrine()->getEntityManager();

		// get the active content pages, using DQL to specify the data fields we need
		$pages = $em->createQuery('
			SELECT p.slug, p.updated, p.type
			FROM StemsPageBundle:Page p 
			WHERE p.deleted = :deleted 
			AND p.status = :status
			AND p.type = :type
		')->setParameters(array(
			'deleted' 		=> false,
			'status' 		=> 'Published',
			'type' 			=> 'content',
		))->getArrayResult();

		return $this->render('StemsPageBundle:Admin:sitemap.html.twig', array(
			'pages'		=> $pages,
		));
	}

	/**
	 * Page overview
	 */
	public function indexAction()
	{		
		// get all pages
		$em = $this->getDoctrine()->getEntityManager();
		$pages = $em->getRepository('StemsPageBundle:Page')->findBy(array('deleted' => false), array('created' => 'DESC'));

		return $this->render('StemsPageBundle:Admin:index.html.twig', array(
			'pages' 	=> $pages,
		));
	}

	/**
	 * Create a page
	 */
	public function createAction()
	{
		// create a new page and persist it to the db
		$em = $this->getDoctrine()->getEntityManager();
		
		$page = new Page();
		$em->persist($page);
		$em->flush();

		// redirect to the edit page for the new entity
		return $this->redirect($this->generateUrl('stems_admin_page_edit', array('id' => $page->getId())));
	}

	/**
	 * Edit a page
	 */
	public function editAction(Request $request, $id)
	{
		// get the blog page request
		$em = $this->getDoctrine()->getManager();
		$page = $em->getRepository('StemsPageBundle:Page')->findOneBy(array('id' => $id, 'deleted' => false));

		// throw an exception if the page could not be found
		if (!$page) {
			$request->getSession()->setFlash('error', 'The requested page could not be found.');
			return $this->redirect($this->generateUrl($this->home));
		}

		// create the form
		$form = $this->createForm(new AdminPageType(), $page);

		// get the section forms
		$sectionForms = array();
		foreach ($page->getSections() as $section) {
			$sectionForms[] = $this->forward($section->getType()->getForm(), array('id' => $section->getId()));
		}

		// get the available section types
		$types = $em->getRepository('StemsPageBundle:SectionType')->findByEnabled(true);

		// handle the form submission
		if ($request->getMethod() == 'POST') {

			// validate the submitted values
			$form->bindRequest($request);


			//if ($form->isValid()) {

				// update the page in the database
				$page->setNew(false);
				$page->setAuthor($this->container->get('security.context')->getToken()->getUser()->getId());

				// order the sections, attached to the page and save their values
				$position = 1;

				foreach ($request->get('sections') as $section) {
					
					// attach and update order
					$sectionEntity = $em->getRepository('StemsPageBundle:Section')->find($section);
					$sectionEntity->setPost($page);
					$sectionEntity->setPosition($position);

					// get all form fields relevant to the section...
					foreach ($request->request->all() as $parameter => $value) {
						// strip the section id from the parameter group and save if it matches
						$explode = explode('_', $parameter);
						$parameterId = reset($explode);
						$parameterId == $sectionEntity->getId() and $sectionParameters = $value;
					}

					// ...then process and update the entity
					$this->forward($sectionEntity->getType()->getUpdate(), array(
						'id'         => $sectionEntity->getEntity(),
						'parameters' => $sectionParameters,
						'em'         => $em,
						'request'    => $request,
					));

					$em->persist($sectionEntity);
					$position++;
				}

				// perist to the db
				$em->persist($page);
				$em->flush();

				$request->getSession()->setFlash('success', 'The page "'.$page->getTitle().'" has been updated.');
				return $this->redirect($this->generateUrl($this->home));

			//} else {
				// $request->getSession()->setFlash('error', 'Your request was not processed as errors were found.');
				// $request->getSession()->setFlash('debug', '');
			//}
		}

		return $this->render('StemsPageBundle:Admin:edit.html.twig', array(
			'form'			=> $form->createView(),
			'sectionForms'	=> $sectionForms,
			'page' 			=> $page,
			'types'			=> $types,
		));
	}

	/**
	 * Delete a page
	 */
	public function deleteAction(Request $request, $id)
	{
		// get the entity
		$em = $this->getDoctrine()->getEntityManager();
		$page = $em->getRepository('StemsPageBundle:Page')->findOneBy(array('id' => $id, 'deleted' => false));

		if ($page) {
			// delete the page if was found
			$name = $page->getTitle();
			$page->setDeleted(true);
			$em->persist($page);
			$em->flush();

			// return the success message
			$request->getSession()->setFlash('success', 'The page "'.$name.'" was successfully deleted!');
		} else {
			$request->getSession()->setFlash('error', 'The requested page could not be deleted as it does not exist in the database.');
		}

		return $this->redirect($this->generateUrl($this->home));
	}

	/**
	 * Publish/unpublish a page
	 */
	public function publishAction(Request $request, $id)
	{
		// get the entity
		$em = $this->getDoctrine()->getEntityManager();
		$page = $em->getRepository('StemsPageBundle:Page')->findOneBy(array('id' => $id, 'deleted' => false));

		if ($page) {

			// set the page the published/unpublished 
			if ($page->getStatus() == 'Draft') {	
				$page->setStatus('Published');
				$page->setPublished(new \DateTime());
				$request->getSession()->setFlash('success', 'The page "'.$page->getTitle().'" was successfully published!');
			} else {
				$page->setStatus('Draft');
				$request->getSession()->setFlash('success', 'The page "'.$page->getTitle().'" was successfully unpublished!');
			}

			$em->persist($page);
			$em->flush();

		} else {
			$request->getSession()->setFlash('error', 'The requested page could not be published as it does not exist in the database.');
		}

		return $this->redirect($this->generateUrl($this->home));
	}
}
