<?php
/**
 * Created by PhpStorm.
 * User: Ste
 * Date: 12/01/2016
 * Time: 21:29
 */

namespace Stems\PageBundle\Annotation;

use Stems\PageBundle\Entity\Layout;
use Stems\PageBundle\Entity\Page;

/**
 * @Annotation
 */
class PageAnnotation
{
	/** @var Page */
	protected $page;

	public function __construct($options)
	{
		$this->page = new Page();

		// Set a non-persisted layout
		if (!array_key_exists('layout', $options)) {
			throw new \InvalidArgumentException('A page must have a layout!');
		}

		$this->page->setLayout(new Layout());
		$this->page->getLayout()->setSlug($options['layout']);

		// Set other optional properties
		if (array_key_exists('title', $options)) {
			$this->page->setTitle($options['title']);
		}

		if (array_key_exists('windowTitle', $options)) {
			$this->page->setWindowTitle($options['windowTitle']);
		}

		if (array_key_exists('metaKeywords', $options)) {
			$this->page->setMetaKeywords($options['metaKeywords']);
		}

		if (array_key_exists('metaDescription', $options)) {
			$this->page->setMetaDescription($options['metaDescription']);
		}

		if (array_key_exists('disableAnalytics', $options)) {
			$this->page->setMetaDescription($options['disableAnalytics']);
		}
	}

	/**
	 * Get Page
	 *
	 * @return Page
	 */
	public function getPage()
	{
		return $this->page;
	}
}