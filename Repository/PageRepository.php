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
		// segment the uri for matching
		$segments = explode('/', $path);

		// if we have no segements then use the raw path, as it only contains one segment
		!$segments and $segments = array($path);

		// segment in % for the SQL like comparison
		array_walk($segments, function(&$item) {
			$item = '%'.$item.'%';
		});

		// consider all pages that have least one segment in their slug as suitable candidates
		$qb = $this->getEntityManager()->createQueryBuilder();

		$qb->addSelect('page');
		$qb->from('StemsPageBundle:Page', 'page');

		$qb->where('page.deleted = :deleted');
		$qb->setParameter('deleted', '0');

		// we need a like clause for each as they cannot be done via an array
		$segmentLikes = array();

		foreach ($segments as $i => $segment) {
			$qb->setParameter('segment'.$i, $segment);
			$segmentLikes[] = $qb->expr()->like('page.slug', ':segment'.$i);
		}
		
		// bosh them all into an orX so we bracket them off from the delete clause
		$qb->andWhere($qb->expr()->orX()->addMultiple($segmentLikes));

		$candidates = $qb->getQuery()->getResult();

		// run comparison for each matched page to see if they're suitable	
		foreach ($candidates as $candidate) {
			
			// replace the dynamic components from the page's slug (eg. {id}) with the wildcard character
			$pattern = trim(preg_replace('/\s*\{[^)]*\}/', '*', $candidate->getSlug()));

			// run a the match function to compare the path against the wildcarded slug
			$pattern = preg_quote($pattern,'/');        
		    $pattern = str_replace( '\*' , '.*', $pattern);   

		    if (preg_match('/^'.$pattern.'$/i', $path)) {
		    	return $candidate;
		    }
		}

		die();

		// fallback if no matches found
		return null;
	}
}