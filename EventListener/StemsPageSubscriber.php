<?php
/**
 * Created by PhpStorm.
 * User: Ste
 * Date: 13/01/2016
 * Time: 20:31
 */

namespace Stems\PageBundle\EventListener;

use Doctrine\Common\Annotations\Reader;
use Doctrine\Common\Util\ClassUtils;
use Stems\PageBundle\Annotation\PageAnnotation;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class StemsPageSubscriber implements EventSubscriberInterface
{
	/** @var Reader */
	protected $annotationReader;

	public function __construct(Reader $annotationReader)
	{
		$this->annotationReader = $annotationReader;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function getSubscribedEvents()
	{
		return [
				'kernel.controller' => 'onFilterController'
		];
	}

	public function onFilterController(FilterControllerEvent $event)
	{
		// Only perform for Stems FrontControllers
		$controller            = $event->getController();
		list($object, $method) = $controller;
		$className             = ClassUtils::getClass($object);
		$reflectionClass       = new \ReflectionClass($className);

		var_dump($controller); die();

		$reflectionMethod      = $reflectionClass->getMethod($method);
		$annotations           = $this->annotationReader->getMethodAnnotations($reflectionMethod);

		// Find and apply the page annotation
		foreach ($annotations as $annotation) {
			if ($annotation instanceof PageAnnotation) {
				$controller->page = $annotation->getPage();
			}
		}
	}
}