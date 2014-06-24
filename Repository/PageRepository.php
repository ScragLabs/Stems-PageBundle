<?php

namespace Stems\PageBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Stems\PageBundle\Exception\PageNotFoundException;

class PageRepository extends EntityRepository
{
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
}