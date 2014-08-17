<?php

namespace StemsPageBundle\Tests\Controller;

use StemsCoreBundle\Tests\Controller\BaseFrontControllerTest;

class FrontControllerTest extends BaseFrontControllerTest
{
	public function testHome()
	{
		// can the page be loaded from the CMS
		$crawler = $this->assertCmsLoadable('/', 'homepage');
	}

	public function testRedirect()
	{
		// the "/homepage" uri should redirect to "/"
		$crawler = $this->client->request('GET', '/homepage');

		$this->assertTrue($this->client->getResponse()->isRedirect('/'));
	}

	public function testPage()
	{
		// use the about page to see if we can load a CMS content page
		$crawler = $this->assertCmsLoadable('/about', 'about');
	}
}
