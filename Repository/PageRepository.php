<?php

namespace Stems\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Stems\PageBundle\Exception\PageNotFoundException;

class PageRepository extends EntityRepository
{
	/**
	 * Load the page entity that matches the slug provided and override options provided
	 *
	 * @param string $slug 				The slug of the page to load
	 * @param array $options 			An indexed array of properties to override for the page
	 * @return Page 					The page entity
	 * @throws PageNotFoundException
	 */
	public function load($slug, $options=array())
	{
		// load the relevant CMS page from the database
		$page = $this->findOneBy(array('slug' => $slug, 'deleted' => false));

		// throw an error if the page wasn't found
		if (!$page) {
			throw new PageNotFoundException('The requested page could not be found.');
		}

		// override any custom values requested, as long as they are not blank
		if (array_key_exists('title', $options)) {
			!empty($options['title']) and $page->setTitle($options['title']);
		}
		if (array_key_exists('windowTitle', $options)) {
			!empty($options['windowTitle']) and $page->setWindowTitle($options['windowTitle']);
		}
		if (array_key_exists('metaKeywords', $options)) {
			!empty($options['metaKeywords']) and $page->setMetaKeywords($options['metaKeywords']);
		}
		if (array_key_exists('metaDescription', $options)) {
			!empty($options['metaDescription']) and $page->setMetaDescription($options['metaDescription']);
		}
		if (array_key_exists('disableAnalytics', $options)) {
			!empty($options['disableAnalytics']) and $page->setMetaDescription($options['disableAnalytics']);
		}
			
		return $page;
	}

	/**
	 * Attempt to find a matching page given a uri path
	 *
	 * @param string $slug 			The request path to match to a page
	 * @return Page 				The page entity found, or null if not found
	 */
	public function estimate($path)
	{
		// load the relevant CMS page from the database
		// @todo - make the query to estimate
		$page = null;

		return $page;
	}
}